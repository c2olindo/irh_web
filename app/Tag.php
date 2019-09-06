<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $guarded = [];

    /*===========================================
    =            Controller Handlers            =
    ===========================================*/
    
    public function resourceTypeTags()
    {
    	return self::where('tag_group','Resource Type')->get();
    }

    public function ageGroupTags()
    {
    	return self::where('tag_group','Age Group')->get();
    }
    
    
    /*=====  End of Controller Handlers  ======*/
    

    /*=====================================
    =            Relationships            =
    =====================================*/
    
    public function resources()
    {
    	return $this->belongsToMany(Resource::class);
    }
    
    /*=====  End of Relationships  ======*/
}
