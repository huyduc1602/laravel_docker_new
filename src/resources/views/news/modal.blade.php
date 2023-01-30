{{-- Modal create --}}
<div class="modal fade" id="newRecord" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add new record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="inline second_input">
                        <label for="release_date">Release date</label>
                        <input class="date_of_delivery" readonly placeholder="2019年1月20日" id="release_date"></input>
                        <label for="title">Title</label>
                        <input class="title" readonly placeholder="○○機能の追加" id="title"></input>
                    </div>
                    <label for="information">Description</label>
                    <textarea rows="8" cols="60" readonly class ="notification" placeholder="ここに内容が入ります。" id="information"></textarea>
                    <label for="link">Link</label>
                    <input id="link" class="link" readonly type="url">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" value="" class="create_record btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal --}}

{{-- Modal Update --}}
<div class="modal fade" id="editRecord" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    @method('PATCH')
                    <div class="inline second_input">
                        <label for="news_edit_form_release_date">Release date</label>
                        <input class="date_of_delivery" readonly placeholder="2019年1月20日" id="news_edit_form_release_date"></input>
                        <label for="news_edit_form_title">Title</label>
                        <input class="title" readonly placeholder="○○機能の追加" id="news_edit_form_title"></input>
                    </div>
                    <label for="news_edit_form_information">Description</label>
                    <textarea rows="8" cols="60" readonly class ="notification" placeholder="ここに内容が入ります。" id="news_edit_form_information"></textarea>
                    <label for="news_edit_form_url">Link</label>
                    <input id="news_edit_form_url" class="link" readonly type="url">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" value="" class="update_record btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal --}}
