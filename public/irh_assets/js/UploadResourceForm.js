// This Class will handle the wizard process of upload Resource form
class UploadResourceForm
{
	constructor()
	{
		 this.prevBtn 	   	= $('#prev_btn');
		 this.nextBtn 	   	= $('#next_btn');
		 this.slideCounter 	= 1;
		 this.currentSlide 	= $('#slide_'+this.slideCounter);
		 this.error 		= $('#showError');
		 this.pageType 		= $('#resourceUploadForm').attr('data-type');
		 // Input Fields
		 this.resourceTitle = $('#resource_title');
		 this.resourceAttachment = $('#resource_attachment_field');
		 this.resourceAttachmentDropzone = $('#resource-attachment-upload');
		 this.resourceDescription = $('#resource_description');
		 this.tagsDropdown = $('.tagsDropdown');
		 this.termsConditionBox = $('#termsConditionsCheck');
		 // Listening to the events
		 this.events();
		 // Checking First and Last Slide
		 this.firstAndLastSlide();
		 // Appending active class
		 this.changeCurrentClass();
	}

	// Events Binding

	events()
	{
		this.prevBtn.on('click',this.previousSlide.bind(this));
		this.nextBtn.on('click',this.nextSlide.bind(this));
	}

	// Methods Section

	previousSlide()
	{
		this.decrementSlideCounter();
		this.showSlide(this.slideCounter);
		this.changeCurrentClass();
	}

	nextSlide()
	{
		this.incrementSlideCounter();
		this.showSlide(this.slideCounter);
		this.changeCurrentClass();
	}

	showSlide(slide)
	{
		$("#slide_"+slide).show();
		$("#slide_"+slide).siblings().hide();
	}

	changeCurrentClass()
	{
		$('#slide-'+this.slideCounter+'-trigger').addClass('current');
		$('#slide-'+this.slideCounter+'-trigger').siblings().removeClass('current');
	}

	incrementSlideCounter()
	{
		if(!this.validateResourceFields())
			return false;
		if(this.pageType == 'createResourceForm')
		{
			this.saveState(this.slideCounter);
		}
		this.slideCounter++;
		this.firstAndLastSlide();
		
	}

	decrementSlideCounter()
	{
		this.slideCounter--;
		this.firstAndLastSlide();
	}

	firstAndLastSlide()
	{
		if(this.slideCounter == 1)
		{
			this.prevBtn.hide();
			this.nextBtn.show();
		}
		else if(this.slideCounter == 4)
		{
			this.nextBtn.hide();
			this.prevBtn.show();
		}
		else
		{
			this.prevBtn.show();
			this.nextBtn.show();
		}
	}

	validateResourceFields()
	{
		this.error.hide();
		if(this.resourceTitle.val() == '' || this.resourceTitle.val() == ' ')
		{
			this.resourceTitle.focus();
			this.error.html('Resource Title is required *');
			this.error.show();
			return false;
		}
		if(this.pageType == 'createResourceForm')
		{
			if(this.resourceAttachment.val() == '' || this.resourceAttachment.val() == ' ')
			{
				this.resourceAttachmentDropzone.focus();
				this.error.html('Resource Attachment is required *');
				this.error.show();
				return false;
			}
		}
		if(this.resourceDescription.val() == '' || this.resourceDescription.val() == ' ')
		{
			this.resourceDescription.focus();
			this.error.html('Resource Description is required *');
			this.error.show();
			return false;
		}
		if($.isEmptyObject(this.tagsDropdown.val()) && this.slideCounter == 2)
		{
			this.error.html('Please choose atleast one tag *');
			this.error.show();
			return false;
		}
		return true;
	}

	saveState(counter)
	{
		 var form = $("#resourceUploadForm");
		 var route = form.attr('action');
		 var formdata = new FormData(form[0]);
		 formdata.append('resource_upload','ajax_wizard');
		 $.ajax({
		 	  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	          type: 'POST',
	          url: route,
	          data: formdata,
	          contentType: false,
			  processData: false,
	          success: function (data){
	          	console.log(data);
	          	if(data.resource)
	          	{
	          		$('#wizard_resource_id').val(data.resource.id);
	          	}
	          	else
	          	{
	          		console.log('something went wrong');
	          	}
	          }
		 });
	}
}

var resourceForm = new UploadResourceForm();