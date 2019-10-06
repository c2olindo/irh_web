<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
   public $guarded = [];

   public function donateOneTime($request)
   {
   	if($request->amount == null || $request->amount == '' || blank($request->amount))
   	{
   		$request->amount = 1;
   	}
   	$centAmount = $request->amount * 100;
   	\Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
   	$customer = \Stripe\Customer::create([
      'email' => $request->stripeEmail,
      'source'  => $request->stripeToken,
	  ]);

	  $charge = \Stripe\Charge::create([
	      'customer' => $customer->id,
	      'amount'   => (int) $centAmount,
	      'currency' => 'usd',
	  ]);

	  self::create([
	  	'transaction_id'	=>	$charge->id,
	  	'email'				=>	$request->stripeEmail,
	  	'amount'			=>	$request->amount,
	  	'type'				=>	'onetime'
	  ]);
   }
}
