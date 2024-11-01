!function(r){"use strict";function t(){this.$body=r("body")}t.prototype.init=function(){r('[data-plugin="dragula"]').each(function(){var t=r(this).data("containers"),a=[];if(t)for(var n=0;n<t.length;n++)a.push(r("#"+t[n])[0]);else a=[r(this)[0]];var i=r(this).data("handleclass");i?dragula(a,{moves:function(t,a,n){return n.classList.contains(i)}}):dragula(a)})},r.Dragula=new t,r.Dragula.Constructor=t}(window.jQuery),function(){"use strict";window.jQuery.Dragula.init()}();

$('.select2').select2({
    placeholder: $(this).data('placeholder') ?? "Select"
});
$('.date-time').flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i"
});

$(document).on("click", ".post-or-schedule", function(){
    $val = $(this).val();
    $val == 1 ? $("#schedule").closest('.row').show() : $("#schedule").closest('.row').hide();
});

$questionNo = $("#question_count").val() ?? 1;
$(".add-question").click(function() {
    console.log($questionNo);
    $html = '';
    $type = $(this).data('type');
    
    $html += '<div class="row border-primary p-2 ml-1 mr-1 mb-2" style="border: 1px solid #ea8bb8">';
    $html += $("#questionBox").html();
    $html += $("#" + $type + 'AnswerBox').html();    
    
    $html = $html.replace('question_ar[]', 'question_ar[' + $questionNo + ']');
    $html = $html.replace('question_en[]', 'question_en[' + $questionNo + ']');    
    $html = $html.replace('marks[]', 'marks[' + $questionNo + ']');

    if($type == 'multiple') {
        while ($html.indexOf('correct_answer[]') != -1) {
            $html = $html.replace('correct_answer[]', 'correct_answer[' + $questionNo + ']');
        }
        
        $html += '<input type="hidden" name="question_type[' + $questionNo + ']" value="multiple">';
    }
    if($type == 'boolean') {
        while ($html.indexOf('boolean_answer[]') != -1) {
            $html = $html.replace('boolean_answer[]', 'boolean_answer[' + $questionNo + ']');
        }
        $html += '<input type="hidden" name="question_type[' + $questionNo + ']" value="boolean">';
    }
    if($type == 'check') {
        while ($html.indexOf('correct_answer[]') != -1) {
            $html = $html.replace('correct_answer[]', 'correct_answer[' + $questionNo + '][]');
        }
        
        $html += '<input type="hidden" name="question_type[' + $questionNo + ']" value="check">';
    }
    if($type != 'boolean') {
        while ($html.indexOf('answer_ar[]') != -1) {
            $html = $html.replace('answer_ar[]', 'answer_ar[' + $questionNo + '][]');
            $html = $html.replace('answer_en[]', 'answer_en[' + $questionNo + '][]');
        }
    }
    
    $html += '</div>';
    $("#questionAnswerBox").append($html);
    $questionNo++;

    var $target = $('html,body'); 
    $target.animate({scrollTop: $target.height()}, 1000);
});

$(document).on('click', ".remove-row", function () {
    $(this).closest('.row').remove();
});

$(document).on('change', "#course", function () {
    $ids = $(this).val();
    $("#chapter, #lesson").prop('disabled', true);
    $.ajax({
        type: 'GET',
        url: $baseUrl + '/chapter-by-course-ids?course_ids=' + $ids,
        dataType: 'json',
        success: function (response) {

            $row = '<option value=""></option>';
            if (response.status = 'success') {
                if (response.chapters) {
                    $.each(response.chapters, function (index, chapter) {
                        $row += '<option value="' + chapter.id + '">' + chapter.name + '</option >';
                    });
                }
                $("#chapter").html($row);
                $("#lesson").empty();
                $("#chapter, #lesson").prop('disabled', false);
            }
        },
        error: function (error) {
            errorHandler(error);
        }
    })
});

$(document).on('change', "#chapter", function () {
    $ids = $(this).val();
    $("#course, #lesson").prop('disabled', true);
    $.ajax({
        type: 'GET',
        url: $baseUrl + '/lesson-by-chapter-ids?chapter_ids=' + $ids,
        dataType: 'json',
        success: function (response) {

            $row = '';
            if (response.status = 'success') {
                if (response.lessons) {
                    $.each(response.lessons, function (index, lesson) {
                        $row += '<option value="' + lesson.id + '">' + lesson.name + '</option >';
                    });
                }
                $("#lesson").html($row);
                $("#course, #lesson").prop('disabled', false);
            }
        },
        error: function (error) {
            errorHandler(error);
        }
    })
});