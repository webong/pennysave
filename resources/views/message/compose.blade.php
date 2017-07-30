@extends('message.main')

<!-- Include Additional CSS specific to page -->
@section('added_css')
  <link rel="stylesheet" href="{{ asset('css/trumbowyg.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/selectize.bootstrap3.css') }}">
@endsection

@section('Compose-Name')
    @include('message.partials.back-to-inbox')
@endsection

<!-- include content -->
@section('message-content')
    <form action="{{ url('/teams/' . $team_id . '/messages/create') }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
        <div class="form-group{{ $errors->has('receivers') ? ' has-error' : '' }}">
            <label for="receivers" class="control-label sr-only">Receivers</label>
            <select name="receivers[]" data-placeholder="Type Name and Select From List" multiple="multiple" class="multiple-select form-control">
                <option></option>
                @if (isset($receivers))
                  @foreach($receivers as $user)
                      <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                  @endforeach
                  @foreach ($users as $otherUsers)
                    @if ($otherUsers->id == Auth::user()->id)
                      @continue
                    @else
                      @if ($receivers->contains($user)) {
                        @continue
                      @else
                         <option value="{{ $otherUsers->id }}">{{ $otherUsers->name }}</option>  
                      @endif
                    @endif
                  @endforeach
                @elseif (isset($everyone))
                  @foreach ($users as $otherUsers)
                    @if ($otherUsers->id == Auth::user()->id)
                      @continue
                    @else
                      <option value="{{ $otherUsers->id }}" selected>{{ $otherUsers->name }}</option>  
                    @endif
                  @endforeach
                @else
                  @foreach ($users as $otherUsers)
                    @if ($otherUsers->id == Auth::user()->id)
                      @continue
                    @else
                      <option value="{{ $otherUsers->id }}">{{ $otherUsers->name }}</option>  
                    @endif
                  @endforeach
                @endif
            </select>

            @if ($errors->has('receivers'))
              <span class="help-block">
                  <strong>{{ $errors->first('receivers') }}</strong>
              </span>
            @endif
        </div>

      <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
        <input maxlength="70" class="form-control" name="subject" placeholder="Subject:" value="@if (isset($message))@if($type=='reply'){{ 'Re: ' . $message->subject }}@else{{ 'Fwd: ' . $message->subject }} @endif @endif">
      </div>
        @if ($errors->has('subject'))
          <span class="help-block">
              <strong>{{ $errors->first('subject') }}</strong>
          </span>
        @endif
      <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
          <textarea id="compose-textarea" class="form-control" style="height: 300px" name="message" placeholder="Message">@if(isset($message)){{ $message->content }}@endif</textarea>
      </div>
        @if ($errors->has('message'))
          <span class="help-block">
              <strong>{{ $errors->first('message') }}</strong>
          </span>
        @endif
      <div class="form-group{{ $errors->has('attachment') ? ' has-error' : '' }}">
        <div class="btn btn-default btn-file">
          <i class="fa fa-paperclip"></i> Attachment
          <input type="file" name="attachment" multiple>
        </div>
        <p class="help-block">You can upload up to three(3) files; Max.: 1MB</p>
      </div>
      @if (isset($message) && ! is_null($message->attachments_csv))
        @if (count($attachments_csv))
            @foreach ($attachments_csv as $attachment_id)           
                $getAttachment = getAttachment($attachment_id);
                @if ($getAttachment)
                  <a href="{{ urldecode($getAttachment->file_name_on_disk) }}">
                    <div class="col-sm-6 col-md-4">
                      <div class="thumbnail">
                        <h1><span class="getAttachmentType($getAttachment->type)"></span></h1>
                        <h5 class="text-center">{{ $getAttachment->given_name }}><br />
                        <small>{{ $getAttachment->size }}></small></h5>
                      </div>
                    </div>
                  </a>
                @endif
            @endforeach
        @endif
      @endif
      @if ($errors->has('attachment'))
        <span class="help-block">
            <strong>{{ $errors->first('attachment') }}</strong>
        </span>
      @endif
      <div class="pull-right">
          <button type="submit" name="submitDraft" class="btn btn-default" value="submitDraft"><i class="fa fa-pencil"></i> Save As Draft</button>
          <button type="submit" name="mailMessageSubmit" class="btn btn-primary" value="submitMail"><i class="fa fa-envelope-o"></i> Send Message</button>
      </div>
      <button type="button" class="btn btn-default" onclick='window.location.href="{{ url()->previous() }}"'><i class="fa fa-times"></i> Discard Message</button>
    </form>
@endsection

@section('added_js')
    <script src="{{ asset('js/selectize.min.js') }}"></script>
    <script src="{{ asset('js/trumbowyg.min.js') }}"></script>
    <script>
      $(function () {
        $("select").selectize({
          plugins: ['remove_button'],
          closeAfterSelect: true,
          hideSelected: true,
          maxItems: 5
        });
        // Add text editor
        $("#compose-textarea").trumbowyg();
      });
    </script>
@endsection
