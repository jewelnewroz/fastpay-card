@extends('layouts.app')

@section('content')
    <article class="content items-list-page">
        <form name="item" id="customerForm" action="{{ route('bundle.update', $bundle->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body" style="border:1px solid #eee;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Operator <span class="text-danger">*</span></label>
                            <select class="form-control" name="operator_id" required>
                                <option value="">Select operator</option>
                                @foreach($operators as $operator)
                                    <option value="{{ $operator->id }}" @if(old('operator_id', $bundle->operator_id) == $operator->id) selected @endif>{{ $operator->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('operator_id'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('operator_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bundle Name <span class="text-danger">*</span></label>
                            <input type="text" id="firstName" name="name"
                                   class="form-control @if($errors->has('name')) is-invalid @endif"
                                   value="{{ old('name', $bundle->name) }}" placeholder="First name" required>
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
                            <label>Logo <span class="text-danger">*</span></label>
                            <input type="file" name="attachment" class="form-control" placeholder="Select logo">
                            @if($errors->has('logo'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('logo') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Denomination <span class="text-danger">*</span></label>
                            <input type="text" name="top_up_profile" value="{{ old('top_up_profile', $bundle->top_up_profile) }}" class="form-control" placeholder="Denomination ID">
                            @if($errors->has('top_up_profile'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('top_up_profile') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" value="{{ old('price', $bundle->price) }}" placeholder="Price" required>
                            @if($errors->has('price'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('price') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Validity <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" name="validity" value="{{ old('validity', $bundle->validity) }}" class="form-control" placeholder="Validity" required>
                            </div>
                            @if($errors->has('validity'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('validity') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Position <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" name="position" value="{{ old('position', $bundle->position) }}" class="form-control" value="99" placeholder="Position">
                            </div>
                            @if($errors->has('position'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('position') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" placeholder="Status" required>
                                <option value="1" @if(old('status', $bundle->status) == '1') selected @endif>Active</option>
                                <option value="0" @if(old('status', $bundle->status) == '0') selected @endif>Inactive</option>
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
                    <button class="btn btn-success pull-right" type="submit">Create bundle</button>
                </div>
            </div>
        </form>
    </article>
@endsection

@section('header')

@endsection

@section('footer')

@endsection
