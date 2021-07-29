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

                        <option {{($payment->idMethod == $method->id) ? 'selected="selected"' : ""  }} {{($payment->idMethod > $method->id) ? 'disabled="true"' : ""  }} value="{{$method->countPer}}">{{$method->name}} - {{$method->sale}}%</option>
                    @endforeach
                </select>
                @else
                <select required id="check" name="method" class="selectpicker" data-title="Single Select" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
                    @foreach($method as $method)
                        <option value="{{$method->countPer}}">{{$method->name}}  - {{$method->sale}}%</option>

                    @endforeach
                </select>
                @endif
            </div>

            @if(isset($payment))
            <div class="form-group">
                <label class="control-label">Note</label>
                <textarea required name="note" class="form-control" placeholder="Chú thích" rows="5">{{$payment->note}}</textarea>
            </div>
            @else
            <div class="form-group">
                <label class="control-label">Note</label>
                <textarea required name="note" class="form-control" placeholder="Chú thích" rows="5">{{$info->name}} Nộp tiền học phí đợt .. (tháng/năm) {{$info->fee}}/tháng {{$info->major}}:{{$info->nameclass}}{{$info->course}}</textarea>
            </div>
            @endif
            <div class="form-group">
                <label class="control-label">Sồ tiền đóng</label>
                <input class="form-control"
                id="pay"
                name="fee"
                type="number"
                required="true"
                @if(isset($payment))
                value="{{$payment->fee}}"
                @else
                value=""
                @endif

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
            <div class="form-group">
                <label class="control-label">Số tháng đóng</label>
                <input class="form-control"
                id="count"
                name="count"
                type="number"
                value=""
            />
            </div>
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
    document.getElementById('count').value = document.getElementById('check').value;
    document.getElementById('check').onchange = function(){
        var x = document.getElementById('check').value;
        document.getElementById('count').value = x;
    }
</script>
@endsection