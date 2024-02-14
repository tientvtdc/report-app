<!-- resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', isset($title) ?? $title)


@section('content')
    <div class="tw-bg-blue-50 tw-w-full tw-h-screen tw-flex tw-flex-row">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark tw-fixed top-0 bottom-0" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="https://hoanghnguyen9109.github.io/fit-tuyensinh/logofooter_fit_tdc.png" alt=""
                     class="tw-w-full bg-white px-2 py-2 rounded-2">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto gap-1">
                <li>
                    <a href="/" class="nav-link text-white {{ request()->is('/') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 "></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/programs" class="nav-link text-white hover:tw-bg-blue-400">
                        <i class="bi bi-book"></i>
                        Chương trình
                    </a>
                </li>
                <li>
                    <a href="/assessments"
                       class="nav-link text-white hover:tw-bg-blue-400 {{ request()->is('assessments*') ? 'active' : '' }}">
                        <i class="bi bi-book"></i>
                        Đánh giá
                    </a>
                </li>
                <li>
                    <a href="/standards"
                       class="nav-link text-white hover:tw-bg-blue-400 {{ request()->is('standards*') ? 'active' : '' }}">
                        <i class="bi bi-info-square"></i>
                        Tiêu chuẩn
                    </a>
                </li>
                <li>
                    <a href="/role" class="nav-link text-white hover:tw-bg-blue-400">
                        <i class="bi bi-person-lock"></i>
                        Role
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <div class="d-flex align-items-center text-white text-decoration-none dropdown-toggle tw-cursor-pointer"
                     data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle tw-mr-2"></i>
                    <strong>{{ auth()->user()->name }}</strong>
                </div>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#">Đổi mật khẩu</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>

                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="dropdown-item">Đăng xuất</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tw-ml-[300px] tw-pt-6 tw-w-full max tw-pr-6">
            {{ Breadcrumbs::render(Route::currentRouteName()) }}
            <div class="tw-w-full tw-mt-6">
                @yield('section')
            </div>
        </div>
    </div>

@endsection


