@extends('admin::layouts.panel')

@section('title',__('user::user.users_list'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('user::user.users_list') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('user::user.users_list') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="users_table" class="table table-centered w-100 dt-responsive nowrap">
                            <thead class="table-light">
                            <tr>
                                <th>{{ __('user::user.id') }}</th>
                                <th>{{ __('user::user.name') }}</th>
                                <th>{{ __('user::user.slug') }}</th>
                                <th>{{ __('user::user.email') }}</th>
                                <th>{{ __('user::user.country') }}</th>
                                <th>{{ __('user::user.source') }}</th>
                                <th>{{ __('user::user.status') }}</th>
                                <th>{{ __('user::user.created_at') }}</th>
                                <th>{{ __('user::user.updated_at') }}</th>
                                <th>{{ __('user::user.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            let table = $('#users_table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('admin.users.index') }}",
                "language": language,
                "pageLength": pageLength,
                "columns": [
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': false},
                ],
                "order": [[0, "desc"]],
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    $('#users_table tr td:nth-child(2)').addClass('table-user');
                    $('#users_table tr td:nth-child(10)').addClass('table-action');
                }
            });
        });
    </script>
@endsection
