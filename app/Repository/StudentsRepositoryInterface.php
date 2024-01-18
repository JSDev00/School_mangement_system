<?php

namespace App\Repository;



interface StudentsRepositoryInterface
{

    //Create Students
    public function createStudent();


    //Get Classrooms
    public function GetClassrooms($id);

    //Get Sections
    public function GetSections($id);

    //create students
    public function CreateStudents($reqeust);

    //Get students
    public function Get_Students();
    //Edit Students
    public function Edit_Students($id);

    //Update Student
    public function Update_Student($request);
    //Delete Student
    public function deleteStudent($request);

    //Show Student
    public function Show_Student($id);
    public function Upload_attachment($request);
    //Download attachments
    public function Download_attachment($studentname,$filename);

    //Delete AttachmentImages
    public function Delete_attachment($request);
}

