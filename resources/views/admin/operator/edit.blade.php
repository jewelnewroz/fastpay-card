@extends('layouts.app')

@section('content')

    <article class="content items-list-page">
        <form name="item" id="customerForm" action="{{ route('operator.create')}}" method="POST">
            @csrf
            @if(count(array_intersect($errors->all(), ['name', 'mobile', 'email'])) > 0)
                error found
            @endif
            <div class="card-body" style="border:1px solid #eee;">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name</label>
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
                            <label>Email</label>
                            <input type="email" name="email"
                                   class="form-control @if($errors->has('email')) is-invalid @endif"
                                   value="{{ old('email') }}" placeholder="Email address">
                            @if($errors->has('email'))
                                <div class="invalid-feedback" style="display:block;">
                                    {{ $errors->first('email') }}
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
