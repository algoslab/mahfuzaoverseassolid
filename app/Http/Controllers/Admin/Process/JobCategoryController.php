<?php

namespace App\Http\Controllers\Admin\Process;

use App\Http\Controllers\Controller;
use App\Models\Admin\Process\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class JobCategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $JobCategorys = JobCategory::with('processCategory')->where('user_id', $user->id)
                          ->where('company_id', $user->company_id)
                          ->get();
        return view('backend.pages.process.job_category', compact('JobCategorys'));
    }

    // public function Activeindex()
    // {
    //     $user = Auth::user();
    //     $JobCategorys = JobCategory::where('company_id', $user->company_id)->where('status', 1)->get();
    //     return response()->json($JobCategorys);
    // }
   /*
    public function Activeindex(Request $request)
    {
        $user = Auth::user();
        $processCategoryId = $request->input('process_category_id');
        if (!$processCategoryId && $user->role === 'admin') {
            return response()->json(['error' => 'Please select a Process category.'], 400);
        }
        $query = JobCategory::where('company_id', $user->company_id)->where('status', 1);
        if ($processCategoryId) {
            $query->where('process_category_id', $processCategoryId);
        }
        $jobCategories = $query->get();
        return response()->json($jobCategories);
    }
    */
    public function Activeindex(Request $request)
        {
            $user = Auth::user();
            $processCategoryId = $request->input('process_category_id');

            $query = JobCategory::where('company_id', $user->company_id)->where('status', 1);

            if ($processCategoryId) {
                $query->where('process_category_id', $processCategoryId);
            }

            $jobCategories = $query->get();
            return response()->json($jobCategories);
        }

    


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'process_category_id'   => 'required|exists:process_categories,id', 
                'name'                  => 'required|string|max:255',
                'note'                  => 'nullable|string|max:2000',
                'status'                => 'nullable|in:1,0'
            ]);
    
            $user = Auth::user();
            JobCategory::create([
                'company_id'            => $user->company_id,
                'process_category_id'   => $request->process_category_id,
                'name'                  => $request->name,
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
        $JobCategory = JobCategory::findOrFail($id);
        return response()->json($JobCategory);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
                'process_category_id'   => 'required|exists:process_categories,id', 
                'name'                  => 'required|string|max:255',
                'note'                  => 'nullable|string|max:2000',
                'status'                => 'nullable|in:1,0'
        ]);
        $user = Auth::user();
        $JobCategorys = JobCategory::findOrFail($id);
        $JobCategorys->process_category_id      = $request->process_category_id;
        $JobCategorys->name      = $request->name;
        $JobCategorys->note      = $request->note;
        $JobCategorys->status    = $request->status ? 1 : 0;
        $JobCategorys->user_id   = $user->id;
        $JobCategorys->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Job Category updated successfully',
        ]);
    }
    

    public function destroy(string $id)
    {
        try {
            $JobCategoryss = JobCategory::findOrFail($id);
            $JobCategoryss->delete();
            return response()->json(['status' => 'success', 'message' => 'Job Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
