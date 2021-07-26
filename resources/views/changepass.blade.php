@extends('layouts.layout')
@section('main')
<div class="card">
    <form id="loginFormValidation" action="{{route('changepasswordprocess')}}" method="POST">
        @csrf
        <div class="header text-center">Đổi mật khẩu</div>
        <div class="content">

            <div class="form-group">
                <label class="control-label">Mật khẩu hiện tại</label>
                <input class="form-control"
                       name="password"
                       type="password"
                       required="true"
                />
            </div>

            <div class="form-group">
                <label class="control-label">Mật khẩu mới</label>
                <input class="form-control"
                        id="newPass"
                       name="newpassword"
                       type="password"
                       required="true"
                />
            </div>
            <div class="form-group">
                <label class="control-label">Nhập lại mật khẩu mới</label>
                <input class="form-control"
                        name="rePass"
                       type="password"
                       required="true"
                />
            </div>
            @if (Session::has('errorPass'))
            <div class="form-group">
                <label style="color:red">{{ Session::get('errorPass') }}</label>
            </div>
        @endif
        </div>

        <div class="footer text-center">
            <button onclick ="return check()" type="submit" class="btn btn-info btn-fill btn-wd">Xác nhận</button>
        </div>
    </form>
</div>
@endsection