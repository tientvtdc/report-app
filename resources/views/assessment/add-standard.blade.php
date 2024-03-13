@extends('assessment.layout')

@section('title', 'Thêm tiêu chuẩn đánh giá')

@section('information')

    <div class="tw-mt-6 tw-flex-row d-flex gap-4 tw-pb-12">
        <div class="tw-w-1/2">
            <div class="tw-text-blue-600 tw-text-xl tw-font-bold tw-pb-2.5">
                {{$criteria['content']}}
            </div>
            <form class="tw-w-full tw-mt-4" method="post">
                @csrf
                <div class="px-3 py-1 bg-white mt-4 border rounded">
                    <table class="table table-sm ">
                        <thead>
                        <tr class="align-top text-center">
                            <th scope="col">Mã</th>
                            <th scope="col">Nội dung</th>
                            <th scope="col">Điểm chuẩn</th>
                            <th scope="col">Điểm đánh giá</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody id="form-add-standard">
                        @php
                            $rowIDs = [];
                        @endphp
                        @foreach ($assessmentCriterionStandards as $assessmentCriterionStandard)
                            @php
                                $rowIDs[] = $assessmentCriterionStandard['standard']['id'];
                            @endphp
                            <tr class="input-standard-box">
                                <td>{{$assessmentCriterionStandard['standard']['code']}}</td>
                                <td>{{$assessmentCriterionStandard['standard']['content']}}</td>
                                <td class="text-center">{{$assessmentCriterionStandard['standard']['point']}}</td>
                                <td class="text-center">
                                    <input class="form-control tw-max-w-[120px] tw-ml-2" type="number"
                                           value="{{$assessmentCriterionStandard['assessed_point']}}" min="0"
                                           max="{{$assessmentCriterionStandard['standard']['point']}}"
                                           name="standards[{{$assessmentCriterionStandard['standard']['id']}}][point]">
                                </td>
                                <td>
                                    <button class="btn text-danger delete-button" type="button">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                    <input type="hidden" value="{{$assessmentCriterionStandard['standard']['id']}}"
                                           name="standards[{{$assessmentCriterionStandard['standard']['id']}}][id]">
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>
                <div class="text-center">
                    <button class="btn btn-primary mt-2 tw-w-min-[150px]" type="submit">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
        <div class="tw-w-1/2">
            <div class="tw-flex-row tw-w-full gap-4 tw-inline-flex">
                <div>
                    <a href="{{route('standards.create')}}" class="btn btn-success tw-min-w-[120px] ">Thêm</a>
                </div>
                <div class="input-group tw-items-center ">
                    <input id="input-search-standard" type="text" class="form-control"
                           placeholder="Tìm kiếm tiêu chuẩn "
                           aria-label="Recipient's username"
                           aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary" type="button" id="button-addon2"><i
                                class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="tw-mt-6 p-3 border bg-white rounded">
                <table class="table table-sm">
                    <thead>
                    <tr class="align-top text-center">
                        <th scope="col">Mã</th>
                        <th scope="col">Nội dung</th>
                        <th scope="col">Điểm chuẩn</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="table-search-standard">
                    @foreach ($standards as $standard)
                        <tr>
                            <td>{{$standard['code']}}</td>
                            <td>{{$standard['content']}}</td>
                            <td class="text-center">{{$standard['point']}}</td>
                            <td>
                                <div
                                        data-code="{{$standard['code']}}"
                                        data-id="{{$standard['id']}}"
                                        data-point="{{$standard['point']}}"
                                        class="tw-cursor-pointer tw-text-3xl tw-text-blue-400 tw-font-bold add-button-standard">
                                    <i class="bi bi-plus"></i>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div>
        </div>

        @endsection

        @section('script')

            <script>
                window.rowIDs = {!! json_encode($rowIDs) !!};
            </script>

    @vite('resources/js/add-standard.js')
@endsection

