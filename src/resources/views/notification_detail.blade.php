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
                <input placeholder="お知らせ" class="notification" id="release_date"></input>
                <div class="inline">
                    <input class="date_of_delivery" placeholder="配信日"></input>
                    <input class="" placeholder="○○機能の追加"></input>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </form>
        </div>
    </div>
</div>