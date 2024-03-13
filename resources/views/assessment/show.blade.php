@extends('assessment.layout')

@section('title', 'Chi tiết đánh giá')

{{--@section('breadcrumbs', 'Chi tiết đánh giá')--}}

@section('information')
    <div class="tw-mt-6 bg-white px-3 pt-2 tw-pb-6 rounded">
        @foreach(  $assessmentCriteria as $assessmentCriterion)
            @php
                $criterion = $assessmentCriterion['criterion'];
            @endphp

            <div class="mt-4">
                <a href="{{route('assessments.addStandards',['id' => $assessment['id']])}}?{{ http_build_query(['idCriteria' => $criterion['id']]) }}"
                   class="tw-text-blue-600 tw-font-bold tw-text-xl">
                    {{ $criterion['code'] }} {{$criterion['content']}}
                </a>
                @php
                    $assessmentCriterion['assessmentCriterionStandards'] = collect($assessmentCriterion['assessmentCriterionStandards'])
                        ->sortBy('standard.code')
                        ->values()
                        ->all();
                @endphp
                @foreach($assessmentCriterion['assessmentCriterionStandards'] as $assessmentCriterionStandards)
                    <div>
                        <div class="flex-row d-flex justify-content-between">

                            <div class="tw-ml-4">
                                <div class="tw-font-semibold tw-text-lg mt-3">
                                    {{ $criterion['code'] }}.{{ $assessmentCriterionStandards['standard']['code'] }}
                                    {{ $assessmentCriterionStandards['standard']->content }}
                                </div>
                                @foreach($assessmentCriterionStandards['evidences'] as $assessmentEvidence )

                                    @php
                                        $evidence = $assessmentEvidence['evidence'];
                                    @endphp
                                    @if($evidence['attachment'])
                                        <a class="tw-ml-4 tw-italic text-decoration-none"
                                           href="{{ Storage::url($evidence['attachment'])}} "
                                           title="Tải xuống {{basename($evidence['attachment'])}}"
                                        >
                                            - {{$assessmentEvidence['code']}} {{$evidence['title']}}
                                        </a>
                                    @else
                                        <div class="tw-ml-4 tw-italic ">
                                            - {{$assessmentEvidence['code']}} {{$evidence['title']}}
                                        </div>
                                    @endif

                                @endforeach
                            </div>

                            <div id="standard-{{$assessmentCriterionStandards['id']}}" class="pt-2">
                                <button data-id="{{$assessmentCriterionStandards['id']}}"
                                        class="tw-cursor-pointer tw-text-blue-600
                                 tw-font-bold btn  p-0 tw-max-h-fit"
                                        title="Thêm minh chứng"
                                        data-bs-toggle="modal" data-bs-target="#addEvidenceModal"
                                >
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr/>

        @endforeach
        <a href="{{route('assessments.addListCriterion',['id'=>request()->route('id')])}}"
           class="link-primary d-block tw-font-bold tw-cursor-pointer tw-mt-4">
            Thêm tiêu chí
        </a>
    </div>
    <div class="tw-pb-12"/>
    <div class="modal  fade" id="addEvidenceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog tw-max-w-[80vw]">
            <div class="modal-content tw-bg-blue-50 tw-h-full tw-min-h-[90vh]">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm minh chứng cho tiêu chuẩn</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-row gap-2 ">
                    <div class="tw-w-3/5 tw-min-h-max d-flex flex-column">
                        <div class="tw-w-full d-flex flex-row">
                            <input class="form-control tw-w-full"
                                   id="search-evidence"
                                   placeholder="Tìm kiếm minh chứng" autofocus>
                            <div class="dropdown" id="dropdown-filter-evidence">
                                <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="bi bi-funnel"></i>
                                </button>
                                <ul class="dropdown-menu tw-min-w-[180px]">
                                    <li class="tw-w-full">
                                        <button data-sort-by="desc" class="px-2 tw-w-full btn-filter btn active">Theo
                                            ngày mới nhất
                                        </button>
                                    </li>
                                    <li class="tw-w-full">
                                        <button data-sort-by="asc" class="px-2 tw-w-full btn-filter btn">Theo ngày cũ
                                            nhất
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <div id="list-search-evidence"
                             class="flex-column d-flex mt-2 bg-white px-2 py-1 border rounded
                        tw-h-full tw-overflow-y-scroll tw-max-h-[600px]">
                        </div>
                    </div>
                    <div class="tw-w-2/5">
                        <form class="tw-h-full" method="post"
                              action="{{route('assessments.addEvidence',['id'=> request()->route('id')])}}"
                        >
                            @csrf
                            @method('put')
                            <input type="hidden" class="input-id-standard"
                                   name="assessment_criterion_standard_id">
                            <div class="tw-w-full mt-2 text-center">
                                Danh sách đã thêm
                            </div>
                            <div id="list-add-evidence"
                                 class="flex-column d-flex mt-3 bg-white px-2 py-1 border rounded
                                tw-h-full tw-overflow-y-scroll tw-max-h-[600px] tw-text-blue-400">
                            </div>
                            <div class="text-center tw-w-full pt-1">
                                <button type="submit" class="btn btn-primary btn-sm tw-min-w-[120px] mx-auto ">
                                    Lưu
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.user_id = {{ Auth::id() }};
        window.userRole = "{{ Auth::user()->hasRole('SUPER_ADMIN') ? 'SUPER_ADMIN' : 'USER' }}";
    </script>
    @vite('resources/js/add-evidence.js')
@endsection
