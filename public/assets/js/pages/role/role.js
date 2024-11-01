$("#allPermissionCheck").on('click', function(){
    if($(this).is(":checked")) {
        $(".permission-check").prop('checked', true);
    } else {
        $(".permission-check").prop('checked', false);
    }
});

$(".module-permission").on('click', function(){
    $module = $(this).data('module');
    if($(this).is(":checked")) {
        $("." + $module + "-permission").prop('checked', true);
    } else {
        $("." + $module + "-permission").prop('checked', false);
    }
});