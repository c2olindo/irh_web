@extends('dashboard.layouts.app')
@section('title', 'Upload Resource')
@section('page_styles')
<link href="{{ asset('irh_assets/vendor/multiselect/css/multi-select.css') }}" media="screen" rel="stylesheet" type="text/css">
<style>
.current
{
color: #0077ff !important;
}
.dropzone
{
border: 2px dashed #0087F7;
border-radius: 5px;
background: white;
}
</style>
@endsection
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
  <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
    <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
    <h3 class="page-title">Edit Existing Resource </h3>
  </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
  <div class="col-lg col-md-12 col-sm-12 mb-4">
    <div class="card">
      <div class="card-header border-bottom">
        <div class="w-100 text-center" style="display: grid;">
          <div id="slide-1-trigger" style="grid-column: 1;">1. Add Files &amp; Describe</div>
          <div id="slide-2-trigger" style="grid-column: 2;">2. Choose Categories</div>
          <div id="slide-3-trigger" style="grid-column: 3;">3. Choose License</div>
          <div id="slide-4-trigger" style="grid-column: 4;">4. Preview &amp; Publish</div>
        </div>
      </div>
      <div class="card-body p-0">
        <form action="{{ route('dashboard.resources.update',$resource) }}" method="POST" id="resourceUploadForm" enctype="multipart/form-data" data-type='updateResourceForm'>
          @csrf
        <div class="p-4 slide" data-source="slide-1-trigger" id="slide_1">
          <div class="card">
            <div class="card-header border-bottom">
              <h6 class="m-0">Add Files &amp; Describe</h6>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="files">Select File(s): (<a href="{{ (!blank($resource->resource_attachment)?asset('irh_assets/uploads/resource_files/'.$resource->resource_attachment):'#') }}">See Existing File</a>)</label>
                <div class="dropzone needsclick dz-clickable p-5" id="resource-attachment-upload">
                  <div class="dz-message needsclick">
                    <h6 class="text-center lead">
                    Drop Your File(s) Here ..
                    </h6>
                  </div>
                </div>
                <input type="hidden" name="resource_attachment" id="resource_attachment_field" data-route="{{ route('ajax.resource.attachment.process') }}" value="{{ $resource->resource_attachment }}">
              </div>
              <div class="form-group">
                <label for="yt-embed">Video Embed Link (Youtube / Vimeo etc)</label>
                <input type="text" class="form-control" name="embed_link" value="{{ $resource->embed_link }}">
              </div>
              <div class="form-group">
                <label for="cover-image">Cover Image</label>
                <input type="file" class="form-control" name="cover_image">
              </div>
              <div class="form-group">
                <label for="preview-image">Preview Image (optional)</label>
                <input type="file" class="form-control" name="preview_image">
              </div>
              <div class="form-group">
                <label for="resource-title">Resource Title</label>
                <input type="text" class="form-control" name="title" id="resource_title" value="{{ $resource->title }}" required>
              </div>
              <div class="form-group">
                <label for="resource-desc">Resource Description</label>
                <textarea name="desc" id="" rows="3" class="form-control summernote">{{ $resource->description }}</textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="p-4 slide" data-source="slide-2-trigger" id="slide_2" style="display: none;">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tags">Choose Tag(s):</label>
                  <select name="tags[]" id="tags_multiselect" class="form-control tagsDropdown" multiple>
                    @foreach($tags as $tag)
                    <optgroup label="{{ $tag->tag_group }}">
                    <option value="{{ $tag->id }}" {{ ($resource->tags->contains($tag->id)) ? 'selected':'' }}>{{ $tag->name }}</option>
                    </optgroup>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tags">Choose Category:</label>
                  <select name="category_id" class="form-control" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ ($resource->category_id == $cat->id)?'selected':'' }}>{{ $cat->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="p-4 slide" data-source="slide-3-trigger" id="slide_3" style="display: none;">
          <div class="container-fluid w-100">
            <h6 class="text-center">To share your resource for free, you must first attach a Creative Commonslicence below.This licence gives you control over how others use and share your work.</h6>
            <div class="row mt-4">
              <div class="col-md-4">
                <div class="card text-center" style="height: 262px;">
                  <div class="card-header border-bottom">
                    <h4 class="m-0">Attribution Licence</h4>
                  </div>
                  <div class="card-body">
                    <p>
                      "I want credit for my work and to freely share my resource with no restrictions on what others can do with it."
                    </p>  
                  </div>
                  <div class="card-footer">
                    <a href="javascript:void(0);" class="btn {{ ($resource->license_type == 'attribution_license')?'btn-success':'btn-accent' }}" id="attribution_license">Choose this</a>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card text-center" style="height: 262px;">
                  <div class="card-header border-bottom">
                    <h4 class="m-0">ShareAlike Licence</h4>
                  </div>
                  <div class="card-body ">
                    <p>
                      "I want credit for my work and to freely share my resource as long as others also freely share anything they make using it."
                    </p>
                  </div>
                  <div class="card-footer">
                    <a href="javascript:void(0);" class="btn {{ ($resource->license_type == 'sharealike_license')?'btn-success':'btn-accent' }}" id="sharealike_license">Selected</a>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card text-center" style="height: 262px;">
                  <div class="card-header border-bottom">
                    <h4 class="m-0">NoDerivatives Licence</h4>
                  </div>
                  <div class="card-body">
                    <p>
                      "I want credit for my work and to freely share my resource but insist that others don't share any changes they've made to it."
                    </p>
                  </div>
                  <div class="card-footer">
                    <a href="javascript:void(0);" class="btn {{ ($resource->license_type == 'nonderivative_license')?'btn-success':'btn-accent' }}" id="nonderivative_license">Choose this</a>
                  </div>
                </div>
              </div>
              <input type="hidden" name="active_license" id="active_license" value="{{ $resource->license_type }}">
            </div>
          </div>
        </div>
        <div class="p-4 slide" data-source="slide-4-trigger" id="slide_4" style="display: none;">
          <div class="container">
            <div class="row">
              <div class="col-md-6 offset-md-3">
               <button type="submit" value="update" class="btn btn-success btn-block">Update</button>
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="card-footer text-center py-2">
        <a href="javascript:void(0);" class="btn btn-info" id="prev_btn" style="display: none;">< Previous</a>&nbsp;
        <a href="javascript:void(0);" class="btn btn-primary" id="next_btn">Next ></a>
        <p class="py-2 text-center" id="showError" style="color: red;display: none;"></p>
      </div>
    </div>
  </div>
</div>
@endsection
@section('page_scripts')
<script src="{{ asset('irh_assets/js/UploadResourceForm.js') }}?v={{ microtime() }}"></script>
<script src="{{ asset('irh_assets/js/ResourceLicenseHandler.js') }}?v={{ microtime() }}"></script>
<script src="{{ asset('irh_assets/js/ResourceAttachmentDropzoneHandler.js') }}?v={{ microtime() }}"></script>
<script src="{{ asset('irh_assets/vendor/multiselect/js/jquery.multi-select.js') }}"></script>
<script>
$('#tags_multiselect').multiSelect();
$('#category_multiselect').multiSelect();
</script>
@stop