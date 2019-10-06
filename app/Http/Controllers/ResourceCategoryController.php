<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResourceCategory;

class ResourceCategoryController extends Controller
{
    public function __construct()
    {

    }

    /**
     *
     * Shows list of all resource categories
     *
     */
    public function index()
    {
    	$categories = ResourceCategory::all();
    	return view('dashboard.resources.categories.index')->withCategories($categories);
    }
    

    /**
     *
     * stores new resource category in database
     *
     */
    public function store(Request $request)
    {
    	$request->validate(['title'=>'required']);
    	$category = ResourceCategory::create($request->all());
    	if($category)
    	{
    		$this->success('Resource Category Created Successfully!!');
    	}
    	else
    	{
    		$this->error();
    	}
    	return redirect()->back();
    }
    

    /**
     *
     * Shows edit details for Resource Category
     *
     */
    public function edit(ResourceCategory $category)
    {
    	$categories = ResourceCategory::all();
    	return view('dashboard.resources.categories.edit')->withCategory($category)->withCategories($categories);
    }

    /**
     *
     * Updates a specific resource category
     *
     */
    public function update(Request $request,ResourceCategory $category)
    {
    	if($category->update($request->all()))
    	{
    		$this->success('Resource Category Updated Successfully!!');
    	}
    	else
    	{
    		$this->error();
    	}
    	return redirect()->route('dashboard.resources.categories.index');
    }

    /**
     *
     * Deletes existing resource category
     *
     */
    public function destroy(ResourceCategory $category)
    {
    	if($category->delete())
    	{
    		$this->success('Resource Category Destroyed Successfully!!');
    	}
    	else
    	{
    		$this->error();
    	}
    	return redirect()->back();
    }
    
    
    
}
