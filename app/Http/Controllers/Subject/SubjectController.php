<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Repository\SubjectRepositoryInterface;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $Subject;

    public function __construct(SubjectRepositoryInterface $Subject){
        $this->Subject = $Subject;
    }
    public function index()
    {
       return $this->Subject->index();
    }




    public function store(Request $request)
    {
        return $this->Subject->store($request);

    }


    public function create()
    {
        return $this->Subject->create();

    }


    public function edit($id)
    {
        return $this->Subject->edit($id);

    }


    public function update(Request $request)
    {
        return $this->Subject->update($request);

    }


    public function destroy(Request $request)
    {
        return $this->Subject->destroy($request);

    }
}
