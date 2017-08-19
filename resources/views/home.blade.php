@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="dashboard-panel">
            <h1 class="page-heading text-info text-center">DASHBOARD<hr /></h1>
            <div class="row">
            <div class="col-md-6">
            <div class="section">
                <div class="page-header">
                    <h2 class="page-header-text text-header"><i class="fa fa-users">&nbsp;&nbsp;</i>
                        Teams &nbsp;&nbsp;<small>Savings with others</small>
                        @if ($user->group->count() > 0)
                            <div class="pull-right">
                                <a role="button" href="{{ url('/create-team') }}" class="btn btn-primary center-block">Create New Team</a>
                            </div>
                        @endif
                    </h2>
                </div>
                <div class="panel-body">
                    @if ($user->group->count() > 0)
                        @foreach ($user->group as $group)
                        <div class="col-sm-6 col-md-6">
                            <a href="{{ url('/teams/' . $group->id) }}" class="no-underline">
                                <div class="thumbnail">
                                    <div class="caption bg-white">
                                        <div class="{{ bg_status($group->status) }} group-caption text-center">
                                            <h3 class="text-center">{{ $group->name }}</h3>
                                        </div>
                                        <div class="thumbnail-footer">
                                            <div class="row">
                                                <div class="col-sm-5 border-right">
                                                    <h4 class="text-center">{{ $group->user()->count() }}<br /><small>@if ($group->user()->count() == 1) Member @else Members @endif</small></h4>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h4 class="text-center">{{ number_format($group->amount) }}<br /><small>{{ $group->period->period }}</small></h4>
                                                </div>
                                            </div>
                                            <p class="margin-top-md"></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    @else
                        <h4 class="text-center">You do not have/belong to any team yet</h4>
                        <button role="button" onclick='window.location.href="{{ url('/create-team') }}"' class="btn btn-primary center-block">Create New Team</button>
                    @endif
                </div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="section">
                <div class="page-header">
                    <h2 class="page-header-text text-header"><i class="fa fa-user">&nbsp;&nbsp;</i>
                        Personal &nbsp;&nbsp;<small>Savings involving only You</small>
                        @if ($user->personal_save->count() > 0)
                            <div class="pull-right">
                                <a role="button" href="{{ url('/create-personal') }}" class="btn btn-primary center-block">Create New Plan</a>
                            </div>
                        @endif
                    </h2>
                </div>
                <div class="panel-body">
                    @if ($user->personal_save->count() > 0)
                        @foreach ($user->personal_save as $personal)
                            <div class="col-md-6">
                                <a href="{{ url('/personal/' . $personal->id) }}" class="no-underline">
                                    <div class="thumbnail">
                                        <div class="caption bg-white">
                                            <div class="text-center">
                                                <h3 class="text-center">{{ $personal->name }}</h3>
                                                <div class="col-sm-5 border-right">
                                                    <h4 class="text-center"><small><sup>Total So Far</sup></small><br />
                                                        <?php $total_so_far = $personal->save_record->sum('amount'); ?>
                                                        @if ($total_so_far == 0) {{ 0.00 }}
                                                        @else {{ number_format($total_so_far) }}
                                                        @endif
                                                    </h4>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h4 class="text-center"><small><sup>Target Amount</sup></small><br />{{ number_format($target_amount = $personal->target_amount) }}</h4>
                                                </div>
                                                <div class="{{ bg_status($personal->status) }} padding-bottom-xs">
                                                    <p class="sub-text"><sup>Percentage:</sup>&nbsp;<span class="text-warning">{{ round($total_so_far / $target_amount * 100, 2) }}<small>%</small></span></p>
                                                </div>
                                            </div>
                                            <div class="thumbnail-footer">
                                                <p class="text-center monthly-amount">{{ number_format($personal->instalment_amount) }}<small>/{{ $personal->recurrences->period }}</small></p>
                                                <p class="margin-top-md"></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <h4 class="text-center">You have not created any personal savings plans yet</h4>
                        <button role="button" onclick='window.location.href="{{ url('/create-personal') }}"' class="btn btn-primary center-block">Create New Savings Plan</button>
                    @endif
                </div>
            </div>
            </div>
            </div>
        </div>
    </div>
@endsection
