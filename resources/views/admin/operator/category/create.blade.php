@extends('layouts.app')

@section('content')

    <article class="content items-list-page">
        <form name="item" id="customerForm" action="{{ route('category.store')}}" method="POST">
            @csrf
            <div class="card-body" style="border:1px solid #eee;">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name (Key) <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name"
                                   class="form-control @if($errors->has('name')) is-invalid @endif"
                                   value="{{ old('name') }}" placeholder="Key">
                            @if($errors->has('name'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Label <span class="text-danger">*</span></label>
                            <input type="text" id="label" name="label"
                                   class="form-control @if($errors->has('label')) is-invalid @endif"
                                   value="{{ old('label') }}" placeholder="Label">
                            @if($errors->has('label'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('label') }}
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
