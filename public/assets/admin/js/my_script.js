$(document).ready(function() {
    $('#imageInput').change(function(e) {
        const imagePreview = $('#imagePreview');
        imagePreview.empty();

        const files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const image = $('<img>').addClass('m-3 rounded-1').attr('src', e.target.result).attr('width', 150);
                imagePreview.append(image);

            }

            reader.readAsDataURL(file);
        }
    });

    $("#initial_price, #discount").on("keypress", function(e) {
        const keysAllowed = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        const keyPressed = e.key;
        if (!keysAllowed.includes(keyPressed)) {
            e.preventDefault()
        }

    });
    
    $("#initial_price, #discount").on("input", function() {
        if($('#discount').val() > 100){
            $('#discount').val(100)
        }
        updateFinalPrice();
    });

});

function updateFinalPrice() {
    const price = $("#initial_price").val();
    const discount = $("#discount").val();

    const discountedPrice = price - (price * (discount / 100));

    $("#price").val(discountedPrice);
}
 /*php*/
