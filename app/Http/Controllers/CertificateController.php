<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CertificateController extends Controller
{

    public $font;
    public $xCoordinate;

    public function saveAsJpg($certificate_id)
    {
        // Retrieve certificate data based on the ID
        $certificate = Certificate::findOrFail($certificate_id);

        // Example: Generate certificate image (JPG) using Intervention Image
        $image = Image::make(public_path('storage/template/template1.jpg'));

        //fullname
        $imageWidth = $image->getWidth(); // Get the width of the image

        // Retrieve the fullname from the certificate
        $fullname = $certificate->applicant->fullname();

        // Estimate the font size and calculate the bounding box of the text
        $fontSize = 90; // Set the font size as needed
        $fontPath = public_path('storage/font/MTCORSVA.ttf'); // Set the path to your selected font file
        $boundingBox = imagettfbbox($fontSize, 40, $fontPath, $fullname);

        // Calculate the text width based on the bounding box
        $textWidth = $boundingBox[2] - $boundingBox[0];

        // Calculate the x-coordinate for center alignment
        $xCoordinate = ($imageWidth - $textWidth) / 2;

        // Calculate the y-coordinate (vertical position) for the text
        $yCoordinate = 400;

        // Add the text to the image with center alignment
        $image->text($fullname, $xCoordinate, $yCoordinate, function ($font) use ($fontPath, $fontSize) {
            $font->file($fontPath);
            $font->size($fontSize);
        });

        //middle part paragraph
        // Add additional text as needed
        $imageWidth = $image->getWidth(); // Get the width of the image

        // Estimate the text width based on the number of characters and font size
        $text = "             for successfully completed the {$certificate->type} at the Local\nGovernment Unit of Manolo Fortich under {$certificate->office_name} \n                           for {$certificate->hrs} hours from " .
            (date('FY', strtotime($certificate->applicant->started_date)) == date('FY', strtotime($certificate->dateFinished)) ?
                date('F j', strtotime($certificate->applicant->started_date)) . ' - ' . date('j, Y', strtotime($certificate->dateFinished)) : (date('Y', strtotime($certificate->applicant->started_date)) == date('Y', strtotime($certificate->dateFinished)) ?
                    date('F j', strtotime($certificate->applicant->started_date)) . ' - ' . date('F j, Y.', strtotime($certificate->dateFinished)) :
                    ''));

        $textWidth = strlen($text) * 5;
        $xCoordinate = 100;

        // Add the text to the image with center alignment
        $image->text($text, $xCoordinate, 470, function ($font) {
            $font->file(public_path('storage/font/arial.ttf')); // Set the path to your selected font file
            $font->size(25); // Set the font size
            $font->align('bottom');
        });


        //last part
        // Add additional text
        $image->text('Given this ' . Carbon::parse($certificate->dateIssued)->format('jS') . ' of ' . ucwords(date('F Y', strtotime($certificate->dateIssued))) . ' at Manolo Fortich, Bukidnon.', 230, 610, function ($font) {
            $font->file(public_path('storage/font/arial.ttf')); // Set the path to your selected font file
            $font->size(25); // Increase the font size as needed
        });;


        // Save the image as JPG

        $fullName = $certificate->applicant->fullname();

        // Sanitize the full name to remove any special characters
        $sanitizedFullName = Str::slug($fullName, '_');

        // Define the directory where you want to save the image
        $directory = 'app/public/certificates/';

        // Define the file name using the sanitized full name and current date/time
        $fileName = $sanitizedFullName . '_' . date('Ymd') . '.jpg';

        // Concatenate the directory path and the file name
        $imagePath = $directory . $fileName;

        // Save the image with the specified file name
        $image->save(storage_path($imagePath));

        return view('reports.certificate', compact('certificate'));
    }
}
