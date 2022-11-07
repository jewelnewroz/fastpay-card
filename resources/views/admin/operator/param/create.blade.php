@extends('layouts.app')

@section('content')

    <article class="content items-list-page">
        <form name="item" id="customerForm" action="{{ route('operator.param.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="operator_id" value="{{ $operator->id }}">
            <div class="card-body" style="border:1px solid #eee;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Field Name <span class="text-danger">*</span></label>
                            <input type="text" id="firstName" name="name"
                                   class="form-control @if($errors->has('name')) is-invalid @endif"
                                   value="{{ old('name') }}" placeholder="Field name" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Field type <span class="text-danger">*</span></label>
                            <select class="form-control" name="type" required>
                                <option value="">Select type</option>
                                <option value="text">Text</option>
                                <option value="numeric">Integer</option>
                            </select>
                            @if($errors->has('type'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('type') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Required? <span class="text-danger">*</span></label>
                            <select class="form-control" name="is_required" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @if($errors->has('is_required'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('is_required') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Field label <span class="text-danger">*</span></label>
                            <input type="text" id="position" name="label" placeholder="Label"
                                   class="form-control @if($errors->has('label')) is-invalid @endif"
                                   value="{{ old('label') }}" required>
                            @if($errors->has('label'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('label') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Placeholder</label>
                            <input type="text" id="position" name="placeholder" placeholder="Placeholder"
                                   class="form-control @if($errors->has('placeholder')) is-invalid @endif"
                                   value="{{ old('placeholder') }}">
                            @if($errors->has('placeholder'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('placeholder') }}
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
