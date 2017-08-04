@extends('layouts.app')

@section('added_css')
    @include('partials._togglecheckbox')
@endsection

@section('added_nav')
    <li class="dropdown">
        <a href="#" id="dLabel" class="dropdown-toggle" role="button" data-toggle="dropdown">
            <span class="text-info fa fa-bell"></span>
            <span class="badge info margin-left-sm padding-bottom-mmd">@if($notifications->count()){{ $notifications->count() }}@endif</span>
        </a>
        <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">
            <div class="notification-heading">
                <h4 class="menu-title dLabel">Notifications</h4>
                <a href="{{ url('/notifications') }}">
                    <h4 class="menu-title pull-right">View all
                        <i class="fa fa-arrow-circle-right margin-left-sm"></i>
                    </h4>
                </a>
            </div>
            @if ($notifications->count())
                <div class="notifications-wrapper">
                    <a class="content view-notification" href="#">
                        <div class="notification-item">
                            <h4 class="item-title">{{ $notifications->team->name }}
                                <small>{{ $notifications->created_at->diffForHumans() }}</small>
                            </h4>
                            <p class="item-info">$notifications->subject </p>
                        </div>  
                    </a>
                </div>
            @else
                <div class="notifications-wrapper padding-top-sm padding-bottom-sm text-center">
                    You don't have any notifications
                </div>
            @endif
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" id="dLabel" class="dropdown-toggle" role="button" data-toggle="dropdown">
            <span class="text-info fa fa-envelope"></span>
            <span class="badge info margin-left-sm padding-bottom-mmd">@if($unread_messages->count()){{ $unread_messages->count() }}@endif</span>
        </a>
        <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">
            <div class="notification-heading">
                <h4 class="menu-title dLabel">Messages</h4>
            </div>
            @if ($unread_messages->count())
                <div class="notifications-wrapper">
                    <a class="content view-message" href="#">
                        <div class="notification-item">
                            <h4 class="item-title">{{ $unread_messages->sender->first_name }}
                                <small> {{ $unread_messages->created_at->diffForHumans() }}</small>
                            </h4>
                            <p class="item-info">{{ $unread_messages->subject }}</p>
                        </div>  
                    </a>
                </div>
            @else
                <div class="notifications-wrapper padding-top-sm padding-bottom-sm text-center">
                    You don't have any new messages
                </div>
            @endif
        </ul>
    </li>

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
