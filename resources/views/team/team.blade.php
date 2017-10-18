@extends('layouts._sections')

@section('left-side-menu')
    @include('partials._team-menu-section')
@endsection

@section('body-title')
    <h2 class="page-heading text-info text-center team-heading">
        {{ $team->name }}
        <div class="no-padding">
            <small class="text-small">Members Count: {{ $team->user->count() }}</small>
            <span class="margin-left-md margin-right-md text-small text-info"><strong>|</strong></span>
            <small class="text-small">Status: 
                @if(! confirm_team_status($team->status, $team->start_date))<span class="text-warning">Inactive
                @else<span class="text-success">Active
                @endif
                </span>
            </small>
        </div> 
        <hr />
    </h2>
@endsection

@section('main-body-section')
    <div class="tab-content">

        @include('team.payment-account')
        @include('team.team-details')
        @include('team.invite-members')
        @include('team.view-members')
        @include('team.notifications')
        @include('team.settings')

        @include('modals._view-announcement-modal')
    </div>
@endsection

@section('added_js')
    @include('views-js.team-details-js')
    @include('views-js.invite-members-js')
@endsection
