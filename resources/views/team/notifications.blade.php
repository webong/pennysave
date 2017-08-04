<div class="section tab-pane" id="notifications">
    <h3 class="box-title text-center invite-heading margin-bottom-md">Notifications<br /></h3>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-8 col-md-offset-2">
            <form method="POST" action="{{ url('teams/'. $team->id .'/invite-members') }}" id="add_users_one_at_a_time">
                {{ csrf_field() }}
                
                <h5 class="text-info text-center">
                    You can invite up to Five (5) Persons at a time Individually<br />
                    To invite using Phone Number, click the <span class="fa fa-mobile padding-left-sm padding-right-sm"></span> on the Email Textbox<br />
                    To invite several persons at once, use the <code>Bulk Invite</code> link
                </h5>
                
                <div class="contain-clone">
                    <div class="row item-to-clone padding-top-sm padding-bottom-sm border-radius-xs">
                        <div class="col-sm-6 col-xs-11 form-group no-bottom-margin has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label class="control-label">Email</label>

                            <div class="input-group">
                                <input type="email" name="email[]" class="form-control text_input clear-after no-border-right" value="{{ old('email[0]') }}" placeholder="Email">
                                <span class="input-group-addon input-addon-email padding-left-right-phone no-border-left" title="Invite Using Phone Number"><i class="fa fa-mobile"></i></span>
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-sm-6 col-xs-11 form-group no-bottom-margin has-feedback hidden {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label class="control-label">Phone</label>
                            
                            <div class="input-group">
                                <div class="input-group-btn country-select">
                                    <select id="countries" name="countries" class="btn input-group-addon" placeholder="Country" title="Select Country">
                                        <option></option>
                                        @if (isset($countries))
                                            @foreach ($countries as $key => $country)
                                                <option value="{{ $key }}" @if($key == 'NG'){{ 'selected' }}@endif>{{ $key . '&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;' . $country }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <input type="phone" name="phone[]" class="form-control text_input clear-after no-border-right no-border-left" value="{{ old('phone[0]') }}" placeholder="Phone">
                                <span class="input-group-addon input-addon-phone no-border-left" title="Invite Using Email Address"><i class="fa fa-envelope" ></i></span>
                            </div>
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    {{ $errors->first('phone') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-5 col-xs-11 form-group no-bottom-margin has-feedback {{ $errors->has('first_name') ? 'has-error' : '' }}">
                            <label class="control-label">First Name (Optional)</label>
                            
                            <input type="text" name="first_name[]" class="form-control text_input clear-after" value="{{ old('first_name[0]') }}" placeholder="First Name (Optional)">
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    {{ $errors->first('first_name') }}
                                </span>
                            @endif
                        </div>
                        <a href="#" class="remove_current_option no-underline text-danger hidden" title="Remove">&times;</a>
                    </div>
                </div>
                <div class="add-more-contain">
                    <a href="#" class="no-underline add_another_user" title="Add Another">Add another</a>
                    <span>or</span> <a href="#" class="no-underline add_several_users" title="Add Several At Once">Bulk Invite</a>
                </div>
                <div class="form-group">
                    <label for="single-message" class="control-label">Custom Invite Message (Optional)</label>
                    <textarea class="form-control countingdown" name="message" placeholder="Add Custom Invite Message (140 Characters Max)" maxlength="140" rows="2"></textarea>
                    <span id="characters" class="bold"></span>
                </div>
                <hr />
                <button class="btn btn-primary center-block" id="submit_invites_btn" name="send_invites" type="submit">Send Invitations</button>
            </form>

            <form method="POST" class="hidden" action="{{ url('teams/' . $team->id . '/invite-members-list') }}" id="add_several_users_at_once">
                {{ csrf_field() }}

                <div class="row">
                    <a href="#" class="custom-margin no-underline back_to_single_user pull-right" title="Add Another">Add one after another</a>
                </div>
                <div class="row">
                    <h5 class="text-info text-center">
                        You can Enter Your Email Address and Phone Numbers seperated by comma in whatever order <br />
                        (E.g.: example@email.com, 2348020000000, example2@email.com)<br />
                        <span class="help-block text-gray">Ensure Phone Number Are Written in International Format with Country Code</span>
                    </h5>
                </div>

                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <textarea class="form-control add-user-details" name="emails" placeholder="Emails or Phone Numbers Seperated by comma" rows="4"></textarea>
                    @if ($errors->has('emails'))
                        <span class="help-block">
                            {{ $errors->first('emails') }}
                        </span>
                    @endif
                </div>
                <textarea class="form-control countingdown" name="message" placeholder="Add Custom Invite Message (140 Characters Max)" maxlength="140" rows="2"></textarea>
                <span id="characters" class="bold"></span>
                <hr />
                <button class="btn btn-primary center-block" id="submit_invites_btn" name="send_invites" type="submit">Send Invitations</button>
            </form>
        </div>
    </div>
</div>