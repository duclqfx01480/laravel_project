@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Add New Hobby</div>

                    <div class="card-body">

                        {{--  POST | hobby  | hobby.store | App\Http\Controllers\HobbyController@store | web --}}
                        {{--  truyền đến /hobby, phương thức post, sẽ gọi hàm store của HobbyController => cần viết hàm store --}}
                        <form autocomplete="off" action="/hobby" method="post" enctype="multipart/form-data">
                            {{-- CSRF Token --}}
                            @csrf

                            <div class="form-group">
                                <label for="name">Name</label>
                                {{-- 27. Validate: Lỗi của từng input riêng biệt, phần $errors bên dưới --}}
                                <input type="text" class="form-control{{ $errors->has('name')? ' border-danger' : '' }}" id="name" name="name" value="{{old('name')}}">
                                {{-- 27. Validate: Lỗi của từng input riêng biệt, phần $errors bên dưới --}}
                                <small class="form-text text-danger">{!! $errors->first('name') !!}</small>
                            </div>

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
                                <textarea class="form-control{{ $errors->has('description')? ' border-danger' : '' }}" id="description" name="description" rows="5">{{old('description')}}</textarea>
                                {{-- 27. Validate: Lỗi của từng input riêng biệt, phần $errors bên dưới --}}
                                <small class="form-text text-danger">{!! $errors->first('description') !!}</small>
                            </div>
                            <input class="btn btn-primary mt-4" type="submit" value="Add Hobby">
                        </form>

                        <a class="btn btn-primary float-right" href="/hobby"><i class="fas fa-arrow-circle-up"></i> Back to Hobby</a>
                    </div> <!-- end div card-body -->
                </div> <!-- end div card-header -->

            </div>

        </div> <!-- end div row -->

    </div> <!-- end container -->
@endsection
