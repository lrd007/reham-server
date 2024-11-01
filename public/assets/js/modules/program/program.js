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

var quill = new Quill("#snow-editor-2", {
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

var quill = new Quill("#snow-editor-ar-2", {
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
$(document).on("click", ".program-type", function(){
    $val = $(this).val();
    $val == 1 ? $(".offer-date").closest('.row').show() : $(".offer-date").closest('.row').hide();
});

$("#saveButton").click(function () {
    $description = $("#snow-editor .ql-editor").html();
    $description = $description == "<p><br></p>" ? "" : $description;
    $("#descriptionBox").text($description);

    $descriptionAr = $("#snow-editor-ar .ql-editor").html();
    $descriptionAr = $descriptionAr == "<p><br></p>" ? "" : $descriptionAr;
    $("#descriptionBoxAr").text($descriptionAr);

    $description = $("#snow-editor-2 .ql-editor").html();
    $description = $description == "<p><br></p>" ? "" : $description;
    $("#descriptionBox2").text($description);

    $descriptionAr = $("#snow-editor-ar-2 .ql-editor").html();
    $descriptionAr = $descriptionAr == "<p><br></p>" ? "" : $descriptionAr;
    $("#descriptionBoxAr2").text($descriptionAr);
});