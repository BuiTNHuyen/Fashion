@extends('admin.layout.master')

@section('content')
<div class="container">
    <h1>Danh sách liên hệ</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Nội dung</th>
                <th>Thời gian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->from }}</td>
                <td>{{ $contact->message }}</td>
                <td>{{ $contact->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $contacts->links() }}
</div>
@endsection 