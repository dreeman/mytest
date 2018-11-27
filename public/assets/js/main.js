$(document).ready(function (e) {
    $('body').on('click', '.js-preview', function (e) {
        let username = $('#fld_username').val();
        let email = $('#fld_email').val();
        let text = $('#fld_text').val();
        $('.js-preview-username').html(username);
        $('.js-preview-email').html(email);
        $('.js-preview-text').html(text);
        $('#myModal').modal('show');
    });

    $('body').on('change', '#fld_image', function(e) {
        if (this.files[0]) {
            let file = this.files[0];
            let reader = new FileReader();
            reader.onload = function(e) {
                let dataURL = reader.result;
                console.log(dataURL);
                $('.js-preview-image').html('<img src="' + dataURL + '">');
            };
            reader.readAsDataURL(file);
        }
    });
});
