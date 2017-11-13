@extends('layouts.auth')

@section('added_css')
    <link href="{{ asset('css/selectize.bootstrap3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/password.min.css') }}" rel="stylesheet">
@endsection

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
                              <label for="first_name" class="control-label">First Name</label>

                              <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required autofocus>

                              @if ($errors->has('first_name'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('first_name') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                              <label for="last_name" class="control-label">Last Name</label>

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
                                    <label for="email" class="control-label">E-Mail Address</label>
                                    
                                    <input id="email" type="text" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="row tab-pane" id="show-phone">
                                    <div class="col-md-5 form-group{{ $errors->has('countries') ? ' has-error' : '' }}">
                                        <label for="countries" class="control-label">Countries</label>

                                        <select id="countries" name="countries" class="form-control" placeholder="Country">
                                            <option></option>
                                            @if (isset($countries))
                                                @foreach ($countries as $key => $country)
                                                    <option value="{{ $key }}" @if($key == 'NG'){{ 'selected' }}@endif>{{ '(' . $key . ') ' . $country }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @if ($errors->has('countries'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('countries') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                        
                                    <div class="col-md-7 form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label for="phone" class="control-label">Phone Number</label>

                                        <input id="phone" type="tel" class="form-control" placeholder="Phone Number" name="phone" value="{{ old('phone') }}">

                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            @if (isset($invitationEmail))
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" id="show-email">
                                    <label for="email" class="control-label">E-Mail Address</label>
                                    
                                    <input readonly id="email" type="text" class="form-control" placeholder="Email Address" name="email" value="@if (isset($invitationEmail)){{ $invitationEmail }}@else{{ old('email') }}@endif">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @else
                                <div class="row tab-pane" id="show-phone">
                                    <div class="col-md-5 form-group{{ $errors->has('countries') ? ' has-error' : '' }}">
                                        <label for="countries" class="control-label">Countries</label>

                                        <select id="countries" name="countries" class="form-control" placeholder="Country">
                                            <option></option>
                                            @if (isset($countries))
                                                @foreach ($countries as $key => $country)
                                                    <option value="{{ $key }}" @if($key == 'NG'){{ 'selected' }}@endif>{{ '(' . $key . ') ' . $country }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @if ($errors->has('countries'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('countries') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-7 form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label for="phone" class="control-label">Phone Number</label>

                                        <input readonly id="phone" type="tel" class="form-control" placeholder="Phone Number" name="phone" value="@if (isset($invitationPhone)){{ $invitationPhone }}@else{{ old('phone') }}@endif">

                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

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

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="tos" {{ old('tos') ? 'checked' : '' }} required> Accept Our <a href="{{ Request::root() }}/tos"> Terms of Service</a>
                                    </label>
                                </div>
                            </div>
                            @if ($errors->has('tos'))
                                <span class="has-error">
                                    <span class="help-block">
                                        <strong>You need to accept our Terms of Service</strong>
                                    </span>
                                </span>
                            @endif
                        </div>

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
    <script src="{{ asset('js/password.min.js') }}"></script>
    <script type="text/javascript">
        $('#password').password();
    </script>
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
    
    <script src="{{ asset('js/selectize.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $("select").selectize({
                'closeAfterSelect': true,
                'openOnFocus': false
            });
        });
    </script>
@endsection
