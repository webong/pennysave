<div class="modal fade" id="add-crediting-account-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header no-border-bottom padding-bottom-xs">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title text-center bold" id="myModalLabel">Add Account</h4>
                </div>
                <div class="modal-body">
                    <form id="add-crediting-account-form" method="post" action="/teams/{{ $team->id }}/save-account-number">
                        {{ csrf_field() }}

                        <div class="bold text-center alert padding-round-sm margin-bottom-md margin-top-xs hidden" id="account-validate-msg"></div>
                        
                        <div class="form-group">
                            <label for="select-bank" class="control-label">Select Bank</label>

                            <select name="bank" id="select-bank" data-placeholder="Select Bank" class="form-control">
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->code }}"
                                        data-imagesrc="{{ asset(urldecode($bank->logo)) }}">{{ $bank->name }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('bank'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bank') }}</strong>
                                </span>
                            @else
                                <span class="help-block">Select Your Bank</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="account-number" class="control-label">Account Number</label>

                            <div class="input-group" id="account-number-group">
                                <input type="text" id="account-number" name="account_number" maxlength="10" class="form-control no-border-right" placeholder="Account Number" />
                                <span class="input-group-addon no-border-left">
                                    <i class="fa fa-exclamation-triangle hidden"></i>
                                </span>
                            </div>

                            @if ($errors->has('account_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('account_number') }}</strong>
                                </span>
                            @else
                                <span class="help-block">Enter Your Account Number</span>
                            @endif
                        </div>
                        <div id="validation-trigger">
                            <button class="btn btn-info btn-sm center-block" id="validate-account-btn">Validate Account Details</button>
                            <div class="text-xs text-info text-center">You need to validate your account before it is added.</div>
                        </div>

                        <div class="form-group hidden" id="account-name-group">
                            <label for="account-name" class="control-label">Account Name</label>
                            <p class="form-text" id="account-name"></p>
                            <input type="hidden" id="account-name-input" name="account_name" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer no-border-top padding-top-sm">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="add-account" disabled>Add Account</button>
                </div>
            </div>
        </div>
    </div>
</div>