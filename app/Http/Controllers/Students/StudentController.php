<?php

namespace App\Http\Controllers\Students;

use App\Models\Students;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Repository\StudentsRepositoryInterface;

class StudentController extends Controller
{


    protected $Students;

    public function __construct(StudentsRepositoryInterface $Students){
        $this->Students = $Students;
    }


    public function index()
    {
        return $this->Students->Get_Students();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->Students->createStudent();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        return $this->Students->CreateStudents($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->Students->Show_Student($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       return $this->Students->Edit_Students($id);
    }


    public function update(StudentRequest $request)
    {
        return $this->Students->Update_Student($request);
    }


    public function destroy(Request $request)
    {
        return $this->Students->deleteStudent($request);
    }
    public function getClassrooms($id)
    {
        return $this->Students->GetClassrooms($id);
    }
    public function Get_Sections($id)
    {
        return $this->Students->GetSections($id);
    }
    public function Upload_attachment(Request $request){
        return $this->Students->Upload_attachment($request);
    }
    public function Download_attachment($studentname,$filename){
        return $this->Students->Download_attachment($studentname,$filename);
    }
    public function Delete_attachment(Request $request){
        return $this->Students->Delete_attachment($request);
    }
}
