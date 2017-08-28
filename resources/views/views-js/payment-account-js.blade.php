<script type="text/javascript">
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
                    validation_message.addClass('alert alert-danger padding-round-sm margin-bottom-md margin-top-xs');
                    icon.removeClass('hidden');
                    account_no_group.addClass('has-error');
                    validation_message.html('Error Validating Account Details');
                } else if (data.status == true) {
                    validation_trigger.hide();
                    if (validation_message.hasClass('alert-danger')) {
                        validation_message.removeClass('alert-danger');
                    }
                    if (account_no_group.hasClass('has-error')) {
                        account_no_group.removeClass('has-error');                    
                    }
                    icon.removeClass('fa-exclamation-triangle');
                    icon.addClass('fa-check');
                    account_no_group.addClass('has-success');
                    validation_message.addClass('alert-success');
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
                if (! icon.hasClass('fa-check')) {
                    icon.removeClass('fa-check');
                }
                if (! icon.hasClass('fa-exclamation-triangle')) {
                    icon.addClass('fa-exclamation-triangle');
                }
                validation_message.addClass('alert alert-danger padding-round-sm margin-bottom-md margin-top-xs');
                account_no_group.find('i').removeClass('hidden');
                account_no_group.addClass('has-error');
                validation_message.html(message);
            }
        });
    });

    $('.modal .form-group').on('change', function () {
        console.log('A New Change Triggered');
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
        validation_message.html('');
        account_name.html('');
        input_account_name.val('');
        submitButton.prop('disabled', true);
    });

    $('#validate-account-btn').change(function () {
        console.log('Change Triggered');
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
        validation_message.html('');
        account_name.html("");
        input_account_name.val(data.data.account_name);
        submitButton.prop('disabled', true);
    });

    $('#add-account').click(function () {
        $('#add-crediting-account-form').submit();
    });
</script>