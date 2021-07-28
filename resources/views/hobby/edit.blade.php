@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Hobby</div>

                    <div class="card-body">

                        {{--  POST | hobby  | hobby.store | App\Http\Controllers\HobbyController@store | web --}}
                        {{--  truyền đến /hobby, phương thức post, sẽ gọi hàm store của HobbyController => cần viết hàm store --}}
                        <form autocomplete="off" action="/hobby/{{$hobby->id}}" method="post" enctype="multipart/form-data">
                            {{-- CSRF Token --}}
                            @csrf

                            {{-- 31 --}}
                            {{-- Method --}}
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                {{-- 27. Validate: Lỗi của từng input riêng biệt, phần $errors bên dưới --}}
                                <input type="text" class="form-control{{ $errors->has('name')? ' border-danger' : '' }}" id="name" name="name" value="{{old('name') ?? $hobby->name}}">
                                {{-- 27. Validate: Lỗi của từng input riêng biệt, phần $errors bên dưới --}}
                                <small class="form-text text-danger">{!! $errors->first('name') !!}</small>
                            </div>

                            @if(file_exists('img/hobbies/' . $hobby->id . '_large.jpg'))
                                <div class="mb-2">
                                    <img style="max-width: 400px; max-height: 300px;" src="{{ URL::asset('img/hobbies/' . $hobby->id . '_large.jpg') }}" alt="thumb">
                                    <br>
                                    <a class="btn btn-outline-danger mt-1" href="/delete-images/hobby/{{$hobby->id}}">Delete Image</a>
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
                                <label for="description">Description</label>
                                {{-- 27. Validate: Lỗi của từng input riêng biệt, phần $errors bên dưới --}}
                                <textarea class="form-control{{ $errors->has('description')? ' border-danger' : '' }}" id="description" name="description" rows="5">{{old('description') ?? $hobby->description}}</textarea>
                                {{-- 27. Validate: Lỗi của từng input riêng biệt, phần $errors bên dưới --}}
                                <small class="form-text text-danger">{!! $errors->first('description') !!}</small>
                            </div>
                            <input class="btn btn-primary mt-4" type="submit" value="Update Hobby">
                        </form>

                        <a class="btn btn-primary float-right" href="/hobby"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div> <!-- end div card-body -->
                </div> <!-- end div card-header -->

            </div>

        </div> <!-- end div row -->

    </div> <!-- end container -->
@endsection
