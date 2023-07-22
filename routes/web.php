<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AdminCompanyController;
use App\Http\Controllers\AdminSchemeController;
use App\Http\Controllers\AuditController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ClaimsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\FCMController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TestController;
use App\Models\Claim;

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

Route::get('activity',[TestController::class, 'getActivities']);

 //FCM TOKEN UPDATE ROUTES
 Route::post('/update-fcm-token',[FCMController::class, 'updateFCMToken'])->name('update-fcm-token');

Route::get('/', function () {
    return redirect()->to('/login');
});

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'authenticateUser'])->name('authenticate');
Route::get('/forgot-password', [AuthController::class, 'forgotPasswordPage'])->name('forgot-password');
Route::get('/logout', [AuthController::class, 'logoutUser'])->name('logout');


//shared authenticated routes WITH COMMON ROLES
Route::group(['middleware' => ['auth','role:system-admin|claim-entry|audit|accounting|front-desk']], function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('home');
    Route::get('/claim-details', [ClaimsController::class, 'claimDetails']);
});


//used by all members
Route::get('/download/{id}/{claimid}', [DownloadController::class, 'downloadClaimFiles']);
Route::post('/report-issue-on-file', [IssueController::class, 'reportIssueOnClaimFile']);
Route::get('/issue-review', [IssueController::class, 'reviewIssue']);
Route::get('/claims-with-issue', [IssueController::class, 'getClaimsWithIssue']);
Route::post('/issue-review', [IssueController::class, 'resolveIssue']);
Route::get('/search-claims',[SearchController::class, 'search']);
Route::get('/customers', [CustomersController::class, 'claimEmployees']);
Route::get('/report-by-company', [ReportsController::class, 'reportsByCompany']);
Route::get('/report-by-scheme', [ReportsController::class, 'reportsByScheme']);
Route::get('/excel-reports', [ReportsController::class, 'excelExports']);
Route::get('/reports-breakdown', [ReportsController::class, 'reportsBreakdown']);

Route::get('/notifications', [NotificationsController::class, 'getNotifications']);

Route::any('/bank-payment-report',[BankController::class, 'paymentReports']);
Route::get('/banks',[BankController::class, 'banks']);
Route::post('/new-bank', [BankController::class, 'addBank']);





Route::group(['middleware' => ['auth','role:system-admin']], function() {
    Route::get('/new-staff', [AccountsController::class, 'newStaff']);
    Route::post('/new-staff', [AccountsController::class, 'saveStaff']);
    Route::get('/all-staffs', [AccountsController::class, 'staffs']);
    Route::get('/edit-staff', [AccountsController::class, 'editStaff']);
    Route::post('/edit-staff', [AccountsController::class, 'saveNewStaffInfo']);
    Route::post('/update-staff-account-state', [AccountsController::class, 'updateStaffAccountState']);

    //EXTRAS
    Route::post('/new-company', [AdminCompanyController::class, 'saveCompany']);
    Route::get('/new-scheme', [AdminSchemeController::class, 'newScheme']);
    Route::get('/new-company', [AdminCompanyController::class, 'newCompany']);
    Route::post('/new-scheme', [AdminSchemeController::class, 'saveScheme']);
    Route::get('/claim-state', [AdminSchemeController::class, 'claimState']);   
});

Route::group(['middleware' => ['auth','role:audit']], function() {
    Route::get('/pending-audit', [AuditController::class, 'pendingAudit']);
    Route::get('/audited-claims', [AuditController::class, 'auditedClaims']);
    Route::get('/audit', [AuditController::class, 'auditClaim']);
    Route::post('/audit', [AuditController::class, 'uploadAuditedFiles']);
});



Route::group(['middleware' => ['auth','role:accounting']], function() {
    Route::get('/pending-receipt', [SchemeController::class, 'pendingReceipt']);
    Route::post('/receive-claim', [SchemeController::class, 'receiveClaim']);
    Route::get('/received-claims', [SchemeController::class, 'receivedClaims']);
    Route::get('/assigned-schemes', [SchemeController::class, 'assignedSchemes']);
    Route::get('/pending-payments', [SchemeController::class, 'pendingPayments']);
    Route::post('/send-to-bank', [SchemeController::class, 'sendPaymentToBank']);
    Route::post('/sent-to-bank', [SchemeController::class, 'paymentSentToBank']);
});


Route::group(['middleware' => ['auth','role:system-admin|claim-entry|front-desk']], function() {
    Route::post('/delete-claim', [ClaimsController::class, 'deleteClaim']);
    Route::post('/delete-single-claim-file', [ClaimsController::class, 'deleteClaimFile']);
    //NEW CLAIM
    Route::get('/new-claim', [ClaimsController::class, 'newClaim']);
    Route::post('/new-claim', [ClaimsController::class, 'saveClaim']);
    Route::get('/invalid-claims', [ClaimsController::class, 'invalidClaims']);
    Route::get('/un-processed-claims', [ClaimsController::class, 'unProcessedClaims']);  
    Route::get('/processed-files', [ClaimsController::class, 'uploadProcessedFiles']);
    Route::post('/processed-files', [ClaimsController::class, 'saveProcessedFiles']);
    Route::get('/request-files', [ClaimsController::class, 'uploadRequestFiles']);
    Route::post('/request-files', [ClaimsController::class, 'saveRequestFiles']);

});
