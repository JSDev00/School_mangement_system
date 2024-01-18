<?php

namespace App\Repository;

interface ExamRepositoryInterface{
    public function index();
    public function edit($id);
    public function store($request);
    public function update($request);
    public function destroy($request);
}
