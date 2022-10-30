@extends('layouts.app')

@section('content')

    <article class="content items-list-page">
        <form name="item" id="customerForm" action="{{ route('category.update', $category->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body" style="border:1px solid #eee;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name (Key) <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name"
                                   class="form-control @if($errors->has('name')) is-invalid @endif"
                                   value="{{ old('name', $category->name) }}" placeholder="Key">
                            @if($errors->has('name'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Label <span class="text-danger">*</span></label>
                            <input type="text" id="label" name="label"
                                   class="form-control @if($errors->has('label')) is-invalid @endif"
                                   value="{{ old('label', $category->label) }}" placeholder="Label">
                            @if($errors->has('label'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('label') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Icon <span class="text-danger">*</span></label>
                            <input type="file" id="label" name="attachment"
                                   class="form-control @if($errors->has('attachment')) is-invalid @endif"
                                   value="{{ old('attachment') }}" placeholder="Label">
                            @if($errors->has('attachment'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('attachment') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Position <span class="text-danger">*</span></label>
                            <input type="number" id="label" name="position_number"
                                   class="form-control @if($errors->has('position_number')) is-invalid @endif"
                                   value="{{ old('position_number', $category->position_number) }}">
                            @if($errors->has('position_number'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('position_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-control @if($errors->has('status')) is-invalid @endif">
                                <option value="1" @if(old('status', $category->status) == '1') selected @endif>Active</option>
                                <option value="0" @if(old('status', $category->status) == '0') selected @endif>Inactive</option>
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success pull-right" type="submit">Save</button>
                </div>
            </div>
        </form>
    </article>
@endsection

@section('header')

@endsection

@section('footer')

@endsection
