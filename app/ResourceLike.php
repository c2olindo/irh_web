<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ResourceLike extends Model
{
    public $guarded = [];

    /*===========================================
    =            Controller Handlers            =
    ===========================================*/
    
    public function likeResourceAgainstLoggedInUser($resource)
    {
        $resource = Resource::find($resource);
    	self::create(['resource_id'=>$resource->id,'user_id'=>Auth::id()]);
    }
    
    
    /*=====  End of Controller Handlers  ======*/
    

    /*=====================================
    =            Relationships            =
    =====================================*/
    
    public function resource()
    {
    	return $this->belongsTo(Resource::class)->withDefault();
    }
    
    public function user()
    {
    	return $this->belongsTo(User::class)->withDefault();
    }

    /*=====  End of Relationships  ======*/
    

}
