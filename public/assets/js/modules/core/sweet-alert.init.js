!function ($) {
    'use strict';

    var SweetAlert = function () { };

    SweetAlert.prototype.errorHandler = function (error, singleInput = false) {
        $('.form-control').each(function (index, value) {
            $(this).css("border-color", "");
        });

        var errors = {};
        var message = undefined;
        var defaultMessage = 'Something went wrong please try again.';

        if (error.message) {
            message = error.message;
            errors = error.errors;
        } else {
            if (!error.responseJSON) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: defaultMessage,
                });
                return 0;
            }

            message = error.responseJSON.message;
            errors = error.responseJSON.errors;
        }

        if (errors && Object.keys(errors).length) {
            var errorList = [], errorMsg = '';

            $.each(errors, function (index, value) {
                $('[name="' + index + '"]').css("border-color", "#f1556c");
                errorList.push(value);
                errorMsg += value + '<br/>';
            });

            var dispErrors = (singleInput !== false) ? errorList[0] : errorMsg;

            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: dispErrors,
            })
        } else if ($.trim(message) != '') {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: message,
            })
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: defaultMessage,
            });
        }
    }

    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery);