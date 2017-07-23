@extends('message.layouts.inbox-draft-sent-template')

@section('main-messages-area')

    @foreach ($messages as $message)
    <tr>
      <td><input name="select_for_delete" value="{{ $message->message_id }}" type="checkbox" class="checkbox_select"></td>
      <td class="mailbox-name">
      @if (($message->first_name.' '.$message->last_name) == Auth::user()->full_name()) {{ 'Me' }} @else {{ $message->first_name.' '.$message->last_name }} @endif</td>
      <td class="mailbox-subject">{{ $message->brief_content }} - {{ $message->brief_content }}</td>
      <td class="mailbox-attachment">@if ($message->attachments_csv) <i class="fa fa-paperclip"></i> @endif</td>
      <td class="mailbox-date">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $message->created_at)->diffForHumans() }}</td>
      <td><a href="/teams/{{$team_id}}/messages/restore/{{ $message->message_id }}">Restore Message</a></td>
    </tr>
    @endforeach

@endsection

@section('error-message')
    You Do Not Have Any Sent Messages In Your Mailbox</b></div>
@endsection
