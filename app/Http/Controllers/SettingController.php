<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    public function index()
    {
    	$settings = Setting::first();
    	if(!$settings)
    	{
    		$settings = new Setting();
    	}
    	return view('dashboard.settings')->withSettings($settings);
    }


    public function update(Request $request)
    {
    	$settings = Setting::first();
    	if(!$settings)
    	{
    		$settings = new Setting();
    	}
    	$settings->privacy_policy = $request->privacy_policy;
    	$settings->terms_conditions = $request->terms_conditions;
    	if($settings->save())
    	{
    		$this->success('Settings Updated Successfully!');
    	}
    	else
    	{
    		$this->error();
    	}
    	return redirect()->back();
    }
}
