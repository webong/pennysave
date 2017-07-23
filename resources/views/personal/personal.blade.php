@extends('layouts._sections')

@section('added_css')
        <link href="{{ asset('css/personal-dashboard.min.css') }}" rel="stylesheet">
@endsection

@section('left-side-menu')
    @include('partials._personal-menu-section')
@endsection

@section('body-title')
    <h2 class="page-heading text-info text-center">{{ $plan_details->name }}<hr /></h2>
@endsection

@section('main-body-section')
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="progress blue">
                <span class="progress-left">
                    <span class="progress-bar"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar"></span>
                </span>
                <div class="progress-value">90%</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="progress yellow">
                <span class="progress-left">
                    <span class="progress-bar"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar"></span>
                </span>
                <div class="progress-value">75%</div>
            </div>
        </div>
    </div>
@endsection
