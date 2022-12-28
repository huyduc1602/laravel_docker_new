@extends('layouts.app', ['activePage' => 'login', 'titlePage' => __('Login')])

@section('content')
<div class="header_label">
    <h1>駐輪場オーナー管理システム</h1>
    <h2>ログイン</h2>
</div>
<div class="container">
    @if (session('unAuthorize'))
        <div class="alert alert-danger">
            {{ session('unAuthorize') }}
        </div>
    @endif
    <div class="login-form">
        <form action="{{ route("login") }}" method="POST" class="form-horizontal">
            @csrf

            <div class="form-group row">
                <label for="id" class="col-sm-3 col-form-label">ID</label>
                <div class="col-sm-9">
                    <input type="text" name="username" class="form-control" value="{{ old('username', '') }}">
                </div>
            </div>
            @if ($errors->has('username'))
                <div id="username-error" class="error text-danger pl-3" for="username"
                     style="display: block;">
                    <strong>{{ $errors->first('username') }}</strong>
                </div>
            @endif
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">パスワード</label>
                <div class="col-sm-9">
                    <input type="password" name="password" class="form-control" value="{{ !$errors->has('password') ? '' : '' }}">
                </div>
            </div>
            @if ($errors->has('password'))
                <div id="password-error" class="error text-danger pl-3" for="password"
                     style="display: block;">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
            @if ($errors->has('login_failed'))
                <div id="password-error" class="error text-danger mt-2 pl-3"
                     style="display: block;">
                    <strong>{{ $errors->first('login_failed') }}</strong>
                </div>
            @endif
            <button type="submit" class="button-login">ログイン</button>
        </form>
    </div>
    @if(count($news) != 0)
    <h3 class="text-center">新着のお知らせ</h3>
    <div class="log">
            <table class="table table-bordered" id="dtb_news">
                <thead>
                <tr>
                    <th scope="col">配信日</th>
                    <th scope="col">タイトル</th>
                    <th scope="col">表示</th>
                </tr>
                </thead>
                <tbody>
                @foreach($news as $n)
                    <tr>
                        <th scope="row">{{ $n->release_date }}</th>
                        <td >{{ $n->title }}</td>
                        <td><button class="show" href='#' data-bs-target="#myModal" data-bs-toggle="modal" value="{{ $n->id }}">詳細</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
    @endif
</div>
<p><a href="{{ route('password.reset') }}">パスワードをお忘れの方</a></p>
    @include('notification_detail')
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.show', function (e) {
                e.preventDefault();
                const id = $(this).val();
                $.ajax({
                    url: '/news/' + id + '/show',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        $('#release_date').val(response.news.release_date)
                        $('#title').val(response.news.title)
                        $('#information').val(response.news.information)
                        $('#link').val(response.news.url)
                        // $('#href-link').attr("href",response.news.url)
                    },
                });
            });
        });
    </script>
@endpush

