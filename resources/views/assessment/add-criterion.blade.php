@extends('assessment.layout')

@section('title', 'Chỉnh sửa tiêu chí cho đánh giá')


@section('information')
    <div class="row justify-content-start -tw-mx-5 tw-mt-6">
        <div class="col-md-9">
            <div class="card rounded">
                <div class="card-header tw-text-xl tw-font-bold">{{ __('Chỉnh sửa tiêu chí cho đánh giá') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('assessments.storeListCriterion',
                        ['id'=>$assessment['id']]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        @foreach($criteria as $criterion)
                            <div class="form-check mt-2 tw-text-lg">
                                <input class="form-check-input"
                                       name="criteria[]"
                                       type="checkbox"
                                       value="{{$criterion['id']}}"
                                       id="criteria-{{$criterion['id']}}"
                                        {{ in_array($criterion->id, $assessmentCriteria->pluck('criterion_id')->toArray()) ?
                                            'checked' : '' }}
                                >

                                <label class="form-check-label" for="criteria-{{$criterion['id']}}">
                                    {{$criterion['content']}}
                                </label>
                            </div>
                        @endforeach
                        <div class="form-group mb-3 mt-3 tw-pt-6">
                            <button type="submit" class="btn btn-primary tw-min-w-[120px]">
                                {{ __('Lưu') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


