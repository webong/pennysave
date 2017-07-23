@extends('layouts.app')

@section('added_css')
    <link href="{{ asset('css/selectize.bootstrap3.css') }}" rel="stylesheet">
    @include('partials._togglecheckbox')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <h3 class="panel-heading text-center">Create Team</h3>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{ route('team-create') }}" id="form_with_amount">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label sr-only">Team Name</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Team Name" required autofocus>

                            @if ($errors->has('name'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                            @endif
                            <span class="help-block">Select A Name for the Team</span>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="amount" class="control-label sr-only">Amount</label>

                                <div class="input-group">
                                    <span class="input-group-addon no-border-right">&#x20A6;</span>
                                    <input id="amount" type="number" class="form-control no-border-left no-border-right" placeholder="Amount" name="amount" pattern="[0-9]*" data-politespace data-grouplength="3" data-delimiter="," data-reverse value="{{ old('amount') }}">
                                    <span class="input-group-addon no-border-left">.00</span>
                                </div>

                                @if ($errors->has('amount'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('amount') }}</strong>
                                  </span>
                                @endif
                                <span class="help-block">Amount To Be Contributed By Members</span>
                            </div>

                            <div class="col-md-6 form-group{{ $errors->has('participants') ? ' has-error' : '' }}">
                                <label for="participants" class="control-label sr-only">Participants</label>

                                <input id="participants" type="number" class="form-control" placeholder="Number of Participants" name="participants" value="{{ old('participants') }}">

                                @if ($errors->has('participants'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('participants') }}</strong>
                                  </span>
                                @endif
                                <span class="help-block">Estimated Number of Participants (Can Be Changed Later)</span>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('recurrence') ? ' has-error' : '' }}">
                            <label for="recurrence" class="control-label sr-only">Payment Intervals</label>

                            <select name="recurrence" data-placeholder="Select Payment Interval" class="single-select form-control">
                                <option></option>
                                @foreach($recurrence as $current)
                                    <option value="{{ $current->id }}"
                                        @if (old('recurrence') == $current->id) {{ ' selected' }}@endif> {{ $current->period }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('recurrence'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('recurrence') }}</strong>
                              </span>
                            @endif
                            <span class="help-block">Set The Payment Interval</span>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                                <label for="start_date" class="control-label sr-only">Start Date</label>

                                <input id="start_date" type="date" class="form-control date" placeholder="Start Date" name="start_date" value="{{ old('start_date') }}" required>

                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block">Select A Tentative Date For Commencement</span>
                            </div>
                            <div class="col-md-6 form-group start-date-auto padding-top-lg">
                                <div class="block-switch">
                                    <input id="toggle-flat" class="toggle toggle-flat" type="checkbox" name="auto_start_date">
                                    <label for="toggle-flat" id="start-date-label" data-on="Yes" data-off="No" title="Set Plan To Automatically Generate Members Payment Hierarchy and Start Plan on The Selected Start Date"></label>
                                </div>
                                <p class="help-block" id="date-picker-help-text">Auto Start on Start Date</p>
                            </div>
                        </div>

                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary btn-lg center-block">
                                Create Team
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('added_js')
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/selectize.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $("select").selectize({
                closeAfterSelect: true
            });

            $('#start_date').datepicker({
                onSelect: function() {
                    $(this).change();
                }    
            }).on("change", function() {
                display("Auto Start on <strong>" + moment($('#start_date').val()).format('ddd[.] Do MMM[,] YYYY') + "<br /><p class='text-center'> (" + moment($('#start_date').val()).fromNow() + ")</p></strong>");
            });
        });

        function display(msg) {
            $("#date-picker-help-text").html(msg);
            $('#start-date-label').attr('title', 'Set Plan To Automatically Generate Members Payment Hierarchy and Start Plan on The Selected Start Date: ' 
            + moment($('#start_date').val()).format('ddd[.] Do MMM[,] YYYY') + " (" + moment($('#start_date').val()).fromNow() + "). You will be notified prior to actual start.");
        };

    </script>
@endsection
