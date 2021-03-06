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


                                                {{-- 30. C???p nh???t d??? li???u--}}
                                                {{-- Th??m m???t link edit ngay sau link ch???a t??n Hobby --}}
                                                {{-- 46. ???n Edit button n???u ch??a ????ng nh???p--}}
                                                {{-- wrap 2 n??t n??y trong auth v?? endauth th?? n???u kh??ng ????ng nh???p n??t s??? ???n ??i--}}

                                                {{-- 48 Hi???n th??? t??n ng?????i vi???t hobby --}}
                                                {{-- 51. Challenge <a> - T???o link ?????n resource route ????? show user --}}
                                                <span class="small">Posted by: <a href="/user/{{ $hobby->user->id }}">{{ $hobby->user->name }} </a> ({{ $hobby->user->hobbies->count() }}) </span>

                                                {{-- 47. Hi???n th??? ng??y t???o hobby --}}
                                                <span class="float-right small mx-2">{{$hobby->created_at->diffForHumans() }}</span>

                                                <br>
                                                {{-- 50. Hi???n th??? tag c???a hobby ???? ra --}}
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

                {{-- ??i???u h?????ng v??? /hobby - trang tr?????c ???? --}}
                <div class="mt-2">
                    <a class="btn btn-primary btn-md" href="{{URL::previous()}}"><i class="fas fa-arrow-circle-up"></i> Back to Hobby</a>
                </div>

            </div>
        </div>
    </div>
@endsection
