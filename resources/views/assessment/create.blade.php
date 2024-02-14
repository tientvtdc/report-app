@extends('layouts.admin')

@section('title', 'Tạo đánh giá')

@section('section')
    <form  method="post" action="{{ route('assessments.store') }}">
        @csrf
        @isset($error)
            <div class="text-danger tw-italic" role="alert">
                {{$error}}
            </div>
        @endisset

        <div class="mb-3 flex-row tw-flex gap-4">
            <div class="tw-w-full">
                <label for="yearPicker" class="form-label">Năm</label>
                <select class="form-control" id="yearPicker" name="schoolyear">
                    @for ($year = date("Y")+1; $year >= 2005; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                @error('schoolyear')
                <div class="text-danger tw-italic">{{ $message }}</div>
                @enderror
            </div>
            <div class="tw-w-full">
                <label for="yearPicker" class="form-label">Chương trình</label>
                <select class="form-control" id="yearPicker" name="program_id">
                    @foreach ($programs as $program)
                        <option value="{{ $program['id'] }}">{{ $program['program_vi_title'] }}</option>
                    @endforeach
                </select>
                @error('program_id')
                <div class="text-danger tw-italic">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <input type="text" class="form-control" id="content" name="assessment_content">
            @error('assessment_content')
            <div class="text-danger tw-italic">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group tw-mb-6">
            <label for="criteria">Chọn tiêu chí:</label><br>
            @foreach ($criteria as $criterion)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="criterion_{{ $criterion->id }}"
                           name="criteria[]" value="{{ $criterion->id }}">
                    <label class="form-check-label"
                           for="criterion_{{ $criterion->id }}">{{ $criterion->content }}</label>
                </div>
            @endforeach
            @error('criteria')
            <div class="text-danger tw-italic">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary ">Thêm</button>
    </form>
@endsection


