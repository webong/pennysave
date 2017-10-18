<script type="text/javascript">
    $(document).ready(function () {
        var validation_message = $('#account-validate-msg');
        var account_name = $('#account-name');
        var account_no_group = $('#account-number-group');
        var validation_trigger = $('#validation-trigger');
        var account_name_group = $('#account-name-group');
        var icon = $('#account-number-group').find('i');
        var submitButton = $('#add-account');
        var input_account_name = $('#account-name-input');
        $('#validate-account-btn').click(function (evt) {
            evt.preventDefault();
            var bankCode = $('form#add-crediting-account-form .dd-selected-value').val();
            var accountNumber = $('form#add-crediting-account-form #account-number').val();
            $.ajax({
                method : "post",
                url	: 	"/payment/resolve-account-number",
                dataType: "json",
                data :  "account_number=" + accountNumber + "&bank_code=" + bankCode,
                success : function (response) {
                    try {
                        var data = JSON.parse(response);
                    } catch (e) {
                        var data = response;
                    }
                    if (data.status == false) {
                        if (validation_message.hasClass('alert-success')) {
                            validation_message.removeClass('alert-success');
                        }
                        if (account_no_group.hasClass('has-success')) {
                            account_no_group.removeClass('has-success');                    
                        }
                        if (! icon.hasClass('fa-check')) {
                            icon.removeClass('fa-check');
                        }
                        if (! icon.hasClass('fa-exclamation-triangle')) {
                            icon.addClass('fa-exclamation-triangle');
                        }
                        if (validation_message.hasClass('hidden')) {
                            validation_message.removeClass('hidden');
                        }
                        validation_message.addClass('alert-danger');
                        icon.removeClass('hidden');
                        account_no_group.addClass('has-error');
                        validation_message.html('Error Validating Account Details');
                    } else if (data.status == true) {
                        validation_trigger.hide();
                        icon.removeClass('hidden');
                        if (validation_message.hasClass('alert-danger')) {
                            validation_message.removeClass('alert-danger');
                        }
                        if (account_no_group.hasClass('has-error')) {
                            account_no_group.removeClass('has-error');                    
                        }
                        if (validation_message.hasClass('hidden')) {
                            validation_message.removeClass('hidden');
                        }
                        validation_message.addClass('alert-success');
                        if (icon.hasClass('fa-exclamation-triangle')) {
                            icon.removeClass('fa-exclamation-triangle');
                        }
                        if (! icon.hasClass('fa-check')) {
                            icon.addClass('fa-check');
                        }
                        account_no_group.addClass('has-success');
                        validation_message.html('Account Validated');
                        account_name.html(data.data.account_name);
                        input_account_name.val(data.data.account_name);
                        account_name_group.removeClass('hidden');
                        submitButton.prop('disabled', false);
                    }
                },
                error : function (response) {
                    var data = response.responseJSON;
                    var message = '';
                    if (data.hasOwnProperty("account_number")) {
                        for (var i = 0; i < data.account_number.length; i++) {
                            message += '<span class="block">' + data.account_number[i] + '</span>';
                        }
                    }
                    if (data.hasOwnProperty("bank_code")) {
                        for (var i = 0; i < data.bank_code.length; i++) {
                            message += '<span class="block">' + data.bank_code[i] + '</span>';
                        }
                    }
                    if (icon.hasClass('fa-check')) {
                        icon.removeClass('fa-check');
                    }
                    if (! icon.hasClass('fa-exclamation-triangle')) {
                        icon.addClass('fa-exclamation-triangle');
                    }
                    validation_message.addClass('alert-danger');
                    if (validation_message.hasClass('hidden')) {
                        validation_message.removeClass('hidden');
                    }
                    account_no_group.find('i').removeClass('hidden');
                    account_no_group.addClass('has-error');
                    validation_message.html(message);
                }
            });
        });

        $('.modal .form-group').on('change', function () {
            account_name_group.addClass('hidden');
            validation_trigger.show();
            if (validation_message.hasClass('alert-danger') || validation_message.hasClass('alert-success')) {
                validation_message.removeClass('alert-danger');
                validation_message.removeClass('alert-success');
            }
            if (account_no_group.hasClass('has-error') || account_no_group.hasClass('has-success')) {
                account_no_group.removeClass('has-error');                 
                account_no_group.removeClass('has-success');                 
            }
            icon.removeClass('fa-exclamation-triangle');
            icon.removeClass('fa-check');
            if (! validation_message.hasClass('hidden')) {
                validation_message.addClass('hidden');
            }
            validation_message.html('');
            account_name.html('');
            input_account_name.val('');
            submitButton.prop('disabled', true);
        });

        var count = 0; // Initialized when Page Loads first time
        $('.account-section').on('change', function(event) {
            var initialized = $('.account-section .dd-selected').length;
            /* 
             * Incremented for each change triggered.
             * Usually, depending on number of .dd-selected on page, within .account-section, 
             * it is triggered on each ddslick function initialization. So to avoid running 
             * this function immediately, the count has to be greater than this triggers caused
             * by ddslick
             */
            count++;
            if (count <= initialized) {
                return;
            }
            if (submitSelection(event)) {
                handleSelection(event);
            }
        });

        function handleSelection(event) {
            var parent = $(event.currentTarget);
            var selected = parent.find('.dd-selected-value').val();
            var displayed = parent.find('.view-account-types');
            $.each(displayed, function (index, value) {
                if (! $(value).hasClass('hidden')) {
                    $(value).addClass('hidden');
                }
            });
            parent.find('.view-account-types#' + selected).removeClass('hidden');
            parent.find('.account-selection').addClass('hidden');
            parent.find('.change-selection').removeClass('hidden');
        }

        function submitSelection(event) {
            var parent = $(event.currentTarget)
            var form = parent.find('.account-form');
            console.log(form);
            var accountType = parent.hasClass('debit-section') ? 'Debiting Account' : 'Crediting Account';
            var saveselection = $.ajax({
                method : "post",
                url : '/teams/{{ $team->id }}/set-payment',
                data :  form.serialize(),
                success : function(response) {
                    console.log(response);
                    if ($('.account-info')) $('.account-info').addClass('hidden');
                    var type = (response == 'success') ? 'success' : 'danger';
                    var message = (response == 'success') ? accountType + ' has been updated' : accountType + ' failed to update';
                    $.alert(message, {
                        type: type,
                        position: ['top-right', [0,0]],
                        closeTime: 15000,
                        minTop: 55
                    });
                    return true;
                },
                error : function(response) {
                    var data = response.responseJSON;
                    console.log(data);
                    message = accountType + ' failed to update';
                    $.alert(message, {
                        type: 'danger',
                        position: ['top-right', [0,0]],
                        closeTime: 15000,
                        minTop: 55
                    });
                    return false;
                }
            });
            return saveselection;
        }

        $('.change-selection').click(function () {
            var btnParent = $(this).parent();
            $.each(btnParent.next('.view-account-types'), function(index, value) {
                if (! value.hasClass('hidden')) {
                    value.addClass('hidden');
                }
            });
            btnParent.next('.account-selection').removeClass('hidden');
            $(this).addClass('hidden');
        });

        $('#add-account').click(function () {
            $('#add-crediting-account-form').submit();
        });
    });

</script>