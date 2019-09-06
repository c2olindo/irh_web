@extends('dashboard.layouts.app')
@section('title', 'Messages')
@section('page_styles')
<link rel="stylesheet" href="{{ asset('irh_assets/vendor/select2/select2.min.css') }}">
<style>
  .chat-history
  {
    height: 100%;
  }
  .message
  {
    padding:1em;
    border:1px solid transparent;
    border-radius: 30px;
    color:#fff;
    display: inline-block;
  }
  .message.my-message
  {
    background: var(--blue);
  }
  .message.their-message
  {
    background: var(--success);
  }
  .my-message-item
  {
    text-align: right;
  }
  textarea.form-control
  {
    border:none;
    resize: none;
    border-bottom: 1px solid #8a848475;
  }
</style>
@endsection
@section('content')
@php 
$message_to_user = null;
if(\Request::has('user'))
{
  $message_to_user = \App\User::find(\Request::get('user'));
  abort_if(!$message_to_user,404);
}
elseif($latest)
{
  if($latest->user_from !== Auth::id())
    $message_to_user = \App\User::find($latest->user_from);
  else
    $message_to_user = \App\User::find($latest->user_to);

  abort_if(!$message_to_user,404);
}

@endphp
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
        <h3 class="page-title">Messages </h3>
    </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
        <div class="card" style="height: 70vh;">
            <div class="card-header border-bottom">
                    <h6 class="m-0">All Chats</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group">
                  @forelse($chats as $chat)
                  <a href="{{ route('dashboard.messages.index') }}?user={{ $chat->user()->id }}" style="color:#3D5170;">
                  <li class="list-group-item {{ ($message_to_user->id === $chat->user()->id)?'bg-primary text-white':'' }}">
                    <p>
                      <i class="material-icons">person_pin</i>
                      <strong>{{ ucwords($chat->user()->full_name) }}</strong>
                    </p>
                  </li>
                  </a>
                  @empty
                  <li class="list-group-item bg-primary text-white">
                    <p class="text-center">
                      No Chats Found
                    </p>
                  </li>
                  @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 mb-4">
      <div class="card" style="height: 70vh;">
        <div class="card-header border-bottom d-flex flex-row justify-content-between">
          <div class="chat-target-name">
            <h6 class="m-0">
              @if(isset($message_to_user) && $message_to_user !== null)
              {{ ucwords($message_to_user->full_name) }}
              @else
              Choose a user to start chat
              @endif
            </h6>
          </div>
          <div class="choose-user-to-chat">
            <form action="{{ route('dashboard.messages.index') }}" class="form-inline" method="GET">
              <div class="form-group mr-1">
                <select name="user" id="usersChat" class="form-control">
                  <option value="" selected disabled>--Choose User to Chat--</option>
                  @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ ucwords($user->full_name) }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <button class="btn btn-sm btn-primary" type="submit">Start Chat</button>
              </div>
            </form>
          </div>
        </div>
        <div class="card-body p-4" style="overflow-y: scroll;">
          <div class="chat-history" id="chathistoryDiv">
            
          </div>
        </div>
        <div class="card-footer" id="messageActions">
          <div class="container-fluid w-100">
            <div class="row">
              <div class="col-md-9">
                <textarea name="" rows="2" class="form-control" placeholder="Type your message here..." id="messageText" style="font-size: 16px;"></textarea>
              </div>
              <div class="col-md-3 d-flex flex-column-reverse">
                <input type="hidden" id="user_from_id" value="{{ Auth::id() }}">
                <input type="hidden" id="user_to_id" value="{{ (!blank($message_to_user))?$message_to_user->id:'' }}">
                <input type="hidden" id="getChatHistoryRoute" value="{{ route('dashboard.messages.getchathistory') }}">
                <button class="btn btn-sm btn-success" id="sendMessageBtn" data-route="{{ route('dashboard.messages.send') }}">Send</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('page_scripts')
<script src="{{ asset('irh_assets/js/MessagesHandler.js') }}"></script>
<script src="{{ asset('irh_assets/vendor/select2/select2.min.js') }}"></script>
<script>
  $('#usersChat').select2();
</script>
@endsection