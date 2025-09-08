<?php

namespace App\Http\Controllers\Admin\Process;

use App\Http\Controllers\Controller;
use App\Models\Admin\Process\ProcessOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProcessOfficeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ProcessOffices = ProcessOffice::where('company_id', $user->company_id)->get();
        return view('backend.pages.process.process_office', compact('ProcessOffices'));
    }

    public function Activeindex()
    {
        $user = Auth::user();
        $ProcessOffices = ProcessOffice::where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($ProcessOffices);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'                    => 'required|string|max:255',
                'license_number'          => 'required|string|max:255',
                'phone_number'            => 'required|string|max:20',
                'email'                   => 'required|email|max:255',
                'opening_balance'         => 'required|numeric',
                'address'                 => 'nullable|string|max:255',
                'office_pad'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'opening_balance_sheet'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'note'                    => 'nullable|string',
                'status'                  => 'nullable|in:0,1',
            ]);

            $officePadPath = null;
            $openingBalanceSheetPath = null;
            $user = Auth::user();

            if ($request->hasFile('office_pad')) {
                $officePadPath = $request->file('office_pad')->store('uploads/office_pad', 'public');
            }

            if ($request->hasFile('opening_balance_sheet')) {
                $openingBalanceSheetPath = $request->file('opening_balance_sheet')->store('uploads/opening_balance_sheet', 'public');
            }

            $office = ProcessOffice::create([
                'name'                   => $request->name,
                'license_number'         => $request->license_number,
                'phone_number'           => $request->phone_number,
                'email'                  => $request->email,
                'opening_balance'        => $request->opening_balance,
                'address'                => $request->address,
                'office_pad'             => $officePadPath,
                'opening_balance_sheet'  => $openingBalanceSheetPath,
                'note'                   => $request->note,
                'status'                 => $request->status ?? 1,
                'company_id'             => $user->company_id,
                'user_id'                => $user->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Office created successfully.',
                'data' => $office
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
        $ProcessOffice = ProcessOffice::findOrFail($id);
        return response()->json($ProcessOffice);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name'                    => 'required|string|max:255',
                'license_number'          => 'required|string|max:255',
                'phone_number'            => 'required|string|max:20',
                'email'                   => 'required|email|max:255',
                'opening_balance'         => 'required|numeric',
                'address'                 => 'nullable|string|max:255',
                'office_pad'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'opening_balance_sheet'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'note'                    => 'nullable|string',
                'status'                  => 'nullable|in:0,1',
            ]);

            $office = ProcessOffice::findOrFail($id);
            $user = Auth::user();

            // Handle new file uploads and delete old files if new ones are provided
            if ($request->hasFile('office_pad')) {
                if ($office->office_pad) {
                    Storage::disk('public')->delete($office->office_pad);
                }
                $office->office_pad = $request->file('office_pad')->store('uploads/office_pad', 'public');
            }

            if ($request->hasFile('opening_balance_sheet')) {
                if ($office->opening_balance_sheet) {
                    Storage::disk('public')->delete($office->opening_balance_sheet);
                }
                $office->opening_balance_sheet = $request->file('opening_balance_sheet')->store('uploads/opening_balance_sheet', 'public');
            }

            // Update other fields
            $office->update([
                'name'                   => $request->name,
                'license_number'         => $request->license_number,
                'phone_number'           => $request->phone_number,
                'email'                  => $request->email,
                'opening_balance'        => $request->opening_balance,
                'address'                => $request->address,
                'note'                   => $request->note,
                'status'                 => $request->status ?? $office->status,
                'company_id'             => $user->company_id,
                'user_id'                => $user->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Office updated successfully.',
                'data' => $office
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
            $ProcessOfficess = ProcessOffice::findOrFail($id);
            $ProcessOfficess->delete();
            return response()->json(['status' => 'success', 'message' => 'Candidate Typess deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
