<?php

namespace App\Livewire;

use App\Models\School;
use Livewire\Component;

class Schools extends Component
{
    public $schools, $searchToken, $school_id, $name, $confirming, $school_head, $position;

    public $isOpen = 0;

    public function mount()
    {
        $this->schools = School::all();
    }

    public function change(){
        $this->schools = School::where('name', 'LIKE', '%' . $this->searchToken . '%')->get();
    }

    public function render()
    {
        return view('livewire.schools')->layout('layouts.admin');

    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->school_id = '';
        $this->school_head = '';
        $this->position = '';

    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }


    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'school_head' => 'required',
            'position' => 'required'
        ]);

        School::updateOrCreate(['id' => $this->school_id], [
            'name' => $this->name,
            'school_head' => $this->school_head,
            'position' => $this->position
        ]);

        session()->flash('message',
            $this->school_id ? 'School Updated Successfully.' : 'School Created Successfully.');
        $this->closeModal();
        $this->schools = School::all();
        $this->resetInputFields();

    }

    public function edit($id)
    {
        $school = School::findOrFail($id);
        $this->school_id = $id;
        $this->name= $school->name;
        $this->school_head= $school->school_head;
        $this->position= $school->position;
        $this->openModal();
    }


    public function delete($id)
    {
        School::find($id)->delete();
        session()->flash('message', 'School Deleted Successfully.');
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }

    public function kill($id)
    {
        School::find($id)->delete();
        session()->flash('message', 'School Deleted Successfully.');
        $this->schools = School::all();
    }
}
