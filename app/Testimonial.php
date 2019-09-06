<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    public $guarded = [];

    public function allTestimonials()
    {
    	return self::all();
    }
}
