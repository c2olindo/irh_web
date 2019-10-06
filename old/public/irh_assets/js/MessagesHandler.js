class MessagesHandler
{
	constructor()
	{
		this.userFrom 	 = $('#user_from_id').val();
		this.userTo   	 = $('#user_to_id').val();
		this.messageBox  = $('#messageText');
		this.sendBtn 	 = $('#sendMessageBtn');
		this.sendRoute   = this.sendBtn.attr('data-route');
		// Listening to events
		this.events();
	}

	events()
	{
		this.sendBtn.on('click',this.sendMessage.bind(this));
		$(window).bind("load", this.loadChatHistory);
		setInterval(this.loadChatHistory,5000);

	}

	sendMessage()
	{
		var bindThis = this;
		if(!this.validateField())
		{
			return false;
		}
		$.ajax({
		 	  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	          type: 'POST',
	          url: this.sendRoute,
	          data: {user_from:this.userFrom,user_to:this.userTo,message:this.messageBox.val()},
	          success: function (data){
	          	bindThis.loadChatHistory();
	          }
		 });
		this.messageBox.val('');
		// update chat history here..
	}

	validateField()
	{
		if (!$.trim(this.messageBox.val())) {
		    this.messageBox.css('border-bottom','1px solid red');
		    this.messageBox.focus();
		    return false;
		}
		this.messageBox.css('border-bottom','1px solid #8a848475');
		return true;
	}

	loadChatHistory()
	{
		var route = $('#getChatHistoryRoute').val();
		var user_to = $('#user_to_id').val();
		var user_from = $('#user_from_id').val();
		var html = '';
		var chatHistoryDiv = $('#chathistoryDiv');
		$.ajax({
		 	  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	          type: 'POST',
	          url: route,
	          data: {user_id:user_to},
	          success: function (data){
	          	if(user_to == '')
	          	{
	          		$('#messageActions').hide();
	          	}
	          	if(data.messages)
	          	{
	          		data.messages.forEach(function(message){
	          			html += `
							
							<div class="${(message.user_from == user_from)?'my-message-item':'their-message-item'} py-2">
				              <div class="message ${(message.user_from == user_from)?'my-message':'their-message'}">
				                ${ message.message }
				              </div>
				            </div>

	          			`;
	          		});
	          		chatHistoryDiv.html(html);
	          	}
	          }
		 });
	}
}

var $msghandler = new MessagesHandler();