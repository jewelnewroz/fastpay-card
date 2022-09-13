@extends('layouts.app')

@section('actionToolBar')
    <a href="{{ route('role.create') }}" class="btn btn-sm btn-success mr-2"><i class="fa fa-plus"></i> Add new</a>
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
        <div class="card items" style="padding: 15px">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <table class="table table-striped table-bordered" id="dataTable">
                            <thead>
                            <tr>
                                <th>
                                    <div>ID</div>
                                </th>
                                <th>
                                    <div>Name</div>
                                </th>
                                <th>
                                    <div>Permission</div>
                                </th>
                                <th style="width:135px;v-align:middle;text-align:center;" class="align-middle">
                                    <div><i class="fa fa-wrench"></i></div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div><!--/col-->
                <div class="clearfix"></div>
            </div>
        </div>
    </article>
@endsection

@section('header')

@endsection

@section('footer')
    <script>
        var url = "{{ route('role.index') }}";
        //
        // Pipelining function for DataTables. To be used to the `ajax` option of DataTables
        //
        $.fn.dataTable.ext.classes.sPageButton = 'page-item';
        $(function () {
            var customFilter = $('#filterToolBar');
            var keyword = $(customFilter).find('input#keywords');
            var search = $(customFilter).find('button#filterBtn');
            console.log(keyword);
            var table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "deferRender": false,
                "autoWidth": false,
                "bAutoWidth": false,
                "sPageButtonActive": "active",
                "ajax": {
                    'url': url,
                    pages: 5, // number of pages to cache
                    'data': function (data) {
                        // Read values
                        data.keyword = $(keyword).val();
                        data.status = $(status).val();
                    }
                },
                dom: 'lBfrtip',
                "lengthChange": true,
                lengthMenu: [[15, 25, 50, 100, 500, -1], [15, 25, 50, 100, 500, "All"]],
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_ ",
                },
                "pageLength": 15,
                "bFilter": false,
                "bInfo": true,
                "searching": false,
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {
                        "mRender": function (data, type, row) {
                            var str = '';
                            if (row['permissions'].length > 0) {
                                for (var i = 0; i < row['permissions'].length; i++) {
                                    str += '<span class="badge badge-primary">' + row['permissions'][i].name + '</span>';
                                }
                            }
                            return str;
                        }
                    }
                    ,
                    {
                        "mRender": function (data, type, row) {
                            return "<a href='/dashboard/manage/role/" + row['id'] + "/edit' class='btn btn-default btn-xs'><i class='fa fa-edit'></i> Edit</a>";
                        }
                    }
                ],
                "columnDefs": [
                    {"targets": [2, 3], "searchable": false, "orderable": false, "visible": true}
                ],
                "order": [[0, 'asc']],
                "buttons": []
            });

            //Custom Filters ( title search )
            $('input').keyup(function (event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                // if(keycode == '13'){
                table.draw();
                // }
            });

            //Custom Filters ( Author search )
            $('button').click(function () {
                table.draw();
            });

            //Custom Filters ( Author search )
            $('select').change(function () {
                table.draw();
            });

        });
    </script>
@endsection
