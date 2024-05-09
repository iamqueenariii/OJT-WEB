<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Office;
use App\Models\Report;
use App\Models\School;
use Livewire\Component;

class Reports extends Component
{
    public $applicants;
    public $offices, $offices_table, $searchToken, $reports, $schools;
    public $school_id;
    public $office_id;

    public $showSchoolTable = false;

    public $showOfficeTable = false;

    public function setTableSchool()
    {
        $this->showSchoolTable = true;
        $this->showOfficeTable = false;

        $this->applicants = Applicant::whereNotNull('school_id')->get();
    }

    public function FilterApplicantsBySchool()
    {
        $this->applicants = Applicant::whereNotNull('school_id')->where('school_id', '=', $this->school_id)->get();
    }

    public function FilterApplicantsByOffice()
    {
        $this->offices_table = Office::where('id', '=', $this->office_id)->get();
    }

    public function setOfficeSchool()
    {
        $this->showOfficeTable = true;
        $this->showSchoolTable = false;

        $this->offices_table = Office::all();
    }

    public function render()
    {
        return view('livewire.reports')->layout('layouts.admin');
    }

    public function changeSchool()
    {
        $this->applicants = Applicant::where('school', 'LIKE', '%' . $this->searchToken . '%')
        ->get();
    }

    public function changeOffice(){
        $this->offices = Office::where('name', 'LIKE', '%' . $this->searchToken . '%')->get();
    }

    public function mount()
    {
        $this->schools = School::all();
        $this->offices = Office::all();
    }
}
