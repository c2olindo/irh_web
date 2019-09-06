<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResourceCategory;
use App\Tag;
use App\Resource;
use App\ResourceReview;
use App\User;
use App\ResourceLike;
use App\ResourceFlag;
use App\Subscriber;
use App\Donation;
use App\Mail\ContactUs;
use Illuminate\Support\Facades\Mail;
use Auth;
use Session;

class ThemeController extends Controller
{
    private $resourceModel = null;
    private $resourceCategoryModel = null;
    private $resourceReviewModel = null;
    private $tagModel = null;
    private $userModel = null;
    private $resourceLikeModel = null;
    private $subscriberModel = null;
    private $resourceFlagModel = null;
    private $donationModel = null;

    public function __construct()
    {
        $this->resourceModel = new Resource();
        $this->resourceCategoryModel = new ResourceCategory();
        $this->resourceReviewModel = new ResourceReview();
        $this->tagModel = new Tag();
        $this->userModel = new User();
        $this->resourceLikeModel = new ResourceLike();
        $this->subscriberModel = new Subscriber();
        $this->resourceFlagModel = new ResourceFlag();
        $this->donationModel = new Donation();
    }

    /**
     *
     * Shows Front-End of Website
     *
     */
    public function index()
    {
    	$categories         = $this->resourceCategoryModel->allCategories();
        $featuredResources  = $this->resourceModel->featuredResources();
        $newResources       = $this->resourceModel->newResources();
    	return view('home')->withCategories($categories)->withFeatured($featuredResources)->with('new_resources',$newResources);
    }
    

    /**
     *
     * Shows list of all resources
     *
     */
    public function resources()
    {
        $resources      = $this->resourceModel->publishedResources(12);
        $resource_types = $this->tagModel->resourceTypeTags();
        $age_groups     = $this->tagModel->ageGroupTags();
        return view('resources')->withResources($resources)->with('resource_types',$resource_types)->with('age_groups',$age_groups);
    }

    /**
     *
     * Resources filtered by category
     *
     */
    public function resourcesByCategory(ResourceCategory $category)
    {
        $resources      = $this->resourceModel->filterByCategory($category);
        return view('resources-by-cat')->withResources($resources)->withCategory($category->title);
    }
    

    /**
     *
     * Show details for single resource
     *
     */
    public function singleResource(Resource $resource)
    {
        $resource->increment('views');
        $relatedResources = $this->resourceModel->relatedResources($resource);
        return view('single-resource')->withResource($resource)->withRelated($relatedResources);
    }
        
    /**
     *
     * Add review to specific resource
     *
     */
    public function addReviewToResource(Request $request)
    {
        $this->resourceReviewModel->addReview($request);
        return redirect()->back();
    }

    /**
     *
     * Updates a review from specific resource
     *
     */
    public function updateReviewFromResource(ResourceReview $review,Request $request)
    {
        $this->resourceReviewModel->updateReview($review,$request);
        return redirect()->back();
    }

    /**
     *
     * Status 0 a review from resource by admin
     *
     */
    public function deleteReviewFromResource(ResourceReview $review)
    {
        $this->resourceReviewModel->deleteReview($review);
        return redirect()->back();
    }
    
    

    /**
     *
     * Filters the resources
     *
     */
    public function filteredResources(Request $request)
    {
        $filtered_resources = $this->resourceModel->filterResources($request);
        $resource_types     = $this->tagModel->resourceTypeTags();
        $age_groups         = $this->tagModel->ageGroupTags();
        return view('filtered-resources')->withResources($filtered_resources)->with('resource_types',$resource_types)->with('age_groups',$age_groups);
    }

    /**
     *
     * Shows Support Us Page
     *
     */

    public function supportUs()
    {
        return view('supportus');
    }
    
    /**
     *
     * Make One-Time Donation
     *
     */
    public function supportUsDonationOneTime(Request $request)
    {
        $this->donationModel->donateOneTime($request);
        Session::flash('success','JazakAllah! You have donated successfully.');
        return redirect()->route('theme.supportus');
    }
    

    /**
     *
     * Show list of all saved Resources
     *
     */
    public function savedResources()
    {
        $saved_resources = $this->resourceModel->loggedInUserSavedResources();
        return view('saved-resources')->withResources($saved_resources);
    }
    

    /**
     *
     * Save a new resource against some user
     *
     */
    public function saveResource(Resource $resource)
    {
        $this->resourceModel->saveResourceAgainstLoggedInUser($resource);
        return redirect()->back();
    }
    
    /**
     *
     * Unsave a specific resource against some user
     *
     */
    public function unSaveResource(Resource $resource)
    {
        $this->resourceModel->unSaveResourceFromLoggedInUser($resource);
        return redirect()->back();
    }
    

    /**
     *
     * Like a specific resource
     *
     */
    public function likeResource(Resource $resource)
    {
        $this->resourceLikeModel->likeResourceAgainstLoggedInUser($resource);
        return redirect()->back();
    }
    

    /**
     *
     * Download attachment for specific resource
     *
     */
    public function downloadResource(Resource $resource)
    {
        if($resource->resource_attachment !== null)
        {
            $resource->increment('downloads');
            $path = public_path('irh_assets/uploads/resource_files/'.$resource->resource_attachment);
            return response()->download($path);
        }
        else
        {
            return redirect()->back();
        }
    }    


    /**
     *
     * Flag a specific resource
     *
     */
    public function flagResource(Request $request)
    {
        $this->resourceFlagModel->flagResource($request);
        Session::flash('success','You have flagged this resource. We will review it soon');
        return redirect()->back();
    }
    

    /**
     *
     * Shows contact us page
     *
     */
    public function contactus()
    {
        return view('contactus');
    }
    
    /**
     *
     * Send mail to Islamic Resource Hub Admin
     *
     */
    public function sendContactMail(Request $request)
    {
        $to = [
                    'address' => 'support@islamicresourcehub.com',
                    'name' => 'Support - Islamic Resource Hub'
                ];
        Mail::to($to)->send(new ContactUs($request));
        Session::flash('success','Message Sent Successfully!');
        return redirect()->back();
    }

    /**
     *
     * Subscribe to newsletter
     *
     */
    public function newsletterSubscription(Request $request)
    {
        $customMessages = [
        'email.unique' => 'You have already subscribed to our newsletter'
        ];
        $request->validate(['email'=>'required|unique:subscribers'],$customMessages);
        $this->subscriberModel->subscribeToNewsletter($request->email);
        Session::flash('success','You have Successfully Subscribe to Our NewsLetter');
        return redirect()->back();
    }
    
    
}
