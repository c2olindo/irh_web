<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Resource extends Model
{
    public $guarded = [];

    /*===========================================
    =            Controller Handlers            =
    ===========================================*/
    
    public function publishedResources($pagination = false)
    {
        if($pagination)
        {
           return self::where('resource_status','published')->orderBy('created_at','desc')->paginate($pagination);
        }
        else
        {
            return self::where('resource_status','published')->orderBy('created_at','desc')->get();
        }
    }

    public function filterByCategory($category)
    {
        return $category->resources;
    }

    public function featuredResources()
    {
        return self::where('isFeatured',1)->where('resource_status','published')->orderBy('updated_at','desc')->limit(16)->get();
    }

    public function newResources()
    {
        return self::where('resource_status','published')->orderBy('created_at','desc')->limit(16)->get();
    }
    
    public function filterResources($request)
    {
        $resources = self::where('resource_status','published');
        if($request->has('keyword') &&  !blank($request->keyword))
        {
            $resources->where('title','LIKE','%'.$request->keyword.'%');
        }

        if($request->has('resource_type'))
        {
            $resources->whereHas('tags',function($tag) use($request){
               return $tag->where('tag_id',$request->resource_type);
            });
        }

        if($request->has('age_group'))
        {
           $resources->whereHas('tags',function($tag) use($request){
               return $tag->where('tag_id',$request->age_group);
            });
        }
        $resources->orderBy('created_at','desc');
        $results = $resources->paginate(12);
        return $results;
    }

    public function loggedInUserSavedResources()
    {
        $user = Auth::user();
        $resources = $user->saved_resources; // string of collected resource ids separated by comma
        if(!blank($resources))
        {
            $saved_resources_arr = explode(',',$resources);
            $saved_resources = Resource::find($saved_resources_arr);
        }
        else
        {
            $saved_resources = collect(new Resource);
        }
        return $saved_resources;
    }

    public function saveResourceAgainstLoggedInUser($resource)
    {
        $user = Auth::user();
        $saved_array = [];
        $existing_saved = $user->saved_resources;
        $new_saved_res_str = '';
        if(!blank($existing_saved))
        {
            $new_saved_res_str = $existing_saved.','.$resource->id;
        }
        else
        {
            $new_saved_res_str = $resource->id;
        }
        $user->saved_resources = $new_saved_res_str;
        $user->save();
    }


    public function unSaveResourceFromLoggedInUser($resource)
    {
        $user = Auth::user();
        $saved_array = [];
        $existing_saved = $user->saved_resources;
        $old_saved_arr = [];
        if(!blank($existing_saved))
        {
            $old_saved_arr = explode(',', $existing_saved);
            $to_remove = [0=>$resource->id];
            $new_arr = array_diff($old_saved_arr, $to_remove);
            $new_arr_str = implode(',', $new_arr);
            $user->saved_resources = $new_arr_str;
            $user->save();
        }
        return redirect()->back();
    }

    public function relatedResources($resource)
    {
         $resources = self::where('resource_status','published');
         $tag_ids = $resource->tags()->pluck('tag_id');
          $resources->whereHas('tags',function($tag) use($tag_ids){
               return $tag->whereIn('tag_id',$tag_ids);
            });
          $related = $resources->limit(4)->get();
          return $related;
    }
    
    /*=====  End of Controller Handlers  ======*/
    

    /*=====================================
    =            Relationships            =
    =====================================*/
    
    public function category()
    {
    	return $this->belongsTo(ResourceCategory::class,'category_id')->withDefault();
    }

    public function user()
    {
    	return $this->belongsTo(User::class)->withDefault();
    }

    public function flags()
    {
    	return $this->hasMany(ResourceFlag::class);
    }

    public function reviews()
    {
    	return $this->hasMany(ResourceReview::class);
    }

    public function likes()
    {
    	return $this->hasMany(ResourceLike::class);
    }

    public function tags()
    {
    	return $this->belongsToMany(Tag::class);
    }
    
    /*=====  End of Relationships  ======*/

    /*=================================
    =            Accessors            =
    =================================*/
    
    public function getResourceStatusFullAttribute()
    {
        $status = $this->resource_status;
        if($status == 'drafted')
        {
            return 'Drafted';
        }
        if($status == 'inreview')
        {
            return 'In-Review';
        }
        if($status == 'published')
        {
            return 'Published';
        }
        if($status == 'rejected')
        {
            return 'Rejected';
        }
    }

    public function getCoverAttachmentPathAttribute()
    {
        if($this->cover_attachment !== null)
        {
            return asset('irh_assets/uploads/resource_cover/'.$this->cover_attachment);
        }
        else
        {
            return asset('irh_assets/images/dummyfile.png');
        }
    }

    public function getPreviewAttachmentPathAttribute()
    {
        if($this->preview_attachment !== null)
        {
            return asset('irh_assets/uploads/resource_preview/'.$this->preview_attachment);
        }
        else
        {
            return asset('irh_assets/images/dummypreview.png');
        }
    }
    
    public function getResourceAttachmentPathAttribute()
    {
        if($this->resource_attachment !== null)
        {
            return asset('irh_assets/uploads/resource_files/'.$this->resource_attachment);
        }
        else
        {
            return '#';
        }
    }

    /*=====  End of Accessors  ======*/

    /*===============================
    =            Helpers            =
    ===============================*/
    
   public function loggedInUserHasReview()
   {
    $review = $this->reviews()->where('user_id',Auth::id())->first();
    if($review)
    {
        return true;
    }
    return false;
   }

   public function isResourceSavedByLoggedInUser()
   {
    $availability = \DB::table('users')->where('id',Auth::id())->whereRaw('FIND_IN_SET(?,saved_resources)', [$this->id])->first();
    if($availability)
    {
        return true;
    }
    else
    {
        return false;
    }
   }

   public function isResourceLikedByLoggedInUser()
   {
     $liked = $this->likes()->where('user_id',Auth::id())->first();
     if($liked)
     {
        return true;
     }
     else
     {
        return false;
     }
   }

    /*=====  End of Helpers  ======*/
    
    
    
}
