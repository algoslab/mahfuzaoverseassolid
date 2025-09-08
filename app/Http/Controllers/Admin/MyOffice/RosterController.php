<?php

namespace App\Http\Controllers\Admin\MyOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\MyOffice\Roster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RosterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rosters = Roster::where('user_id', $user->id)
                          ->where('company_id', $user->company_id)
                          ->get();
        return view('backend.pages.myoffice.roster', compact('rosters'));
    }

    
    public function activeIndex()
    {
        $user = Auth::user();
        $rosters = Roster::where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($rosters);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'        => 'required|string|max:255|unique:rosters,name',
                'code'        => 'required|string|max:255|unique:rosters,code',
                'duty_hours'  => 'required|integer|min:0',
                'start_time'  => 'required|date_format:H:i',
                'end_time'    => 'required|date_format:H:i',
                'meal_break'  => 'required|in:1,0',
                'note'        => 'nullable|string|max:2000',
                'status'      => 'required|in:1,0'
            ]);
    
            $user = Auth::user();
            Roster::create([
                'company_id'     => $user->company_id,
                'name'           => $request->name,
                'code'           => $request->code,
                'duty_hours'     => $request->duty_hours,
                'start_time'     => $request->start_time,
                'end_time'       => $request->end_time,
                'meal_break'     => $request->meal_break,
                'note'           => $request->note,
                'user_id'        => $user->id,
                'status'         => $request->status
            ]);
    
            return response()->json(['status' => 'success','message' => 'Roster added successfully']);
    
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
        $rosters = Roster::findOrFail($id);
        return response()->json($rosters);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:255',
            'duty_hours'  => 'required|integer|min:0',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i',
            'meal_break'  => 'nullable|in:1,0',
            'note'        => 'nullable|string|max:2000',
            'status'      => 'nullable|in:1,0'
        ]);
        $user = Auth::user();
        $Roster = Roster::findOrFail($id);
    
        $Roster->name           = $request->name;
        $Roster->code           = $request->code;
        $Roster->duty_hours     = $request->duty_hours;
        $Roster->start_time     = $request->start_time;
        $Roster->end_time       = $request->end_time;
        $Roster->meal_break     = $request->meal_break ? 1 : 0;
        $Roster->note           = $request->note;
        $Roster->status         = $request->status ? 1 : 0;
        $Roster->user_id        = $user->id;
        $Roster->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Roster updated successfully',
        ]);
    }
    

    public function destroy(string $id)
    {
        try {
            $rosters = Roster::findOrFail($id);
            $rosters->delete();
            return response()->json(['status' => 'success', 'message' => 'Roster Data deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
