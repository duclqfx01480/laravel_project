@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">

                    <!-- 57. Cải tiến trang home khi người dùng đăng nhập thành công -->
                    <h2>Welcome {{ auth()->user()->name }}</h2>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

{{--                    {{ __('You are logged in!') }}--}}

                    <!-- 58 -->
                    @isset($hobbies)
                        @if($hobbies->count() > 0)
                            <h3>Your posts:</h3>
                        @endif

                        <ul class="list-group">
                            @foreach($hobbies as $hobby)
                                <li class="list-group-item">
                                    <a title="Show Details" href="/hobby/{{$hobby->id}}">{{ $hobby->name }}</a>
                                    {{-- Cập nhật dữ liệu--}}
                                    {{-- Thêm một link edit ngay sau link chứa tên Hobby --}}
                                    {{-- Ẩn Edit button nếu chưa đăng nhập--}}
                                    {{-- wrap 2 nút này trong auth và endauth thì nếu không đăng nhập nút sẽ ẩn đi--}}

                                    @auth
                                        {{-- Thêm link delete --}}
                                        {{-- Delete cần phương thức delete nên sẽ cần một form --}}
                                        <form class="float-right" style="display: inline" action="/hobby/{{$hobby->id}}" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <input class="btn btn-sm btn-outline-danger ml-2" type="submit" title="Delete this hobby" value="Delete">
                                        </form>

                                        <a class="float-right btn btn-sm btn-outline-primary ml-2" title="Edit this hobby" href="/hobby/{{$hobby->id}}/edit"><i class="fas fa-edit"></i> Edit</a>
                                    @endauth

                                    {{-- Hiển thị ngày tạo hobby --}}
                                    <span class="float-right small mx-2">{{$hobby->created_at->diffForHumans() }}</span>

                                    <br>
                                    {{-- Hiển thị tag của hobby đó ra --}}
                                    @foreach($hobby->tags as $tag)
                                        <a href="/hobby/tag/{{ $tag->id }}"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                                    @endforeach

                                </li>
                            @endforeach
                        </ul>
                    @endisset
                        <!-- end 58 -->

                    <!-- 57. Nút cho phép tạo bài viết mới -->
                    <a class="btn btn-success btn-sm mt-2" href="/hobby/create"><i class="fas fa-plus-circle"></i> Create new Hobby</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
