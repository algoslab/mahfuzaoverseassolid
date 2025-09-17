<?php

namespace App\Http\Controllers\Admin\Process;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Process\CandidateTypeField;

class CandidateTypeFieldController extends Controller
{
    public function toggleField(Request $request)
    {
        // Validate request
        $request->validate([
            'candidate_type_id' => 'required|exists:candidate_types,id',
            'step_name' => 'required|string',
            'field_name' => 'required|string',
            'attr_value' => 'required|string',
            'is_enable' => 'required|boolean',
        ]);

        CandidateTypeField::updateOrCreate(
            [
                'candidate_type_id' => $request->candidate_type_id,
                'attr_value' => $request->attr_value,
            ],
            [
                'step_name' => $request->step_name,
                'field_name' => $request->field_name,
                'is_enable' => $request->is_enable,
            ]
        );

        return response()->json(['success' => true]);
    }

    

}
