@extends('layouts.app', ['activePage' => 'myProfile', 'titlePage' => __('Profile')])

@section('content')
    <div class="content-wrapper">
        <div class="form-warpper">
            <form name="user_edit" method="post" action="{{ route('user.update', $user->id)}}">
                @csrf
                @method('PATCH')
                <div id="user_edit">
                    <div class="form-group mt-2 mb-3"> <label class="control-label" for="user_edit_alias">Name</label>
                        <input type="text" id="user_edit_alias" name="name" class="form-control mt-1"
                            value="{{$user->name}}">
                    </div>
                    <div class="form-group mt-3 mb-2"> <label class="control-label required" for="user_edit_email">Email</label>
                            <input type="email" id="user_edit_email" name="email" required="required"
                                class="form-control mt-1" value="{{$user->email}}">
                    </div>
                </div>
                <input type="submit" value="Save" class="btn btn-primary mt-1">
                
            </form>
        </div>
    </div>
@endsection
