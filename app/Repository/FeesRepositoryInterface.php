<?php

namespace App\Repository;

interface FeesRepositoryInterface{
    public function index();
    public function add();
    public function edit($id);
    public function saveFees($request);
    public function delete($request);
    public function update($request);
}
