<?php

use App\Http\Controllers\Admin\HRM\EmployeeController;
use App\Http\Controllers\Business\CompaniesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Supper_Admin\Location\ContinentController;
use App\Http\Controllers\Supper_Admin\Location\CurrencyController;
use App\Http\Controllers\Supper_Admin\Location\CountryController;
use App\Http\Controllers\Supper_Admin\Location\DistrictController;
use App\Http\Controllers\Supper_Admin\Location\DivisionController;
use App\Http\Controllers\Supper_Admin\Location\PostOfficeController;
use App\Http\Controllers\Supper_Admin\Location\StateController;
use App\Http\Controllers\Supper_Admin\Location\ThanaController;
use App\Http\Controllers\Supper_Admin\service\AirTicketcontroller;
use App\Http\Controllers\Supper_Admin\service\HazzUmrahcontroller;
use App\Http\Controllers\Supper_Admin\service\WorkPermitcontroller;
use App\Http\Controllers\Admin\MyOffice\BranchController;
use App\Http\Controllers\Admin\MyOffice\DepartmentController;
use App\Http\Controllers\Admin\MyOffice\DesignationController;
use App\Http\Controllers\Admin\MyOffice\RoleController;
use App\Http\Controllers\Admin\MyOffice\RosterController;
use App\Http\Controllers\Admin\MyOffice\HolidayController;
use App\Http\Controllers\Admin\permission\PermissionButtonController;
use App\Http\Controllers\Admin\Mikrotik\HotspotController;
use App\Http\Controllers\Admin\Mikrotik\MacController;
use App\Http\Controllers\Supper_Admin\MikrotikServiceController;
use App\Http\Controllers\Supper_Admin\Mikrotik\MikrotikDeviceController;
use App\Http\Controllers\Admin\People\AgentController;
use App\Http\Controllers\Admin\People\DelegateController;
use App\Http\Controllers\Admin\People\DelegateOfficeController;
use App\Http\Controllers\Admin\Process\CandidateTypeController;
use App\Http\Controllers\Admin\Process\ProcessCategoryController;
use App\Http\Controllers\Admin\Process\JobCategoryController;
use App\Http\Controllers\Admin\Process\JobListController;
use App\Http\Controllers\Admin\Process\ProcessStepController;
use App\Http\Controllers\Admin\Process\ProcessOfficeController;
use App\Http\Controllers\Admin\Process\AsignJobToOfficeController;
use App\Http\Controllers\Admin\Process\AirlineOfficeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Resource route for companies
Route::resource('companies', CompaniesController::class);
Route::get('/airtickets/active', [AirTicketController::class, 'Activeindex'])->name('api.airticket.active');
Route::get('/airtickets/locations', [AirTicketController::class, 'getDestinations'])->name('api.ticket.getDestinations');
Route::get('/hazz/active', [HazzUmrahcontroller::class, 'Activeindex'])->name('api.hazz.active');
Route::get('/workpermit/active', [WorkPermitcontroller::class, 'Activeindex'])->name('api.workpermit.active');


// Dashboard route with role-based redirection
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'supper_admin') {
        return redirect()->route('supper_admin.dashboard');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    abort(403, 'Unauthorized');
})->middleware(['auth', 'verified'])->name('dashboard');


