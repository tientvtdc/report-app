@extends('layouts.admin')

@section('title', 'Chi tiết đánh giá')

@section('section')
    <div>
        <div class="flex-row gap-4 d-flex flex-wrap">
            <div>
                Năm học: {{$assessment['schoolyear']}}
            </div>
            <div>
                Chương trình: {{$assessment['program']['program_vi_title']}}
            </div>
            <div class="tw-w-full">
                Nội dung: {{$assessment['content']}}
            </div>
        </div>

    </div>
@endsection


