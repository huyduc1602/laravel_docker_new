@extends('layouts.app', ['activePage' => 'news', 'titlePage' => __('News')])

@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper d-flex justify-content-around">
                    <div class="navbar-form col-3">
                        <div class="input-group no-border">
                            <div class="form-group">
                                <input type="text" id="searchTerm" name="searchTerm" autocomplete="off"
                                    aria-haspopup="true" class="form-control dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="true" placeholder="Search...">
                                <ul class='dropdown-menu input-group' aria-labelledby="searchTerm" role="menu">
                                    <li>
                                        <form method="get" action="{{ route('timesheet.search') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="date"> Date start</label>
                                                <input type="date" id="form_search_date" name="date"
                                                    class="form-control" aria-describedby="emailHelp">
                                            </div>
                                            <div class="mb-3">
                                                <label for="project"> Project</label>
                                                <select class="form-control" id="form_search_project" name="project">
                                                    <option value=''></option>
                                                    <optgroup label="IDS VietNam">
                                                        @foreach ($project as $p)
                                                            <option value='{{ $p->name }}'>{{ $p->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="activity"> Activity</label>
                                                <select class="form-control" id="form_search_activity" name="activity">
                                                    <option value=''></option>
                                                    @foreach ($activity as $a)
                                                        <option value='{{ $a->name }}'>{{ $a->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tags"> Tags</label>
                                                <input type="text" class="form-control" id="form_search_tags"
                                                    name="tags">
                                            </div>
                                            <button type="submit" class="search btn btn-primary">Search</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                    <div class="breadcrumb">
                        <div class="box-tools">
                            <div class="btn-group">
                                <a class="btn btn-default btn-visibility" href="#" data-bs-toggle="modal"
                                    data-bs-target="#customTable">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a class="addRecord btn btn-default" href="#" data-bs-toggle="modal"
                                    data-bs-target="#newRecord">
                                    <i class="fa-regular fa-square-plus"></i>
                                </a>
                                <a class="btn btn-default btn-help" systiteke
                                    href="https://www.kimai.org/documentation/timesheet.html" target="_blank"><i
                                        class="far fa-question-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <div id="dataTable" style="min-height: 300px;"></div>

            </div>
        </div>
    </div>
    @include('timesheets.modal')
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

            fetchRecord();

            // Get data by default
            function fetchRecord() {
                $.ajax({
                    url: '/en/timesheets/list',
                    type: 'GET',
                    dataType: 'json',
                    success: function(responses) {
                        $('#dataTable').html('');
                        $('#dataTable').append(responses.record);
                    },
                });
            };

            // Save column custom view to cookie
            $(document).on('click', '.vSave', function(e) {
                e.preventDefault();

                data = {
                    '_token': "{{ csrf_token() }}",
                    'begin': $('#column_starttime').prop('checked'),
                    'end': $('#column_endtime').prop('checked'),
                    'duration': $('#column_duration').prop('checked'),
                    'customer': $('#column_customer').prop('checked'),
                    'project': $('#column_project').prop('checked'),
                    'activity': $('#column_activity').prop('checked'),
                    'description': $('#column_description').prop('checked'),
                    'tags': $('#column_tags').prop('checked'),
                };
                $.ajax({
                    url: '/en/columns',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(responses) {
                        fetchRecord();
                        $('#customTable').modal('hide');
                    },
                });
            });

            // Remove column custom view settings in cookie
            $(document).on('click', '.vReset', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/en/columns',
                    type: 'GET',
                    dataType: 'json',
                    success: function(responses) {
                        fetchRecord();
                        $('#customTable').modal('hide');
                    },
                });
            });

            // Search handle
            $(document).on('click', '.search', function(e) {
                e.preventDefault();
                var date = $('#form_search_date').val();
                var project = $('#form_search_project').val();
                var activity = $('#form_search_activity').val();
                var tags = $('#form_search_tags').val();
                $.ajax({
                    url: '/en/timesheets/search?date=' + date + '&project=' + project +
                        '&activity=' + activity + '&tags=' + tags,
                    type: 'GET',
                    dataType: 'json',
                    success: function(responses) {
                        $('#dataTable').html('');
                        $('#dataTable').append(responses.record);
                    },
                });
            });

            $(document).on('click', '.addRecord', function(e) {
                var today = new Date();
                var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                var dateTime = date + ' ' + time;
                $('#timesheet_create_form_begin').val(dateTime);
                console.log($('#timesheet_create_form_begin').val());
            });

            $(document).on('click', '.create_record', function(e) {
                e.preventDefault();

                data = {
                    '_token': "{{ csrf_token() }}",
                    'begin': $('#timesheet_create_form_begin').val(),
                    'end': $('#timesheet_create_form_end').val(),
                    'duration': $('#timesheet_create_form_duration').val(),
                    'project': $('#timesheet_create_form_project').val(),
                    'activity': $('#timesheet_create_form_activity').val(),
                    'description': $('#timesheet_create_form_description').val(),
                    'tags': $('#timesheet_create_form_tags').val(),
                };

                $.ajax({
                    type: 'POST',
                    url: '/en/timesheets/create',
                    data: data,
                    dataType: 'json',

                    success: function(responses) {
                        fetchRecord();
                        $('#timesheet_create_form_duration').val('');
                        $('#timesheet_create_form_project').val('');
                        $('#timesheet_create_form_activity').val('');
                        $('#timesheet_create_form_description').val('');
                        $('#timesheet_create_form_tags').val('');
                        $('#newRecord').modal('hide');
                    },
                });
            });

            $(document).on('click', '.edit_record', function(e) {
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    url: '/en/timesheets/' + id + '/show',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#timesheet_edit_form_begin').val(response.timesheet.begin)
                        $('#timesheet_edit_form_end').val(response.timesheet.end)
                        $('#timesheet_edit_form_duration').val(response.timesheet.duration)
                        $('#timesheet_edit_form_project').val(response.timesheet.project)
                        $('#timesheet_edit_form_activity').val(response.timesheet.activity)
                        $('#timesheet_edit_form_description').val(response.timesheet
                            .description)
                        $('#timesheet_edit_form_tags').val(response.timesheet.tags)
                        $('.update_record').val(id)
                    },
                });
            });

            $(document).on('click', '.update_record', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var data = {
                    "_token": "{{ csrf_token() }}",
                    'end': $('#timesheet_edit_form_end').val(),
                    'duration': $('#timesheet_edit_form_duration').val(),
                    'project': $('#timesheet_edit_form_project').val(),
                    'activity': $('#timesheet_edit_form_activity').val(),
                    'description': $('#timesheet_edit_form_description').val(),
                    'tags': $('#timesheet_edit_form_tags').val(),
                };

                $.ajax({
                    url: '/en/timesheets/' + id,
                    type: 'PATCH',
                    data: data,
                    dataType: 'json',

                    success: function(response) {
                        fetchRecord();
                        $("#editRecord").modal('hide');
                    },
                });
            });

            // Pagination
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                var link = $(this).attr('href');

                $.ajax({
                    url: link,
                    type: 'GET',
                    dataType: 'json',
                    success: function(responses) {
                        $('#dataTable').html('');
                        $('#dataTable').append(responses.record);
                    },
                });
            });
        });
    </script>
@endpush
