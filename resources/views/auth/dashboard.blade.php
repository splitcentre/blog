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

    @endsection
