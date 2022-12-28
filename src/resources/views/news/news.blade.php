@extends('layouts.app', ['activePage' => 'timesheet', 'titlePage' => __('Timesheet')])

@section('content')
    <div class="container-xxl content-wrapper pt-2">
        <div class="content">
            <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper d-flex justify-content-around">
                    <div class="navbar-form col-3 d-flex">
                        <div class="input-group no-border">
                            <div class="form-group d-flex align-items-center">
                                <label for="searchTerm"></label>
                                <input type="text" id="searchTerm" name="searchTerm" autocomplete="off"
                                       aria-haspopup="true" class="form-control dropdown-toggle"
                                       data-bs-toggle="dropdown"
                                       aria-expanded="true" placeholder="Search...">
                                <ul class='dropdown-menu input-group' aria-labelledby="searchTerm" role="menu">
                                    <li>
                                        <form method="get" action="{{ route('news.search') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="form_search_start_date">Date</label>
                                                <input type="date" id="form_search_start_date" name="start_date"
                                                       class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="form_search_end_date">Date</label>
                                                <input type="date" id="form_search_end_date" name="end_date"
                                                       class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="form_search_title"> Title</label>
                                                <input type="text" class="form-control" id="form_search_title"
                                                       name="tags">
                                            </div>
                                            <button type="submit" class="search btn btn-primary">Search</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-white btn-round btn-just-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <div class="breadcrumb mb-0">
                        <div class="box-tools">
                            <a class="addRecord btn btn-default" href="#" data-bs-toggle="modal"
                               data-bs-target="#newRecord">
                                <i class="fa-regular fa-square-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <div id="dataTable"></div>

            </div>
        </div>
    </div>
    @include('news.modal')
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {

            fetchRecord();

            // Get data by default
            function fetchRecord() {
                var dataTable = $('#dataTable');
                $.ajax({
                    url: '/news/list',
                    type: 'GET',
                    dataType: 'json',
                    success: function (responses) {
                        dataTable.html('');
                        dataTable.append(responses.record);
                    },
                });
            }

            // Search handle
            $(document).on('click', '.search', function (e) {
                e.preventDefault();
                var dataTable = $('#dataTable');
                var startDate = $('#form_search_start_date').val();
                var endDate = $('#form_search_end_date').val();
                var title = $('#form_search_title').val();
                $.ajax({
                    url: '/news/search?dateStart=' + startDate + '&dateEnd=' + endDate +
                        '&title=' + title,
                    type: 'GET',
                    dataType: 'json',
                    success: function (responses) {
                        dataTable.html('');
                        dataTable.append(responses.record);
                    },
                });
            });

            $(document).on('click', '.create_record', function (e) {
                e.preventDefault();

                data = {
                    '_token': "{{ csrf_token() }}",
                    'title': $('#news_create_form_title').val(),
                    'release_date': $('#news_create_form_release_date').val(),
                    'information': $('#news_create_form_information').val(),
                    'url': $('#news_create_form_url').val(),
                };

                $.ajax({
                    type: 'POST',
                    url: '/news/create',
                    data: data,
                    dataType: 'json',

                    success: function (responses) {
                        fetchRecord();
                        $('#news_create_form_title').val('');
                        $('#news_create_form_release_date').val('');
                        $('#news_create_form_information').val('');
                        $('#news_create_form_url').val('');
                        $('#newRecord').modal('hide');
                    },
                });
            });

            $(document).on('click', '.edit_record', function (e) {
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    url: '/news/' + id + '/show',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        $('#news_edit_form_release_date').val(response.news.release_date)
                        $('#news_edit_form_title').val(response.news.title)
                        $('#news_edit_form_information').val(response.news.information)
                        $('#news_edit_form_url').val(response.news.url)
                        $('.update_record').val(id)
                    },
                });
            });

            $(document).on('click', '.update_record', function (e) {
                e.preventDefault();
                var id = $(this).val();
                var data = {
                    "_token": "{{ csrf_token() }}",
                    'title': $('#news_edit_form_title').val(),
                    'release_date': $('#news_edit_form_release_date').val(),
                    'information': $('#news_edit_form_information').val(),
                    'url': $('#news_edit_form_url').val(),
                };

                $.ajax({
                    url: '/news/' + id,
                    type: 'PATCH',
                    data: data,
                    dataType: 'json',

                    success: function (response) {
                        console.log(response.status);
                        // if(response.status == 200) {
                        //     fetchRecord();
                        //     $("#editRecord").modal('hide');
                        // }
                    },
                });
            });

            // Pagination
            $(document).on('click', '.page-link', function (e) {
                e.preventDefault();
                var link = $(this).attr('href');
                var dataTable = $('#dataTable');

                $.ajax({
                    url: link,
                    type: 'GET',
                    dataType: 'json',
                    success: function (responses) {
                        dataTable.html('');
                        dataTable.append(responses.record);
                    },
                });
            });
        });
    </script>
@endpush
