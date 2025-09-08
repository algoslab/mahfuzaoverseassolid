<?php

namespace App\Http\Controllers\Admin\Process;

use App\Http\Controllers\Controller;
use App\Models\Admin\Process\AsignJobToOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AsignJobToOfficeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $AsignJobToOffices = AsignJobToOffice::with('processOffice', 'processCategory', 'jobCategory', 'jobList')
                                                ->where('company_id', $user->company_id)
                                                ->get();
        return view('backend.pages.process.asign_job_office', compact('AsignJobToOffices'));
    }

    public function Activeindex()
    {
        $user = Auth::user();
        $AsignJobToOffices = AsignJobToOffice::where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($AsignJobToOffices);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'processing_cost'       => 'required|numeric|min:0',
                'proces_office_id'      => 'required|exists:process_offices,id',
                'process_category_id'   => 'required|exists:process_categories,id',
                'job_category_id'       => 'required|exists:job_categories,id',
                'job_list_id'           => 'required|exists:job_lists,id',
                'note'                  => 'nullable|string|max:2000',
                'status'                => 'nullable|in:0,1',
            ]);

            $user = Auth::user();

            AsignJobToOffice::create([
                'processing_cost'       => $request->processing_cost,
                'proces_office_id'      => $request->proces_office_id,
                'process_category_id'   => $request->process_category_id,
                'job_category_id'       => $request->job_category_id,
                'job_list_id'           => $request->job_list_id,
                'note'                  => $request->note,
                'status'                => $request->status ?? 1,
                'company_id'            => $user->company_id,
                'user_id'               => $user->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Job assigned to office successfully.'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'fail',
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        // return 1;
        $AsignJobToOffice = AsignJobToOffice::with('processOffice', 'processCategory', 'jobCategory', 'jobList')->findOrFail($id);
        return response()->json($AsignJobToOffice);
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'processing_cost'       => 'required|numeric|min:0',
                'proces_office_id'      => 'required|exists:process_offices,id',
                'process_category_id'   => 'required|exists:process_categories,id',
                'job_category_id'       => 'required|exists:job_categories,id',
                'job_list_id'           => 'required|exists:job_lists,id',
                'note'                  => 'nullable|string|max:2000',
                'status'                => 'nullable|in:0,1',
            ]);

            $user = Auth::user();
            $asignJob = AsignJobToOffice::findOrFail($id);
            $asignJob->update([
                'processing_cost'       => $request->processing_cost,
                'proces_office_id'      => $request->proces_office_id,
                'process_category_id'   => $request->process_category_id,
                'job_category_id'       => $request->job_category_id,
                'job_list_id'           => $request->job_list_id,
                'note'                  => $request->note,
                'status'                => $request->status ?? 1,
                'user_id'               => $user->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Assigned job updated successfully.'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'fail',
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    

    public function destroy(string $id)
    {
        try {
            $AsignJobToOfficess = AsignJobToOffice::findOrFail($id);
            $AsignJobToOfficess->delete();
            return response()->json(['status' => 'success', 'message' => 'Candidate Typess deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
