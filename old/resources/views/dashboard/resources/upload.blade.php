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
    <h3 class="page-title">Upload New Resource </h3>
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
          <div id="slide-4-trigger" style="grid-column: 4;">4. Preview &amp; Submit</div>
        </div>
      </div>
      <div class="card-body p-0">
        <form action="{{ route('dashboard.resources.processupload') }}" id="resourceUploadForm" method="POST" enctype="multipart/form-data" data-type='createResourceForm'>
          @csrf
        <div class="p-4 slide" data-source="slide-1-trigger" id="slide_1">
          <div class="card">
            <div class="card-header border-bottom">
              <h6 class="m-0">Add Files &amp; Describe</h6>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="files">Select File(s):</label>
                <div class="dropzone needsclick dz-clickable p-5" id="resource-attachment-upload">
                  <div class="dz-message needsclick">
                    <h6 class="text-center lead">
                    Drop Your File(s) Here ..
                    </h6>
                  </div>
                </div>
                <input type="hidden" name="resource_attachment" class="slide_1_group" id="resource_attachment_field" data-route="{{ route('ajax.resource.attachment.process') }}" value="">
              </div>
              <div class="form-group">
                <label for="yt-embed">Video Embed Link (Youtube / Vimeo etc)</label>
                <input type="text" class="form-control slide_1_group" name="embed_link">
              </div>
              <div class="form-group">
                <label for="cover-image">Cover Image</label>
                <input type="file" class="form-control slide_1_group" name="cover_image">
              </div>
              <div class="form-group">
                <label for="preview-image">Preview Image (optional)</label>
                <input type="file" class="form-control slide_1_group" name="preview_image">
              </div>
              <div class="form-group">
                <label for="resource-title">Resource Title</label>
                <input type="text" class="form-control slide_1_group" name="title" id="resource_title" required>
              </div>
              <div class="form-group">
                <label for="resource-desc">Resource Description</label>
                <textarea name="desc" id="resource_description" rows="3" class="form-control summernote slide_1_group"></textarea>
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
                  <select name="tags[]" class="tagsDropdown slide_2_group" id="tags_multiselect" class="form-control" multiple>
                    @foreach($tags as $tag)
                    <optgroup label="{{ $tag->tag_group }}">
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    </optgroup>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tags">Choose Category:</label>
                  <select name="category_id" class="form-control slide_2_group" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
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
                    <a href="javascript:void(0);" class="btn btn-accent" id="attribution_license">Choose this</a>
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
                    <a href="javascript:void(0);" class="btn btn-success" id="sharealike_license">Selected</a>
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
                    <a href="javascript:void(0);" class="btn btn-accent" id="nonderivative_license">Choose this</a>
                  </div>
                </div>
              </div>
              <input type="hidden" class="slide_3_group" name="active_license" id="active_license" value="">
            </div>
          </div>
        </div>
        <div class="p-4 slide" data-source="slide-4-trigger" id="slide_4" style="display: none;">
          <div class="container">
            <div class="row mb-3">
              <div class="col-md-6 offset-md-3">
                <input type="checkbox" name="tac" id="termsConditionsCheck" required> I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>.
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <button type="submit" name="resource_upload" value="draft_preview" class="btn btn-accent btn-block">Draft &amp; Preview</button>
              </div>
              <div class="col-md-6">
               <button type="submit" name="resource_upload" value="publish" class="btn btn-success btn-block">Publish</button>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" name="wizard_resource_id" id="wizard_resource_id" value="">
        </form>
      </div>
      <div class="card-footer text-center py-2" style="margin-top: 36px;margin-bottom: 25px;">
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