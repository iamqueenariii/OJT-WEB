<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


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

        // //middle part paragraph
        $imageWidth = $image->getWidth(); // Get the width of the image

        // Estimate the text width based on the number of characters and font size
        $text = "for successfully completed the {$certificate->type} at the Local \nGovernment Unit of Manolo Fortich under {$certificate->office_name} \nfor {$certificate->hrs} hours from " .
            (date('FY', strtotime($certificate->applicant->started_date)) == date('FY', strtotime($certificate->dateFinished)) ?
                date('F j', strtotime($certificate->applicant->started_date)) . ' - ' . date('j, Y', strtotime($certificate->dateFinished)) : (date('Y', strtotime($certificate->applicant->started_date)) == date('Y', strtotime($certificate->dateFinished)) ?
                    date('F j', strtotime($certificate->applicant->started_date)) . ' - ' . date('F j, Y.', strtotime($certificate->dateFinished)) :
                    ''));

        // Estimate the font size and calculate the bounding box of each line of text
        $fontSize = 25;
        $fontPath = public_path('storage/font/arial.ttf');
        $lines = explode("\n", $text);

        // Calculate the maximum text width among all lines
        $maxTextWidth = 0;
        foreach ($lines as $line) {
            $boundingBox = imagettfbbox($fontSize, 39, $fontPath, $line);
            $lineWidth = $boundingBox[2] - $boundingBox[0];
            if ($lineWidth > $maxTextWidth) {
                $maxTextWidth = $lineWidth;
            }
        }

        // Calculate the x-coordinate for center alignment of each line
        $xCoordinates = [];
        foreach ($lines as $line) {
            $boundingBox = imagettfbbox($fontSize, 39, $fontPath, $line);
            $lineWidth = $boundingBox[2] - $boundingBox[0];
            $xCoordinate = ($imageWidth - $lineWidth) / 2;
            $xCoordinates[] = $xCoordinate;
        }

        // Calculate the y-coordinate (vertical position) for the text
        $yCoordinate = 470;

        // Add each line of text to the image with center alignment
        foreach ($lines as $index => $line) {
            $xCoordinate = $xCoordinates[$index];
            $image->text($line, $xCoordinate, $yCoordinate, function ($font) use ($fontPath, $fontSize) {
                $font->file($fontPath); // Set the path to your selected font file
                $font->size($fontSize); // Set the font size
            });
            $yCoordinate += $fontSize * 1.5; // Adjust y-coordinate for next line spacing
        }

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
        return response()->download(storage_path($imagePath), $fileName);

        // return view('reports.certificate', compact('certificate'));
    }



public function saveAsJpgs($certificate_ids)
{
    // Check if $certificate_ids is a JSON string
    if (is_string($certificate_ids)) {
        // Decode the JSON string to get the array of certificate IDs
        $ids = json_decode($certificate_ids);

        // Check if JSON decoding was successful
        if ($ids === null && json_last_error() !== JSON_ERROR_NONE) {
            // Handle the case where JSON decoding failed
            return response()->json(['error' => 'Invalid JSON format for certificate IDs'], 400);
        }
    } elseif (is_array($certificate_ids)) {
        // If $certificate_ids is already an array, use it directly
        $ids = $certificate_ids;
    } else {
        // Handle the case where $certificate_ids is neither a JSON string nor an array
        return response()->json(['error' => 'Certificate IDs must be provided as an array or a JSON string'], 400);
    }

    // Initialize a new ZipArchive instance
    $zip = new ZipArchive;

    // Create a unique temporary file name for the zip archive
    $zipFileName = 'certificates_' . uniqid() . '.zip';

    // Define the directory where you want to save the temporary ZIP file
    $directory = storage_path('app/public/certificates/');

    // Make sure the temporary directory exists, if not, create it
    if (!file_exists($directory) && !mkdir($directory, 0755, true)) {
        return response()->json(['error' => 'Failed to create directory for saving ZIP file'], 500);
    }

    // Concatenate the directory path and the file name to get the full temporary file path for the zip archive
    $zipFilePath = $directory . DIRECTORY_SEPARATOR . $zipFileName;

    // Open the temporary file for writing
    if ($zip->open($zipFilePath, ZipArchive::CREATE) !== true) {
        // Handle the case where zip archive creation failed
        return response()->json(['error' => 'Failed to create zip archive'], 500);
    }

    // Iterate through each certificate ID
    foreach ($ids as $certificate_id) {
        // Retrieve certificate data based on the ID
        $certificate = Certificate::find($certificate_id);

        // Ensure the certificate exists
        if (!$certificate) {
            return response()->json(['error' => "Certificate not found for ID: $certificate_id"], 404);
        }

        // Generate certificate image (JPG) using the saveAsJpg function
        $imagePath = $this->generateCertificateImage($certificate);

        // Ensure the image path is valid
        if (!$imagePath) {
            return response()->json(['error' => "Failed to generate image for certificate ID: $certificate_id"], 500);
        }

        // Add the image file to the zip archive with a unique name
        $imageFilePath = storage_path($imagePath);
        $imageName = $certificate->applicant->fullname() . '.jpg';

        // Check if the image file exists
        if (file_exists($imageFilePath)) {
            $zip->addFile($imageFilePath, $imageName);
        } else {
            // Handle the case where the image file does not exist
            return response()->json(['error' => "Image file not found for certificate ID: $certificate_id"], 404);
        }
    }

    // Close the zip archive
    $zip->close();

    // Check if the ZIP file was created successfully
    if (!file_exists($zipFilePath)) {
        return response()->json(['error' => 'Failed to create ZIP file'], 500);
    }

    // Return a download response for the ZIP archive
    return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
}

