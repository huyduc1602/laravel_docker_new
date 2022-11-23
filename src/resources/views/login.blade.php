<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <!-- Bootstrap CSS -->
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Bootstrap Bundle with Popper -->
    <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <title>Document</title>
</head>
@include('layout.header')
<body>
    <div class="header_label">
        <h1>駐輪場オーナー管理システム</h1>
        <h2>ログイン</h2>
    </div>
    <div class="container">
        <div class="login-form">
            <form action="" method="post" class="form-horizontal">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">ID</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">パスワード</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control">
                </div>
            </div>
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
                <tr>
                    <th scope="row" id="release_date">2018年12月20日</th>
                    <td id="title">○○機能の追加</td>
                    <td><a href="#myModal" data-bs-toggle="modal">詳細</a></td>
                    </tr>
                    <tr>
                    <th scope="row" id="release_date">2018年12月13日</th>
                    <td id="title">△△機能の障害について</td>
                    <td><a href="#myModal" data-bs-toggle="modal">詳細</a></td>
                    </tr>
                    <tr>
                    <th scope="row" id="release_date">2018年12月6日</th>
                    <td id="title">口口についてのお知らせ</td>
                    <td><a href="#myModal" data-bs-toggle="modal">詳細</a></td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
    <p><a href="">パスワードをお忘れの方</a></p>
    @include('notification_detail')
</body>
@include('layout.footer')
</html>