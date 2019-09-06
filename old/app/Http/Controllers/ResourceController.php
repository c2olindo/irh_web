<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RejectResource;
use App\Resource;
use App\ResourceCategory;
use App\ResourceFlag;
use App\Tag;
use App\User;
use Auth;
use Session;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     * Shows list of all resources
     *
     */
    public function index()
    {
    	$resources = Resource::orderBy('id','desc')->get();
    	return view('dashboard.resources.index')->withResources($resources);
    }

    /**
     *
     * Show list of all flagged resources
     *
     */
    public function flaggedResources()
    {
        $flags = ResourceFlag::whereStatus('pending')->get();
        return view('dashboard.resources.flagged')->withFlags($flags);
    }
    
    /**
     *
     * Reject Flag
     *
     */
    public function rejectFlag(ResourceFlag $flag)
    {
        $flag->status = 'rejected';
        if($flag->save())
        {
            $this->success('Flag Rejected');
        }
        else
        {
            $this->error();
        }
        return redirect()->back();
    }
    

    /**
     *
     * Approves and Publish a resource (in-review)
     *
     */
    public function approve(Resource $resource)
    {
        $resource->resource_status = 'published';
        if($resource->save())
        {
            $this->success("Resource Published Successfully!!");
        }
        else
        {
            $this->error();
        }
        return redirect()->back();
    }

    /**
     *
     * Disapprove and Reject a resource (in-review)
     *
     */
    public function disapprove(Resource $resource,Request $request)
    {
        $resource->resource_status = 'rejected';
        if($resource->save())
        {
            $to = [
                    'address' => $resource->user->email,
                    'name' => $resource->user->email
                ];
            Mail::to($to)->send(new RejectResource($resource->title,$request->reason,$request->details));
            $this->success("Resource Rejected Successfully!!");
        }
        else
        {
            $this->error();
        }
        return redirect()->back();
    }

    /**
     *
     * Featured / Un-Featured a specific resource
     *
     */

    public function featured(Request $request)
    {
        $res = Resource::find($request->res_id);
        if($res)
        {
            $res->isFeatured = $request->status;
            if($res->save())
            {
                return response()->json(['success'=>'success'],200);
            }
            else
            {
                return response()->json(['error'=>'error'],200);
            }
        }
        else
        {
            return response()->json(['error'=>'error'],200);
        }
    }
    
    

    /*=========================================
    =            Methods for Role {user}            =
    =========================================*/
    
    /**
     *
     * Shows list of all resources against specific user
     *
     */
    public function userResources()
    {
        $user = Auth::user();
        if($user->hasRole('user'))
        {
             $resources = $user->resources()->orderBy('id','desc')->get();
             return view('dashboard.resources.user-resources')->withResources($resources);
        }
        else
        {
            $this->error();
            return redirect()->route('dashboard.index');
        }
       
    }
    
    /**
     *
     * Preview a specific resource
     *
     */
    public function previewUserResource(Resource $resource)
    {
        return view('preview-single-resource')->withResource($resource);
    }
    

    /**
     *
     * Shows upload form for uploading new resource
     *
     */
    public function upload()
    {
        $resources_tags = Tag::all();
        $resources_categories = ResourceCategory::all();
        return view('dashboard.resources.upload')->withTags($resources_tags)->withCategories($resources_categories);
    }

    public function processUpload(Request $request)
    {
        $defaultResourceStatus = 'inreview';
        if(Auth::user()->hasRole('admin'))
        {
            $defaultResourceStatus = 'published';
        }
        if(Auth::user()->hasRole('user') AND Auth::user()->verified === 1)
        {
            $defaultResourceStatus = 'published';
        }
        switch ($request->resource_upload) {
            case 'ajax_wizard':
                $resource = $this->wizardStoreResourceOrWizardUpdate($request);
                if($resource)
                {
                    return response()->json(['resource'=>$resource],200);
                }
                else
                {
                    return response()->json(['error'=>'error'],200);
                }
            break;
            case 'publish':
                $resource = Resource::find($request->wizard_resource_id);
                if(!$resource)
                {
                    if($this->store($request,$defaultResourceStatus))
                    {
                        $this->success('Jazakallahu Khairan for sharing your resource');
                        return redirect()->route('dashboard.index'); // change it to my resources page
                    }
                }
                $request->request->set('updateOnlyStatus', $defaultResourceStatus);
                if($this->update($resource,$request))
                {
                    $this->success("Resource Uploaded Successfully!");
                    return redirect()->route('dashboard.index'); // change it to my resources page
                }
                else
                {
                    $this->error();
                    return redirect()->back();
                }
                break;
            case 'draft_preview':
                $resource = Resource::find($request->wizard_resource_id);
                if(!$resource)
                {
                    if($res = $this->storeResource($request,'drafted'))
                    {
                        $this->success("Resource Uploaded and Drafted Successfully!");
                         return redirect()->route('dashboard.resources.preview.user',$res);
                    }
                    else
                    {
                         $this->error();
                        return redirect()->back();
                    }
                }
                 $this->success("Resource Uploaded and Drafted Successfully!");
                 return redirect()->route('dashboard.resources.preview.user',$resource);
                
                break;
            
            default:
                abort(500,'Something went wrong');
                break;
        }
    }

    private function wizardStoreResourceOrWizardUpdate(Request $request)
    {
        if(!blank($request->wizard_resource_id))
        {
            $resource = Resource::find($request->wizard_resource_id);
            if(!$resource)
            {
                return false;
            }
           $request->returnBool = true;
           if($this->update($resource,$request))
           {
            return $resource;
           }
        }
        else
        {
            $resource = $this->storeResource($request,'drafted');
            if($resource)
            {
                return $resource;
            }
            return false;
        }
    }

    private function storeResource(Request $request,$status)
    {
        $cover_image = $preview_image = null;

        if($request->hasFile('cover_image'))
        {
            $attachment = $request->file('cover_image');
            $attachmentName = time().$attachment->getClientOriginalName();
            $attachment->move(public_path('irh_assets/uploads/resource_cover/'),$attachmentName);
            $cover_image = $attachmentName;
        }


        if($request->hasFile('preview_image'))
        {
            $attachment = $request->file('preview_image');
            $attachmentName = time().$attachment->getClientOriginalName();
            $attachment->move(public_path('irh_assets/uploads/resource_preview/'),$attachmentName);
            $preview_image = $attachmentName;
        }

        $resource = Resource::create([
            'user_id'       =>  Auth::id(),
            'category_id'   =>  $request->category_id,
            'title'         =>  $request->title,
            'description'   =>  $request->desc,
            'license_type'  =>  $request->active_license,
            'resource_attachment'   =>  $request->resource_attachment,
            'cover_attachment'      =>  $cover_image,
            'preview_attachment'    =>  $preview_image,
            'embed_link'            =>  $request->embed_link,
            'resource_status'       =>  $status
        ]);
        if($resource)
        {
            if(!blank($request->tags))
            {
                foreach($request->tags as $tag)
                {
                    $resource->tags()->attach($tag);
                }
            }
            return $resource;
        }
        return false;
    }

    /**
     *
     * Submit a draft for review to be publish
     *
     */
    public function submitDraftedForReview(Resource $resource)
    {
        $resource->resource_status = 'inreview';
        if($resource->save())
        {
            $this->success('Jazakallahu Khairan for sharing your resource, as part of quality control one of our team members will need to approve of your resource before going live.');
        }
        else
        {
            $this->error();
        }
        Session::flash('successPublish','inreview');
        return redirect()->back();
    }
    
    /**
     *
     * Show edit form for existing resource
     *
     */
    public function edit(Resource $resource)
    {
        $resources_tags = Tag::all();
        $resources_categories = ResourceCategory::all();
        return view('dashboard.resources.edit')->withResource($resource)->withTags($resources_tags)->withCategories($resources_categories);
    }
    

    /**
     *
     * Updates an existing resource
     *
     */
    public function update(Resource $resource,Request $request)
    {
        if($request->has('updateOnlyStatus'))
        {
            $resource->resource_status = $request->updateOnlyStatus;
            $resource->save();
            return true;
        }

        $cover_image = $preview_image = $resource_attachment = null;

        if($request->hasFile('cover_image'))
        {
            $attachment = $request->file('cover_image');
            $attachmentName = time().$attachment->getClientOriginalName();
            $attachment->move(public_path('irh_assets/uploads/resource_cover/'),$attachmentName);
            $cover_image = $attachmentName;
        }
        else
        {
            $cover_image = $resource->cover_attachment;
        }


        if($request->hasFile('preview_image'))
        {
            $attachment = $request->file('preview_image');
            $attachmentName = time().$attachment->getClientOriginalName();
            $attachment->move(public_path('irh_assets/uploads/resource_preview/'),$attachmentName);
            $preview_image = $attachmentName;
        }
        else
        {
            $preview_image = $resource->preview_attachment;
        }

        if(blank($request->resource_attachment) OR $request->resource_attachment === '')
        {
            $resource_attachment = $resource->resource_attachment;
        }
        else
        {
            $resource_attachment = $request->resource_attachment;
        }


        $resource->category_id           =  $request->category_id;
        $resource->title                 =  $request->title;
        $resource->description           =  $request->desc;
        $resource->license_type          =  $request->active_license;
        $resource->resource_attachment   =  $request->resource_attachment;
        $resource->cover_attachment      =  $cover_image;
        $resource->preview_attachment    =  $preview_image;
        $resource->embed_link            =  $request->embed_link;


        if($resource->save())
        {
            if(!blank($request->tags))
            {
                foreach($request->tags as $tag)
                {
                    $resource->tags()->sync($tag);
                }
            }
            $this->success('Resource Updated Successfully!');
        }
        if($request->has('returnBool') and $request->returnBool === true)
        {
            return true;
        }
        return redirect()->back();
    }
    

    /*----------  Ajax Handlers  ----------*/
    
    public function processResourceAttachment(Request $request)
    {
        $attachment = $request->file('file');
        $attachmentName = $attachment->getClientOriginalName();
        $attachment->move(public_path('irh_assets/uploads/resource_files/'),$attachmentName);
        chmod(public_path().'/irh_assets/uploads/resource_files/'.$attachmentName, 0777);
        return response()->json(['filename'=>$attachmentName],200);
    }


    
    /*=====  End of Methods for Role {user}  ======*/
    
}
