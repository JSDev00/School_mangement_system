<?php
namespace App\Repository;

interface TeacherRepositoryInterface{
    // Get Teachers
    public function getAllTeachers();

    // Get Specialization
    public function getSpecialization();

    // Get Gender
    public function getGender();

    // Store Teachers
    public function StoreTeachers($request);

    //Edit Teachers
    public function editTeachers($id);
    //Update Teachers
    public function updateTeachers($request);

    //Delete Teachers
    public function deleteTeachers($request);
}

