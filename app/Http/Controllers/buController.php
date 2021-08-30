<?php

namespace App\Http\Controllers;

use App\Models\CourseModel;
use App\Models\FeeModel;
use App\Models\PayMentModel;
use App\Models\StudentModel;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class buController extends Controller
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
        $allstudents = FeeModel::join('student', 'idStudent','=','student.id')
        ->join('classbk', 'student.idClass', '=', 'classbk.id')
        ->join('scholarship', 'scholarship.id', '=', 'student.idStudentShip')
        ->join('course', 'course.id', '=', 'classbk.idCourse')
        ->select('student.*', 'classbk.name as classname', 'scholarship.name as scholarship', 'course.name as course', 'course.id as idcorse','fee.fee as feebl','fee.id as feeid')
        ->where('fee.disable',0)
        ->get();
        return View('bufee.index',[
            'list' => $allstudents,
            'classbk'=>$class
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
        //
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
        $info = FeeModel::join('student', 'idStudent','=','student.id')
        ->join('payment','fee.idMethod','=','payment.id')
        ->select('fee.*','payment.*','fee.id as idfee')
        ->where('fee.id',$id)
        ->first();
        $student = StudentModel::select('*')
        ->where('id',$info->idStudent)
        ->first();
        $left = ($student->fee*$info->countPer-($student->fee*$info->countPer*$info->sale/100))-$info->fee;
        return view('bufee.view',[
            'info' => $info,
            'method'=>$method,
            'left'=>$left
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
        (($request->paid+$request->paymore) >= $request->thieu) ? $disable = 1 : $disable = 0;
        FeeModel::where('id',$id)
            ->update([
                'note' => $request->note,
                'fee' => $request->paid+$request->paymore,
                'date' =>date('Y-m-d'),
                'disable'=> $disable
            ]);
        return view('bufee.success',[
            'id' => $id,
            'paymore'=>$request->paymore,
        ]);
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

    public function exportwordcompensation($id)
    {
        $fee = FeeModel::where('fee.id', $id)
            ->join('student', 'fee.idStudent', '=', 'student.id')
            ->join('classbk', 'student.idClass', '=', 'classbk.id')
            ->select('fee.*', 'student.name', 'student.dateBirth', 'student.address')
            ->first();
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
            $templateProcessor->setValue('fee', number_format($_GET['pay']));

            $fileName = "phiếu thu " . $fee->name;    //// đặt tên file
            $templateProcessor->saveAs($fileName . '.docx');      //// cái này k cần quan tâm nhưng bắt buộc phải có
            return response()->download($fileName . '.docx')->deleteFileAfterSend(true);
    }
}
