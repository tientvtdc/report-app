@extends('layouts.admin')

@section('title', isset($title) ?? $title)

@section('section')
    <div>
        <div class="flex-row gap-4 d-flex flex-wrap bg-white rounded px-2 py-3 border">
            <div>
              <span class="tw-font-bold">
                   Năm học:
              </span> {{$assessment['schoolyear']}}
            </div>
            <div>
                <span class="tw-font-bold"> Chương trình:</span> {{$assessment['program']['program_vi_title']}}
            </div>
            <div class="tw-ml-auto tw-mr-4 d-flex flex-row">
                <a class="mx-3 "
                   href="{{route('assessments.generatePDF',['id' => $assessment['id']])}}"
                >
                    <i class="bi bi-printer"></i> Tải PDF
                </a>

                <a
                        href="{{route('assessments.downloadFileEvidence',['id' => $assessment['id']])}}"
                        class="mx-3" target="_blank">
                    <i class="bi bi-download"></i> Tải file minh chứng
                </a>

            </div>
            <div class="tw-w-full">
                <span class="tw-font-bold"> Nội dung: </span>{{$assessment['content']}}
            </div>
        </div>
        <div class="px-2">
            @yield('information')
        </div>
    </div>
@endsection



