@extends('layouts.layout')
@section('main')
<div class="card">
    <form action="{{route('compensation.update',$info->idfee)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="header text-center">Đóng bù hóa đơn</div>
        <div class="content">
            <div class="form-group">
                <label class="control-label">Hình thức đóng</label>
                <select required id="check" name="method" class="selectpicker" data-title="Single Select" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
                    @foreach($method as $method)

                        <option {{($info->idMethod == $method->id) ? 'selected="selected"' : ""  }} disabled>{{$method->name}} - {{$method->sale}}%</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="control-label">Người đóng</label>
                <input class="form-control"
                       name="name"
                       type="text"
                       required="true"
                       value="{{$info->payer}}"
                       readonly
                />
            </div>

            <div class="form-group">
                <label class="control-label">Số tiền đã đóng (VND)</label>
                <input class="form-control"
                       name="payed"
                       type="number"
                       required="true"
                       value="{{$info->fee}}"
                       readonly
                />
            </div>

            <div class="form-group">
                <label class="control-label">Số tiền còn thiếu (VND)</label>
                <input class="form-control"
                       name="thieu"
                       type="number"
                       required="true"
                       value="{{$left}}"
                       readonly
                />
            </div>
            <div class="form-group">
                <label class="control-label">Số tiền đóng bù</label>
                <input class="form-control"
                       name="paymore"
                       type="number"
                       required="true"
                       value="{{$left}}"
                />
            </div>

        </div>

        <div class="footer text-center">
            <button type="submit" class="btn btn-info btn-fill btn-wd">Đóng bù</button>
        </div>
    </form>
</div>
@endsection