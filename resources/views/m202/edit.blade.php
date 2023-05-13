@extends('layouts.main')

@section('title', $title)

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Quick Learning</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('m202.update', $m202->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="exampleInputEmail1">Exam Code</label>
                        <input type="text" name="code" class="form-control {{ $errors->has('code') ? 'is-invalid' : ''}}" value="{{ old('code', $m202->code) }}" placeholder="Enter exam code" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Exam Name</label>
                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" value="{{ old('name', $m202->name) }}" placeholder="Enter exam name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Exam Type</label>
                        <input type="text" name="type" class="form-control {{ $errors->has('type') ? 'is-invalid' : ''}}" value="{{ old('type', $m202->type) }}" placeholder="Enter exam type" required>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Duration</label>
                        <input type="text" name="duration" class="form-control {{ $errors->has('duration') ? 'is-invalid' : ''}}" value="{{ old('duration', $m202->duration) }}" placeholder="Enter duration" required>
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Start Date</label>
                        <input type="text" name="start_date" class="form-control datepicker {{ $errors->has('start_date') ? 'is-invalid' : ''}}" value="{{ old('start_date', date('d-m-Y', strtotime($m202->start_date))) }}" placeholder="Enter start date" size="30" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">End Date</label>
                        <input type="text" name="end_date" class="form-control datepicker {{ $errors->has('end_date') ? 'is-invalid' : ''}}" value="{{ old('end_date', date('d-m-Y', strtotime($m202->end_date))) }}" placeholder="Enter end date" size="30" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Facilitator</label>
                        <input type="text" name="facilitator" class="form-control {{ $errors->has('facilitator') ? 'is-invalid' : ''}}" value="{{ old('facilitator', $m202->facilitator) }}" placeholder="Enter facilitator" required>
                        @error('facilitator')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Maker</label>
                        <input type="text" name="maker" class="form-control {{ $errors->has('maker') ? 'is-invalid' : ''}}" value="{{ old('maker', $m202->maker) }}" placeholder="Enter maker" required>
                        @error('maker')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <a href="/m202" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'dd-mm-yy'
            });
        } );
    </script>
@endsection
