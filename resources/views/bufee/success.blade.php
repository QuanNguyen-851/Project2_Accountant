@extends('layouts.layout')
@section('main')

<center><div style="font-size:75px;color:rgb(29, 202, 29);">Thành công</div></center>
<center><div style="margin-top:75px">
<a href="{{route('exportwordcompensation',$id)}}?pay={{$paymore}}" type="button" style="height:100px;width:200px;padding-top:35px;font-size:20px;margin-right:75px" class="btn btn-success">Xuất file word</a>
<a href="{{route('compensation.index')}}" type="button" style="height:100px;width:200px;padding-top:35px;font-size:20px" class="btn btn-info">Trở về trang chủ</a>
</div></center>

@endsection