<!-- Modal HTML -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="modal-body">
                <label class="modal-label">お知らせ</label>
                <div class="inline second_input">
                    <input class="date_of_delivery" readonly placeholder="2019年1月20日" id="release_date"></input>
                    <input class="title" readonly placeholder="○○機能の追加" id="title"></input>
                </div>
                <textarea rows="8" cols="60" readonly class ="notification" placeholder="ここに内容が入ります。" id="information"></textarea>
                <input id="link" class="link" readonly type="url">
                <div class="btn-modal">
                <button type="button" class="btn-submit">ダウンロード</button>
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">閉じる</button>
                </div>
            </form>
        </div>
    </div>
</div>
