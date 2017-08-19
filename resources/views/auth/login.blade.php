@extends('layouts.auth')

@section('content')
    <div class="row margin-top-xxxl">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <h3 class="panel-heading text-center">Login</h3>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        @if (isset($emailOrPhone))
                            <div class="alert alert-info text-center col-md-10 col-md-offset-1 bold">You Need To Login To Accept This Request</div>
                        @endif
                        
                        <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                            <label for="login" class="control-label">E-Mail Address or Phone Number</label>

                            <input id="login" type="text" class="form-control" name="login" value="@if(isset($emailOrPhone)){{ $emailOrPhone }}@else{{ old('login') }}@endif" placeholder="Email Address or Phone Number" required autofocus>

                            @if ($errors->has('login'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('login') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg center-block">
                                Login
                            </button>
                        </div>
                        <div class="text-center">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
