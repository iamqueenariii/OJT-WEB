<?php

use App\Http\Controllers\PrintController;
use App\Livewire\Applicant;
use App\Livewire\Certificates;
use App\Livewire\Dashboard;
use App\Livewire\Offices;
use App\Livewire\Reports;
use App\Livewire\Schools;
use App\Livewire\Users;
use App\Models\Certificate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

Route::get('dashboard',Dashboard::class)->name('dashboard');
Route::get('applicants',Applicant::class)->name('applicants');
Route::get('offices',Offices::class)->name('offices');
Route::get('reports',Reports::class)->name('reports');
Route::get('schools',Schools::class)->name('schools');
Route::get('certificates',Certificates::class)->name('certificates');

Route::get('print-school/{school_id}', [PrintController::class, 'PrintSchool'])->name('print-school');
Route::get('print-office/{office_id}', [PrintController::class, 'PrintOffice'])->name('print-office');
Route::get('print-certs/{certificate_ids}', [PrintController::class, 'PrintCerts'])->name('print-certificates');
Route::get('print-cert/{certificate_id}', [PrintController::class, 'PrintCert'])->name('print-certificate');
});

Route::get('save-as-jpg/{certificate_id}', [CertificateController::class, 'saveAsJpg'])->name('save-as-jpg');





