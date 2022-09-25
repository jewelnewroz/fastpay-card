@extends('layouts.app')

@section('content')

    <article class="content items-list-page">
        <form name="item" id="customerForm" action="{{ route('operator.store')}}" method="POST">
            @csrf
            @if(count(array_intersect($errors->all(), ['name', 'mobile', 'email'])) > 0)
                error found
            @endif
            <div class="card-body" style="border:1px solid #eee;">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Operator Name <span class="text-danger">*</span></label>
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
                            <label>Gateway <span class="text-danger">*</span></label>
                            <select class="form-control" name="gateway" required>
                                <option value="">Select gateway</option>
                                @foreach($gateways as $gateway)
                                    <option value="{{ $gateway->name }}">{{ $gateway->label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('gateway'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('gateway') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title"
                                   class="form-control @if($errors->has('title')) is-invalid @endif"
                                   value="{{ old('title') }}" placeholder="Store">
                            @if($errors->has('title'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Store <span class="text-danger">*</span></label>
                            <input type="text" id="store" name="store"
                                   class="form-control @if($errors->has('store')) is-invalid @endif"
                                   value="{{ old('store') }}" placeholder="First name">
                            @if($errors->has('store'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('store') }}
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
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Applicable for <span class="text-danger">*</span></label>
                            <input type="file" name="user_types" class="form-control">
                            @if($errors->has('user_types'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('user_types') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success pull-right" type="submit">Update</button>
                </div>
            </div>
        </form>
    </article>
@endsection

@section('header')

@endsection

@section('footer')

@endsection