// Group routes for 'supper_admin' with prefix and middleware
Route::middleware(['auth', 'verified'])->prefix('supper_admin')->name('supper_admin.')->group(function () {
    Route::get('/', function () {
        return view('supper_admin.pages.home.dashboard');
    })->name('dashboard');

    Route::post('air-ticket-csv', [AirTicketcontroller::class, 'importCSV'])->name('air-ticket.import');
    Route::get('air-ticket-csv-download', [AirTicketcontroller::class, 'downloadTemplate'])->name('air-ticket.download-template');
    Route::get('/continents/active', [ContinentController::class, 'Activeindex'])->name('continent.active');
    Route::get('/countries/active', [CountryController::class, 'Activeindex'])->name('country.active');
    Route::get('/divisions/active', [DivisionController::class, 'Activeindex'])->name('division.active');
    Route::get('/district/active', [DistrictController::class, 'Activeindex'])->name('district.active');
    Route::get('/thana/active', [ThanaController::class, 'Activeindex'])->name('thana.active');
    Route::get('/company/active', [CompaniesController::class, 'Activeindex'])->name('company.active');


    Route::get('/connect-router/{id}', [MikrotikServiceController::class, 'connectToRouter'])->name('mikrotik.connect');
    Route::get('/disconnect-router/{id}', [MikrotikServiceController::class, 'disconnectFromRouter'])->name('mikrotik.disconnect');
    Route::get('/check-router', [MikrotikServiceController::class, 'checkRouterStatus'])->name('mikrotik.check');
    Route::post('mikrotik/hotspot-user', [MikrotikServiceController::class, 'createHotspotUser'])->name('mikrotik.user');



    // Resource routes for services under supper_admin
    Route::resource('air-ticket', AirTicketcontroller::class);
    Route::resource('hazz-umrah', HazzUmrahcontroller::class);
    Route::resource('workpermits', WorkPermitcontroller::class);
    Route::resource('companies', CompaniesController::class)->only(['create', 'edit', 'show', 'update', 'destroy']);
    Route::resource('continents', ContinentController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('districts', DistrictController::class);
    Route::resource('thanas', ThanaController::class);
    Route::resource('postoffices', PostOfficeController::class);
    Route::resource('states', StateController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::resource('mikrotik-devices', MikrotikDeviceController::class);



});

// Group routes for 'admin' with prefix and middleware
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('backend.pages.home.dashboard');
    })->name('dashboard');
    Route::get('/branches/active', [BranchController::class, 'activeIndex'])->name('branch.active');
    Route::get('/department/active', [DepartmentController::class, 'Activeindex'])->name('department.active');
    Route::get('/designation/active', [DesignationController::class, 'Activeindex'])->name('designation.active');
    Route::get('/roster/active', [RosterController::class, 'activeIndex'])->name('roster.active');
    Route::get('/roles/active', [RoleController::class, 'activeIndex'])->name('roles.active');
    Route::get('/employee/active', [EmployeeController::class, 'activeIndex'])->name('employee.active');
    Route::match(['get', 'post'], '/employee/{id}/finger', [EmployeeController::class, 'finger'])->name('employee.finger');
    Route::match(['get', 'post'], '/employee/{id}/card', [EmployeeController::class, 'accessCard'])->name('employee.card');
    Route::get('/router/active', [MikrotikDeviceController::class, 'Activeindex'])->name('router.active');
    Route::get('/agent/active', [AgentController::class, 'Activeindex'])->name('agent.active');
    Route::get('/delegate/active', [DelegateController::class, 'Activeindex'])->name('delegate.active');
    Route::get('/processCategory/active', [ProcessCategoryController::class, 'Activeindex'])->name('processCategory.active');
    Route::get('/jobCategory/active', [JobCategoryController::class, 'Activeindex'])->name('jobCategory.active');
    Route::get('/jobLists/active', [JobListController::class, 'Activeindex'])->name('jobLists.active');
    Route::get('/processOffices/active', [ProcessOfficeController::class, 'Activeindex'])->name('processOffices.active');


    Route::resource('branches', BranchController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionButtonController::class);
    Route::resource('rosters', RosterController::class);
    Route::resource('holidays', HolidayController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('agents', AgentController::class);
    Route::resource('hotspots', HotspotController::class);
    Route::resource('mac-address', MacController::class);
    Route::resource('delegates', DelegateController::class);
    Route::resource('delegateOffice', DelegateOfficeController::class);
    Route::resource('candidateTypes', CandidateTypeController::class);
    Route::resource('processCategory', ProcessCategoryController::class);
    Route::resource('jobCategory', JobCategoryController::class);
    Route::resource('jobLists', JobListController::class);
    Route::resource('processSteps', ProcessStepController::class);
    Route::resource('processOffices', ProcessOfficeController::class);
    Route::resource('asignjobtoOffice', AsignJobToOfficeController::class);
    Route::resource('airlineOffices', AirlineOfficeController::class);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include authentication routes
require __DIR__.'/auth.php'; 
