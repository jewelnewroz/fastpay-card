@inject('commonHelper', \App\Helper\CommonHelper::class)
@extends('layouts.app')

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
        <select class="form-control select2-blue" id="filterOperator" placeholder="Select operator"></select>
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
                                <div>Trx ID</div>
                            </th>
                            <th>
                                <div>Sender</div>
                            </th>
                            <th>
                                <div>Receiver</div>
                            </th>
                            <th>
                                <div>Transaction type</div>
                            </th>
                            <th>
                                <div>Amount</div>
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
        let url = "{{ route('transaction.index') }}";
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
                    {"data": "tx_unique_id"},
                    {"data": "sender.name"},
                    {"data": "receiver.name"},
                    {"data": "transaction_type.name"},
                    {"data": "amount"},
                    {"data": "status"},
                    {"data": "created_at"},
                    {
                        "mRender": function (data, type, row) {
                            return "<a href='/dashboard/transaction/" + row['id'] + "' class='btn btn-default'><i class='fa fa-eye'></i></a> ";
                        }
                    }
                ],
                "columnDefs": [
                    {"targets": [6], "searchable": false, "orderable": false, "visible": true}
                ],
                "order": [[5, 'desc']],
                buttons: {!! json_encode($commonHelper->dataTableButtons(['copy', 'pdf','print', 'visibility'])) !!},
            });

            $('.select2-blue').select2({
                theme: "bootstrap4",
                allowClear: true,
                placeholder: "Select operator",
                width: "160px",
                height: "55px",
                ajax: {
                    url: 'https://api.github.com/search/repositories',
                    dataType: 'json',
                    data: function (params) {
                        let query = {
                            search: params.term,
                            type: 'public'
                        }
                        return query;
                    }
                }
            }).on('select2:select', function (e) {
                let data = e.params.data;
                alert('ok')
                console.log(data);
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
