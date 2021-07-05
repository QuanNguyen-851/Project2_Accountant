<?php

namespace App\Http\Controllers;

use App\Models\FeeModel;
use App\Models\PayMentModel;
use App\Models\StudentModel;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allstudents = StudentModel::join('classbk', 'student.idClass', '=', 'classbk.id')
            ->join('scholarship', 'scholarship.id', '=', 'student.idStudentShip')
            ->join('course', 'course.id', '=', 'classbk.idCourse')
            ->select('student.*', 'classbk.name as classname', 'scholarship.name as scholarship', 'course.name as course', 'course.id as idcorse')
            ->where('student.disable', '!=', '1')->get();
        return View('fee.index',[
            'list' => $allstudents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $getId = PayMentModel::select('*')->where('countPer',$request->method)->first();
        $id = $getId->id;
        if(isset($request->firstcount)){
            
            FeeModel::insert([
                'idStudent' => $request->id,
                'idMethod' => $id,
                'note' => $request->note,
                'fee' => $request->fee,
                'accountant' => $request->session()->get('email'),
                'payer' => $request->nameStudent,
                'date' => date('Y-m-d'),
                'class_bk' => $request->classStudent,
                'countPay' => $request->firstcount,
                'disable' => 0
            ]);
        } else {
            FeeModel::insert([
                'idStudent' => $request->id,
                'idMethod' => $id,
                'note' => $request->note,
                'fee' => $request->fee,
                'accountant' => $request->session()->get('email'),
                'payer' => $request->nameStudent,
                'date' => date('Y-m-d'),
                'class_bk' => $request->classStudent,
                'countPay' => $request->count + $request->method,
                'disable' => 0
            ]);
        }
        $maxpayment = FeeModel::select('fee.*')
        ->where('fee.idStudent',$request->id)->max('id');
        $payment = FeeModel::select('fee.*')
        ->where('id',$maxpayment)->first();
        if ($payment->countPay>=30){
            StudentModel::where('id', $request->id)
            ->update(['disable' => 1]);
            FeeModel::where('idStudent',$request->id)
            ->update(['disable' => 1]);
        }
        return redirect(route('login'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $method = PayMentModel::Select('payment.*')->get();
        $info = StudentModel::join('classbk', 'classbk.id','=','student.idClass')
        ->join('course','classbk.idCourse','=','course.id')
        ->Select('student.*','classbk.name as nameclass','course.name as course')
        ->where('student.id',$id)
        ->first();
        
        $maxpayment = FeeModel::select('fee.*')
        ->where('fee.idStudent',$id)->max('id');
        $payment = FeeModel::select('fee.*')
        ->where('id',$maxpayment)->first();
        
        
        return View('fee.fee',[
            'method' => $method,
            'info' => $info,
            'payment' => $payment
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
