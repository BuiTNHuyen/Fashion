$(document).ready(function() {
    $('.btn-touchspin').click(function(e) {
        var elementQty = $(this).closest('.quantity');
        var currentValue = elementQty.find('.input-group').val();
        var product_id = elementQty.find('.product-id').val();
        if($(this).hasClass('bootstrap-touchspin-up')){
            currentValue++;
            if($(this).hasClass('cart')){
                window.location.href = `/cart/increase/${product_id}`
            }
        }   
        else{
            if (currentValue > 1) {
                currentValue--;
                if($(this).hasClass('cart')){
                    window.location.href = `/cart/decrease/${product_id}`
                }
            }
        }
        elementQty.find('.input-group').val(currentValue);
    })
})

function addProdToCompare(productId){
    let compareProducts = JSON.parse(localStorage.getItem('compareProducts')) || [];

    if (compareProducts.length >= 3) {
        toastr.error('Bạn chỉ có thể so sánh tối đa 3 sản phẩm.', 'Error', {timeOut: 3000})
        return;
    }

    if (compareProducts.some(prod => prod.id === productId)) {
        toastr.error('Sản phẩm này đã có trong danh sách so sánh.', 'Error', {timeOut: 3000})
        return;
    }

    $.ajax({
        url: '/api/product/' + productId,
        method: 'GET',
        success: function(response) {
            if (response.status === 'success') {
                let product = response.data;
                compareProducts.push(product);
                localStorage.setItem('compareProducts', JSON.stringify(compareProducts));
                toastr.success('Sản phẩm đã được thêm vào danh sách so sánh.', 'Success',{timeOut: 3000})

            } else {
                toastr.error('Error', response.message, {timeOut: 3000})
            }
        },
        error: function() {
            toastr.error('Đã xảy ra lỗi khi tìm chi tiết sản phẩm.', 'Error',{timeOut: 3000})
        }
    });
} /*php*/
