@extends('message.layouts.inbox-draft-sent-template')

@section('main-messages-area')

    @foreach ($messages as $message)
    <tr>
      <td><input name="select_for_delete"  value="{{ $message->message_id }}" type="checkbox" class="checkbox_select"></td>
      <td class="mailbox-name"><a href="/teams/{{$team_id}}/messages/sent/{{ $message->message_id }}" class="text-black no-underline">
      @if (($message->first_name.' '.$message->last_name) == Auth::user()->full_name()) {{ 'Me' }} @else {{ $message->first_name.' '.$message->last_name }} @endif</a></td>
      <td class="mailbox-subject"><a href="/teams/{{$team_id}}/messages/sent/{{ $message->message_id }}" class="text-black no-underline">{{ $message->brief_content }} - {{ $message->brief_content }}</a></td>
      <td class="mailbox-attachment"><a href="/teams/{{$team_id}}/messages/sent/{{ $message->message_id }}" class="text-black no-underline">@if ($message->attachments_csv) <i class="fa fa-paperclip"></i> @endif</a></td>
      <td class="mailbox-date"><a href="/teams/{{$team_id}}/messages/sent/{{ $message->message_id }}" class="text-black no-underline">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $message->created_at)->diffForHumans() }}</a></td>
    </tr>
    @endforeach

@endsection

@section('error-message')
    You Do Not Have Any Sent Messages In Your Mailbox</b></div>
@endsection
