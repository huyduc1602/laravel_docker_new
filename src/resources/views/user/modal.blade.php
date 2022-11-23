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
                <form class="form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">face</i>
                                </span>
                            </div>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="{{ __('Name...') }}" value="{{ old('name') }}" required>
                        </div>
                        @if ($errors->has('name'))
                            <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">email</i>
                                </span>
                            </div>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
                        </div>
                        @if ($errors->has('email'))
                            <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                            </div>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="{{ __('Password...') }}" required>
                        </div>
                        @if ($errors->has('password'))
                            <div id="password-error" class="error text-danger pl-3" for="password"
                                style="display: block;">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>
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
                    <div class="form-group"> <label class="control-label" for="user_edit_alias">Name</label>
                        <input type="text" id="user_edit_name" name="name" class="form-control">
                    </div>
                    <div class="form-group"> <label class="control-label" for="user_edit_title">Title</label>
                        <input type="text" id="user_edit_title" name="title" class="form-control">
                    </div>
                    <div class="form-group"> <label class="control-label" for="user_edit_avatar">Profile
                            image</label>
                        <input type="text" id="user_edit_avatar" name="avatar" class="form-control">
                    </div>
                    <div class="form-group"> <label class="control-label required"
                            for="user_edit_email">Email</label>
                        <input type="email" id="user_edit_email" name="email" required="required"
                            class="form-control">
                    </div>
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
