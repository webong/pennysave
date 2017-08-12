@extends('layouts.spa')

@section('content')

    <div class="position-ref half-height push-down">
        <div class="text-center">
            <span class="fa fa-exclamation-triangle fa-5x"></span>
        </div>
    </div>
    <div class="flex-center position-ref quarter-height">
        <div class="content">
            <div class="text-xxxl">500</div>
            <div class="title m-b-md">
                Please Bear With Us, We Will Fix This In No Time. 
            </div>
        </div>
    </div>
    <div class="more-padding">
        <button class="btn btn-primary btn-lg center-block" onclick='window.location.href="@if(Auth::check()){{ route('main-dashboard') }}@else{{ url('/') }}@endif"'>
            @if (Auth::check()) Back To DashBoard
            @else Back To HomePage
            @endif
        </block>
    </div>
@endsection