<?php

namespace App\Livewire;

use App\Models\Applicant as ModelsApplicant;
use App\Models\Certificate;
use App\Models\Office;
use App\Models\School;
use Livewire\Component;
use Livewire\WithPagination;

class Applicant extends Component
{

    public $fname, $lname, $mname, $users_id, $applicant_id, $bday, $address, $school_id, $office_id, $offices, $confirming, $searchToken, $filename, $started_date, $hrs, $schools, $type, $certModal, $applicant, $dateFinished, $dateIssued, $certEdit, $year;

    use WithPagination;

    public $isOpen = 0;

    public $office;

    public $showYearCreated = false, $years = ['2023', '2024', '2025'];
    public $createdDate = [];

    public function setYearCreated($year)
    {
        $this->showYearCreated = true;

        $this->year = $year;

        $this->createdDate = ModelsApplicant::pluck('created_at')->toArray();
    }

    public function mount()
    {
        $this->offices=Office::all();
        $this->schools=School::all();
    }

    public function render()
    {

        $applicants = ModelsApplicant::where(function ($applicant) {
            return $applicant->where('fname', 'like', '%' . $this->searchToken . '%')->orWhere('lname', 'like', '%' . $this->searchToken . '%')
            ->orWhere('mname', 'like', '%' . $this->searchToken . '%');
        })
        ->when($this->year != null, function ($applicant) {
            return $applicant->whereYear('created_at', $this->year);
        })
        ->paginate(10);

        return view('livewire.applicant', compact('applicants'))->layout('layouts.admin');

    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    private function resetInputFields()
    {
        $this->lname = '';
        $this->fname = '';
        $this->mname = '';
        $this->bday = '';
        $this->started_date = '';
        $this->hrs = '';
        $this->address = '';
        $this->school_id = '';
        $this->office_id = '';
        $this->applicant_id = '';
        $this->applicant = '';
        $this->dateFinished = '';
        $this->dateIssued = '';
        $this->type = '';
        $this->confirming = '';
    }

    public function toggleStatus(ModelsApplicant $applicant)
    {

        if($applicant->status){
            $applicant->update(['status' => false]);
        }
        else{
            $applicant->update(['status' => true]);
            $this->applicant = $applicant;
            $this->certModal = true;
        }
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {
        $this->validate([
            'fname' => 'required',
            'lname' => 'required',
            'started_date' => 'required',
            'hrs' => 'required',
            'school_id' => 'required',
            'office_id' => 'required',
            'type' => 'required'
            ]);

        $data = [
            'fname' => $this->fname,
            'mname' => $this->mname,
            'lname' => $this->lname,
            'started_date' => $this->started_date,
            'hrs' => $this->hrs,
            'address' => $this->address,
            'school_id' => $this->school_id,
            'office_id' => $this->office_id,
            'type' => $this->type
        ];

        if ($this->bday) {
            $data['bday'] = $this->bday;
        }

        ModelsApplicant::updateOrCreate(['id' => $this->applicant_id], $data);

        session()->flash('message',
        $this->applicant_id ? 'Applicant Updated Successfully.' : 'Applicant Created Successfully.');
        session()->flash('message', 'Applicant saved successfully.');
        $this->closeModal();
        $this->resetInputFields();

    }


    public function edit($id)
    {
        $applicant = ModelsApplicant::findOrFail($id);
        $this->applicant_id = $id;
        $this->fname = $applicant->fname;
        $this->mname = $applicant->mname;
        $this->lname = $applicant->lname;
        $this->address = $applicant->address;
        $this->bday = $applicant->bday;
        $this->started_date = $applicant->started_date;
        $this->hrs = $applicant->hrs;
        $this->school_id = $applicant->school_id;
        $this->office_id = $applicant->office_id;
        $this->type = $applicant->type;
        $this->confirming = '';
        $this->openModal();

    }

    public function delete($id)
    {
        Applicant::find($id)->delete();
        session()->flash('message', 'On-the-Job Trainee Deleted Successfully.');
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }

    public function kill($id)
    {
        // $applicants = ModelsApplicant::find($id);
        ModelsApplicant::find($id)->delete();

    }

    public function storeCert ()
    {
        $this->validate([
            'dateFinished' => 'required',
            'dateIssued' => 'required',
            ]);

        $data = [
            'fullname' => $this->applicant->fullname(),
            'type' => $this->applicant->type,
            'office_name' => $this->applicant->office->name,
            'dateFinished' => $this->dateFinished,
            'dateIssued' => $this->dateIssued,
            'hrs' => $this->applicant->hrs,
        ];
        $this->applicant->certificate()->create($data);
        $this->certModal = false;
        $this->resetInputFields();
    }

};


