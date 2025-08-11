jQuery(document).ready(function($){
	//final width --> this is the quick view image slider width
	//maxQuickWidth --> this is the max-width of the quick-view panel
	var sliderFinalWidth = 400,
		maxQuickWidth = 900;

	//open the quick view panel
	$('.quick-view.product').on('click', function(event){
		var selectedImage = $(this).closest('.product-miniature').find("img:first"),
            productId = $(this).data('id');

		//update the visible slider image in the quick view panel
		//you don't need to implement/use the updateQuickView if retrieving the quick view data with ajax
        $.ajax({
            url: '/api/product/' + productId,
            method: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    let product = response.data;
                    
                    $('.cd-quick-view .product-img img').attr('src', product.image_url);
                    $('.product-info h4').text(product.name)
                    $('.product-info .price').text(product.price_sale)
                    $('.product-info #product-code').text(product.product_code)
                    $('.product-info #category').text(product.category)
                    $('.product-info #origin').text(product.origin)
                    $('.product-info #brand').text(product.brand)
                    $('.product-info #texture').text(product.texture)
                    $('.product-info #skin_type').text(product.skin_type)
                    $('.product-info #form-add-to-cart').attr('action', '/cart/add/' + product.id);
                    if (product.quantity > 0) {
						$('.product-info span.check').text('Còn hàng')
						$('.product-info span.check').removeClass('text-danger')
						$('.product-info span.check').addClass('text-success')
					}
					else{
						$('.product-info span.check').text('Hết hàng')
						$('.product-info span.check').removeClass('text-success')
						$('.product-info span.check').addClass('text-danger')
					}

                    // Hiển thị overlay và popup
                    $('.overlay').fadeIn();
                    animateQuickView(selectedImage, sliderFinalWidth, maxQuickWidth, 'open');
                } else {
                    console.log(response.message);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi khi tìm chi tiết sản phẩm.');
            }
        });

		// updateQuickView(slectedImageUrl);
	});

	//close the quick view panel
    $('.cd-close, .overlay').on('click', function(event){
        if( $(event.target).is('.cd-close') || $(event.target).is('.overlay')) {
			closeQuickView( sliderFinalWidth, maxQuickWidth);
		}
	});
	$(document).keyup(function(event){
		//check if user has pressed 'Esc'
    	if(event.which=='27'){
			closeQuickView( sliderFinalWidth, maxQuickWidth);
		}
	});

	//quick view slider implementation
	// $('.cd-quick-view').on('click', '.cd-slider-navigation a', function(){
	// 	updateSlider($(this));
	// });

	//center quick-view on window resize
	$(window).on('resize', function(){
		if($('.cd-quick-view').hasClass('is-visible')){
			window.requestAnimationFrame(resizeQuickView);
		}
	});

	// function updateSlider(navigation) {
	// 	var sliderConatiner = navigation.parents('.cd-slider-wrapper').find('.cd-slider'),
	// 		activeSlider = sliderConatiner.children('.selected').removeClass('selected');
	// 	if ( navigation.hasClass('cd-next') ) {
	// 		( !activeSlider.is(':last-child') ) ? activeSlider.next().addClass('selected') : sliderConatiner.children('li').eq(0).addClass('selected'); 
	// 	} else {
	// 		( !activeSlider.is(':first-child') ) ? activeSlider.prev().addClass('selected') : sliderConatiner.children('li').last().addClass('selected');
	// 	} 
	// }

	// function updateQuickView(url) {
	// 	$('.cd-quick-view .cd-slider li').find('img').attr('src', url);
	// }

	function resizeQuickView() {
		var quickViewLeft = ($(window).width() - $('.cd-quick-view').width())/2,
			quickViewTop = ($(window).height() - $('.cd-quick-view').height())/2;
		$('.cd-quick-view').css({
		    "top": quickViewTop,
		    "left": quickViewLeft,
		});
	} 

	function closeQuickView(finalWidth, maxQuickWidth) {
		var selectedImage = $('.product-show').find('img');
		//update the image in the gallery
		if( !$('.cd-quick-view').hasClass('velocity-animating') && $('.cd-quick-view').hasClass('add-content')) {
			animateQuickView(selectedImage, finalWidth, maxQuickWidth, 'close');
		}
	}

	function animateQuickView(image, finalWidth, maxQuickWidth, animationType) {
		//store some image data (width, top position, ...)
		//store window data to calculate quick view panel position
		var parentListItem = image.closest('.product-miniature'),
			topSelected = image.offset().top - $(window).scrollTop(),
			leftSelected = image.offset().left,
			widthSelected = image.width(),
			heightSelected = image.height(),
			windowWidth = $(window).width(),
			windowHeight = $(window).height(),
			finalLeft = (windowWidth - finalWidth)/2,
			finalHeight = finalWidth * heightSelected/widthSelected,
			finalTop = (windowHeight - finalHeight)/2,
			quickViewWidth = ( windowWidth * .8 < maxQuickWidth ) ? windowWidth * .8 : maxQuickWidth ,
			quickViewLeft = (windowWidth - quickViewWidth)/2;
		
            if( animationType == 'open') {
            parentListItem.addClass('product-show');
			//place the quick view over the image gallery and give it the dimension of the gallery image
			$('.cd-quick-view').css({
			    "top": topSelected,
			    "left": leftSelected,
			    "width": widthSelected,
			}).velocity({
				//animate the quick view: animate its width and center it in the viewport
				//during this animation, only the slider image is visible
			    'top': finalTop+ 'px',
			    'left': finalLeft+'px',
			    'width': finalWidth+'px',
			}, 1000, [ 400, 20 ], function(){
				//animate the quick view: animate its width to the final value
				$('.cd-quick-view').addClass('animate-width').velocity({
					'left': quickViewLeft+'px',
			    	'width': quickViewWidth+'px',
				}, 300, 'ease' ,function(){
					//show quick view content
					$('.cd-quick-view').addClass('add-content');
				});
			}).addClass('is-visible');
		} else {
			//close the quick view reverting the animation
			$('.cd-quick-view').removeClass('add-content').velocity({
			    'top': finalTop+ 'px',
			    'left': finalLeft+'px',
			    'width': finalWidth+'px',
			}, 300, 'ease', function(){
				$('.overlay').fadeOut();
				$('.cd-quick-view').removeClass('animate-width').velocity({
					"top": topSelected,
				    "left": leftSelected,
				    "width": widthSelected,
				}, 500, 'ease', function(){
					$('.cd-quick-view').removeClass('is-visible');
                    parentListItem.removeClass('product-show');
				});
			});
		}
	}
	function closeNoAnimation(image, finalWidth, maxQuickWidth) {
		var parentListItem = image.parent('.product-miniature'),
			topSelected = image.offset().top - $(window).scrollTop(),
			leftSelected = image.offset().left,
			widthSelected = image.width();

        $('.overlay').fadeOut();
		$('.cd-quick-view').velocity("stop").removeClass('add-content animate-width is-visible').css({
			"top": topSelected,
		    "left": leftSelected,
		    "width": widthSelected,
		});
	}
}); /*php*/
