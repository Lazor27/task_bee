$( document ).ready(function() {
    function readURL(input) {
        $('.previeww').show();
        $('#blah').hide();
        $('.previeww').after('<img id="blah" src="#" style="display:none;"/>');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(320)
                    .height(240);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function getPhoto() {
        $('.previeww').hide();
        $('#blah').show();
    }

    function CheckWithPreview() {

        getPreview();
    }

    function getPreview() {
        v = document.getElementById("preview");
        if (v && document.getElementById('view')) {
            var str = '<h3><b>&nbspPreview:</b></h3><p> &nbspИмя: ' + document.forms[0].name.value + '</p>';
            str += '<p>&nbspEmail: ' + document.forms[0].email.value + '</p>';
            str += '<p>&nbspDescription: ' + document.forms[0].description.value + '</p><p>&nbspUploaded image:</p>';
            document.getElementById('view').innerHTML = str;
        }
        getPhoto();
    }

    $("#image").on("change", function () {
        readURL(this);
    } );
    $("#preview").on("click", CheckWithPreview)

});