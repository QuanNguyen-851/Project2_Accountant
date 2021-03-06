@extends('layouts.layout')
@section('main')
<h1>Học phí sinh viên</h1>
<hr style='width:99%'>
<div class="toolbar">

    <a style="margin-right:100px" onclick="return confirm('Xác nhận ?')" href="{{route('count')}}" class="btn btn-success" type="button">Đợt mới</a>

    <select id="change" style="margin-right:100px;width:200px">
        <option value="0">All</option>
        @foreach($classbk as $items)
        <option {{(isset($id) && $id == $items->id)? "selected" : ""}} value="{{$items->id}}">{{$items->name}}</option>
        @endforeach
    </select>

</div>

<table id="bootstrap-table" class="table">
    <thead>
        <th data-field="id" class="text-center">#</th>
    	<th data-field="name" data-sortable="true">Tên</th>
    	<th data-field="gender" data-sortable="true">Giới tính</th>
        <th data-field="date" data-sortable="true">Ngày sinh</th>
        <th data-field="address">Địa chỉ</th>
        <th data-field="class">Lớp</th>
    	<th>Action</th>
    </thead>
    <tbody>
        @foreach ($list as $item)
        <tr>
        	<td>{{$item->id}}</td>
        	<td>{{$item->name}}</td>
        	<td>@php
                $gt = ($item->gender == 1) ? "Nam" : "Nữ";
            @endphp
                {{$gt}}
            </th>
            @php
                $date=date_create($item->dateBirth);
            @endphp
            </td>
        	
            <td>{{date_format($date,"d/m/Y")}}</td>
            <td>{{$item->address}}</td>
            <td>{{$item->classname}}{{$item->course}}</td>
            <td><a href="{{route('fee.show',$item->id)}}" type="button" class="btn btn-success">Đóng học</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection