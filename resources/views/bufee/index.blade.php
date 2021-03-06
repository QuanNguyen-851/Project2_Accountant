@extends('layouts.layout')
@section('main')
<h1>Các biên lai còn thiếu</h1>
<hr style='width:99%'>
<div class="toolbar">

</div>

<table id="bootstrap-table" class="table">
    <thead>
        <th data-field="id" class="text-center">#</th>
    	<th data-field="name" data-sortable="true">Tên</th>
    	<th data-field="gender" data-sortable="true">Giới tính</th>
        <th data-field="date" data-sortable="true">Ngày sinh</th>
        <th data-field="address">Địa chỉ</th>
        <th data-field="class">Lớp</th>
        <th data-field="fee">Đã đóng</th>
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
            <td>{{number_format($item->feebl)}}</td>
            <td><a href="{{route('compensation.show',$item->feeid)}}" type="button" class="btn btn-success">Đóng bù</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection