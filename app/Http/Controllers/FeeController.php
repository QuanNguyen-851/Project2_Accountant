<?php

namespace App\Http\Controllers;

use App\Models\CourseModel;
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
        // $maxpayment = FeeModel::select('fee.*')
        // ->where('fee.idStudent',$request->id)->max('id');
        // $payment = FeeModel::select('fee.*')
        // ->where('id',$maxpayment)->first();
        // $check = FeeModel::select('fee.*','payment.sale as sale','payment.countPer as countPer')
        // ->join('payment','fee.idMethod','=','payment.id')
        // -> where('idStudent',$request->id)->get();
        // $student = StudentModel::select('student.fee')
        // ->where('id',$request->id)->first();
        // $fee = 0;
        // foreach($check as $check){
        //     $fee += $check->fee + ($student->fee*$check->countPer*($check->sale/100));
        // }
        // echo $fee;
        // $totalfee = StudentModel::join('classbk', 'student.idClass','=','classbk.id')
        // ->join('major','classbk.idMajor','=','major.id')
        // ->join('scholarship','student.idStudentShip','=','scholarship.id')
        // ->select('major.fee as fee','scholarship.scholarship as scholarship')
        // ->where('student.id',$request->id)->first();
        // $checkfee = ($totalfee->fee*30)-($totalfee->scholarship);
        // if ($payment->countPay>=30 && $fee>=$checkfee){
        //     StudentModel::where('id', $request->id)
        //     ->update(['disable' => 1]);
            // FeeModel::where('idStudent',$request->id)
            // ->update(['disable' => 1]);
        // }
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
        ->join('major','classbk.idMajor','=','major.id')
        ->Select('student.*','classbk.name as nameclass','course.name as course','major.name as major')
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
    public function addcount(){
        $course = CourseModel::Select('course.*')
        ->where('countMustPay','<','30')
        ->where('disable','=','0')
        ->get();
        foreach($course as $course){
            $count = $course->countMustPay;
            CourseModel::where('id',$course->id)
            ->update(['countMustPay' => $count+1]);
        }
        return redirect(route('login'));
    }
}
