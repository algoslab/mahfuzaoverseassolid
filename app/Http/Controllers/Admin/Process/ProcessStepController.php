<?php

namespace App\Http\Controllers\Admin\Process;

use App\Http\Controllers\Controller;
use App\Models\Admin\Process\ProcessStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ProcessStepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $ProcessSteps = ProcessStep::where('company_id', $user->company_id)->get();
        return view('backend.pages.process.process_step', compact('ProcessSteps'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'                 => 'required|string|max:255',
                'country_id'           => 'required|array',
                'gender'               => 'nullable|array',
                'process_category_id'  => 'required|array',
                'is_document'          => 'required|integer|in:0,1',
                'is_scheduled'         => 'required|integer|in:0,1',
                'is_youtube_link'      => 'nullable|integer|in:0,1',
                'note'                 => 'nullable|string',
                'status'               => 'nullable|integer|in:0,1',
            ]);

            // return 1;

            $user = Auth::user();

            $data = new ProcessStep();
            $data->name             = $request->name;
            $data->country_id       = json_encode($request->country_id);
            $data->gender           = $request->gender ? json_encode($request->gender) : null;
            $data->process_category_id = json_encode($request->process_category_id);
            $data->is_document      = $request->is_document;
            $data->is_scheduled     = $request->is_scheduled;
            $data->is_youtube_link  = $request->is_youtube_link;
            $data->note             = $request->note;
            $data->status           = $request->status ?? 1;
            $data->company_id       = $user->company_id;
            $data->user_id          = $user->id;
            $data->save();
        

        return response()->json(['status' => 'success','message' => 'Process Step added successfully']);

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
        $processStep = ProcessStep::findOrFail($id);

        $processStep->country_id = json_decode($processStep->country_id, true);
        $processStep->gender = $processStep->gender ? json_decode($processStep->gender, true) : null;
        $processStep->process_category_id = json_decode($processStep->process_category_id, true);

        return response()->json($processStep);
    }


    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'                 => 'required|string|max:255',
                'country_id'           => 'required|array',
                'gender'               => 'nullable|array',
                'process_category_id'  => 'required|array',
                'is_document'          => 'nullable|integer|in:0,1',
                'is_scheduled'         => 'nullable|integer|in:0,1',
                'is_youtube_link'      => 'nullable|integer|in:0,1',
                'note'                 => 'nullable|string',
                'status'               => 'nullable|integer|in:0,1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'errors' => $validator->errors()
                ], 422);
            }
        //    return 1;
            $data = ProcessStep::findOrFail($id);

            $data->name = $request->name;
            $data->country_id = json_encode($request->country_id);
            $data->gender = $request->gender ? json_encode($request->gender) : null;
            $data->process_category_id = json_encode($request->process_category_id);
            $data->is_document = $request->is_document;
            $data->is_scheduled = $request->is_scheduled;
            $data->is_youtube_link = $request->is_youtube_link;
            $data->note = $request->note;
            $data->status = $request->status ? 1: 0;
            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Process Step updated successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $ProcessStep = ProcessStep::findOrFail($id);
            $ProcessStep->delete();
            return response()->json(['status' => 'success', 'message' => 'Process Step deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
