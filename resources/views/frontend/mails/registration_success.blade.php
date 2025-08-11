
<x-mail::message>
# Đăng ký tài khoản thành công

Xin chào {{$user->name}},<br>
Cảm ơn bạn đã lựa chọn {{config('app.name')}}. Tài khoản của bạn đã được tạo thành công. <br>
Chúng tôi hy vọng bạn sẽ có những trải nghiệm tuyệt vời khi mua sắm tại cửa hàng của chúng tôi!

<x-mail::button url="{{route('login')}}">
Đăng nhập tài khoản
</x-mail::button>
 
Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message> /*php*/
