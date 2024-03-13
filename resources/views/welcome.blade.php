<!-- resources/views/child.blade.php -->

@extends('layouts.admin')

@section('title', 'Welcome')

@section('section')
    <div class="">
        <h4 class="">
            Thông tin hoạt động
        </h4>
        <form method="GET" action="/" class="input-group tw-items-center tw-w-full ">
            <input type="text" class="form-control"
                   placeholder="Tìm kiếm log theo tên người dùng ..." value="{{request()->input('q')}}"
                   name="q">
            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i>
            </button>
        </form>
        <div class="px-4 rounded py-4 mt-2 bg-white tw-max-h-[700px] overflow-y-auto" id="list-activity">
            @foreach($activities as $activity)
                <p>
                    <span class="tw-font-bold"> {{$activity['causer']['name']}}</span>
                    <span class="tw-italic tw-text-gray-500"> ( {{$activity['updated_at']}})</span>
                    : {{ $activity->description }}</p>
            @endforeach
        </div>
    </div>
@endsection

@section('script')
    @vite('resources/js/load-more-activity.js')
@endsection