// Helper function to generate and save JPG for a given certificate ID
public function generateCertificateImage($certificate)
{
    // Example: Generate certificate image (JPG) using Intervention Image
    $image = Image::make(public_path('storage/template/template1.jpg'));

    // Fullname
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

    // Middle part paragraph
    $text = "for successfully completed the {$certificate->type} at the Local \nGovernment Unit of Manolo Fortich under {$certificate->office_name} \nfor {$certificate->hrs} hours from " .
        (date('FY', strtotime($certificate->applicant->started_date)) == date('FY', strtotime($certificate->dateFinished)) ?
            date('F j', strtotime($certificate->applicant->started_date)) . ' - ' . date('j, Y', strtotime($certificate->dateFinished)) : (date('Y', strtotime($certificate->applicant->started_date)) == date('Y', strtotime($certificate->dateFinished)) ?
                date('F j', strtotime($certificate->applicant->started_date)) . ' - ' . date('F j, Y.', strtotime($certificate->dateFinished)) :
                ''));

    // Estimate the font size and calculate the bounding box of each line of text
    $fontSize = 25;
    $fontPath = public_path('storage/font/arial.ttf');
    $lines = explode("\n", $text);

    // Calculate the maximum text width among all lines
    $maxTextWidth = 0;
    foreach ($lines as $line) {
        $boundingBox = imagettfbbox($fontSize, 39, $fontPath, $line);
        $lineWidth = $boundingBox[2] - $boundingBox[0];
        if ($lineWidth > $maxTextWidth) {
            $maxTextWidth = $lineWidth;
        }
    }

    // Calculate the x-coordinate for center alignment of each line
    $xCoordinates = [];
    foreach ($lines as $line) {
        $boundingBox = imagettfbbox($fontSize, 39, $fontPath, $line);
        $lineWidth = $boundingBox[2] - $boundingBox[0];
        $xCoordinate = ($imageWidth - $lineWidth) / 2;
        $xCoordinates[] = $xCoordinate;
    }

    // Calculate the y-coordinate (vertical position) for the text
    $yCoordinate = 470;

    // Add each line of text to the image with center alignment
    foreach ($lines as $index => $line) {
        $xCoordinate = $xCoordinates[$index];
        $image->text($line, $xCoordinate, $yCoordinate, function ($font) use ($fontPath, $fontSize) {
            $font->file($fontPath); // Set the path to your selected font file
            $font->size($fontSize); // Set the font size
        });
        $yCoordinate += $fontSize * 1.5; // Adjust y-coordinate for next line spacing
    }

    // Add additional text
    $image->text('Given this ' . Carbon::parse($certificate->dateIssued)->format('jS') . ' of ' . ucwords(date('F Y', strtotime($certificate->dateIssued))) . ' at Manolo Fortich, Bukidnon.', 230, 610, function ($font) {
        $font->file(public_path('storage/font/arial.ttf')); // Set the path to your selected font file
        $font->size(25); // Increase the font size as needed
    });

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

    return $imagePath; // Return the relative path of the saved image
}

}
