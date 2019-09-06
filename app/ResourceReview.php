<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceReview extends Model
{
    public $guarded = [];

    /*===========================================
    =            Controller Handlers            =
    ===========================================*/
    
    public function addReview($request)
    {
        $request->user()->reviews()->create($request->all());
    }

    public function updateReview($review,$request)
    {
        $review->update($request->all());
    }

    public function deleteReview($review)
    {
        $review->status = 0;
        $review->save();
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

    /*===============================
    =            Helpers            =
    ===============================*/
    
     public function resourceStarsRatings()
    {
        $starCount = $this->stars;
        $starHtml = '';
        if($starCount !== null)
        {
            $counter = 0;
            for($i=0;$i<$starCount;$i++)
            {
                $starHtml .= '<i class="fas fa-star" style="color:var(--yellow-color);"></i>';
                $counter++;
            }
            while($counter < 5)
            {
                $starHtml .= '<i class="far fa-star"></i>';
                $counter++;
            }
        }
        else
        {
            for($i=0;$i<5;$i++)
            {
                $starHtml .= '<i class="far fa-star"></i>';
            }
        }
        return $starHtml;
    }
    
    
    /*=====  End of Helpers  ======*/
    
}
