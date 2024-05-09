<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Certificate;
use App\Models\Office;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Certificates extends Component
{

    public $certificate, $applicant_id, $fullname, $dateFinished, $dateIssued, $hrs, $office_name, $type, $certEdit, $certificate_id, $office_id, $selected_cert = [], $searchToken, $offices, $selectAll, $year;

    public $showYear = false, $years;
    public $dateIssuedList = [];

    public function setYear($year)
    {
        $this->showYear = true;

        $this->year = $year;

        $this->dateIssuedList = Certificate::pluck('dateIssued')->toArray();
    }

    public function print()
    {
        $certificate_ids = json_encode(array_keys($this->selected_cert, true));
        return redirect()->route('print-certificates', ['certificate_ids' => $certificate_ids]);
    }

    public function openModal()
    {
        $this->certEdit = true;
    }

    public function closeModal()
    {
        $this->applicant_id = null;
        $this->certificate_id = null;
        $this->fullname = null;
        $this->dateFinished = null;
        $this->dateIssued = null;
        $this->hrs = null;
        $this->office_name = null;
        $this->type = null;
        $this->certEdit = false;
    }

    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        $this->applicant_id = $certificate->applicant_id;
        $this->certificate_id = $id;
        $this->fullname = $certificate->fullname;
        $this->dateFinished = $certificate->dateFinished;
        $this->dateIssued = $certificate->dateIssued;
        $this->hrs = $certificate->hrs;
        $this->office_id = $certificate->applicant->office->id;
        $this->type = $certificate->type;
        $this->openModal();
    }

    public function delete($id)
    {
        Certificate::find($id)->delete();
        session()->flash('message', 'On-the-Job Trainee Deleted Successfully.');
    }

    public function mount()
    {
        $this->offices = Office::all();
        $certificates = Certificate::get('id');

        $this->years = Certificate::selectRaw('Year(dateIssued) as year')->distinct()->pluck('year')->toArray();

        foreach ($certificates as $certificate) {
            $this->selected_cert[$certificate->id] = false;
        }
    }

    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            foreach ($this->selected_cert as $key => $value) {
                $this->selected_cert[$key] = true;
            }
        } else {
            foreach ($this->selected_cert as $key => $value) {
                $this->selected_cert[$key] = false;
            }
        }
    }

    // Handle actions when other checkboxes are clicked
    public function updatedSelectedCert($value, $id)
    {
        if ($value) {
        } else {
        }
    }

    public function render()
    {
        $certificates = Certificate::where(function ($certificate) {
            return $certificate->where('fullname', 'like', '%' . $this->searchToken . '%')
                ->orWhere('office_name', 'like', '%' . $this->searchToken . '%')
                ->orWhere('type', 'like', '%' . $this->searchToken . '%');
        })
            ->when($this->year != null, function ($certificate) {
                return $certificate->whereYear('dateIssued', $this->year);
            })
            ->paginate(10);


        return view('livewire.certificates', compact('certificates'))->layout('layouts.admin');
    }

    public function storeCert()
    {
        $this->validate([
            'dateFinished' => 'required',
            'dateIssued' => 'required',
        ]);
        $data = [
            'fullname' => $this->fullname,
            'type' => $this->type,
            'dateFinished' => $this->dateFinished,
            'dateIssued' => $this->dateIssued,
            'hrs' => $this->hrs,
        ];
        if (isset($this->office_id)) {
            $office = Office::find($this->office_id);
            $data['office_name'] = $office->name;
        }
        Certificate::where('id', '=', $this->certificate_id)->update($data);
        $this->closeModal();
    }

    public function saveCertificate($certificate_id)
    {
        // Ensure certificate_id is set
        if (!$certificate_id) {
            return; // Return early if certificate_id is not set
        }

        return redirect()->route('save-as-jpg', ['certificate_id' => $certificate_id]);

        // Handle the response as needed
    }
}
