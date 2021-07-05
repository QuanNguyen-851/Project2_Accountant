@extends('layouts.layout')
@section('main')
<div class="card">
    <form id="loginFormValidation" action="{{route('fee.store')}}" method="post">
        @csrf
        <div class="header text-center">Đóng Học Phí</div>
        <div class="content">
            <input type="hidden" name="id" value="{{$info->id}}">
            <div class="form-group">
                @if (isset($payment))
                <label id="chon" class="control-label">Hình thức đóng</label>
                <select required id="check" name="method" class="selectpicker" data-title="Single Select" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
                    @foreach($method as $method)
                        <option {{($payment->idMethod == $method->id) ? 'selected="selected"' : ""  }} value="{{$method->countPer}}">{{$method->name}}</option>
                    @endforeach
                </select>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">Note</label>
                <textarea required name="note" class="form-control" placeholder="Chú thích" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label class="control-label">Sồ tiền đóng</label>
                <input class="form-control"
                name="fee"
                type="number"
                required="true"
                value="{{$info->fee}}"
         />
            </div>
            <div class="form-group">
                <label class="control-label">Người đóng</label>
                <input class="form-control"
                name="nameStudent"
                type="text"
                readonly="true"
                value="{{$info->name}}"
         />
            </div>
            <div class="form-group">
                <label class="control-label">Lớp</label>
                <input class="form-control"
                name="classStudent"
                type="text"
                readonly="true"
                value="{{$info->nameclass}}{{$info->course}}"
         />
            </div>
        @if (isset($payment))
            <div class="form-group">
                <label class="control-label">Số đợt đã đóng</label>
                <input class="form-control"
                name="count"
                type="number"
                readonly
                value="{{$payment->countPay}}"
            />
            </div>
         @else
         <div class="form-group">
            <label class="control-label">Số đợt đóng </label>
            <input id='ad' name='firstcount' class="form-control" type="number" value="0">
        </div>
         @endif
        <div class="footer text-center">
            <button type="submit" class="btn btn-info btn-fill btn-wd" >Đóng học</button>
        </div>
    </form>
</div>
{{-- <script>
    
    document.getElementById('check').onclick = function(){
        var check = document.getElementById('check').checked;
        if(check == 1) {
            document.getElementById("count").disabled = false;    
        } 
        else {
            document.getElementById('count').disabled = true;
        }
    }
</script> --}}
<script>
    document.getElementById('check').onchange = function(){
        var x = document.getElementById('check').value;
        document.getElementById('ad').value = x;
    }
</script>
@endsection