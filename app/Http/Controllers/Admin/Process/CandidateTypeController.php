<?php

namespace App\Http\Controllers\Admin\Process;

use App\Http\Controllers\Controller;
use App\Models\Admin\Process\CandidateType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Admin\Process\CandidateTypeField;

class CandidateTypeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $candidateTypes = CandidateType::where('user_id', $user->id)
                          ->where('company_id', $user->company_id)
                          ->get();
        return view('backend.pages.process.candidate_type', compact('candidateTypes'));
    }

    public function Activeindex()
    {
        $user = Auth::user();
        $CandidateTypes = CandidateType::where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($CandidateTypes);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'           => 'required|string|max:255|unique:candidate_types,name',
                'note'           => 'nullable|string|max:2000',
                'status'         => 'nullable|in:1,0'
            ]);
    
            $user = Auth::user();
            CandidateType::create([
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
        $CandidateType = CandidateType::findOrFail($id);
        return response()->json($CandidateType);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'note'           => 'nullable|string|max:2000',
            'status'         => 'nullable|in:1,0'
        ]);
        $user = Auth::user();
        $CandidateTypes = CandidateType::findOrFail($id);
        $CandidateTypes->name      = $request->name;
        $CandidateTypes->note      = $request->note;
        $CandidateTypes->status    = $request->status ? 1 : 0;
        $CandidateTypes->user_id   = $user->id;
        $CandidateTypes->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Candidate Types updated successfully',
        ]);
    }
    

    public function destroy(string $id)
    {
        try {
            $CandidateTypess = CandidateType::findOrFail($id);
            $CandidateTypess->delete();
            return response()->json(['status' => 'success', 'message' => 'Candidate Typess deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

   public function manageForm($id)
    {
        $candidateType = CandidateType::findOrFail($id);
        $savedFields = CandidateTypeField::where('candidate_type_id', $id)
                                          ->pluck('is_enable', 'attr_value')
                                          ->toArray();
      
        $html = view('backend.components.process.manage_form_partial', compact('candidateType', 'savedFields'))->render();
        return response()->json(['html' => $html]);

    }

}