<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    public $guarded = [];

    /*===========================================
    =            Controller Handlers            =
    ===========================================*/
    
    public function allCategories()
    {
    	return self::all();
    }
    
    
    /*=====  End of Controller Handlers  ======*/
    

     /*=====================================
    =            Relationships            =
    =====================================*/
    
    public function resources()
    {
    	return $this->hasMany(Resource::class,'category_id');
    }
    
    /*=====  End of Relationships  ======*/
}
