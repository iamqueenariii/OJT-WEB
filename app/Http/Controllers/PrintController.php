<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Office;
use App\Models\School;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function PrintSchool($school_id)
    {
        // $schools  = null;
        if($school_id == 0) {
            $schools = School::all();
        } else {
            $schools = School::where('id', $school_id)->get();
        }

        return view('reports.school', compact('schools'));
    }

    public function PrintOffice($office_id)
    {
        // $offices  = null;
        if($office_id == 0) {
            $offices = Office::all();
        } else {
            $offices = Office::where('id', $office_id)->get();
        }

        return view('reports.office', compact('offices'));
    }

    public function PrintCerts($certificate_ids)
    {
        $ids = json_decode($certificate_ids);

        $certificates = Certificate::whereIn('id', $ids)->get();

        return view('reports.certificates', compact('certificates'));
    }

    public function PrintCert($certificate_id)
    {

        $certificate = Certificate::find($certificate_id);

        return view('reports.certificate', compact('certificate'));
    }

}
