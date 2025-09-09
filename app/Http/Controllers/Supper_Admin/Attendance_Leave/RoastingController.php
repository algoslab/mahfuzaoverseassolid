<?php

namespace App\Http\Controllers\Supper_Admin\Attendance_Leave;

use App\Http\Controllers\Controller;
use App\Models\Admin\HRM\Employee;
use App\Models\Admin\MyOffice\Roster;
use App\Models\Supper_Admin\Attendance_Leave\Leave;
use App\Models\Supper_Admin\Attendance_Leave\Roasting;
use Illuminate\Http\Request;

class RoastingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('department_id') && $request->department_id) {
            $departmentId = $request->get('department_id');
            $employees = Employee::with('branch')
//                ->where('company_id', $user->company_id)
                ->where('status', 1)
                ->where('department_id', $departmentId)
                ->get();
        } else {
            $employees = Employee::with('branch')
//                ->where('company_id', $user->company_id)
                ->where('status', 1)->get();

        }
        $rosters = Roster::
//        where('company_id', $user->company_id)->
        where('status', 1)->get();
        return view('supper_admin.pages.attendanceAndLeave.assign-roasting', compact('employees', 'rosters'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Roasting $roasting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roasting $roasting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->update(['roster_id'=>$request->roster_id]);
            return response()->json(['status' => 'success', 'message' => 'Roaster update successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roasting $roasting)
    {
        //
    }
}
