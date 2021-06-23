@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __('Hobby Details') }}</div>

                    {{-- 29. Tạo trang xem chi tiết --}}
                    <div class="card-body">
                        <b>{{$hobby->name}}</b>
                        <p>{{$hobby->description}}</p>
                    </div>
                </div>

                {{-- 29. Tạo trang xem chi tiết --}}
                {{-- Điều hướng về /hobby --}}
                <div class="mt-2">
                    <a class="btn btn-primary btn-md" href="/hobby"><i class="fas fa-arrow-circle-up"></i> Back to Hobby</a>
                </div>

            </div>
        </div>
    </div>
@endsection
