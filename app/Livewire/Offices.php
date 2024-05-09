<?php

namespace App\Livewire;

use App\Models\Office;
use Livewire\Component;

class Offices extends Component
{
    public $offices, $searchToken, $office_id, $name, $confirming, $office_head, $position;

    public $isOpen = 0;

    public function mount()
    {
        $this->offices = Office::all();
    }

    public function change(){
        $this->offices = Office::where('name', 'LIKE', '%' . $this->searchToken . '%')->get();
    }

    public function render()
    {
        return view('livewire.offices')->layout('layouts.admin');

    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->office_id = '';
        $this->office_head = '';
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
            'office_head' => 'required',
            'position' => 'required'
        ]);

        Office::updateOrCreate(['id' => $this->office_id], [
            'name' => $this->name,
            'office_head' => $this->office_head,
            'position' => $this->position
        ]);

        session()->flash('message',
            $this->office_id ? 'Office Updated Successfully.' : 'Office Created Successfully.');
        $this->closeModal();
        $this->offices = Office::all();
        $this->resetInputFields();

    }

    public function edit($id)
    {
        $office = Office::findOrFail($id);
        $this->office_id = $id;
        $this->name= $office->name;
        $this->office_head= $office->office_head;
        $this->position= $office->position;
        $this->openModal();
    }


    public function delete($id)
    {
        Office::find($id)->delete();
        session()->flash('message', 'Office Deleted Successfully.');
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }

    public function kill($id)
    {
        Office::find($id)->delete();
        session()->flash('message', 'Office Deleted Successfully.');
        $this->offices = Office::all();
    }
}
