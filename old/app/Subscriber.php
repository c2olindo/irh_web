<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    public $guarded = [];

    /*===========================================
    =            Controller Handlers            =
    ===========================================*/
    
    public function subscribeToNewsletter($email)
    {
    	self::create(['email'=>$email]);
    }
    
    /*=====  End of Controller Handlers  ======*/
    
}
