@extends('layouts.admin')

@section('title', 'Các minh chứng hết hạn')


@section('section')

    <div class="tw-mt-6 bg-white px-3 py-2" id="evidence-table">
        <div class="container ">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="tw-font-bold tw-uppercase mt-4">Các minh chứng hết hạn </h3>
                </div>
            </div>
            <div class="row mt-2    ">
                <div class="col-md-12">
                    <form action="{{ route('assessments.cloneFromAssessment',[$assessment]) }}" method="post">
                        @csrf
                        @foreach($expireEvidences as $expireEvidence)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="expireEvidence[]"
                                       value="{{$expireEvidence['id']}}"
                                       id="expireEvidence{{$expireEvidence['id']}}">
                                <label class="form-check-label" for="expireEvidence{{$expireEvidence['id']}}">
                                    {{$expireEvidence['title']}}
                                    <span class="text-danger">
                                       (Hiệu lực từ {{$expireEvidence['valid_from']}}
                                        - {{$expireEvidence['valid_to']}})
                                    </span>
                                </label>
                            </div>
                        @endforeach
                        <div class="tw-w-full text-center">
                            <button class="btn btn-primary mt-4 " id="btn-download">
                                Tiếp tục sao chép
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
