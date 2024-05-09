<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Office;
use Livewire\Component;

class Dashboard extends Component
{

    public $data;

    public function mount()
    {
        $offices = Office::get();
        $this->data = [];
        foreach($offices as $office) {
            $this->data[]=[
                'x' => $office->name, 'y' => $office->applicants->count()
            ];
        }

    }



    public function render()
    {
        return view('livewire.dashboard',[
            'TotalApplicants' => Applicant::count(),
            // ''
        ])->layout('layouts.admin');
    }

}
