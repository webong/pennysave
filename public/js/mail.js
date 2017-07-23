$(document).ready(function(){ 
    $('#inputSenderList').bind('select', function () {
        var userId = $(this).val();
        var countOccurrence = 0;
        var allUsers = 0;
        $(this).val('');
        var ifExist = $('.thumbnail-mail-span').each(function(index, item) {
            var currentItem = $(item).data('name');
            if (currentItem == userId) {
                countOccurrence++;
                return true;
            }
            if (currentItem == 'All Users') {
                allUsers = 1;
            }
            return true;
        });
        if (countOccurrence > 0) {
            var intended = (userId == 'All Users') ? 'Option' : 'User';
            $('#addedPreviously').html('You Have Added This '+ intended +' Already');
            $('#addedPreviously').removeClass('hidden').delay(2000).queue(function(n){
                $('#addedPreviously').addClass('hidden'); n();
            });
            return;
        }
        if (allUsers == 1) {
            // Check that All Users has been previously selected and disallow individual selection
            $('#addedPreviously').html('You Can\'t Add Single Individuals Until You Remove <b>All Users</b>');
            $('#addedPreviously').removeClass('hidden').delay(5000).queue(function(n){
                $('#addedPreviously').addClass('hidden'); n();
            });
            return;
        }
        if (userId == 'All Users') {
            var generatingElement = '<span class="thumbnail-mail-span" data-name="'+ userId +'" id="'+ userId +'"><img class="thumbnail-width-img" src="../img/generic.png" class="thumbnail-mail-img" /><span>'+ userId +'</span><span class="btn-closeUserDetails" title="Remove This User" >&times;</span></span>';
            $('#senderDetails').html(generatingElement);
            return;
        }
       var obj = $('#users option').each(function(index, item) {
            if ($(item).val() == userId) {
                var generatingElement = '<span class="thumbnail-mail-span" data-name="'+ userId +'" id="'+ $(item).data('value') +'"><img class="thumbnail-width-img" src="../'+ $(item).data('img') +'" class="thumbnail-mail-img" /><span>'+ $(item).data('name') +'</span><span class="btn-closeUserDetails" title="Remove This User" >&times;</span></span>';
                $('#senderDetails').append(generatingElement);
            }
        });
    });

    $('.mailSubmission').click(function(evt) {
        evt.stopPropagation();
        var listOfSenders = '';
        $('.thumbnail-mail-span').each(function(index, item) {
            listOfSenders += $(item).attr('id') + ';';
        });
        var finalList = listOfSenders.slice(0,-1);
        $('#mailMessageForm').val(finalList);
        $('#mailMessageSubmit').val($(this).attr('id')); 
        $('#mailMessageSubmit').trigger('click');
    });

    $('#divContentEditable').on("click", ".btn-closeUserDetails", function() {
        $(this).parent().remove();
    });

    $('.messageStarred').on('click', function(){
        alert('Clicked');
        var messageId = $(this).data('value');
        console.log(messageId);
        $.ajax({
            url: "/messages/change/starred",
            method: 'POST',
            data: {id:messageId},
            success: function(result) {
                console.log(result);
                if (result.value == 0) {
                    $(this).removeClass('fa-star');
                    $(this).addClass('fa-star-o');
                } else {
                    $(this).removeClass('fa-star-o');
                    $(this).addClass('fa-star');    
                }
            },
            error: function(error) {
                console.log(error);
            }
        });


    });

});

