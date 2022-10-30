@inject('commonHelper', \App\Helper\CommonHelper::class)
@extends('layouts.app')

@section('actionToolBar')
    <a href="{{ route('category.create') }}" class="btn btn-sm btn-success ml-2"><i class="fa fa-plus"></i> Add new</a>
@endsection

@section('filterBar')
    <div class="form-group">
        <button type="button" class="btn btn-warning" id="filterBtn"><i class="fa fa-search"></i></button>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Search" id="keywords">
    </div>
@endsection

@section('content')

    <article class="content items-list-page">
        <div class="card items p-2">
            <div class="col-sm-12">
                <div class="clearfix"></div>
                <div class="box" style="padding:15px 0;">
                    <table class="table table-striped table-bordered" id="dataTable">
                        <thead>
                        <tr>
                            <th style="width:40px;">
                                <div>Icon</div>
                            </th>
                            <th>
                                <div>Key</div>
                            </th>
                            <th>
                                <div>Label</div>
                            </th>
                            <th>
                                <div>Position</div>
                            </th>
                            <th>
                                <div>Status</div>
                            </th>
                            <th style="width:80px;" class="align-middle">
                                <div>Action</div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div><!--/col-->
            <div class="clearfix"></div>
        </div>
    </article>
@endsection

@section('header')

@endsection

@section('footer')
    <script>
        let url = "{{ route('category.index') }}";
        $.fn.dataTable.ext.classes.sPageButton = 'page-item';

        $(function () {
            let customFilter = $('#filterToolBar');
            let table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "deferRender": true,
                "bAutoWidth": false,
                "sPageButtonActive": "active",
                "ajax": {
                    'url': url,
                    pages: 5
                },
                dom: 'lBfrtip',
                "lengthChange": true,
                lengthMenu: [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]],
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_ ",
                },
                "pageLength": 25,
                "bFilter": true,
                "bInfo": true,
                "searching": false,
                saveState: true,
                "columns": [
                    {
                        "mRender": function (data, type, row) {
                            return "<img src='/" + row['icon'] + "' class='table-avatar'>";
                        }
                    },
                    {"data": "name"},
                    {"data": "label"},
                    {"data": "position_number"},
                    {"data": "status"},
                    {
                        "mRender": function (data, type, row) {
                            return "<a href='/dashboard/operator/category/" + row['id'] + "/edit' class='btn btn-default'><i class='fa fa-edit'></i> Edit</a> ";
                        }
                    }
                ],
                "columnDefs": [
                    {"targets": [5], "searchable": false, "orderable": false, "visible": true}
                ],
                "order": [[1, 'ASC']],
                buttons: {!! json_encode($commonHelper->dataTableButtons(['pdf','print'])) !!},
            });

            //Custom Filters
            $('input').keyup(function (event) {
                let keycode = (event.keyCode ? event.keyCode : event.which);
                // if(keycode == '13'){
                table.draw();
                // }
            });

            //Custom Filters
            $('button').click(function () {
                table.draw();
            });

            //Custom Filters
            $('select').change(function () {
                table.draw();
            });

            $('table').on('click', '.user-action', function (e) {
                e.defaultPrevented;
                console.log(this);
                let url = "{{ route('category.index') }}";
                let action = $(this).data('action');
                let id = $(this).data('user-id');

                let data = {action: action, id: id};
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are going to " + action + " this customer account.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            dataType: 'json',
                            success: function (response, textStatus, xhr) {
                                table.draw();
                                Toast.fire({
                                    icon: response.label,
                                    title: response.content
                                });
                            }
                        });
                    }
                });
                return false;
            });
        });
    </script>
@endsection
