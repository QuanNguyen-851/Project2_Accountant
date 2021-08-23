<?php

namespace App\Http\Controllers;

use PhpOffice\PhpWord\TemplateProcessor;

use App\Models\CourseModel;

use App\Models\StudentModel;
use App\Models\SubFeeModel;
use Illuminate\Http\Request;

class subfee extends Controller
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
        return view('subfee.index',[
            'list' => $allstudents,
            'classbk' =>$class
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        ($request->fee >= 1000000)? $disable = 1 : $disable = 0; 

        SubFeeModel::insert([
            'idStudent' => $request->id,
            'note' => $request->note,
            'fee' => $request->fee,
            'accountant' => $request->session()->get('email'),
            'payer' => $request->nameStudent,
            'date' => date('Y-m-d'),
            'class_bk' => $request->classStudent,
            'countPay' => $request->count,

            'disable' => $disable

        ]);
        $maxid = SubFeeModel::select('subfee.id')
        ->where('idStudent',$request->id)
        ->max('id');
        return view('subfee.success',[
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
        $info = StudentModel::join('classbk', 'classbk.id','=','student.idClass')
        ->join('course','classbk.idCourse','=','course.id')
        ->join('major','classbk.idMajor','=','major.id')
        ->Select('student.*','classbk.name as nameclass','course.name as course','major.name as major')
        ->where('student.id',$id)
        ->first();
        
        $maxpayment = SubFeeModel::select('subfee.*')
        ->where('subfee.idStudent',$id)->max('id');
        $payment = SubFeeModel::select('subfee.*')
        ->where('id',$maxpayment)->first();
        return view('subfee.subfee',[
            'payment' => $payment,
            'info' => $info
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
        ->where('countSubFeeMustPay','<','30')
        ->where('disable','=','0')
        ->get();
        foreach($course as $course){
            $count = $course->countSubFeeMustPay;
            CourseModel::where('id',$course->id)
            ->update(['countSubFeeMustPay' => $count+1]);
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
        return view('subfee.index',[
            'classbk'=>$class,
            'id'=>$id,
            'list' => $allstudents
        ]);
    }
    public function exportwordsubfee($id)
    	{
        $subfee = SubFeeModel::where('subfee.id', $id)
            ->join('student', 'subfee.idStudent', '=', 'student.id')
            ->join('classbk', 'student.idClass', '=', 'classbk.id')
            ->select('subfee.*', 'student.name', 'student.dateBirth', 'student.address')
            ->first();
        $templateProcessor = new TemplateProcessor('word-templade/subfee.docx');
        $templateProcessor->setValue('id', $subfee->id);
        $templateProcessor->setValue('day', date_format(date_create($subfee->date), "d"));
        $templateProcessor->setValue('month', date_format(date_create($subfee->date), "m"));
        $templateProcessor->setValue('year', date_format(date_create($subfee->date), "Y"));
        $templateProcessor->setValue('payer', $subfee->payer);
        $templateProcessor->setValue('dateBirth', date_format(date_create($subfee->dateBirth), "d.m.Y"));
        $templateProcessor->setValue('address', $subfee->address);
        $templateProcessor->setValue('note', $subfee->note);
        $templateProcessor->setValue('fee', number_format($subfee->fee));
        $fileName = "phiếu thu " . $subfee->name;
        $templateProcessor->saveAs($fileName . '.docx');
        return response()->download($fileName . '.docx')->deleteFileAfterSend(true);
        
    	}
}
