@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __($user->name) }}</div>

                    <div class="card-body">
                        <b>Motto: </b> {{ $user->motto }}<br>
                        <p class="mt-2"><b>About me: </b><br> {{ $user->about_me }}</p>

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
