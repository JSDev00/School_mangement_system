<?php

namespace App\Repository;


interface StudentsRepositoryPromotionsInterface{
    public function index();
    public function store($request);
    public function create();
    public function destroy($request);
}
