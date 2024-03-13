@extends('layouts.admin')

@section('section')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <div class="mb-3 form-group row">
                            <label for="current_password"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu hiện tại') }}</label>

                            <div class="col-md-6">
                                <input id="current_password" type="password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       name="current_password" required autofocus>

                                @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-group row">
                            <label for="new_password"
                                   class="col-md-4 col-form-label text-md-right">{{ __(' Mật khẩu mới') }}</label>

                            <div class="col-md-6">
                                <input id="new_password" type="password"
                                       class="form-control @error('new_password') is-invalid @enderror"
                                       name="new_password" required>

                                @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-group row">
                            <label for="new_password_confirmation"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Xác nhận Mật khẩu') }}</label>

                            <div class="col-md-6">
                                <input id="new_password_confirmation" type="password" class="form-control"
                                       name="new_password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Đổi mật khẩu') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
