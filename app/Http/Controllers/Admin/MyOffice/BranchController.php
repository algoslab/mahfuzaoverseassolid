<?php

namespace App\Http\Controllers\Admin\MyOffice;

use App\Http\Controllers\Controller;
use App\Models\Admin\MyOffice\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $branches = Branch::where('user_id', $user->id)
                          ->where('company_id', $user->company_id)
                          ->get();
        return view('backend.pages.myoffice.branch', compact('branches'));
    }

    public function activeIndex(Request $request)
    {
        $user = Auth::user();
        $companyId = $request->input('company_id');
        if (!$companyId) {
            if ($user->role === 'supper_admin') {
                return response()->json(['error' => 'Please select a company.'], 400);
            }
            $companyId = $user->company_id;
        }
        $branches = Branch::where('company_id', $companyId)->where('status', 1)->get();
        return response()->json($branches);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // return $request->all();
        try {
            $request->validate([
                'name'          => 'required|string|max:255',
                'code'          => 'nullable|string|max:255',
                'phone'         => 'required|string|max:11',
                'email'         => 'required|string|max:50',
                'picture'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'address'       => 'required|string|max:1000',
                'note'          => 'required|string|max:2000',
                'status'        => 'required|in:1,0'
            ]);

            $user = Auth::user();
            $user_id = $user->id;
            $company_id = $user->company_id;
            $imagePath = null;

            if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
                $file = $request->file('picture');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('branch', $filename, 'public');
            }
            // return  $imagePath;
            Branch::create([
                'company_id'    => $company_id,
                'name'          => $request->input('name'),
                'code'          => $request->input('code'),
                'phone'         => $request->input('phone'),
                'email'         => $request->input('email'),
                'address'       => $request->input('address'),
                'picture'       => $imagePath,
                'note'          => $request->input('note'),
                'user_id'       => $user_id,
                'status'        => $request->input('status')
            ]);
            return response()->json(['status' => 'success', 'message' => 'Branch added Successfully']);
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
        $branches = Branch::findOrFail($id);
        return response()->json($branches);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'code'    => 'nullable|string|max:255',
            'phone'   => 'required|string|max:11',
            'email'   => 'required|string|max:50',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:1000',
            'note'    => 'required|string|max:2000',
        ]);
    
        $branch = Branch::findOrFail($id);
    
        // ✅ Handle image upload
        if ($request->hasFile('picture')) {
            // Delete old image if exists
            if ($branch->picture && Storage::disk('public')->exists($branch->picture)) {
                Storage::disk('public')->delete($branch->picture);
            }
            // Store new image
            $file = $request->file('picture');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('branch', $filename, 'public');
            $branch->picture = $path;
        }
        // ✅ Update other fields
        $branch->name    = $request->name;
        $branch->code    = $request->code;
        $branch->phone   = $request->phone;
        $branch->email   = $request->email;
        $branch->address = $request->address;
        $branch->note    = $request->note;
        $branch->status  = $request->status ? 1 : 0;
        $branch->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Branch updated successfully',
        ]);
    }

    public function destroy(string $id)
    {
        try {
            $branches = Branch::findOrFail($id);
            $branches->delete();
            return response()->json(['status' => 'success', 'message' => 'branches deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}

