<?php

if (!function_exists('convertPrice')) {
    function convertPrice($amount, $currency = 'đ')
    {
        return number_format($amount) . $currency;
    }
}

if (!function_exists('initialPrice')) {
    function initialPrice($amount, $discount)
    {
        $price = $amount/(1 - ($discount/100));
        return $price;
    }
}

if (!function_exists('isReview')) {
    function isReview($order_product_id, $product_id)
    {
        $review = \App\Models\Review::where('order_product_id', $order_product_id)->where('product_id', $product_id)->first();
        return $review;
    }
}
 /*php*/
