<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Business\Company as BusinessCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Business\Company;
use App\Models\User;

class CompaniesController extends Controller
{

    public function index()
    {
        $pendingCompany = Company::get();
            return view('supper_admin.pages.company.companies', compact('pendingCompany'));
    }

    public function activeIndex(Request $request)
    {
        $companies = Company::where('status', 1)->get();
        return response()->json($companies);

    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_name'      => 'required|string|max:255',
            'company_code'      => 'nullable|string|unique:companies,company_code',
            'start_date'        => 'required|date',
            'email'             => 'required|email|unique:companies,email',
            'contact_number'    => 'required|string|max:20',
            'alternate_number'  => 'nullable|string|max:20',
            'country'           => 'nullable|string|max:255',
            'district'          => 'nullable|string|max:255',
            'city'              => 'nullable|string|max:255',
            'zip_code'          => 'nullable|string|max:20',
            'owner_name'        => 'nullable|string|max:255',
            'owner_number'      => 'nullable|string|max:20',
            'owner_email'       => 'nullable|email|unique:companies,owner_email',
            'nid_no'            => 'nullable|string|unique:companies,nid_no',
            'nid_photo'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'comments'          => 'nullable|string',
            'checkbox'          => 'nullable|in:on,1,0',
            'password'          => 'required|min:6',
        ]);
        $validatedData['company_code'] = $this->generateCompanyCode();
        // Handle file upload
        if ($request->hasFile('nid_photo')) {
            $validatedData['nid_photo'] = $request->file('nid_photo')->store('nid_photos', 'public');
        }
    
        // Convert `status` & `checkbox` values
        $validatedData['status'] = ($request->status === 'on') ? '1' : '0';
        $validatedData['checkbox'] = ($request->checkbox === 'on') ? '1' : '0';
    
        // Create company
        $company = Company::create([
            'company_name'      => $validatedData['company_name'],
            'company_code'      => $validatedData['company_code'],
            'start_date'        => $validatedData['start_date'],
            'email'             => $validatedData['email'],
            'contact_number'    => $validatedData['contact_number'],
            'alternate_number'  => $validatedData['alternate_number'],
            'country'           => $validatedData['country'],
            'district'          => $validatedData['district'],
            'city'              => $validatedData['city'],
            'zip_code'          => $validatedData['zip_code'],
            'owner_name'        => $validatedData['owner_name'],
            'owner_number'      => $validatedData['owner_number'],
            'owner_email'       => $validatedData['owner_email'],
            'nid_no'            => $validatedData['nid_no'],
            'nid_photo'         => $validatedData['nid_photo'] ?? null,
            'comments'          => $validatedData['comments'],
            'checkbox'          => $validatedData['checkbox'],
            'status'            => $validatedData['status'],
        ]);
    
        // Create user
        $user = User::create([
            'company_id' => $company->id,
            'name'       => $validatedData['owner_name'] ?? 'Unknown',
            'username'   => $company->company_code,
            'role'       => 'admin',
            'email'      => $validatedData['email'],
            'password'   => Hash::make($validatedData['password']),
            'isActive'   => $company->status,
        ]);
    
        return redirect()->route('login')->with([
            'message'  => 'Company and User created successfully! Please log in.',
            'username' => $validatedData['company_code'],
            'email'    => $validatedData['email'],
            'password' => $validatedData['password'],
        ]);
    }
    
    private function generateCompanyCode()
    {
        $lastCompany = Company::latest('id')->first();
        $nextNumber = $lastCompany ? ((int) substr($lastCompany->company_code, 3)) + 1 : 111;
        return 'CMP' . $nextNumber;
    }


    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:0,1',
        ]);
        $company = Company::findOrFail($id);
        $company->update(['status' => $validatedData['status']]);
        User::where('company_id', $company->id)->update(['isActive' => $validatedData['status']]);
    
        return response()->json([
            'message' => 'Company status updated successfully!',
            'status'  => $company->status,
        ]);
    }
    

    public function destroy(string $id)
    {
        //
    }
}
