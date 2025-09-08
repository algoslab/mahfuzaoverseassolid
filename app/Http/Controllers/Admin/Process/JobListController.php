<?php

namespace App\Http\Controllers\Admin\Process;

use App\Http\Controllers\Controller;
use App\Models\Admin\Process\JobList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class JobListController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $JobLists = JobList::with('jobCategory')->where('company_id', $user->company_id)->get();
        return view('backend.pages.process.job_list', compact('JobLists'));
    }

    // public function Activeindex()
    // {
    //     $user = Auth::user();
    //     $JobLists = JobList::where('company_id', $user->company_id)->where('status', 1)->get();
    //     return response()->json($JobLists);
    // }

    public function Activeindex(Request $request)
    {
        $user = Auth::user();
        $jobCategoryId = $request->input('job_category_id');
        if (!$jobCategoryId && $user->role === 'admin') {
            return response()->json(['error' => 'Please select a Job category.'], 400);
        }
        $query = JobList::where('company_id', $user->company_id)->where('status', 1);
        if ($jobCategoryId) {
            $query->where('job_category_id', $jobCategoryId);
        }
        $JobLists = $query->get();
        return response()->json($JobLists);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'job_category_id'       => 'required|exists:job_categories,id', 
                'name'                  => 'required|string|max:255',
                'job_type'              => 'required|string|max:255',
                'note'                  => 'nullable|string|max:2000',
                'status'                => 'nullable|in:1,0'
            ]);
    
            $user = Auth::user();
            JobList::create([
                'company_id'            => $user->company_id,
                'job_category_id'       => $request->job_category_id,
                'name'                  => $request->name,
                'job_type'              => $request->job_type,
                'note'                  => $request->note,
                'user_id'               => $user->id,
                'status'                => $request->status
            ]);
    
            return response()->json(['status' => 'success','message' => 'Job Category added successfully']);
    
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail','errors' => $e->validator->errors()], 422); 
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail','message' => $e->getMessage()], 500);
        }
    }
    


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $JobList = JobList::findOrFail($id);
        return response()->json($JobList);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
                'job_category_id'       => 'required|exists:job_categories,id', 
                'name'                  => 'required|string|max:255',
                'job_type'              => 'required|string|max:255',
                'note'                  => 'nullable|string|max:2000',
                'status'                => 'nullable|in:1,0'
        ]);
        $user = Auth::user();
        $JobLists = JobList::findOrFail($id);
        $JobLists->job_category_id = $request->job_category_id;
        $JobLists->name      = $request->name;
        $JobLists->job_type  = $request->job_type;
        $JobLists->note      = $request->note;
        $JobLists->status    = $request->status ? 1 : 0;
        $JobLists->user_id   = $user->id;
        $JobLists->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Job Category updated successfully',
        ]);
    }
    

    public function destroy(string $id)
    {
        try {
            $JobListss = JobList::findOrFail($id);
            $JobListss->delete();
            return response()->json(['status' => 'success', 'message' => 'Job Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
