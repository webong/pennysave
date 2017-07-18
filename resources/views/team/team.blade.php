@extends('layouts._sections')

@section('left-side-menu')
    @include('partials._team-menu-section')
@endsection

@section('body-title')
    <h2 class="page-heading text-info text-center">{{ $team->name }}<hr /></h2>
@endsection

@section('main-body-section')
    <div class="tab-content">

        @include('team.team-details')
        @include('team.invite-members')
        @include('team.view-members')

    </div>
@endsection
