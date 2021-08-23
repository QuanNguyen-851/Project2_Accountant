<?php

namespace App\Http\Controllers;

use PhpOffice\PhpWord\TemplateProcessor;

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
        $class = CourseModel::select('*')
        ->where('disable',0)
        ->get();
        $allstudents = StudentModel::join('classbk', 'student.idClass', '=', 'classbk.id')
            ->join('scholarship', 'scholarship.id', '=', 'student.idStudentShip')
            ->join('course', 'course.id', '=', 'classbk.idCourse')
            ->select('student.*', 'classbk.name as classname', 'scholarship.name as scholarship', 'course.name as course', 'course.id as idcorse')
            ->where('student.disable', '!=', '1')->get();
        return View('fee.index',[
            'list' => $allstudents,
            'classbk'=>$class
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
        $lastpay = FeeModel::select('fee.*')
        ->where('fee.idStudent',$request->id)->max('id');
        if (isset($lastpay)){
        $payment = FeeModel::select('fee.*')
        ->where('id',$lastpay)->first();
        $lastcount = $payment->countPay;
        $count = $lastcount + $request->count;
        } else {
            $count = 0 + $request->count;
        }
        $student = StudentModel::select('*')
        ->where('id',$request->id)
        ->first();
        $getId = PayMentModel::select('*')
        ->where('countPer',$request->method)
        ->first();
        (($student->fee*$request->count-($student->fee*$request->count*$getId->sale/100)) <= $request->fee) ? $disable = 1 : $disable = 0;
        $id = $getId->id;
            FeeModel::insert([
                'idStudent' => $request->id,
                'idMethod' => $id,
                'note' => $request->note,
                'fee' => $request->fee,
                'accountant' => $request->session()->get('name'),
                'payer' => $request->nameStudent,
                'date' => date('Y-m-d'),
                'class_bk' => $request->classStudent,
                'countPay' => $count,
                'disable' => $disable
            ]);
        $maxid = FeeModel::select('fee.id')
        ->where('idStudent',$request->id)
        ->max('id');
        return view('fee.success',[
            'id'=>$maxid
        ]);
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
    public function student($id)
    {
        $class = CourseModel::select('*')
        ->where('disable',0)
        ->get();
        $allstudents = StudentModel::join('classbk', 'student.idClass', '=', 'classbk.id')
            ->join('scholarship', 'scholarship.id', '=', 'student.idStudentShip')
            ->join('course', 'course.id', '=', 'classbk.idCourse')
            ->select('student.*', 'classbk.name as classname', 'scholarship.name as scholarship', 'course.name as course', 'course.id as idcorse')
            ->where('student.disable', '!=', '1')
            ->where('course.id',$id)
            ->get();
        return View('fee.index',[
            'list' => $allstudents,
            'classbk'=>$class,
            'id'=>$id
        ]);
    }
    public function exportwordfee($id)
    	{
        $fee = FeeModel::where('fee.id', $id)
            ->join('student', 'fee.idStudent', '=', 'student.id')
            ->join('classbk', 'student.idClass', '=', 'classbk.id')
            ->select('fee.*', 'student.name', 'student.dateBirth', 'student.address')
            ->first();    //câu query tùy theo trường hợp ô muốn dùng mà thay đổi nhé

        $templateProcessor = new TemplateProcessor('word-templade/fee.docx');    // cái này k cần quan tâm nhưng bắt buộc phải có
				     //(key  , value)					
        $templateProcessor->setValue('id', $fee->id);    // những thứ trong dấu '' không nên sửa vì file đầu ra sẽ dựa vào key
        $templateProcessor->setValue('day', date_format(date_create($fee->date), "d"));
        $templateProcessor->setValue('month', date_format(date_create($fee->date), "m"));
        $templateProcessor->setValue('year', date_format(date_create($fee->date), "Y"));
        $templateProcessor->setValue('payer', $fee->payer);
        $templateProcessor->setValue('dateBirth', date_format(date_create($fee->dateBirth), "d.m.Y"));
        $templateProcessor->setValue('address', $fee->address);
        $templateProcessor->setValue('note', $fee->note);
        $templateProcessor->setValue('fee', number_format($fee->fee));

        $fileName = "phiếu thu " . $fee->name;    //// đặt tên file
        $templateProcessor->saveAs($fileName . '.docx');      //// cái này k cần quan tâm nhưng bắt buộc phải có
        return response()->download($fileName . '.docx')->deleteFileAfterSend(true);    //// xuất ra file
        
    	}

}
