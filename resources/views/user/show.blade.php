@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header" style="font-size: 150%;">{{ __($user->name) }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <b>Motto: </b> {{ $user->motto }}<br>
                                <p class="mt-2"><b>About me: </b><br> {{ $user->about_me }}</p>

                            </div>

                            <div class="col-md-3">
                                @if(\Illuminate\Support\Facades\Auth::user() && file_exists('img/users/' . $user->id . '_large.jpg'))
                                    <img class="img-thumbnail" src="{{ URL::asset('img/users/' . $user->id . '_large.jpg') }}" alt="thumb">
                                @endif

                                @if(!\Illuminate\Support\Facades\Auth::user() && file_exists('img/users/' . $user->id . '_pixelated.jpg'))
                                    <img class="img-thumbnail" src="{{ URL::asset('img/users/' . $user->id . '_pixelated.jpg') }}" alt="thumb">
                                @endif
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Hobbies List -->
                                @if($user->hobbies->count()>0)
                                    <h5>Hobbies of {{ $user->name }}</h5>
                                    <ul class="list-group">
                                        @foreach($user->hobbies as $hobby)
                                            <li class="list-group-item">
                                                {{-- 70 comment out this line <a title="Show Details" href="/hobby/{{$hobby->id}}">{{ $hobby->name }}</a>--}}

                                                {{-- 70 --}}
                                                @if(file_exists('img/hobbies/' . $hobby->id . '_thumb.jpg'))
                                                    <a title="Show Details" href="/hobby/{{$hobby->id}}">
                                                        <img src="{{ URL::asset('/img/hobbies/' . $hobby->id . '_thumb.jpg') }}" alt="thumb">
                                                    </a>
                                                @endif

                                                &nbsp;<a title="Show Details" href="/hobby/{{$hobby->id}}">{{ $hobby->name }}</a>


                                                {{-- 30. Cập nhật dữ liệu--}}
                                                {{-- Thêm một link edit ngay sau link chứa tên Hobby --}}
                                                {{-- 46. Ẩn Edit button nếu chưa đăng nhập--}}
                                                {{-- wrap 2 nút này trong auth và endauth thì nếu không đăng nhập nút sẽ ẩn đi--}}

                                                {{-- 48 Hiển thị tên người viết hobby --}}
                                                {{-- 51. Challenge <a> - Tạo link đến resource route để show user --}}
                                                <span class="small">Posted by: <a href="/user/{{ $hobby->user->id }}">{{ $hobby->user->name }} </a> ({{ $hobby->user->hobbies->count() }}) </span>

                                                {{-- 47. Hiển thị ngày tạo hobby --}}
                                                <span class="float-right small mx-2">{{$hobby->created_at->diffForHumans() }}</span>

                                                <br>
                                                {{-- 50. Hiển thị tag của hobby đó ra --}}
                                                @foreach($hobby->tags as $tag)
                                                    <a href="/hobby/tag/{{ $tag->id }}"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>
                                        {{ $user->name }} has not created any hobby yet.
                                    </p>
                                @endif
                                <!-- End Hobbies List -->
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Điều hướng về /hobby - trang trước đó --}}
                <div class="mt-2">
                    <a class="btn btn-primary btn-md" href="{{URL::previous()}}"><i class="fas fa-arrow-circle-up"></i> Back to Hobby</a>
                </div>

            </div>
        </div>
    </div>
@endsection
