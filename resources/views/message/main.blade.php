@extends('layouts.app')
<!-- include content -->
@section('added_css')
    <link href="{{ asset('css/message.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
      <div class="">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="panel-heading col-md-3">
              <button role="button" onclick='window.location.href="{{ url('/teams/' . $team_id)}}"' class="btn btn-info center-block">Return To Team</button> 
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="panel panel-default">
                <div class="panel-heading">
                  @yield('Compose-Name')
                </div>
                <div class="panel-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li class="{{ check_active(Request::url(), url('/teams/' . $team_id . '/messages'), $team_id) }}"><a href="{{ url('/teams/' . $team_id . '/messages') }}"><i class="fa fa-inbox"></i> Inbox
                      <span class="label label-default pull-right">@if ($unread) {{ $unread }} @endif</span></a></li>
                    <li class="{{ check_active(Request::url(), url('/teams/' . $team_id . '/messages/sent'), $team_id) }}"><a href="{{ url('/teams/' . $team_id . '/messages/sent') }}"><i class="fa fa-envelope-o"></i> Sent</a></li>
                    <li class="{{ check_active(Request::url(), url('/teams/' . $team_id . '/messages/draft'), $team_id) }}"><a href="{{ url('/teams/' . $team_id . '/messages/draft') }}"><i class="fa fa-file-text-o"></i> Drafts</a></li>
                  </ul>
                </div>
                <!-- /.panel-body -->
              </div>
            </div>
            <div class="col-md-9">
              <div class="panel panel-default same-height @if(isset($messages) && (! $messages->count())){{ 'flex-center' }}@endif">
                <div class="panel-body">
                  @yield('message-content')
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
      </div>
    </div>
@endsection
