@extends('layouts.app')

@section('content')

    <article class="content items-list-page">
        <form name="item" id="customerForm" action="{{ route('operator.update', $operator->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body" style="border:1px solid #eee;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Operator Name <span class="text-danger">*</span></label>
                            <input type="text" id="firstName" name="name"
                                   class="form-control @if($errors->has('name')) is-invalid @endif"
                                   value="{{ old('name', $operator->name) }}" placeholder="First name">
                            @if($errors->has('name'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Logo (for POS)<span class="text-danger">*</span></label>
                            <input type="file" class="form-control" placeholder="Select logo">
                            @if($errors->has('logo'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('logo') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Category <span class="text-danger">*</span></label>
                            <select class="form-control" name="gateway" required>
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" @if($operator->category == $category->name) selected @endif>{{ $category->label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('category') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Gateway <span class="text-danger">*</span></label>
                            <select class="form-control" name="gateway" required>
                                <option value="">Select gateway</option>
                                @foreach($gateways as $gateway)
                                    <option value="{{ $gateway->name }}" @if($operator->gateway == $gateway->name) selected @endif>{{ $gateway->label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('gateway'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('gateway') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Position <span class="text-danger">*</span></label>
                            <input type="number" id="position" name="position"
                                   class="form-control @if($errors->has('position')) is-invalid @endif"
                                   value="{{ old('position', $operator->position) }}">
                            @if($errors->has('position'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('position') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control">
                                <option value="1" @if($operator->status == 1) selected @endif>Active</option>
                                <option value="0" @if($operator->status == 0) selected @endif>Inactive</option>
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Permissions <span class="text-danger">*</span></label>
                            <div class="form-group clearfix">
                                @foreach($roles as $role)
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="permissions[]" value="{{ $role->id }}"
                                               id="permissions">
                                        <label for="checkboxPrimary1">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            </div>
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
