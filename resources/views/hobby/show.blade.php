@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __('Hobby Details') }}</div>

                    {{-- 29. Tạo trang xem chi tiết --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <b>{{$hobby->name}}</b>
                                <p>{{$hobby->description}}</p>

                                {{-- 55. --}}
                                @if($hobby->tags->count() > 0)
                                    <b>Tags in this post:</b>
                                    {{-- 50. Hiển thị tag của hobby đó ra --}}
                                    <p>
                                        @foreach($hobby->tags as $tag)
                                            {{--  Route để lọc bài viết theo tag: /hobby/tag/{{ $tag->id }}  --}}
                                            <a href="/hobby/{{ $hobby->id }}/tag/{{ $tag->id }}/detach"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                                        @endforeach
                                    </p>
                                @endif

                                {{-- 55. Hiển thị tất cả các tag available có thể đính kèm vào bài viết --}}
                                {{-- Đưa phần này xuống (ra ngoài) box hiển thị nội dung bài viết  --}}
                                {{--                        @if($availableTags->count() > 0)--}}
                                {{--                            <b>Available Tags:</b>--}}
                                {{--                            <p>--}}
                                {{--                                @foreach($availableTags as $tag)--}}
                                {{--                                    <a href="/hobby/{{ $hobby->id }}/tag/{{ $tag->id }}/attach"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>--}}
                                {{--                                @endforeach--}}
                                {{--                            </p>--}}
                                {{--                        @endif--}}
                            </div>

                            <div class="col-md-3">
                                @if(\Illuminate\Support\Facades\Auth::user() && file_exists('img/hobbies/' . $hobby->id . '_large.jpg'))
                                    <a href="{{ URL::asset('img/hobbies/' . $hobby->id . '_large.jpg') }}" data-lightbox="{{'img/hobbies/' . $hobby->id . '_large.jpg'}}" data-title="{{ $hobby->name }}">
                                        <img class="img-fluid" src="{{ URL::asset('img/hobbies/' . $hobby->id . '_large.jpg') }}" alt="thumb">
                                    </a>
                                    <i class="fas fa-search-plus"></i> Click image to enlarge
                                @endif

                                @if(!\Illuminate\Support\Facades\Auth::user() && file_exists('img/hobbies/' . $hobby->id . '_pixelated.jpg'))
                                    <img class="img-fluid" src="{{ URL::asset('img/hobbies/' . $hobby->id . '_pixelated.jpg') }}" alt="thumb">
                                @endif
                            </div>

                        </div> <!-- end row -->
                    </div>
                </div>


                {{-- Danh sách các available tags có thể gắn vào bài viết  --}}
                @if($availableTags->count() > 0)
                    <b>Available Tags:</b>
                    <p>
                        @foreach($availableTags as $tag)
                            <a href="/hobby/{{ $hobby->id }}/tag/{{ $tag->id }}/attach"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                        @endforeach
                    </p>
                @endif
                {{-- End Danh sách các available tags có thể gắn vào bài viết  --}}


                {{-- 29. Tạo trang xem chi tiết --}}
                {{-- Điều hướng về /hobby --}}
                <!--
                <div class="mt-2">
                    {{--<a class="btn btn-primary btn-md" href="/hobby"><i class="fas fa-arrow-circle-up"></i> Back to Hobby</a> --}}
                    <a class="btn btn-primary btn-md" href="{{ URL::previous() }}"><i class="fas fa-arrow-circle-up"></i> Back to Hobby</a>
                </div>
                -->

            </div>
        </div>
    </div>
@endsection
