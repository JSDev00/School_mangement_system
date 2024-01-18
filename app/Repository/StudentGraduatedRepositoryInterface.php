<?php

namespace App\Repository;

interface StudentGraduatedRepositoryInterface{
    public function index();
    public function create();
    public function softDelete($request);
     // ReturnData Students
     public function ReturnData($request);

     // destroy Students
     public function destroy($request);


}
