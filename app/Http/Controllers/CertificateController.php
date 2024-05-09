<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class CertificateController extends Controller
{

    public $font;

    public function saveAsJpg($certificate_id)
    {
        // Retrieve certificate data based on the ID
        $certificate = Certificate::findOrFail($certificate_id);

        // Example: Generate certificate image (JPG) using Intervention Image
        $image = Image::make(public_path('storage/template/template1.jpg'));

        // Add certificate content to the image
        // $image->text($certificate->applicant->fullname(), 85, 400, function ($font) {
        //     $font->file(public_path('storage/font/arial_bold.ttf')); // Set the path to your selected font file
        //     $font->size(55); // Increase the font size as needed

        // });
        
        $imageWidth = $image->getWidth(); // Get the width of the image

        // Calculate the text width
        $text = $certificate->applicant->fullname();
        $textWidth = strlen($text) * 10; // Estimate text width (adjust the constant as needed)

        // Calculate the x-coordinate for center alignment
        $xCoordinate = ($imageWidth - $textWidth) / 10;

        // Add the text to the image with fixed position and center alignment
        $image->text($text, $xCoordinate, 400, function ($font) {
            $font->file(public_path('storage/font/arial_bold.ttf')); // Set the path to your selected font file
            $font->size(55); // Set the font size as needed
        });





        // Add additional text as needed
        $imageWidth = $image->getWidth(); // Get the width of the image

        // Estimate the text width based on the number of characters and font size
        $text = "             for successfully completed the {$certificate->type} at the Local\nGovernment Unit of Manolo Fortich under {$certificate->office_name} \n                           for {$certificate->hrs} hours from " .
            (date('FY', strtotime($certificate->applicant->started_date)) == date('FY', strtotime($certificate->dateFinished)) ?
                date('F j', strtotime($certificate->applicant->started_date)) . ' - ' . date('j, Y', strtotime($certificate->dateFinished)) : (date('Y', strtotime($certificate->applicant->started_date)) == date('Y', strtotime($certificate->dateFinished)) ?
                    date('F j', strtotime($certificate->applicant->started_date)) . ' - ' . date('F j, Y.', strtotime($certificate->dateFinished)) :
                    ''));

        $textWidth = strlen($text) * 5; // Assume an average width per character, adjust as needed

        // Calculate the x-coordinate to center-align the text
        // $xCoordinate = ($imageWidth - $textWidth) /2;
        $xCoordinate = 100;

        // Add the text to the image with center alignment
        $image->text($text, $xCoordinate, 470, function ($font) {
            $font->file(public_path('storage/font/arial.ttf')); // Set the path to your selected font file
            $font->size(25); // Set the font size
            $font->align('bottom');
        });





        // Add additional text
        $image->text('Given this ' . Carbon::parse($certificate->dateIssued)->format('jS') . ' of ' . ucwords(date('F Y', strtotime($certificate->dateIssued))) . ' at Manolo Fortich, Bukidnon.', 230, 610, function ($font) {
            $font->file(public_path('storage/font/arial.ttf')); // Set the path to your selected font file
            $font->size(25); // Increase the font size as needed
            // $font->align('center');
            // $font->display('flex');

        });;


        // Save the image as JPG
        $imagePath = 'app/public/certificates/' . time() . '.jpg';
        $image->save(storage_path($imagePath));

        // Optionally, you can return the image path or any other response
        return response()->json(['image_path' => $imagePath]);
    }
}
