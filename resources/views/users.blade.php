@extends('auth.layouts')  

@section('content')
<div class="container">
    <h1>User Data</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                <img src="{{asset('storage/'.$user->photo )}}" width="150px">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
