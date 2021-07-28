@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __('All the tags') }}</div>

                    <div class="card-body">
                        <ul class="list-group">

                            @foreach($tags as $tag)
                                <li class="list-group-item">
                                    <!--
                                    <span style="font-size: 130%;" class="mr-2 badge badge-{{ $tag->style}}" >{{ $tag->name }}</span>
                                    -->
                                    {{--<a title="Show Details" href="/tag/{{$tag->id}}">{{ $tag->name }}</a> --}}
                                    <a href="/hobby/tag/{{ $tag->id }}" style="font-size: 110%;" class="mr-2 badge badge-{{ $tag->style }}" >{{ $tag->name }}</a>

                                    @auth

                                        <!-- DELETE -->
                                        <!-- 88 -->
                                        @can('delete', $tag)
                                            <form class="float-right" style="display: inline;" action="/tag/{{$tag->id}}" method="post">
                                                @csrf
                                                @method("DELETE")
                                                <input class="btn btn-sm btn-outline-danger ml-2" type="submit" title="Delete this tag" value="Delete">
                                            </form>
                                        @endcan

                                        <!-- EDIT -->
                                        <!-- 88 -->
                                        @can('update', $tag)
                                            <a class="float-right btn btn-sm btn-outline-primary ml-2" title="Edit this tag" href="/tag/{{$tag->id}}/edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        @endcan
                                    @endauth

                                    <!-- 56. Tạo link thống kê số bài viết có gắn thẻ tương ứng -->
                                    <a href="/hobby/tag/{{ $tag->id }}" class="float-right">in {{ $tag->hobbies->count() }} posts</a>

                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                @can('create', $tag)
                    <div class="mt-2">
                        <a class="btn btn-success btn-sm" href="/tag/create"><i class="fas fa-plus-circle"></i> Add new Tag</a>
                    </div>
                @endcan

            </div>
        </div>
    </div>
@endsection
