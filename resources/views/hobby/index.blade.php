@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __('All the hobbies') }}</div>

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($hobbies as $hobby)
                                <li class="list-group-item">
                                    <a title="Show Details" href="/hobby/{{$hobby->id}}">{{ $hobby->name }}</a>
                                    {{-- a -> 29. Tạo trang xem chi tiết --}}
                                    {{-- a href sẽ dẫn đến hobby.show, do đó cần viết code trong HobbyController, phương thức show --}}
                                    {{-- GET|HEAD | hobby/{hobby} | hobby.show | App\Http\Controllers\HobbyController@show --}}

                                    {{-- 30. Cập nhật dữ liệu--}}
                                    {{-- Thêm một link edit ngay sau link chứa tên Hobby --}}
                                    <a class="btn btn-sm btn-outline-primary ml-2" title="Edit this hobby" href="/hobby/{{$hobby->id}}/edit"><i class="fas fa-edit"></i> Edit</a>

                                    {{-- 31. Xóa dữ  liệu--}}
                                    {{-- Thêm link delete --}}
                                    {{-- Delete cần phương thức delete nên sẽ cần một form --}}
                                    <form class="float-right" style="display: inline" action="/hobby/{{$hobby->id}}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <input class="btn btn-sm btn-outline-danger ml-2" type="submit" title="Delete this hobby" value="Delete">
                                    </form>

                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

{{--            23. Nút nhấn để thêm mới một Hobby--}}
                <div class="mt-2">
                    <a class="btn btn-success btn-sm" href="/hobby/create"><i class="fas fa-plus-circle"></i> Add new Hobby</a>
                </div>

            </div>
        </div>
    </div>
@endsection
