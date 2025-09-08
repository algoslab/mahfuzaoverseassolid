<?php

namespace App\Http\Controllers\Admin\People;

use App\Http\Controllers\Controller;
use App\Models\Admin\People\Delegate;
use App\Models\Admin\People\DelegateOffice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DelegateOfficeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $delegateOffice = DelegateOffice::with('delegate')->where('company_id', $user->company_id)->get();
        return view('backend.pages.people.delegate_office', compact('delegateOffice'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'branch_id'             => 'required|exists:branches,id',
                'delegate_id'           => 'required|exists:delegates,id',
                'office_name'           => 'required|string|max:255',
                'contact_number'        => 'required|string|max:20',
                'licence_number'        => 'required|string|max:255',
                'attachment'            => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'address'               => 'nullable|string|max:1000',
                'note'                  => 'nullable|string|max:1000',
                'status'                => 'nullable|boolean',
            ]);

            $user = Auth::user();
            $user_id = $user->id;

            $uploadFile = function ($fileField) use ($request) {
                if ($request->hasFile($fileField) && $request->file($fileField)->isValid()) {
                    $file = $request->file($fileField);
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    return $file->storeAs('uploads/delegate', $filename, 'public');
                }
                return null;
            };

            $data = $request->only([
                'branch_id', 'delegate_id', 'office_name', 'contact_number','licence_number',  'address', 'note', 'status'
            ]);

            // Set user ID
            $data['user_id'] = $user_id;
            $data['company_id'] = $user->company_id;

            // Set file paths
            $data['attachment']  = $uploadFile('attachment');
            DelegateOffice::create($data);
            return response()->json(['status' => 'success','message' => 'Delegates added successfully']);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail','errors' => $e->validator->errors(),], 422);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail','message' => $e->getMessage(),], 500);
        }
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        try {
            $delegateOffice = DelegateOffice::findOrFail($id);
            if ($delegateOffice->attachment && Storage::disk('public')->exists($delegateOffice->attachment)) {
                Storage::disk('public')->delete($delegateOffice->attachment);
            }

            $delegateOffice->delete();
            return response()->json(['status' => 'success','message' => 'Delegate office files deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(),]);
        }
    }
}
