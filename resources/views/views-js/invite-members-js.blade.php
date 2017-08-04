<script src="{{ asset('js/selectize.min.js') }}"></script>
<script>
    var cloned_counter = 1;
    $(function () {
        $('.add_another_user').click(function(evt) {
            evt.preventDefault();
            var item = $('div.item-to-clone');
            cloned_counter++;
            if (cloned_counter <= 5) {
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
                cloned_counter--;
                var message = 'You Can Only Send Five (5) Invitations At A Time';
                $('#error-message').html(message).removeClass('hidden').delay(5000).queue(function(n){
                    $('#error-message').addClass('hidden'); n();
                });
            }
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
            cloned_counter--;
        });

        $('.add_several_users').click(function () {
            $('#add_users_one_at_a_time').addClass('hidden');
            $('#add_several_users_at_once').removeClass('hidden');
        });

        $('.back_to_single_user').click(function () {
            $('#add_several_users_at_once').addClass('hidden');
            $('#add_users_one_at_a_time').removeClass('hidden');
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
    });
</script>