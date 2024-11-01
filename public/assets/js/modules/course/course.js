$(".select2").select2({
    placeholder: $(this).data("placeholder") ?? "Select",
});

var quill = new Quill("#snow-editor", {
    theme: "snow",
    modules: {
        toolbar: [
            [{ font: [] }, { size: [] }],
            ["bold", "italic", "underline", "strike"],
            [{ color: [] }, { background: [] }],
            [{ script: "super" }, { script: "sub" }],
            [{ header: [!1, 1, 2, 3, 4, 5, 6] }, "blockquote", "code-block"],
            [
                { list: "ordered" },
                { list: "bullet" },
                { indent: "-1" },
                { indent: "+1" },
            ],
            ["direction", { align: [] }],
            ["link", "image", "video"],
            ["clean"],
        ],
    },
});

var quill = new Quill("#snow-editor-ar", {
    theme: "snow",
    modules: {
        toolbar: [
            [{ font: [] }, { size: [] }],
            ["bold", "italic", "underline", "strike"],
            [{ color: [] }, { background: [] }],
            [{ script: "super" }, { script: "sub" }],
            [{ header: [!1, 1, 2, 3, 4, 5, 6] }, "blockquote", "code-block"],
            [
                { list: "ordered" },
                { list: "bullet" },
                { indent: "-1" },
                { indent: "+1" },
            ],
            ["direction", { align: [] }],
            ["link", "image", "video"],
            ["clean"],
        ],
    },
});

$(document).on("click", ".post-or-schedule", function () {
    $val = $(this).val();
    $val == 1
        ? $("#schedule").closest(".row").show()
        : $("#schedule").closest(".row").hide();
});
$(".date-time").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
});

$("#saveButton").click(function () {
    $description = $("#snow-editor .ql-editor").html();
    $description = $description == "<p><br></p>" ? "" : $description;
    $("#descriptionBox").text($description);

    $descriptionAr = $("#snow-editor-ar .ql-editor").html();
    $descriptionAr = $descriptionAr == "<p><br></p>" ? "" : $descriptionAr;
    $("#descriptionBoxAr").text($descriptionAr);
});

$(".nav-link").click(function () {
    removeErrors();
});

// Dropzon for upload product images
Dropzone.options.bonusMaterialDropzone = {
    paramName: "bonus_material",
    maxFilesize: 50, // MB
    init: function () {
        this.on("error", function (file, errorMessage) {
            errorHandler(errorMessage);
        });
    },
};

$(document).on("change", "#course", function () {
    $id = $(this).val();
    $("#chapter").prop("disabled", true);
    $.ajax({
        type: "GET",
        url: $baseUrl + "/chapter-by-course-ids?course_ids=" + $id,
        dataType: "json",
        success: function (response) {
            $row = '<option value=""></option>';
            $teachers = "";
            if ((response.status = "success")) {
                if (response.chapters) {
                    $.each(response.chapters, function (index, chapter) {
                        $row +=
                            '<option value="' +
                            chapter.id +
                            '">' +
                            chapter.name +
                            "</option >";
                    });
                }

                $("#chapter").html($row), $("#chapter").prop("disabled", false);
            }
        },
        error: function (error) {
            errorHandler(error);
        },
    });
});

$("#videoType").on("change", function () {
    $(".video-input").hide();

    $("#duration").attr("disabled", true);
    $val = $(this).val();
    if ($val == "url") {
        $("#video_url").show();
        $("#duration").attr("disabled", false);
    } else if ($val == "embeded") {
        $("#video_embeded_code").show();
        $("#duration").attr("disabled", false);
    } else {
        $("#video").show();
    }
});

$("#addPackage").click(function () {
    $row = $(".package-container").html();
    $("#packageContainer").append($row);
});

$(document).on("click", ".remove-program", function () {
    $(this).closest(".row").remove();
});

$("#file_type_select").on("change", function () {
    if ($(this).val() === "vimeo") {
        $("#image_or_video").hide();
        $("#vimeo_link").show();
    } else if ($(this).val() === "") {
        $("#image_or_video").hide();
        $("#vimeo_link").hide();
    } else {
        $("#vimeo_link").hide();
        $("#image_or_video").show();
    }
});

$("#get_started_type_select").on("change", function () {
    if ($(this).val() === "vimeo") {
        $("#get_started_video").hide();
        $("#get_started_vimeo").show();
    } else if ($(this).val() === "") {
        $("#get_started_video").hide();
        $("#get_started_vimeo").hide();
    } else {
        $("#get_started_vimeo").hide();
        $("#get_started_video").show();
    }
});

$("#addMaterial").click(function(){
    $row = $('.material-container').html();
    $("#materialContainer").append($row);
});

$(document).on('click', ".remove-material", function () {
    $(this).closest('.bg-light').remove();
});

$(document).on('change', ".video-or-vimeo-type", function () {
    $row = $(this).closest('.row');
    $video = $row.find('.video-type-input');
    $vimeo = $row.find('.vimeo-type-input');

    if($(this).val() == "vimeo") {
        $video.hide();
        $vimeo.show();
    } else{
        $video.show();
        $vimeo.hide();
    }
});
