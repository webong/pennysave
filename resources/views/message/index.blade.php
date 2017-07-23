@extends('message.layouts.inbox-draft-sent-template')

@section('main-messages-area')

    @foreach ($messages as $message)
    <tr>
      <td><input name="select_for_delete"  value="{{ $message->message_id }}" type="checkbox" class="checkbox_select"></td>
      <td class="mailbox-name">
        @if ($message->receiver_status == 1)<a href="/teams/{{$team_id}}/messages/read/{{ $message->message_id }}" class="text-black no-underline"><b>@if (($message->first_name.' '.$message->last_name) == Auth::user()->full_name()) {{ 'Me' }} @else {{ $message->first_name.' '.$message->last_name }} @endif</a></b></td>
          <td class="mailbox-subject"><b><a href="/teams/{{$team_id}}/messages/read/{{ $message->message_id }}" class="text-black no-underline">{{ $message->brief_content }}</b> - {{ $message->brief_content }}</a></td>
          <td class="mailbox-attachment"><a href="/teams/{{$team_id}}/messages/read/{{ $message->message_id }}" class="text-black no-underline">@if ($message->attachments_csv) <i class="fa fa-paperclip"></i> @endif</a></td>
          <td class="mailbox-date"><b><a href="/teams/{{$team_id}}/messages/read/{{ $message->message_id }}" class="text-black no-underline">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $message->created_at)->diffForHumans() }}</a></b></td>
        @else <a href="/teams/{{$team_id}}/messages/read/{{ $message->message_id }}" class="text-black no-underline">{{ $message->first_name.' '.$message->last_name }}</a></td>
          <td class="mailbox-subject"><a href="/teams/{{$team_id}}/messages/read/{{ $message->message_id }}" class="text-black no-underline">{{ $message->brief_content }} - {{ $message->brief_content }}</a></td>
          <td class="mailbox-attachment"><a href="/teams/{{$team_id}}/messages/read/{{ $message->message_id }}" class="text-black no-underline">@if ($message->attachments_csv) <i class="fa fa-paperclip"></i> @endif</a></td>
          <td class="mailbox-date"><a href="/teams/{{$team_id}}/messages/read/{{ $message->message_id }}" class="text-black no-underline">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $message->created_at)->diffForHumans() }}</a></td>
        @endif
    </tr>
    @endforeach

@endsection

@section('error-message')
    You Do Not Have Any Messages In Your Mailbox
@endsection
