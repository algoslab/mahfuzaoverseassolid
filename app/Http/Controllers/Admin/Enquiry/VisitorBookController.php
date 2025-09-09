<?php

namespace App\Http\Controllers\Admin\Enquiry;

use App\Http\Controllers\Controller;
use App\Models\Admin\Enquiry\HowFindUs;
use App\Models\Admin\Enquiry\VisitorBook;
use App\Models\Admin\HRM\Employee;
use App\Models\Admin\Process\CandidateType;
use App\Models\FindUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VisitorBookController extends Controller
{
    public function index(Request $request)
    {
        $visitorBooks = VisitorBook::latest()->with('howFindUs', 'candidateType')->get();
        $candidateTypes = CandidateType::all();
        $howFindUs = HowFindUs::select('id', 'name')->get();

        return view('backend.pages.enquiry.visitor_book', compact('visitorBooks', 'candidateTypes', 'howFindUs'));
    }

    public function show($id)
    {
        $visitorBook = VisitorBook::findOrFail($id);
        return response()->json($visitorBook);
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone'             => 'required|string',
            'full_name'         => 'required|string',
            'address'           => 'nullable|string',
            'candidate_type_id' => 'required|integer',
            'reference_type'    => 'required|string',
            'note'              => 'nullable|string',
            'how_find_us_id'       => 'required|string',
            'entry_time'        => 'nullable|string',
        ]);
        $entryTime = $request->entry_time ?? now()->format('H:i');
        $employeeId = Employee::where('user_id', Auth::id())->select('id')->first();
        $visitorBook = VisitorBook::create([
            'phone'             => $request->phone,
            'full_name'         => $request->full_name,
            'address'           => $request->address,
            'candidate_type_id' => $request->candidate_type_id,
            'employee_id'       => $request->$employeeId->id ?? null,
            'reference_type'    => $request->reference_type,
            'note'              => $request->note,
            'how_find_us_id'    => $request->how_find_us_id,
            'entry_time'        => $entryTime,
            'entry_by'          => Auth::id(),
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Visitor record added successfully.', 'data' => $visitorBook]);
        }
        return redirect()->route('admin.visitor-books.index')->with('success', 'Visitor record added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'phone'             => 'required|string',
            'full_name'         => 'required|string',
            'address'           => 'nullable|string',
            'candidate_type_id' => 'required|integer',
            'reference_type'    => 'required|string',
            'note'              => 'nullable|string',
            'how_find_us_id'       => 'required|string',
            'entry_time'        => 'nullable|string',
        ]);
        $visitorBook = VisitorBook::findOrFail($id);
        $data = $request->all();
        if (empty($data['entry_time'])) {
            $data['entry_time'] = now()->format('H:i');
        }
        $visitorBook->update($data);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Visitor record updated successfully.', 'data' => $visitorBook]);
        }
        return redirect()->route('admin.visitor-books.index')->with('success', 'Visitor record updated successfully.');
    }

    public function destroy($id, Request $request)
    {
        VisitorBook::findOrFail($id)->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Visitor record deleted successfully.']);
        }
        return redirect()->route('admin.visitor-books.index')->with('success', 'Visitor record deleted successfully.');
    }
}
