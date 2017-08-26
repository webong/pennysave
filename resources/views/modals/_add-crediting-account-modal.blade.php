<div class="modal fade" id="add-crediting-account-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header no-border-bottom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title text-center bold" id="myModalLabel">Create Announcement</h4>
                </div>
                <div class="modal-body">
                    <form id="make-announcement-form">
                        <div class="form-group">
                            <label for="announce-subject" class="control-label">Select Bank</label>

                            <select name="bank" id="select-bank" data-placeholder="Select Bank" class="form-control">
                                <option></option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}"
                                        data-imagesrc="{{ asset(urldecode($bank->logo)) }}"> {{ $bank->name }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('bank'))
                            <span class="help-block">
                                <strong>{{ $errors->first('bank') }}</strong>
                            </span>
                            @endif
                            <span class="help-block">Set Your Bank</span>

                        </div>
                        <div class="form-group">
                            <label for="announce-content" class="control-label">Account Number</label>

                            <input type="number" name="account_number" class="form-control" placeholder="Account Number" />

                            @if ($errors->has('account_number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('account_number') }}</strong>
                            </span>
                            @endif
                            <span class="help-block">Enter Your Account Number</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer no-border-top">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="create-announcement">Send Announcement</button>
                </div>
            </div>
        </div>
    </div>
</div>