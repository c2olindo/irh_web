<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class ResourceTagController extends Controller
{
    public function __construct()
    {

    }

    /**
     *
     * Shows list of all resource tags
     *
     */
    public function index()
    {
    	$tags = Tag::all();
    	return view('dashboard.resources.tags.index')->withTags($tags);
    }

    /**
     *
     * Shows create form for a new resource tag
     *
     */
    public function create()
    {
    	return view('dashboard.resources.tags.create');
    }

    /**
     *
     * Stores a new resource tag in database
     *
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'tag_group'	=>	'required',
    		'name'		=>	'required'
    	]);

    	$tag = Tag::create($request->all());
    	if($tag)
    	{
    		$this->success('New Resource Tag Added Successfully!');
    	}
    	else
    	{
    		$this->error();
    	}
    	return redirect()->route('dashboard.resources.tags.index');
    }
    

    /**
     *
     * shows edit form for existing tag
     *
     */
    public function edit(Tag $tag)
    {
    	return view('dashboard.resources.tags.edit')->withTag($tag);
    }

    /**
     *
     * Updates a specific resource tag
     *
     */
    public function update(Request $request,Tag $tag)
    {
    	if($tag->update($request->all()))
    	{
    		$this->success('Resource Tag Updated Successfully!!');
    	}
    	else
    	{
    		$this->error();
    	}
    	return redirect()->route('dashboard.resources.tags.index');
    }
    
    /**
     *
     * Destroys an existing resource tag
     *
     */
    public function destroy(Tag $tag)
    {
    	if($tag->delete())
    	{
    		$this->success('Resource Tag Destroyed Successfully!!');
    	}
    	else
    	{
    		$this->error();
    	}
    	return redirect()->back();
    }
    
    
    
    
}
