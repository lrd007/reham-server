$baseUrl = $("#baseUrl").val();
$dataTable = '';
$modal = $('#baseModal');
$isAr = $("#local").val() == 'ar';
$tableLanguage = {
    "emptyTable":     "لا توجد بيانات متوفرة في الجدول",
    "info":           "إظهار _START_ إلى _END_ من _TOTAL_ من الإدخالات",
    "infoEmpty":      "إظهار 0 إلى 0 من 0 مدخلات",
    "infoFiltered":   "(تمت تصفيته من إجمالي إدخالات _MAX_)",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "إظهار إدخالات _MENU_",
    "loadingRecords": "تحميل...",
    "processing":     "يعالج...",
    "search":         "بحث:",
    "zeroRecords":    "لم يتم العثور على سجلات مطابقة",
    "paginate": {
        "first":      "أولاً",
        "last":       "آخر",
        "next":       ">",
        "previous":   "<"
    },
    "aria": {
        "sortAscending":  ": تفعيل لفرز العمود تصاعديا",
        "sortDescending": ": تفعيل لفرز العمود تنازليًا"
    }
};

$(".collapse:not(:has(li))").each(function(){
    $(this).closest('li').remove()
});

$(document).on('change keypress', '.form-control, .form-check-input', function () {
    $(this).css("border-color", "");
    $(this).closest(".validation-message").remove();
    $(this).siblings(".validation-message").remove();
});

function disableButton(self) {
    $loadingText = $(self).attr('data-loading-text');
    $html = $(self).html();
    $html = $html.indexOf('<div') !== -1 ? $html.substr(0, $html.indexOf('<div')) : $html;
    $(self).prop('disabled', true);
    $(self).attr('data-original-text', $html);
    $spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    if (!$loadingText) {
        $loadingText = $spinner;
    }
    $(self).html($loadingText);
}

function enableButton(self) {
    $text = $(self).attr('data-original-text');
    $(self).html($text);
    $(self).prop('disabled', false);
}

$.ajaxSetup({
    headers: {
        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content")
    }
});

// Events & Function 
$(".excel-import").click(function () {
    $(".row.bg-light").toggle();
});

$(".data-table").length > 0 && $(".data-table").each(function () {
    var e = $(this).attr("id");
    var gridElement = $("#" + e);

    $dataTable = gridElement.DataTable({
        serverSide: false,
        processing: true,
        responsive: false,
        stateSave: true,
        ajax: {
            url: gridElement.attr("data-table-source"),
            type: "post",
        },
        language: $isAr ? $tableLanguage : {}
    });
});

function removeErrors() {
    $('.form-control').each(function (index, value) {
        $(this).css("border-color", "");
    });
    $(".validation-message").remove();
}

function errorHandler(error) {
    
    removeErrors();
    $msg =  $isAr ? 'حدث خطأ ما. أعد المحاولة من فضلك.' : 'Something went wrong please try again.';

    if (error.message) {
        $message = error.message;
        $errors = error.errors;
    } else {
        if (!error.responseJSON) {
            if(error.status == 403) {
                $msg = $isAr ? 'هذا الإجراء غير مصرح به.' : 'This action is unauthorized.';
            }
            toastr.error($msg);
            return 0;
        }

        $message = error.responseJSON.message;
        $errors = error.responseJSON.errors;
    }

    if($errors && Object.keys($errors).length) {
        $errorList = '';    
        $.each($errors, function(index, value) {
            $('[name="'+ index +'"]').css("border-color", "#f1556c");
            $('[name="'+ index +'"], [name="'+ index +'[]"]').closest('div:not(.form-check-inline, .custom-checkbox)').append('<span class="d-block text-danger validation-message">'+ value +'</span>');
            $errorList += value + '<br/>';
        });
        toastr.error($errorList);
    } else if ($.trim($message) != '') {
        toastr.error($message);
    } else {
        toastr.error($msg);
    }
}

function modalSpinner() {
    return '<div class="modal-body p-4">' +
        '<div class="row d-flex justify-content-center">' +
        '<div class="spinner" role="status"></div>' +
        '</div>' +
        '</div>';
}

$(document).on('click', ".modal-button", function () {
    $url = $(this).attr('data-url');
    $modalContent = $modal.find('.modal-content');
    $modalContent.html(modalSpinner());
    $modal.modal('show');

    if ($url) {
        $.ajax({
            method: 'GET',
            url: $url,
            dataType: "html",
            success: function (response) {
                $modalContent.html(response);
                if(response.indexOf('select2') != -1 && response.indexOf('ajax-select') == -1){
                    $('.select2').select2({
                        placeholder: $(this).data('placeholder') ?? "Select"
                    });
                }
                
                if(response.indexOf('date-time') != -1) {
                    $('.date-time').flatpickr({
                        enableTime: true,
                        dateFormat: "Y-m-d H:i"
                    });
                }
            },
            error: function(error) {
                errorHandler(error);
                $modal.modal('hide');
            }
        })
    }
});

