@extends('layouts.auth')

@section('content')
    <div class="row margin-top-xxl">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <h3 class="panel-heading text-center">Register</h3>
                <div class="panel-body">
                    <!-- <form role="form" method="POST" action="{{ route('register') }}"> -->
                    <form role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        @if (isset($invitationEmail) || isset($invitationPhone))
                            <div class="alert alert-info text-center col-md-10 col-md-offset-1 bold">Please Sign Up To Get Started</div>
                        @endif

                        <div class="row">
                          <div class="col-md-6 form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                              <label for="first_name" class="control-label sr-only">First Name</label>

                              <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required autofocus>

                              @if ($errors->has('first_name'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('first_name') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                              <label for="last_name" class="control-label sr-only">Last Name</label>

                              <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>

                              @if ($errors->has('last_name'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('last_name') }}</strong>
                                  </span>
                              @endif
                          </div>
                        </div>

                        @if (! isset($invitationEmail) && ! isset($invitationPhone))
                            <div class="col-md-8 col-md-offset-2 margin-bottom-lg">
                                <ul class="nav nav-pills nav-justified">
                                    <li role="list" class="active email-phone"><a href="#show-email" aria-controls="show-email" data-toggle="tab">Use Email</a></li>
                                    <li role="list" class="phone-email"><a href="#show-phone" aria-controls="show-phone" data-toggle="tab">Use Phone Number</a></li>
                                </ul>
                            </div>
                        
                            <div class="tab-content">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} tab-pane active" id="show-email">                                                            
                                    <label for="email" class="col-md-4 control-label sr-only">E-Mail Address</label>
                                    
                                    <input id="email" type="text" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} tab-pane @if(isset($invitationPhone)){{'active'}}@endif"  id="show-phone">
                                    <label for="phone" class="col-md-4 control-label sr-only">Phone Number</label>

                                    <input id="phone" type="tel" class="form-control" placeholder="Phone Number" name="phone" value="{{ old('phone') }}">

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            @if (isset($invitationEmail))
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} tab-pane active" id="show-email">
                                    <label for="email" class="col-md-4 control-label sr-only">E-Mail Address</label>
                                    
                                    <input readonly id="email" type="text" class="form-control" placeholder="Email Address" name="email" value="@if (isset($invitationEmail)){{ $invitationEmail }}@else{{ old('email') }}@endif">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @else
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} tab-pane @if(isset($invitationPhone)){{'active'}}@endif"  id="show-phone">
                                    <label for="phone" class="col-md-4 control-label sr-only">Phone Number</label>

                                    <input readonly id="phone" type="tel" class="form-control" placeholder="Phone Number" name="phone" value="@if (isset($invitationPhone)){{ $invitationPhone }}@else{{ old('phone') }}@endif">

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endif
                        @endif

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label sr-only">Password</label>

                            <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        @if (isset($invitationEmail) || isset($invitationPhone))
                            <input type="hidden" name="registerToTeam" value="{{ $team_id }}" />     
                        @endif

                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary btn-lg center-block">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('added_js')
    @if (! isset($invitationEmail) && ! isset($invitationPhone))
        <script>
            $(document).ready(function () {
                $('.email-phone').click(function() {
                    $('#phone').val("");
                });

                $('.phone-email').click(function() {
                    $('#email').val("");
                });
            });
        </script>
    @endif
@endsection
