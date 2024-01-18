<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Repository\StudentGraduatedRepositoryInterface;
use Illuminate\Http\Request;

class GraduteStudents extends Controller
{
    protected $Graduate;

    public function __construct(StudentGraduatedRepositoryInterface $Graduate){
        $this->Graduate = $Graduate;
    }

    public function index()
    {
        return $this->Graduate->index();
    }

    public function create()
    {
        return $this->Graduate->create();
    }
    public function store(Request $request)
    {
        return $this->Graduate->softDelete($request);
    }

    public function update(Request $request)
    {
       return $this->Graduate->ReturnData($request);

    }
    public function destroy(Request $request)
    {
       return $this->Graduate->destroy($request);
    }

}