$(document).on('click', '.add-value-box', function () {
    $row = '<tr ><td>' +
        '<input type="text" name="attribute_values[]" class="form-control mt-2" placeholder="Attribute Value">' +
        '</td>' +
        '<td class="text-right">' +
        '<button type="button" class="btn btn-danger mt-2" onclick="removeDynamicRow(this)">-</button>' +
        '</td></tr>';

    $("#baseModal #attributeValues").append($row);
});

$(document).on('click', '#baseModal .save-button, .global-save', function () {
    $this = $(this);
    disableButton($this);
    $form = $(this).closest('form');
    $action = $form.attr('action');
    $redirection = $form.attr('data-redirection');
    $method = 'post';
    
    if ($action) {
        $.ajax({
            type: $method,
            url: $action,
            data: new FormData($form[0]),
            dataType: 'json',
            processData: false,
            contentType: !1,
            success: function (response) {
                $successMessage = $isAr ? 'حفظ بنجاح.' : 'Saved Successfully.'
                toastr.success($successMessage);
                removeErrors()
                if(response.redirection) {
                    window.location.replace(response.redirection);
                }
                if($redirection) {
                    window.location.replace($redirection);
                }
                if ($dataTable) {
                    $dataTable.draw();
                }
                $modal.modal('hide');
                enableButton($this);
            },
            error: function (error) {
                errorHandler(error);
                enableButton($this);
            }
        })
    }
});

function reloadDatatable() {
    $dataTable.draw();
}

$(document).on('click', '.delete-button, .recover-button', function () {

    $self = $(this);
    $icon = 'warning';
    $text = $isAr ? "لن تتمكن من استرداد هذا!" : "You won't be able to recover this!";
    $confirmButtonText = $isAr ? "حذف" : 'Delete';
    $confirmButtonClass = 'important-btn-danger';

    if($self.hasClass('recover-button')) {
        $icon = 'info';
        $text = $isAr ? "هل ترغب في استعادة هذا!" : 'Would you like to recover this!';
        $confirmButtonText = $isAr ? "استعادة" : 'Recover';
        $confirmButtonClass = 'important-btn-success';
    } else if($self.hasClass('soft-delete-button')) {
        $text = $isAr ? "هل ترغب في أرشفة هذا!" : 'Would you like to archive this!';
        $confirmButtonText = $isAr ? "أرشيف" : 'Archive';
        $confirmButtonClass = '';
    }

    Swal.fire({
        title:  $isAr ? "هل أنت واثق؟" : "Are you sure?",
        text: $text,
        icon: $icon,
        showCancelButton: !0,
        confirmButtonText : $confirmButtonText,
        cancelButtonText: $isAr ? "يلغي" : "Cancel",
        customClass: {
            confirmButton: $confirmButtonClass
        }

    }).then(function (e) {
        if (e.value) {
            disableButton($self);
            $form = $self.closest('form');
            $action = $form.attr('action');
            $dataLoad = $form.attr('data-load');
            $dataTarget = $form.attr('data-target');
            $dataCallbackFunction = $form.attr('data-callback-function');

            $.ajax({
                type: 'POST',
                url: $action,
                data: $form.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status = 'success') {
                        if ($dataLoad == 'true') {
                            window.location.reload();
                        } else {
                            if ($dataTarget) {
                                $self.closest($dataTarget).remove();
                            }

                            if ($dataCallbackFunction) {
                                var callbackFunction = window[$dataCallbackFunction];
                                callbackFunction();
                            }
                        }
                    }
                    enableButton($self);
                },
                error: function (error) {
                    errorHandler(error);
                    enableButton($self);
                }
            });
        }
    });
});

$(document).on('change', ".status-switch", function () {
    $form = $(this).closest('form');
    $dataCallbackFunction = $form.attr('data-callback-function');
    $self = $(this);

    $.ajax({
        type: 'POST',
        url: $form.attr('action'),
        data: $form.serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status = 'success' && $dataCallbackFunction) {
                var callbackFunction = window[$dataCallbackFunction];
                callbackFunction();
            }
            enableButton($self);
        },
        error: function (error) {
            errorHandler(error);
            enableButton($self);
        }
    });
});

$(document).on('change', ".status-switch2", function () {
console.log('Yes Muhammad');
    $form = $(this).closest('form');
    $dataCallbackFunction = $form.attr('data-callback-function');
    $self = $(this);

    $.ajax({
        type: 'POST',
        url: $form.attr('action'),
        data: $form.serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status = 'success' && $dataCallbackFunction) {
                var callbackFunction = window[$dataCallbackFunction];
                callbackFunction();
            }
            enableButton($self);
        },
        error: function (error) {
            errorHandler(error);
            enableButton($self);
        }
    });
});

var $tableUrl = $("table").data('table-source');
var $queryString = '';
$(document).on('click', ".apply-button-filter", function () {
    $tableUrl = $tableUrl.split('?')[0];
    $queryString = $(this).closest('form').serialize();
    $url = $tableUrl + '?' + $queryString;
    $dataTable.ajax.url($url).load();
    $modal.modal('hide');
});

$("#exportButtonDrop a").click(function () {
    window.open($(this).data('href') + "?" + $queryString);
});
