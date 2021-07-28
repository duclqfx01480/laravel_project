@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    {{-- 51 @ 16:53 Hiển thị tiêu đề tương ứng với dữ liệu của hobbies (có đang lọc hay không) --}}
                    @isset($filter)
                        {{--<div class="card-header">{{ __('Filtered Hobbies by tag ' . $filter->name) }}</div> --}}
                        <div class="card-header">
                            Filtered Hobbies by tag <span style="font-size: 120%;" class="badge badge-{{ $filter->style }}">{{ $filter->name }}</span>
                            <span class="float-right"><a href="/hobby">Show all Hobbies</a></span>
                        </div>

                    @else
                        <div class="card-header">{{ __('All the hobbies') }}</div>
                    @endisset


                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($hobbies as $hobby)
                                <li class="list-group-item">

                                    {{-- 70.  --}}
                                    @if(file_exists('img/hobbies/' . $hobby->id . '_thumb.jpg'))
                                    <a title="Show Details" href="/hobby/{{$hobby->id}}">
                                        <img src="{{ URL::asset('img/hobbies/' . $hobby->id . '_thumb.jpg') }}" alt="thumb">
                                    </a>
                                    @endif

                                    &nbsp;<a title="Show Details" href="/hobby/{{$hobby->id}}">{{ $hobby->name }}</a>

                                    {{-- a -> 29. Tạo trang xem chi tiết --}}
                                    {{-- a href sẽ dẫn đến hobby.show, do đó cần viết code trong HobbyController, phương thức show --}}
                                    {{-- GET|HEAD | hobby/{hobby} | hobby.show | App\Http\Controllers\HobbyController@show --}}

                                    {{-- 30. Cập nhật dữ liệu--}}
                                    {{-- Thêm một link edit ngay sau link chứa tên Hobby --}}
                                    {{-- 46. Ẩn Edit button nếu chưa đăng nhập--}}
                                    {{-- wrap 2 nút này trong auth và endauth thì nếu không đăng nhập nút sẽ ẩn đi--}}

                                    {{-- 48 Hiển thị tên người viết hobby --}}
                                    {{-- 51. Challenge <a> - Tạo link đến resource route để show user --}}

                                    <span class="small">
                                        Posted by: <a href="/user/{{ $hobby->user->id }}">{{ $hobby->user->name }} </a> ({{ $hobby->user->hobbies->count() }})

                                        {{-- 75 --}}
                                        {{-- Hiển thị Thumbnail của user --}}
{{--                                        @if(file_exists('img/users/' . $hobby->user->id . '_thumb.jpg'))--}}
{{--                                            <a title="Show Details" href="/user/{{$hobby->user->id}}">--}}
{{--                                            <img class="rounded" src="{{ URL::asset('img/users/' . $hobby->user->id . '_thumb.jpg') }}" alt="thumb">--}}
{{--                                        </a>--}}
{{--                                        @endif--}}

{{--                                        <a href="/user/{{ $hobby->user->id }}">--}}
{{--                                            <img class="rounded" src="{{ URL::asset('img/thumb_portrait.jpg') }}" alt="thumb">--}}
{{--                                        </a>--}}
                                    </span>

                                    @auth
                                        {{-- 31. Xóa dữ  liệu--}}
                                        {{-- Thêm link delete --}}
                                        {{-- Delete cần phương thức delete nên sẽ cần một form --}}
                                        <form class="float-right" style="display: inline" action="/hobby/{{$hobby->id}}" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <input class="btn btn-sm btn-outline-danger ml-2" type="submit" title="Delete this hobby" value="Delete">
                                        </form>

                                        <a class="float-right btn btn-sm btn-outline-primary ml-2" title="Edit this hobby" href="/hobby/{{$hobby->id}}/edit"><i class="fas fa-edit"></i> Edit</a>
                                    @endauth

                                    {{-- 47. Hiển thị ngày tạo hobby --}}
                                    <span class="float-right small mx-2">
                                        {{$hobby->created_at->diffForHumans() }}
                                    </span>

                                    <br>
                                    {{-- 50. Hiển thị tag của hobby đó ra --}}
                                    @foreach($hobby->tags as $tag)
                                        <a href="/hobby/tag/{{ $tag->id }}"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                                    @endforeach

                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- 45. Thêm các nút chuyển trang --}}
                <div class="mt-3 inline">
                    {{ $hobbies->links("pagination::bootstrap-4") }}
                </div>


                {{-- 23. Nút nhấn để thêm mới một Hobby--}}
                @auth
                <div class="mt-2">
                    <a class="btn btn-success btn-sm" href="/hobby/create"><i class="fas fa-plus-circle"></i> Add new Hobby</a>
                </div>
                @endauth

            </div>
        </div>
    </div>
@endsection
