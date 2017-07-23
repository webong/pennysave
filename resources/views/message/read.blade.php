@extends('message.main')

@section('Compose-Name')
  @include('message.partials.create-button')
@endsection

<!-- include content -->
@section('message-content')
    <div class="box-tools pull-right">
      <a @if ($prev) {{ 'href=/teams/' . $team_id . '/messages/read/'. $prev }} @endif class="btn btn-box-tool @if (! $prev) {{ ' disabled'}} @endif" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
      <a @if ($next) {{ 'href=/teams/' . $team_id . '/messages/read/'. $next }} @endif class="btn btn-box-tool @if (! $next) {{ ' disabled'}} @endif" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
      <a type="button" href="/teams/{{$team_id}}/messages/reply/@if($type == 'sent'){{ 'sent' }}@else{{ 'receive' }}@endif/{{ $message->message_id }}" class="btn btn-default"><i class="fa fa-reply"></i> Reply</a>
      <a type="button" href="/teams/{{$team_id}}/messages/forward/@if($type == 'sent'){{ 'sent' }}@else{{ 'receive' }}@endif/{{ $message->message_id }}" class="btn btn-default"><i class="fa fa-share"></i> Forward</a>
      <a type="button" href="/teams/{{$team_id}}/messages/trash/@if($type == 'sent'){{ 'sent' }}@else{{ 'receive' }}@endif/{{ $message->message_id }}" class="btn btn-default"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <div class="mailbox-read-info">
      <h3>{{ $message->subject }}</h3>
      <h5>From: @if (($message->first_name.' '.$message->last_name) == Auth::user()->full_name()) {{ 'Me' }} @else {{ $message->first_name.' '.$message->last_name }} @endif
      <h5></h5>
        <span class="mailbox-read-time pull-right">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $message->created_at)->format('j M, Y h:i A') }}</span></h5>
    </div>
    <!-- /.mailbox-read-info -->
    <div class="mailbox-controls with-border text-center">
      <div class="btn-group">
        <a href="/teams/{{$team_id}}/messages/trash/@if($type == 'sent'){{ 'sent' }}@else{{ 'receive' }}@endif/{{ $message->message_id }}" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
          <i class="fa fa-trash-o"></i></a>
        <a href="/teams/{{$team_id}}/messages/reply/@if ($type == 'sent'){{ 'sent' }}@else{{ 'receive' }}@endif/{{ $message->message_id}}" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
          <i class="fa fa-reply"></i></a>
        <a href="/teams/{{$team_id}}/messages/forward/@if ($type == 'sent'){{ 'sent' }}@else{{ 'receive' }}@endif/{{ $message->message_id }}" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">
          <i class="fa fa-share"></i></a>
      </div>
    </div>
    <hr />
    <!-- /.mailbox-controls -->
    <div class="mailbox-read-message">
      {!! html_entity_decode($message->content) !!}
    </div>
    <!-- /.mailbox-read-message -->
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
    @if ($message->attachments_csv)
    <ul class="mailbox-attachments clearfix">
      <li>
        <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

        <div class="mailbox-attachment-info">
          <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Sep2014-report.pdf</a>
              <span class="mailbox-attachment-size">
                1,245 KB
                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
              </span>
        </div>
      </li>
      <li>
        <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>

        <div class="mailbox-attachment-info">
          <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
              <span class="mailbox-attachment-size">
                1,245 KB
                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
              </span>
        </div>
      </li>
      <li>
        <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"></span>

        <div class="mailbox-attachment-info">
          <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
              <span class="mailbox-attachment-size">
                2.67 MB
                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
              </span>
        </div>
      </li>
      <li>
        <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png" alt="Attachment"></span>

        <div class="mailbox-attachment-info">
          <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
              <span class="mailbox-attachment-size">
                1.9 MB
                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
              </span>
        </div>
      </li>
    </ul>
    @endif
@endsection
