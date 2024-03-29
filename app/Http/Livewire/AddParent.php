<?php

namespace App\Http\Livewire;

use App\Models\ParentAttachment;
use Livewire\WithFileUploads;

use Livewire\Component;
use App\Models\Relegion;
use App\Models\myParents;
use App\Models\typeBloods;
use App\Models\Nationalities;
use Illuminate\Support\Facades\Hash;

class AddParent extends Component
{
    use WithFileUploads;

    public $successMessage = '';

    public $catchError;

    public $currentStep = 1,
    $updateMode = false,
    $show_table = true,
    $photos,
    // Father_INPUTS
    $Email, $Password,
    $Name_Father, $Name_Father_en,
    $National_ID_Father, $Passport_ID_Father,
    $Phone_Father, $Job_Father, $Job_Father_en,
    $Nationality_Father_id, $Blood_Type_Father_id,
    $Address_Father, $Religion_Father_id,
    // Mother_INPUTS
    $Name_Mother, $Name_Mother_en,
    $National_ID_Mother, $Passport_ID_Mother,
    $Phone_Mother, $Job_Mother, $Job_Mother_en,
    $Nationality_Mother_id, $Blood_Type_Mother_id,
    $Address_Mother, $Religion_Mother_id;


    //this is a real time validation
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,
            [
                'Email' => 'required|email',
                'National_ID_Father' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
                'Passport_ID_Father' => 'min:10|max:10',
                'Phone_Father' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'National_ID_Mother' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
                'Passport_ID_Mother' => 'min:10|max:10',
                'Phone_Mother' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
            ]
        );
    }



    public function submitForm()
    {
        try {
            $My_Parent = new myParents();
            $My_Parent->Email = $this->Email;
            $My_Parent->Password = Hash::make($this->Password);
            $My_Parent->Name_Father = ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father];
            $My_Parent->National_ID_Father = $this->National_ID_Father;
            $My_Parent->Passport_ID_Father = $this->Passport_ID_Father;
            $My_Parent->Phone_Father = $this->Phone_Father;
            $My_Parent->Job_Father = ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];
            $My_Parent->Passport_ID_Father = $this->Passport_ID_Father;
            $My_Parent->Nationality_Father_id = $this->Nationality_Father_id;
            $My_Parent->Blood_Type_Father_id = $this->Blood_Type_Father_id;
            $My_Parent->Religion_Father_id = $this->Religion_Father_id;
            $My_Parent->Address_Father = $this->Address_Father;

            // Mother_INPUTS
            $My_Parent->Name_Mother = ['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother];
            $My_Parent->National_ID_Mother = $this->National_ID_Mother;
            $My_Parent->Passport_ID_Mother = $this->Passport_ID_Mother;
            $My_Parent->Phone_Mother = $this->Phone_Mother;
            $My_Parent->Job_Mother = ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother];
            $My_Parent->Passport_ID_Mother = $this->Passport_ID_Mother;
            $My_Parent->Nationality_Mother_id = $this->Nationality_Mother_id;
            $My_Parent->Blood_Type_Mother_id = $this->Blood_Type_Mother_id;
            $My_Parent->Religion_Mother_id = $this->Religion_Mother_id;
            $My_Parent->Address_Mother = $this->Address_Mother;

            $My_Parent->save();

            if (!empty($this->photos)) {
                foreach ($this->photos as $photo) {
                    $photo->storeAs($this->National_ID_Father, $photo->getClientOriginalName(), $disk = 'parent_attachments');
                    ParentAttachment::create([
                        'file_name' => $photo->getClientOriginalName(),
                        'parent_id' => myParents::latest()->first()->id,
                    ]);
                }
            }

            $this->successMessage = trans('messages.success');
            // $this->clearForm();
            $this->currentStep = 1;
        } catch (\Exception $e) {
            $this->catchError = $e->getMessage();
        }
        ;

    }
    public function render()
    {
        return view('livewire.add-parent', [
            'Nationalities' => Nationalities::all(),
            'Type_Bloods' => typeBloods::all(),
            'Religions' => Relegion::all(),
            'my_parents' => myParents::all(),
        ]);
    }
    public function firstStepSubmit()
    {
        $this->validate([
            'Email' => 'required|unique:my_parents,Email,' . $this->id,
            'Password' => 'required',
            'Name_Father' => 'required',
            'Name_Father_en' => 'required',
            'Job_Father' => 'required',
            'Job_Father_en' => 'required',
            'National_ID_Father' => 'required|unique:my_parents,National_ID_Father,' . $this->id,
            'Passport_ID_Father' => 'required|unique:my_parents,Passport_ID_Father,' . $this->id,
            'Phone_Father' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Father_id' => 'required',
            'Blood_Type_Father_id' => 'required',
            'Religion_Father_id' => 'required',
            'Address_Father' => 'required',
        ]);
        $this->currentStep = 2;
    }
    public function secondStepSubmit()
    {
        $this->validate([
            'Name_Mother' => 'required',
            'Name_Mother_en' => 'required',
            'National_ID_Mother' => 'required|unique:my_parents,National_ID_Mother,' . $this->id,
            'Passport_ID_Mother' => 'required|unique:my_parents,Passport_ID_Mother,' . $this->id,
            'Phone_Mother' => 'required',
            'Job_Mother' => 'required',
            'Job_Mother_en' => 'required',
            'Nationality_Mother_id' => 'required',
            'Blood_Type_Mother_id' => 'required',
            'Religion_Mother_id' => 'required',
            'Address_Mother' => 'required',
        ]);
        $this->currentStep = 3;
    }
    //back
    public function back($step)
    {
        $this->currentStep = $step;
    }
    public function showformadd(){
        $this->show_table = false;
    }
    public function edit($id){
        $this->show_table = false;
    }
}
