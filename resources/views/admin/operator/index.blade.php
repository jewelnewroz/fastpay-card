@inject('commonHelper', \App\Helper\CommonHelper::class)
@extends('layouts.app')

@section('actionToolBar')
    <a href="{{ route('operator.create') }}" class="btn btn-sm btn-success ml-2"><i class="fa fa-plus"></i> Add new</a>
@endsection

@section('filterBar')
    <div class="form-group">
        <button type="button" class="btn btn-warning" id="filterBtn"><i class="fa fa-search"></i></button>
    </div>
    <div class="form-group">
        <select class="form-control" id="status">
            <option value="">Select status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
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
                            <th>
                                <div>Logo</div>
                            </th>
                            <th>
                                <div>Operator name</div>
                            </th>
                            <th>
                                <div>Gateway</div>
                            </th>
                            <th>
                                <div>Type</div>
                            </th>
                            <th>
                                <div>Position</div>
                            </th>
                            <th>
                                <div>Status</div>
                            </th>
                            <th>
                                <div>Created at</div>
                            </th>
                            <th style="width:40px;v-align:middle;text-align:center;" class="align-middle">
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
        let url = "{{ route('operator.index') }}";
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
                    pages: 5, // number of pages to cache
                    'data': function (data) {
                        // Read values
                        data.keyword = $(customFilter).find('input#keywords').val();
                        data.status = $(customFilter).find('select#status').val();
                    }
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
                            return '<a href="/dashboard/operator/' + row['id'] + '"><img class="table-avatar" src="' + row['logo'] + '"></a>';
                        }
                    },
                    {
                        "mRender": function (data, type, row) {
                            return '<a href="/dashboard/operator/' + row['id'] + '">' + row['name'] + '</a>';
                        }
                    },
                    {"data": "gateway"},
                    {"data": "category"},
                    {"data": "position"},
                    {"data": "status"},
                    {"data": "created_at"},
                    {
                        "mRender": function (data, type, row) {
                            let str = "<div class='btn-group'> <button class='btn btn-default btn-sm dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fa fa-ellipsis-h' aria-hidden='true'></i></button> <div class='dropdown-menu dropdown-menu-right'> ";
                            str += "<a href='/dashboard/operator/" + row['id'] + "' class='dropdown-item'><i class='fa fa-eye'></i> View</a> ";
                            str += "<a href='/dashboard/operator/" + row['id'] + "/edit' class='dropdown-item'><i class='fa fa-edit'></i> Edit</a> ";
                            if (row['status'] != 'Active') {
                                str += "<a href='#' class='dropdown-item user-action' data-action='active' data-user-id='" + row['id'] + "'><i class='fa fa-check'></i> Active</a> ";
                            } else {
                                str += "<a href='#' class='dropdown-item user-action' data-action='deactive' data-user-id='" + row['id'] + "'><i class='fa fa-ban'></i> Deactive</a> ";
                            }
                            str += "</div> </div>";

                            return str;
                        }
                    }
                ],
                "columnDefs": [
                    {"targets": [6], "searchable": false, "orderable": false, "visible": true}
                ],
                "order": [[5, 'desc']],
                buttons: {!! json_encode($commonHelper->dataTableButtons(['copy', 'pdf','print', 'visibility'])) !!},
            });

            //Custom Filters
            $('input').keyup(function (event) {
                let keycode = (event.keyCode ? event.keyCode : event.which);
                table.draw();
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
                let url = "{{ route('user.index') }}";
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
