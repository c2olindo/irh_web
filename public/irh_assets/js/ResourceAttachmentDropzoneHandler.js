class ResourceAttachmentDropzoneHandler
{
	constructor()
	{
		Dropzone.autoDiscover = false;
		this.dropzoneContainer = $("#resource-attachment-upload");
		this.attachmentField = $("#resource_attachment_field");
		this.route = this.attachmentField.attr('data-route');
		this.dropzoneOptions();
		this.events();
	}

	events()
	{
		$(document).ready(this.triggerDropzone.bind(this));
	}

	dropzoneOptions()
	{
		Dropzone.options.resourceAttachmentUpload = 
		{
		  maxFiles:1,
		  renameFile: function(file) {
		      var dt = new Date();
		      var time = dt.getTime();
		     return time+file.name;
		  },
		  addRemoveLinks: false,
		  timeout: 50000,
		  removedfile: function(file) 
  		  {
  		  	 $("#resource_attachment_field").val('');
  		  	 var fileRef;
          	 return (fileRef = file.previewElement) != null ? 
          	 fileRef.parentNode.removeChild(file.previewElement) : void 0;
  		  },
		  success: function(file, response) 
		  {
		     $("#resource_attachment_field").val(response.filename);
		  },
		  error: function(file, response)
		  {
		    console.log(response);
		  }
		}
	}

	triggerDropzone()
	{
		this.dropzoneContainer.dropzone({ 
	    url: this.route,
	    addRemoveLinks : true,
	    maxFiles:1,
	    dictResponseError: 'Error uploading file!',
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	  });
	}


}

var resAttachmentDropzone = new ResourceAttachmentDropzoneHandler();