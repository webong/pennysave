<div class="section tab-pane" id="settings">
    <h3 class="box-title text-center invite-heading margin-bottom-md">Settings<br /><small>Manage The Team</h3>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-8 col-md-offset-2">
            <form method="POST" action="{{ url('teams/'. $team->id .'/invite-members') }}" id="add_users_one_at_a_time">
                {{ csrf_field() }}

                <div class="contain-clone">
                    <div class="row item-to-clone padding-top-sm padding-bottom-sm border-radius-xs">
                        <div class="col-sm-6 col-xs-11 form-group no-bottom-margin has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
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
                            <div class="input-group">
                                <input type="phone" name="phone[]" class="form-control text_input clear-after no-border-right" value="{{ old('phone[0]') }}" placeholder="Phone">
                                <span class="input-group-addon input-addon-phone no-border-left" title="Invite Using Email Address"><i class="fa fa-envelope" ></i></span>
                            </div>
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    {{ $errors->first('phone') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-5 col-xs-11 form-group no-bottom-margin has-feedback {{ $errors->has('first_name') ? 'has-error' : '' }}">
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
                <textarea class="form-control countingdown" name="message" placeholder="Add Custom Invite Message (140 Characters Max)" maxlength="140" rows="2"></textarea>
                <span id="characters" class="bold"></span>
                <hr />
                <button class="btn btn-primary center-block" id="submit_invites_btn" name="send_invites" type="submit">Send Invitations</button>
            </form>

            <form method="POST" class="hidden" action="{{ url('teams/'. $team->id .'/invite-members') }}" id="add_several_users_at_once">
                {{ csrf_field() }}

                <div class="row">
                    <a href="#" class="custom-margin no-underline back_to_single_user pull-right" title="Add Another">Add one after another</a>
                </div>
                <div class="row">
                    <h4 class="text-info text-center">
                        You can Enter Your Email Address and Phone Numbers seperated by comma in whatever order <br />
                        (E.g.: example@email.com, 2348020000000, example2@email.com)<br />
                        <small class="help-block">Ensure Phone Number Are Written in International Format with Country Code</small>
                    </h4>
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

@section('added_js')
    <script>
        $('.add_another_user').click(function(evt) {
            evt.preventDefault()
            var item = $('.item-to-clone');
            var total = item.length;
            if (total < 5) {
                var cloned = item.first().clone(true);
                cloned.children('.remove_current_option').removeClass('hidden');
                cloned.find(".clear-after").val('');
                $('.contain-clone').append(cloned);
                if (! cloned.find('input[type="email"]')) {
                    cloned.find('input[type="phone"]').focus();
                } else {
                    cloned.find('input[type="email"]').focus();
                }
            } else {
                var message = 'You Can Only Send Five (5) Invitations At A Time';
                $('#error-message').html(message).removeClass('hidden').delay(5000).queue(function(n){
                    $('#error-message').addClass('hidden'); n();
                });
            }
        });

        $('.add_several_users').click(function (){
            $('#add_users_one_at_a_time').addClass('hidden');
            $('#add_several_users_at_once').removeClass('hidden');
        });

        $('.back_to_single_user').click(function (){
            $('#add_several_users_at_once').addClass('hidden');
            $('#add_users_one_at_a_time').removeClass('hidden');
        });

        $('.remove_current_option').click(function(evt) {
            evt.preventDefault();
            var toFocus = $(this).parent().prev();
            $(this).parent().remove();
            if (! toFocus.find('input[type="email"]')) {
                toFocus.find('input[type="phone"]').focus()
            } else {
                toFocus.find('input[type="email"]').focus();
            }
        });

        $('.remove_current_option').mouseover(function() {
            $(this).parent().addClass('bg-danger');
        });

        $('.remove_current_option').mouseout(function() {
            $(this).parent().removeClass('bg-danger');
        });

        $('.input-addon-email').click(function() {
            var mainParent = $(this).parents('div.form-group');
            mainParent.addClass('hidden');
            var emailInput = mainParent.next('div.form-group').find('.form-control');
            emailInput.val('');
            mainParent.next('div.form-group').removeClass('hidden');
            emailInput.focus();
        });
        $('.input-addon-phone').click(function() {
            var mainParent = $(this).parents('div.form-group');
            mainParent.addClass('hidden');
            var phoneInput = mainParent.prev('div.form-group').find('.form-control');
            phoneInput.val('');
            mainParent.prev('div.form-group').removeClass('hidden');
            phoneInput.focus();
        });
    </script>
@endsection
