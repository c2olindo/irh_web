<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class ResourceFlag extends Model
{
    public $guarded = [];

    /*===========================================
    =            Controller Handlers            =
    ===========================================*/
    
    public function flagResource($request)
    {
    	self::create([
    		'user_id'		=>	Auth::id(),
    		'resource_id'	=>	$request->resource_id,
    		'reason'		=>	$request->reason
    	]);
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
