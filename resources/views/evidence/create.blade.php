@extends('layouts.admin')

@section('title', 'Tạo đánh giá')

@section('section')
    <div class="row justify-content-start">
        <div class="col-md-9">
            <div class="card rounded">
                <div class="card-header tw-text-xl tw-font-bold">{{ __('Tạo Minh Chứng') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('evidences.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="title">{{ __('Tiêu đề') }}</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   name="title" id="title" value="{{ old('title') }}" required>

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="title">{{ __('Tên Phòng - Khoa - Trung tâm cấp') }}</label>
                            <input type="text" class="form-control @error('name_organizations') is-invalid @enderror"
                                   name="name_organizations" id="name_organizations" value="{{ old('name_organizations') }}" required>

                            @error('name_organizations')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group mb-3">
                            <label for="issued_at">{{ __('Ngày cấp') }}</label>
                            <input type="date" class="form-control @error('issued_at') is-invalid @enderror"
                                   name="issued_at" id="issued_at" value="{{ old('issued_at') }}" required>

                            @error('issued_at')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="valid_from">{{ __('Có hiệu lực từ') }}</label>
                            <input type="date" class="form-control @error('valid_from') is-invalid @enderror"
                                   name="valid_from" id="valid_from" value="{{ old('valid_from') }}">

                            @error('valid_from')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="valid_to">{{ __('Có hiệu lực đến') }}</label>
                            <input type="date" class="form-control @error('valid_to') is-invalid @enderror"
                                   name="valid_to" id="valid_to" value="{{ old('valid_to') }}">

                            @error('valid_to')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="attachment">{{ __('Đính kèm') }}</label>
                            <input type="file" class="form-control @error('attachment') is-invalid @enderror"
                                   name="attachment" id="attachment">
                            <div id="my-dropzone" class="dropzone"></div>

                            @error('attachment')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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


