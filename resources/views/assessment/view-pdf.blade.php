@extends('layouts.admin')

@section('title', 'Chi tiết đánh giá')

{{--@section('breadcrumbs', 'Chi tiết đánh giá')--}}

@section('section')
    <style>
        @import url('https://fonts.cdnfonts.com/css/times-new-roman');
    </style>

    <div class="tw-mt-6 bg-white px-3 py-2" id="evidence-table">
        <div class="container " style=" font-family: 'Times New Roman', sans-serif;">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="tw-font-bold tw-uppercase">Bảng mã minh chứng <br>
                        Năm {{ $assessment['schoolyear']}}</h3>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <table class="table table-bordered  border-black ">
                        <thead>
                        <tr class="text-center align-top tw-font-bold">
                            <th style="background: #bebebe">Số</th>
                            <th style="background: #bebebe">Tiêu chí</th>
                            <th style="background: #bebebe">Tiêu chuẩn</th>
                            <th style="background: #bebebe">Mã minh chứng</th>
                            <th style="background: #bebebe" class="tw-max-w-[120px]">MC sử dụng chung cho các tiêu chí,
                                tiêu chuẩn
                            </th>
                            <th style="background: #bebebe">Tên minh chứng</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $stt = 0;
                            $genericEvidenceCodes = [];
                        @endphp
                        @foreach(  $assessmentCriteria as $assessmentCriterion)
                            @php
                                $criterion = $assessmentCriterion['criterion'];
                                $assessmentCriterion['assessmentCriterionStandards'] = collect($assessmentCriterion['assessmentCriterionStandards'])
                                    ->sortBy('standard.code')
                                    ->values()
                                    ->all();
                            @endphp

                            @foreach($assessmentCriterion['assessmentCriterionStandards'] as $assessmentCriterionStandards)

                                @foreach($assessmentCriterionStandards['evidences'] as $assessmentEvidence )

                                    @php
                                        $evidence = $assessmentEvidence['evidence'];
                                        if (!isset($genericEvidenceCodes[$evidence['id']])) {

                                        }
                                    @endphp



                                    <tr class="tw-border-top-[6px]! border-black">
                                        <td>{{++$stt}}</td>
                                        <td>{{ $criterion['code'] }}</td>
                                        <td>{{ $criterion['code']}}
                                            .{{ $assessmentCriterionStandards['standard']['code'] }}</td>
                                        @if (!isset($genericEvidenceCodes[$evidence['id']]))
                                            <td>{{ $criterion['code']}}
                                                .{{ $assessmentCriterionStandards['standard']['code'] }}
                                                .{{ $assessmentEvidence['code'] }}</td>
                                            <td class="tw-max-w-[120px]">
                                            </td>
                                            @php
                                                $genericEvidenceCodes[$evidence['id']] = ($criterion['code']) . '.' .
                                                    ($assessmentCriterionStandards['standard']['code']) . '.' . $assessmentEvidence['code'];
                                            @endphp
                                        @else
                                            <td></td>
                                            <td class="tw-max-w-[120px]">
                                                {{$genericEvidenceCodes[$evidence['id']]}}
                                            </td>
                                        @endif

                                        <td>{{ $evidence['title'] }}</td>
                                    </tr>
                                @endforeach
                            @endforeach

                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="tw-w-full text-center">
        <button class="btn btn-primary mt-4 mx-4 " id="btn-download">
            Tải xuống PDF
        </button>
        <button class="btn btn-success mt-4 mx-4 " id="btn-download-excel">
            Tải xuống Excel
        </button>
    </div>

@endsection

@section('script')
    @vite('resources/js/download-pdf.js')
@endsection
