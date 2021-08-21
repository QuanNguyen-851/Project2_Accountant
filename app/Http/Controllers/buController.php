<?php

namespace App\Http\Controllers;

use App\Models\CourseModel;
use App\Models\FeeModel;
use App\Models\StudentModel;
use Illuminate\Http\Request;

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
        //
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
