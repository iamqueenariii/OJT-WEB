<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class TextToImageConverter extends Component
{
    public $textInput;
    public $image;
    public $certificate_id; // Add this property

    public function render()
    {
        return view('livewire.text-to-image-converter');
    }

    public function generateImage()
    {
        // Generate image from text
        $img = Image::canvas(400, 200, '#ffffff');
        
        $imagePath = 'images/' . time() . '.png';
        $img->save(public_path($imagePath));

        // Set image path
        $this->image = asset($imagePath);
    }

    public function saveCertificate()
    {
        // Ensure certificate_id is set
        if (!$this->certificate_id) {
            return; // Return early if certificate_id is not set
        }

        return redirect()->route('save-as-jpg', ['certificate_id' => $this->certificate_id]);
        // Handle the response as needed
    }
}
