<?php

namespace App\Http\Livewire;

use App\Models\My_Parent;
use App\Models\Nationalitie;
use App\Models\ParentAttachment;
use App\Models\Religion;
use App\Models\Type_Blood;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddParent extends Component
{    public $catchError,$updateMode = false,$photos;
    use WithFileUploads;
    public $currentStep = 1,

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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'Email' => 'required|email',
            'National_ID_Father' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'Passport_ID_Father' => 'min:10|max:10',
            'Phone_Father' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'National_ID_Mother' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'Passport_ID_Mother' => 'min:10|max:10',
            'Phone_Mother' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
        ]);
    }


    public function render()
    {
        return view('livewire.add-parent', [
            'Nationalities' => Nationalitie::all(),
            'Type_Bloods' => Type_Blood::all(),
            'Religions' => Religion::all(),
        ]);

    }

    //firstStepSubmit
    public function firstStepSubmit()
    {
        $datavalidtate=$this->validate(
            [
                'Email' => 'required|email',
                'Password' => 'required|min:6',
                'Name_Father'=>'required',
                'Name_Father_en'=>'required',
                'National_ID_Father'=>'numeric|min:9',
                'Passport_ID_Father'=>'numeric|min:9',
                'Phone_Father'=>'numeric|min:6',
                'Nationality_Father_id'=>'numeric',
                'Blood_Type_Father_id'=>'numeric',
                'Address_Father'=>'required',
                'Job_Father_en'=>'required',
                'Job_Father'=>'required',

                'Religion_Father_id'=>'required',


            ]
        );
        $this->currentStep = 2;
    }

    //secondStepSubmit
    public function secondStepSubmit()
    {
        $datavaldiation=$this->validate([
            'Name_Mother'=>'required',
            'Name_Mother_en'=>'required',
            'National_ID_Mother'=>'numeric|min:9',
            'Passport_ID_Mother'=>'numeric|min:9',
            'Phone_Mother'=>'numeric|min:6',
            'Job_Mother'=>'required',
            'Job_Mother_en'=>'required',
            'Nationality_Mother_id'=>'numeric|required',
            'Blood_Type_Mother_id'=>'numeric|required',
            'Address_Mother'=>'required',
            'Religion_Mother_id'=>'numeric|required',
      ]);
        $this->currentStep = 3;
    }


    //back
    public function back($step)
    {
        $this->currentStep = $step;
    }

    public function submitForm(){

        My_Parent::create([
    'Email'=>$this->Email,
    'Password'=>$this->Password,
    'Name_Father' => ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father],
    'National_ID_Father'=>$this->National_ID_Father,
    'Passport_ID_Father'=>$this->Passport_ID_Father,
    'Phone_Father'=>$this->Phone_Father,
    'Job_Father'=>['en' => $this->Job_Father_en, 'ar' => $this->Job_Father],
    'Nationality_Father_id'=>$this->Nationality_Father_id,
    'Blood_Type_Father_id'=>$this->Blood_Type_Father_id,
    'Religion_Father_id'=>$this->Religion_Father_id,
    'Address_Father'=>$this->Address_Father,

    'National_ID_Mother'=>$this->National_ID_Mother,
    'Passport_ID_Mother'=>$this->Passport_ID_Mother,
    'Phone_Mother'=>$this->Phone_Mother,
    'Job_Mother'=>['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother],
    'Nationality_Mother_id'=>$this->Nationality_Mother_id,
    'Blood_Type_Mother_id'=>$this->Blood_Type_Mother_id,
    'Religion_Mother_id'=>$this->Religion_Mother_id,
    'Address_Mother'=>$this->Address_Mother,
    'Name_Mother'=>['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother],


]);
                        if (!empty($this->photos)){
                            foreach ($this->photos as $photo) {
                                $photo->storeAs($this->National_ID_Father, $photo->getClientOriginalName(), $disk = 'parent_attachments');
                                ParentAttachment::create([
                                    'file_name' => $photo->getClientOriginalName(),
                                    'parent_id' => My_Parent::latest()->first()->id,
                                ]);
                            }
                        }
            $this->successMessage = trans('messages.success');
            $this->clearForm();
            $this->currentStep = 1;


        $this->currentStep = 1;

    }
    public function clearForm()
    {
        $this->Email = '';
        $this->Password = '';
        $this->Name_Father = '';
        $this->Job_Father = '';
        $this->Job_Father_en = '';
        $this->Name_Father_en = '';
        $this->National_ID_Father ='';
        $this->Passport_ID_Father = '';
        $this->Phone_Father = '';
        $this->Nationality_Father_id = '';
        $this->Blood_Type_Father_id = '';
        $this->Address_Father ='';
        $this->Religion_Father_id ='';

        $this->Name_Mother = '';
        $this->Job_Mother = '';
        $this->Job_Mother_en = '';
        $this->Name_Mother_en = '';
        $this->National_ID_Mother ='';
        $this->Passport_ID_Mother = '';
        $this->Phone_Mother = '';
        $this->Nationality_Mother_id = '';
        $this->Blood_Type_Mother_id = '';
        $this->Address_Mother ='';
        $this->Religion_Mother_id ='';

    }

}
