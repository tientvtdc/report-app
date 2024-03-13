<!-- resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', isset($title) ?? $title)


@section('content')
    <div class=" tw-w-full tw-h-screen tw-flex tw-flex-row">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark tw-fixed top-0 bottom-0" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="{{ asset('images/logofooter_fit_tdc.png') }}" alt=""
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
                    <a href="/evidences"
                       class="nav-link text-white hover:tw-bg-blue-400 {{ request()->is('evidences*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-check"></i>
                        Minh chứng
                    </a>
                </li>
                <li>
                    <a href="/assessments"
                       class="nav-link text-white hover:tw-bg-blue-400 {{ request()->is('assessments*') ? 'active' : '' }}">
                        <i class="bi bi-file-bar-graph"></i>
                        Đánh giá
                    </a>
                </li>
                @if( Auth::user()->hasRole('SUPER_ADMIN'))

                    <li>
                        <a href="/criteria"
                           class="nav-link text-white hover:tw-bg-blue-400 {{ request()->is('criteria*') ? 'active' : '' }}">
                            <i class="bi bi-card-checklist"></i>
                            Tiêu chí
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
                        <a href="/users"
                           class="nav-link text-white hover:tw-bg-blue-400 {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="bi bi-person-lock"></i>
                            User
                        </a>
                    </li>
                @endif

            </ul>
            <hr>
            <div class="dropdown">
                <div class="d-flex align-items-center text-white text-decoration-none dropdown-toggle tw-cursor-pointer"
                     data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle tw-mr-2"></i>
                    <strong>{{ auth()->user()->name }}</strong>
                </div>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="/change-password">Đổi mật khẩu</a></li>
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

            @hasSection('breadcrumbs')
                @yield('breadcrumbs')
            @else
                @if (Route::currentRouteName() && Breadcrumbs::exists(Route::currentRouteName()))
                    {{ Breadcrumbs::render(Route::currentRouteName()) }}
                @endif
            @endif

            <div class="tw-w-full tw-mt-6">
                @yield('section')
            </div>

        </div>
    </div>

@endsection


