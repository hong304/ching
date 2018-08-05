var imageInput;
var imageIdInput;
var imgApiUrl;
function initImageGallery(imageInputEl, imageIdInputEl, api) {
    imageInput = imageInputEl;
    imageIdInput = imageIdInputEl;
    imgApiUrl = api;
    var imageCatagories = $("#selectFromGallery").find('.tab-pane');
    $.each(imageCatagories, function (index, category) {
        ajaxLoadImageData(category.id, 1);
    });
}
function ajaxLoadImage(el, type, page) {
    nextPage = parseInt(page) + 1;
    ajaxLoadImageData(type, page);
    $(el).attr('onclick', 'ajaxLoadImage(this,"' + type + '", ' + nextPage + ')');
}
function ajaxLoadImageData(type, page) {
    $.getJSON(imgApiUrl + "/" + type + "?page=" + page, function (result) {
        var photoEnd = $("#" + type).children().first();
        var photoList = result.data;
        $.each(photoList, function (index, image) {
            var html = '<a href="javascript:void(0);" class="image-option-link" onclick="chooseImageFromGallery(this)" data-toggle="tooltip" data-html="true" title="<img src=\'';
            html += image.original_image_url + "\' /> \" >";
            html += '<div class="card mb-2 mt-2 image-card"><img class="card-img-top" src="' + image.small_image_url + '"><span class="selected-image"><i class="fa fa-check" aria-hidden="true"></i></span>';
            html += '<input type="hidden" class="image-id" value="' + image.id + '">';
            html += '<input type="hidden" class="image-src" value="' + image.original_image_url + '"></div></a>';
            photoEnd.append(html);
        });
        $("#" + type).find('button').removeAttr('disabled');
        reInitTooltip();
    });
}

function reInitTooltip() {
    var tooltipEl = $('a[data-toggle="tooltip"]');
    tooltipEl.tooltip('dispose');
    tooltipEl.tooltip({
        animation: false,
        trigger: "hover",
        placement: "bottom",
        container: ".add-section",
        constraints: [
            {
                to: 'scrollParent',
                attachment: 'together'
            }
        ]
    });
}

function chooseImageFromGallery(el) {
    $(".image-option-link").removeClass("active");
    $(el).addClass("active");

    var imageId = $(el).find(".image-id").val();
    var imageSrc = $(el).find(".image-src").val();
    imageIdInput.val(imageId);

    imageInput.replaceWith(imageInput.val('').clone(true));
    $('#image-preview').attr('src', imageSrc);
    $('.image-preview-holder').removeClass("no-image");
}

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image-preview').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function changeImageSelected(el) {
    readURL(el);
    imageIdInput.val("");
    $(".image-option-link").removeClass("active");
    $(".no-image").removeClass("no-image");
}