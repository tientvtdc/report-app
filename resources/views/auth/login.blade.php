<!-- resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Đăng Nhập')

@section('content')
    <div class="tw-bg-blue-50 tw-w-full tw-h-screen">

        <div class="container mx-auto d-flex flex-column tw-justify-center tw-items-center tw-h-full">
            <div class="tw-max-w-lg tw-w-full mx-auto tw-bg-white py-4 tw-px-10 rounded-4">
                <img src="https://hoanghnguyen9109.github.io/fit-tuyensinh/logofooter_fit_tdc.png" alt=""
                     class="tw-w-full">
                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    <div class="mb-3 mt-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                               pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                               title="Vui lòng nhập địa chỉ email hợp lệ" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me">
                        <label class="form-check-label" for="remember_me">Nhớ đăng nhập</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Đăng nhập</button>
                </form>
            </div>
        </div>

    </div>


    @yield('script');
@endsection


