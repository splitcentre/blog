    @extends('auth.layouts')
    @section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="class-body">
                    @if ($message=Session::get('success'))
                    <div class="alert alert-success">{{$message}}</div>
                    @else
                    <div class="alert alert-success">You Logged in!!!</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="photo" class="col-md-4 col-form-label text-md-end text-start">Photo</label>
        <div>
            <input type="file" class="form_control @error ('photo') is_invalid @enderror" id="photo" name="photo" value ="{{old('photo')}}">
            @if ($errors->has('photo'))
            <span class="text-danger">{{$errors->first('photo')}}</span>
            @endif
        </div>
    </div>
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
                    @if ($user->photo)
                        <img src="{{ asset('storage/photos/' . $user->photo) }}" width="500px" height="300px" alt="Original Photo">
                    @else
                        No Photo
                    @endif
                </td>
                <td>
                    @if ($user->thumbnail)
                        <img src="{{ asset('storage/photos/' . $user->thumbnail) }}" alt="Thumbnail">
                    @else
                        No Thumbnail
                    @endif
                </td>
                <td>
                    @if ($user->square)
                        <img src="{{ asset('storage/photos/' . $user->square) }}" alt="Square Photo">
                    @else
                        No Square Photo
                    @endif
                </td>
                <td>
                    <a href="{{ route('edit-profile', ['id' => $user->id]) }}" enctype="multipart/form-data" class="btn btn-primary">Edit</a>
                    <form class="mt-2" action="{{ route('delete-photos', ['id' => $user->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning">Delete</button>
                    </form>
                </td>
                @endforeach
            </tr>
            @if (session('success'))
                <div class="alert alert-primary">
                    {{ session('success') }}
                </div>
            @endif
        </tbody>
    </table>
</div>
    @endsection
