@inject('commonHelper', \App\Helper\CommonHelper::class)
@extends('layouts.app')

@section('actionToolBar')
    <a href="{{ route('operator.edit', $operator->id) }}" class="btn btn-sm btn-success ml-2"><i class="fa fa-edit"></i> Edit</a>
@endsection

@section('content')
    <section class="content">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true">Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#requestParams" role="tab"
                   aria-controls="requestParams" aria-selected="false">Request params</a>
            </li>
        </ul>
        <div class="tab-content p-3 bg-white" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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

            <div class="tab-pane" id="requestParams" role="tabpanel" aria-labelledby="requestParams-tab">
                <div class="btn-group float-right mb-3">
                    <a href="#" class="btn btn-success"><i class="fa fa-plus"></i> Add new request param</a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Field name</th>
                        <th>Field Label</th>
                        <th>Placeholder</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('header')

@endsection

@section('footer')

@endsection
