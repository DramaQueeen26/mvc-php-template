$(document).ready(function() {

    // AJAX FORM

	$('form').submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var response = $('.response');
        var action = form.attr('action');
        var method = form.attr('method');
        var formdata = new FormData(this);
        var loading = $(".spinner-grow");
        var button = $('.form button');

        button.hide();
        loading.removeClass('visually-hidden');
        
        $.ajax({
            type: method,
            url: action,
            data: formdata ? formdata : form.serialize(),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                loading.addClass('spinner-grow text-primary visually-hidden');
                button.show();
                response.html(data);
            },
            error: function (data) {
                loading.addClass('spinner-grow text-primary visually-hidden');
                button.show();
                response.html(data);
            }
        });
        return false;
    });

});