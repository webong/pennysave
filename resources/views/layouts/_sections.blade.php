@extends('layouts.app')

@section('added_css')
    @include('partials._togglecheckbox')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button role="button" onclick='window.location.href="{{ route('main-dashboard')}}"' class="btn btn-info center-block">Return To Dashboard</button> 
                </div>
                @yield('left-side-menu')
            </div>
        </div>
        <div class="col-md-9">
            <div class="main-panel border-light main-area">
                <div class="panel-header">
                    @yield('body-title')
                </div>
                <div class="panel-body">

                    @yield('main-body-section')

                </div>
            </div>
        </div>
    </div>
@endsection
