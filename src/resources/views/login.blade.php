@extends('layouts.app', ['activePage' => 'login', 'titlePage' => __('Login')])

@section('content')
<div class="header_label">
    <h1>駐輪場オーナー管理システム</h1>
    <h2>ログイン</h2>
</div>
<div class="container">
    <div class="login-form">
        <form action="{{ route("login") }}" method="POST" class="form-horizontal">
            @csrf
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">ID</label>
                <div class="col-sm-9">
                    <input name="id" class="form-control" />
                    @if ($errors->has('id'))
                    <div id="email-error" class="form-error" for="email" style="text-align : left; display : block">
                        <strong class="error text-danger">{{ $errors->first('id') }}</strong>
                    </div>
                @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">パスワード</label>
                <div class="col-sm-9">
                    <input type="password" name="password" class="form-control">
                    @if ($errors->has('password'))
                        <div id="password-error" class="form-error" for="password" style="text-align : left; display : block">
                            <strong  class="error text-danger">{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            @if ($errors->has('login_failed'))
                <div id="password-error" class="error text-danger h-fit">
                    <p>{{ $errors->first('login_failed') }}</p>
                </div>
            @endif
            <button type="submit" class="button-login">ログイン</button>
        </form>
    </div>
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
                    <th scope="row" id="release_date">{{ $n->release_date }}</th>
                    <td id="title">{{ $n->title }}</td>
                    <td><button class="show" href='#' data-bs-target="#myModal" data-bs-toggle="modal" value="{{ $n->id }}">詳細</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<p><a href="">パスワードをお忘れの方</a></p>
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
                        $('#release_date').val(response.news.name)
                        $('#title').val(response.news.title)
                        $('#information').val(response.news.information)
                    },
                });
            });
        });
    </script>
@endpush

