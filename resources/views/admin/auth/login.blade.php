@extends('layouts.app-admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            @if(Session::has('login_failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{Session::get('login_failed')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card mt-5 border-0 shadow-sm">
                <div class="card-body text-center  px-5">
                    <div class="row ">
                        <div class="col mt-3 text-center">
                            <h2><b>Admin Login</b></h2>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.auth.login') }}">
                        @csrf

                    <div class="row mt-3">
                        <div class="col text-left">
                            <div class="alert alert-primary">
                                <h6>
                                    Email: webadmin@gmail.com
                                </h6>
                                <h6>
                                    Password: webadmin12345678
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                            autocomplete="email" autofocus
                            placeholder="Email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="off"
                            placeholder="Kata Sandi">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col">
                            <button type="submit" class="btn btn-block shadow border-0 btn-primary">
                                <b>{{ __('LOGIN') }}</b>
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
