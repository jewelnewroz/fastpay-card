@inject('commonHelper', \App\Helper\CommonHelper::class)
@extends('layouts.app')

@section('actionToolBar')
    <a href="{{ route('operator.edit', $operator->id) }}" class="btn btn-sm btn-success ml-2"><i class="fa fa-edit"></i> Edit</a>
@endsection

@section('content')
    <section class="content">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link @if(in_array(request()->input('tab'), ['', 'info'] )) active @endif" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true">Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->input('tab') == 'param') active @endif" id="profile-tab" data-toggle="tab" href="#requestParams" role="tab"
                   aria-controls="requestParams" aria-selected="false">Request params</a>
            </li>
        </ul>
        <div class="tab-content p-3 bg-white" id="myTabContent">
            <div class="tab-pane @if(in_array(request()->input('tab'), ['', 'info'] )) fade show active @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <td>{{ $operator->name }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $operator->operatorCategory->label }}</td>
                    </tr>
                    <tr>
                        <th>Gateway</th>
                        <td>{{ \App\Helper\CommonHelper::purseGateway($operator->gateway) }}</td>
                    </tr>
                    <tr>
                        <th>Position</th>
                        <td>{{ $operator->position }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $operator->nice_status }}</td>
                    </tr>
                </table>
            </div>

            <div class="tab-pane @if(request()->input('tab') == 'param') fade show active @endif" id="requestParams" role="tabpanel" aria-labelledby="requestParams-tab">
                <div class="btn-group float-right mb-3">
                    <a href="{{ route('operator.param.create', $operator->id) }}" class="btn btn-success"><i class="fa fa-plus"></i> Add new request param</a>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Field name</th>
                        <th>Field type</th>
                        <th>Field Label</th>
                        <th>Placeholder</th>
                        <th>Is Required?</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($operator->requestParams as $param)
                    <tr>
                        <td>{{ $param->name }}</td>
                        <td>{{ $param->type }}</td>
                        <td>{{ $param->label }}</td>
                        <td>{{ $param->placeholder }}</td>
                        <td>{{ $param->is_required ? 'Yes' : 'No' }}</td>
                        <td>
                            <form action="{{ route('operator.param.delete', $param->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i> Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('header')

@endsection

@section('footer')

@endsection
