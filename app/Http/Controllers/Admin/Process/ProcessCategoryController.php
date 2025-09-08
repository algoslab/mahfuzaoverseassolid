<?php

namespace App\Http\Controllers\Admin\Process;

use App\Http\Controllers\Controller;
use App\Models\Admin\Process\ProcessCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProcessCategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ProcessCategorys = ProcessCategory::where('user_id', $user->id)
                          ->where('company_id', $user->company_id)
                          ->get();
        return view('backend.pages.process.process_category', compact('ProcessCategorys'));
    }

    public function Activeindex()
    {
        $user = Auth::user();
        $ProcessCategorys = ProcessCategory::where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($ProcessCategorys);
    }
    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'           => 'required|string|max:255|unique:process_categories,name',
                'note'           => 'nullable|string|max:2000',
                'status'         => 'nullable|in:1,0'
            ]);
    
            $user = Auth::user();
            ProcessCategory::create([
                'company_id'     => $user->company_id,
                'name'           => $request->name,
                'note'           => $request->note,
                'user_id'        => $user->id,
                'status'         => $request->status
            ]);
    
            return response()->json(['status' => 'success','message' => 'Candidate Types added successfully']);
    
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
        $ProcessCategory = ProcessCategory::findOrFail($id);
        return response()->json($ProcessCategory);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'note'           => 'nullable|string|max:2000',
            'status'         => 'nullable|in:1,0'
        ]);
        $user = Auth::user();
        $ProcessCategorys = ProcessCategory::findOrFail($id);
        $ProcessCategorys->name      = $request->name;
        $ProcessCategorys->note      = $request->note;
        $ProcessCategorys->status    = $request->status ? 1 : 0;
        $ProcessCategorys->user_id   = $user->id;
        $ProcessCategorys->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Candidate Types updated successfully',
        ]);
    }
    

    public function destroy(string $id)
    {
        try {
            $ProcessCategoryss = ProcessCategory::findOrFail($id);
            $ProcessCategoryss->delete();
            return response()->json(['status' => 'success', 'message' => 'Candidate Typess deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
