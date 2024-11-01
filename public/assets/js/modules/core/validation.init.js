!function ($) {
    'use strict';

    var Validation = function () { };

    Validation.prototype.validateDate = function () {
        var dtToday = new Date(),
            month = dtToday.getMonth() + 1,
            day = dtToday.getDate(),
            year = dtToday.getFullYear();

        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        return year + '-' + month + '-' + day;
    }

    Validation.prototype.validateBirthDate = function () {
        var maxDate = this.validateDate();
        $('#inputDOB').attr('max', maxDate);
    }

    Validation.prototype.validateExpiryDate = function () {
        var maxDate = this.validateDate();
        $('#inputDOE').attr('min', maxDate);
    }

    Validation.prototype.validateKidLastName = function () {
        $('#inputFatherLastName').on('focusout', function () {
            var fLastName = $(this).val(),
                kLastName = $('[name="kid_last_name"]').val();

            if (fLastName !== kLastName) {
                var error = { errors: [], message: "Kid last name should be same as Father last name" };
                $(this).css("border-color", "#f1556c");
                $.SweetAlert.errorHandler(error, true);
            }
        });
    }

    Validation.prototype.init = function () {
        $.Validation.validateBirthDate()
        $.Validation.validateExpiryDate()
        $.Validation.validateKidLastName()
    }

    $.Validation = new Validation, $.Validation.Constructor = Validation
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Validation.init()
    }(window.jQuery);