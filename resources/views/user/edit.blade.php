@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit User Profile</div>

                    <div class="card-body">

                        {{--  POST | hobby  | hobby.store | App\Http\Controllers\HobbyController@store | web --}}
                        {{--  truyền đến /hobby, phương thức post, sẽ gọi hàm store của HobbyController => cần viết hàm store --}}
                        <form autocomplete="off" action="/user/{{$user->id}}" method="post" enctype="multipart/form-data">
                            {{-- CSRF Token --}}
                            @csrf

                            @method('PUT')

                            <div class="form-group">
                                <label for="motto">Motto</label>
                                <input type="text" class="form-control{{ $errors->has('motto')? ' border-danger' : '' }}" id="motto" name="motto" value="{{old('motto') ?? $user->motto}}">
                                <small class="form-text text-danger">{!! $errors->first('motto') !!}</small>
                            </div>

                            @if(file_exists('img/users/' . $user->id . '_large.jpg'))
                                <div class="mb-2">
                                    <img style="max-width: 400px; max-height: 300px;" src="{{ URL::asset('img/users/' . $user->id . '_large.jpg') }}" alt="thumb">
                                    <br>
                                    <a class="btn btn-outline-danger mt-1" href="/delete-images/user/{{$user->id}}">Delete Image</a>
                                </div>
                            @endif

                            <!-- 66. Thêm field file upload -->
                            <!-- Để upload ảnh thì ở form bổ sung thêm enctype="multipart/form-data" (xem ở trên) -->
                            <!-- và tắt Autocomplete -->
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control {{ $errors->has('name')? ' border-danger' : '' }}" id="image" name="image" value="">
                                <small class="form-text text-danger">{!! $errors->first('image') !!}</small>
                            </div>


                            <div class="form-group">
                                <label for="about_me">About me</label>
                                <textarea class="form-control" id="about_me" name="about_me" rows="5">{{old('about_me') ?? $user->about_me}}</textarea>
                            </div>
                            <input class="btn btn-primary mt-4" type="submit" value="Update My Profile">
                        </form>

                        <a class="btn btn-primary float-right" href="/user"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div> <!-- end div card-body -->
                </div> <!-- end div card-header -->

            </div>

        </div> <!-- end div row -->

    </div> <!-- end container -->
@endsection
