<?php

namespace App\Http\Controllers\Admin\Process;

use App\Http\Controllers\Controller;
use App\Models\Admin\Process\CandidateDynamicForm;
use App\Models\Admin\Process\CandidateDynamicFormField;
use App\Models\Admin\Process\UpdatedCandidateDynamicFormField;
use App\Models\Supper_Admin\Payroll\Expense\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CandidateDynamicFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = CandidateDynamicForm::with(['candidateDynamicFormFields'])->get();
        return view('backend.pages.process.dynamic-form', compact('forms'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'form_name'    => 'required',
                'field_name'      => 'required',
                'background_image' => 'nullable|mimes:jpg,jpeg,png|max:10240', // 10MB max
                'status'    => 'required|in:Enabled,Disabled'
            ]);

            $backgroundImagePath = null;

            if ($request->hasFile('background_image')) {
                $file = $request->file('background_image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $backgroundImagePath = $file->storeAs('uploads/dynamic_forms', $filename, 'public');
            }

            $form = CandidateDynamicForm::create([
                'form_name'      => $request->input('form_name'),
                'background_image'         => $backgroundImagePath,
                'note'  => $request->input('note'),
                'status'    => $request->input('status') === 'Enabled' ? 'Enabled' : 'Disabled'
            ]);

            if ($request->only('field_name')) {
                $data = [];
                foreach ($request->field_name as $key => $row) {
                    $data[] = [
                        'candidate_dynamic_form_id' => $form->id,
                        'field_name' => $request->field_name[$key],
                        'created_at' => now(),
                    ];
                }
                CandidateDynamicFormField::insert($data);

                $updatedData = [];
                foreach ($request->field_name as $key => $row) {
                    $updatedData[] = [
                        'candidate_dynamic_form_id' => $form->id,
                        'field_name' => $request->field_name[$key],
                        'created_at' => now(),
                    ];
                }
                UpdatedCandidateDynamicFormField::insert($updatedData);
            }
            return response()->json(['status' => 'success', 'message' => 'Dynamic form added Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->validator->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CandidateDynamicForm $candidateDynamicForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $candidateDynamicForm = CandidateDynamicForm::with(['candidateDynamicFormFields'])->findOrFail($id);
        return response()->json($candidateDynamicForm);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'form_name'    => 'required',
                'field_name'      => 'required',
                'background_image' => 'nullable|mimes:jpg,jpeg,png|max:10240', // 10MB max
                'status'    => 'required|in:Enabled,Disabled'
            ]);

            $candidateDynamicForm = CandidateDynamicForm::findOrFail($id);
            $candidateDynamicForm->form_name = $request->form_name;
            $candidateDynamicForm->note = $request->note;
            $candidateDynamicForm->status = $request->status === 'Enabled' ? 'Enabled' : 'Disabled';
            // If user asked to remove file
            if ($request->has('remove_file') && $request->remove_file) {
                if ($candidateDynamicForm->background_image) {
                    Storage::disk('public')->delete($candidateDynamicForm->background_image);
                    $candidateDynamicForm->background_image = null; // Clear DB field
                }
            }

// If a new file was uploaded
            if ($request->hasFile('background_image')) {
                // Delete old file if exists
                if ($candidateDynamicForm->background_image) {
                    Storage::disk('public')->delete($candidateDynamicForm->background_image);
                }

                $file = $request->file('background_image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $backgroundImagePath = $file->storeAs('uploads/dynamic_forms', $filename, 'public');

                $candidateDynamicForm->background_image = $backgroundImagePath; // Save new file path
            }
            $candidateDynamicForm->save();

            if ($request->only('field_name')) {
                if ($candidateDynamicForm->candidateDynamicFormFields) {
                    $candidateDynamicForm->candidateDynamicFormFields()->delete();
                }
                if ($candidateDynamicForm->updatedCandidateDynamicFormFields) {
                    $candidateDynamicForm->updatedCandidateDynamicFormFields()->delete();
                }
                $data = [];
                foreach ($request->field_name as $key => $row) {
                    $data[] = [
                        'candidate_dynamic_form_id' => $candidateDynamicForm->id,
                        'field_name' => $request->field_name[$key],
                        'created_at' => now(),
                    ];
                }
                CandidateDynamicFormField::insert($data);

                $updatedData = [];
                foreach ($request->field_name as $key => $row) {
                    $updatedData[] = [
                        'candidate_dynamic_form_id' => $candidateDynamicForm->id,
                        'field_name' => $request->field_name[$key],
                        'created_at' => now(),
                    ];
                }
                UpdatedCandidateDynamicFormField::insert($updatedData);
            }

            return response()->json(['status' => 'success', 'message' => 'Expense item updated successfully']);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->validator->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $candidateDynamicForm = CandidateDynamicForm::findOrFail($id);
            if ($candidateDynamicForm->candidateDynamicFormFields) {
                $candidateDynamicForm->candidateDynamicFormFields()->delete();
            }
            if ($candidateDynamicForm->updatedCandidateDynamicFormFields) {
                $candidateDynamicForm->updatedCandidateDynamicFormFields()->delete();
            }
            $candidateDynamicForm->delete();
            return response()->json(['status' => 'success', 'message' => 'Dynamic form deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function addField(Request $request)
    {

        $newField = UpdatedCandidateDynamicFormField::create([
            'candidate_dynamic_form_id' => $request->candidate_dynamic_form_id,
            'field_name' => $request->field_name,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Field added Successfully',
            'new_field' => $newField // <-- return new field object
        ]);
    }

    public function copy(Request $request)
    {
        $field = UpdatedCandidateDynamicFormField::findOrFail($request->field_id);

        $newField = UpdatedCandidateDynamicFormField::create([
            'candidate_dynamic_form_id' => $field->candidate_dynamic_form_id,
            'field_name' => $field->field_name,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Field copied Successfully',
            'new_field' => $newField // <-- return new field object
        ]);
    }

    public function fieldDestroy($id)
    {
        $field = UpdatedCandidateDynamicFormField::findOrFail($id);
        $field->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Field deleted successfully'
        ]);
    }

}
