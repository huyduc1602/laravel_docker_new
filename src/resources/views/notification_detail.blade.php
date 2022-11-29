<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="{{asset('css/notification.css')}}" rel="stylesheet">
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Bootstrap Bundle with Popper -->
    <script src="{{asset('js/notification.js')}}"></script>
    <title>Document</title>
</head>
    
<!-- Modal HTML -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="modal-body">
                <label class="modal-label">お知らせ</label>
                <div class="inline second_input">
                    <input class="date_of_delivery" placeholder="2019年1月20日" id="release_date"></input>
                    <input class="title" placeholder="○○機能の追加" id="title"></input>
                </div>
                <textarea rows="8" cols="60" class ="notification" placeholder="ここに内容が入ります。" id="information"></textarea>
                <input id="link" class="link" value="https://xxx.xxx.xxx" type=”url”></input>
                <div class="btn-modal">
                <button type="button" class="btn-submit">ダウンロード</button>
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">閉じる</button>
                <div class="btn-modal">
            </form>
        </div>
    </div>
</div>