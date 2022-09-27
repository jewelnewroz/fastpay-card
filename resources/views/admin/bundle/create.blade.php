@extends('layouts.app')

@section('content')

    <article class="content items-list-page">
        <form name="item" id="customerForm" action="{{ route('bundle.store')}}" method="POST">
            @csrf
            <div class="card-body" style="border:1px solid #eee;">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Bundle Name <span class="text-danger">*</span></label>
                            <input type="text" id="firstName" name="name"
                                   class="form-control @if($errors->has('name')) is-invalid @endif"
                                   value="{{ old('name') }}" placeholder="First name">
                            @if($errors->has('name'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Operator <span class="text-danger">*</span></label>
                            <select class="form-control" name="operator_id" required>
                                <option value="">Select operator</option>
                                @foreach($operators as $operator)
                                    <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('operator_id'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('operator_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Logo <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" placeholder="Select logo">
                            @if($errors->has('logo'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('logo') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>POS Logo <span class="text-danger">*</span></label>
                            <input type="file" name="pos_logo" class="form-control" placeholder="Select logo">
                            @if($errors->has('pos_logo'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('pos_logo') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Denomination <span class="text-danger">*</span></label>
                            <input type="text" name="top_up_profile" class="form-control" placeholder="Denomination ID">
                            @if($errors->has('top_up_profile'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('top_up_profile') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" placeholder="Price">
                            @if($errors->has('price'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('price') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Applicable for <span class="text-danger">*</span></label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input name="applicable_for" type="checkbox" id="checkboxPrimary2">
                                    <label for="checkboxPrimary2">
                                        Reseller
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input name="applicable_for" type="checkbox" id="checkboxPrimary3">
                                    <label for="checkboxPrimary3">
                                        Dealer
                                    </label>
                                </div>
                            </div>
                            @if($errors->has('applicable_for'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('applicable_for') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" placeholder="Status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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
