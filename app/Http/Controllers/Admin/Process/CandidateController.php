<?php

namespace App\Http\Controllers\Admin\Process;

use App\Models\Admin\Process\AgentTransaction;
use App\Traits\FileUpload;
use App\Models\Admin\Gender;
use Illuminate\Http\Request;
use App\Models\Admin\Relation;
use App\Models\Admin\Religion;
use App\Models\Admin\BloodGroup;
use App\Models\Admin\Profession;
use App\Models\Admin\People\Agent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CandidateRequest;
use App\Models\Admin\Process\Candidate;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CandidateFileRequest;
use App\Models\Admin\Process\CandidateFile;
use App\Models\Admin\Process\CandidateType;
use App\Models\Supper_Admin\Location\State;
use App\Models\Supper_Admin\Location\Thana;
use App\Models\Supper_Admin\Location\Country;
use App\Models\Supper_Admin\Location\District;
use App\Models\Supper_Admin\Location\Division;
use App\Http\Requests\CandidateLocationRequest;
use App\Http\Requests\CandidatePassportRequest;
use App\Models\Admin\Process\CandidateLocation;
use App\Models\Admin\Process\CandidatePassport;
use App\Models\Supper_Admin\Location\PostOffice;
use App\Http\Requests\CandidateExperienceRequest;
use App\Models\Admin\Process\CandidateExperience;
use App\Http\Requests\CandidatePersonalInfoRequest;
use App\Models\Admin\Process\CandidatePersonalInfo;
use App\Models\Admin\Process\CandidateTypeField;


class CandidateController extends Controller
{
    use FileUpload;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Candidate::with(['agent', 'personalInfo', 'personalInfo.gender', 'experiences', 'experiences.workType', 'passport',]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $name = $row->personalInfo?->full_name ?? 'N/A';
                    return '
                    <div class="dropdown" style="position: relative;">
                        <a href="#" class="badge badge-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-list"></i> '.$name.'
                        </a>

                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item view-profile-btn" data-toggle="modal" data-target="#candidateProfileModal" data-id="'.$row->id.'">View Profile</a>
                            <a href="#" class="dropdown-item candidate-commission-setup-btn" data-toggle="modal" data-target="#candidateCommissionSetupModal" data-id="'.$row->id.'" data-commission="'.$row->commission.'" data-name="'.$name.'">Commission Setup</a>
                            <a href="#" class="dropdown-item view-transaction-btn" data-toggle="modal" data-target="#candidateTransactionListModal" data-id="'.$row->id.'" data-name="'.$name.'">View Transactions</a>
                            <a href="#" class="dropdown-item make-transaction-btn" data-toggle="modal" data-target="#candidateTransactionModal" data-id="'.$row->id.'" data-name="'.$name.'">Make Transaction</a>
                            <a href="#" class="dropdown-item candidate-type-transfer-btn" data-toggle="modal" data-target="#candidateTypeTransferModal" data-id="'.$row->id.'" data-current-type-id="'.$row->candidate_type_id.'" data-current-type="'.($row->candidateType?->name ?? '').'">Type Transfer</a>
                            <a class="dropdown-item" href="#">Print Dynamic Form</a>
                            <a href="#" class="dropdown-item deleteBonusBtn" data-id="'.$row->id.'">Delete</a>
                            <a class="dropdown-item" href="'.($row->files?->candidate_photo ? asset($row->files->candidate_photo) : '#').'" target="_blank">
                                Candidate Photo
                            </a>

                            <a href="#" class="dropdown-item text-success candidate-comments-btn" data-toggle="modal" data-target="#candidateCommentsModal" data-id="'.$row->id.'">Comments</a>
                        </div>
                    </div>';
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->whereHas('personalInfo', function ($q) use ($keyword) {
                        $q->whereRaw("LOWER(CONCAT(first_name, ' ', last_name)) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                    });
                })
                ->addColumn('agent', function($row){
                    $agent = $row->agent?->full_name ?? '';
                    return '
                    <div class="dropdown" style="position: relative;">
                        <a href="#" class="badge badge-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-list"></i> '.$agent.'
                        </a>

                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item view-agent-profile-btn" data-toggle="modal" data-target="#agentProfileModal" data-id="'.$row->referral_agent_id.'">View Profile</a>
                                 <a href="#" class="dropdown-item view-agent-transaction-btn" data-toggle="modal" data-target="#agentTransactionListModal" data-id="'.$row->id.'" data-name="'.$agent.'">View Transactions</a>
                            <a href="#" class="dropdown-item make-agent-transaction-btn" data-toggle="modal" data-target="#agentTransactionModal" data-id="'.$row->id.'" data-name="'.$agent.'" data-referral_agent_id="'.$row->referral_agent_id.'">Make Transaction</a>
                        </div>
                    </div>';
                })
                ->filterColumn('agent', function ($query, $keyword) {
                    $query->whereHas('agent', function ($q) use ($keyword) {
                        $q->whereRaw("LOWER(CONCAT(first_name, ' ', last_name)) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                    });
                })
                ->addColumn('age_gender', function ($row) {
                    $age = $row->personalInfo?->age . 'y';
                    $gender = $row->personalInfo?->gender?->name;
                    return $age . ($gender ? " - {$gender}" : '');
                })
                ->filterColumn('age_gender', function ($query, $keyword) {
                    $query->whereHas('personalInfo', function ($q) use ($keyword) {
                        $q->whereRaw("LOWER(date_of_birth) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                    });
                })
                ->addColumn('nid', function ($row) {
                    return $row->personalInfo?->nid_or_birth_certificate ?? '';
                })
                ->addColumn('passport', function ($row) {
                    return $row->passport?->passport_number ?? '';
                })
                ->addColumn('passport_validity', function($row) {
                    return $row->passport?->passportValidity ?? '';
                })
                ->addColumn('interested_country', function ($row) {
                    return $row->country?->name ?? '';
                })
                ->filterColumn('interested_country', function ($query, $keyword) {
                    $query->whereHas('country', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                    });
                })
                ->addColumn('interested_profession', function ($row) {
                    return $row->profession?->name ?? '';
                })
                ->filterColumn('interested_profession', function ($query, $keyword) {
                    $query->whereHas('profession', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                    });
                })
                ->addColumn('status', function ($row) {
                    return $row->status === 1
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown">
                            <i class="fa fa-bars"></i> Action
                        </button>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item editAgentButton" data-id="' . $row->id . '">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <button class="dropdown-item text-danger deleteagentBtn" data-id="' . $row->id . '">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>';
                })
                ->rawColumns(['name', 'agent', 'status', 'action'])
                ->make(true);
        }

        $candidateTypes = CandidateType::where('status', 1)->pluck('name', 'id')->toArray();
        $transactionPurposes = \App\Models\Admin\Process\CandidateTransaction::$transactionPurposes;
        $careCandidates = Candidate::with(['personalInfo', 'candidateType'])->get();
        return view('backend.pages.process.candidates.index', compact('candidateTypes', 'transactionPurposes', 'careCandidates'));
    }

    public function activeIndex(Request $request)
    {
        if ($request->has('candidate_type_id') && $request->candidate_type_id) {
            $typeId = $request->get('candidate_type_id');
            $candidates = Candidate::whereHas('candidateType', function ($query) {
                $query->select('id', 'name')->where('status', 1);
            })->with([
                'candidateType' => function ($query) {
                    $query->select('id', 'name');
                },
                'personalInfo' => function ($query) {
                    $query->select('candidate_id', 'first_name', 'last_name');
                }
            ])
                ->where('candidate_type_id', $typeId)
                ->get();
        } else {
            $candidates = Candidate::whereHas('candidateType', function ($query) {
                $query->select('id', 'name')->where('status', 1);
            })->with([
                'candidateType' => function ($query) {
                    $query->select('id', 'name');
                },
                'personalInfo' => function ($query) {
                    $query->select('candidate_id', 'first_name', 'last_name');
                }
            ])->get();
        }

        return response()->json($candidates);

    }

    public function create(Request $request, $step = 1)
    {
        $candidateTypes = CandidateType::where('status', 1)->pluck('name', 'id');
        $agents = Agent::where('status', 1)->get()->pluck('full_name', 'id');
        $countries = Country::where('status', 1)->pluck('name', 'id');
        $professions = Profession::where('status', 1)->pluck('name', 'id');

        return view('backend.pages.process.candidates.create', compact('step', 'candidateTypes', 'agents', 'countries', 'professions'));
    }

    public function store(Request $request)
    {
        $step = (int) $request->input('step', 1);
        $isPrev = $request->has('prev');

        // Step-wise validation
        if (!$isPrev) {
            if ($step == 1) {
                app(CandidateRequest::class);
            } elseif ($step == 2) {
                app(CandidatePersonalInfoRequest::class);
            } elseif ($step == 3) {
                app(CandidateExperienceRequest::class);
            } elseif ($step == 4) {
                app(CandidatePassportRequest::class);
            } elseif ($step == 5) {
                app(CandidateLocationRequest::class);
            } elseif ($step == 6) {
                app(CandidateFileRequest::class);
            }
        }

        if ($isPrev) {
            $step = max(1, $step); // Prevent step below 1
        } else {
            $data = $request->except([
                '_token', 'step', 'prev',
                'departure_seal', 'arrival_seal',
                'passport_scan_copy', 'file_path'
            ]);

            if ($step == 3) {
                if ($request->hasFile('departure_seal')) {
                    $data['departure_seal'] = $this->uploadFile('candidate', $request->file('departure_seal'), 'candidate/departure_seal');
                }

                if ($request->hasFile('arrival_seal')) {
                    $data['arrival_seal'] = $this->uploadFile('candidate', $request->file('arrival_seal'), 'candidate/arrival_seal');
                }

                if (isset($data['travelled_country_id']) && is_array($data['travelled_country_id'])) {
                    $data['travelled_country_id'] = json_encode($data['travelled_country_id']);
                }
            }

            if ($step == 4) {
                if ($request->hasFile('passport_scan_copy')) {
                    $data['passport_scan_copy'] = $this->uploadFile('candidate', $request->file('passport_scan_copy'), 'candidate/passport_scan_copy');
                }
            }

            if ($step == 6) {
                if ($request->hasFile('candidate_photo')) {
                    $data['candidate_photo'] = $this->uploadFile('candidate', $request->file('candidate_photo'), 'candidate/files');
                }
                if ($request->hasFile('police_verification')) {
                    $data['police_verification'] = $this->uploadFile('candidate', $request->file('police_verification'), 'candidate/files');
                }
                if ($request->hasFile('other_certification')) {
                    $data['other_certification'] = $this->uploadFile('candidate', $request->file('other_certification'), 'candidate/files');
                }
                if ($request->hasFile('optional_file')) {
                    $data['optional_file'] = $this->uploadFile('candidate', $request->file('optional_file'), 'candidate/files');
                }
            }

            // Save this step’s data into session
            session()->put("form.step_$step", $data);

            // Final submission
            if ($step == 7) {
                DB::beginTransaction();
                try {
                    $formData = [
                        'step_1' => session('form.step_1', []),
                        'step_2' => session('form.step_2', []),
                        'step_3' => session('form.step_3', []),
                        'step_4' => session('form.step_4', []),
                        'step_5' => session('form.step_5', []),
                        'step_6' => session('form.step_6', []),
                    ];

                    $step1 = $formData['step_1'];
                    $step2 = $formData['step_2'];
                    $step3 = $formData['step_3'];
                    $step4 = $formData['step_4'];
                    $step5 = $formData['step_5'];
                    $step6 = $formData['step_6'];

                    // Step 1 → Create Candidate
                    $candidate = Candidate::create($step1);

                    // Step 2 → Personal Info
                    CandidatePersonalInfo::create(array_merge($step2, [
                        'candidate_id' => $candidate->id,
                    ]));

                    // Step 3 → Experience
                    if (isset($step3['travelled_country_id']) && is_array($step3['travelled_country_id'])) {
                        $step3['travelled_country_id'] = json_encode($step3['travelled_country_id']);
                    }
                    CandidateExperience::create(array_merge($step3, [
                        'candidate_id' => $candidate->id,
                    ]));

                    // Step 4 → Passport
                    CandidatePassport::create(array_merge($step4, [
                        'candidate_id' => $candidate->id,
                    ]));

                    // Step 5 → Location
                    CandidateLocation::create(array_merge($step5, [
                        'candidate_id' => $candidate->id,
                    ]));

                    // Step 6 → Files
                    CandidateFile::create(array_merge($step6, [
                        'candidate_id' => $candidate->id,
                    ]));

                    DB::commit();

                    // Clear session
                    session()->forget('form');

                    return response()->json([
                        'success' => true,
                        'redirect' => route('admin.candidates.index'),
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();

                    // Optional: log the error
                    Log::error('Candidate creation failed: ' . $e->getMessage());

                    return response()->json([
                        'success' => false,
                        'message' => 'Something went wrong. Please try again.',
                        'error' => $e->getMessage()
                    ], 500);
                }
            }

            // Go to next step
            $step++;
        }

        // Prepare data for next step view
        $data = ['step' => $step];

        // Add required step-wise select options
        if ($step == 1) {
            $data['candidateTypes'] = CandidateType::where('status', 1)->pluck('name', 'id');
            $data['agents'] = Agent::where('status', 1)->get()->pluck('full_name', 'id');
            $data['countries'] = Country::where('status', 1)->pluck('name', 'id');
            $data['professions'] = Profession::where('status', 1)->pluck('name', 'id');
        } elseif ($step == 2) {
            $data['genders'] = Gender::where('status', 1)->pluck('name', 'id');
            $data['relations'] = Relation::where('status', 1)->pluck('name', 'id');
            $data['religions'] = Religion::where('status', 1)->pluck('name', 'id');
            $data['bloodGroups'] = BloodGroup::where('status', 1)->pluck('name', 'id');
        } elseif ($step == 3) {
            $data['workTypes'] = Profession::where('status', 1)->pluck('name', 'id');
            $data['travelledCountries'] = Country::where('status', 1)->pluck('name', 'id');
        } elseif ($step == 4) {
            $data['passportIssuePlaces'] = District::where('status', 1)->pluck('name', 'id');
        } elseif ($step == 5) {
            $data['countries'] = Country::where('status', 1)->pluck('name', 'id');
            $data['divisions'] = Division::where('status', 1)->pluck('name', 'id');
            $data['districts'] = District::where('status', 1)->pluck('name', 'id');
            $data['thanas'] = Thana::where('status', 1)->pluck('name', 'id');
            $data['postOffices'] = PostOffice::where('status', 1)->pluck('name', 'id');
            $data['states'] = State::where('status', 1)->pluck('name', 'id');
        } elseif ($step == 7) {
            $data['candidateTypes'] = CandidateType::where('status', 1)->pluck('name', 'id')->toArray();
            $data['agents'] = Agent::where('status', 1)->get()->pluck('full_name', 'id')->toArray();
            $data['professions'] = Profession::where('status', 1)->pluck('name', 'id')->toArray();
            $data['genders'] = Gender::where('status', 1)->pluck('name', 'id')->toArray();
            $data['relations'] = Relation::where('status', 1)->pluck('name', 'id')->toArray();
            $data['religions'] = Religion::where('status', 1)->pluck('name', 'id')->toArray();
            $data['bloodGroups'] = BloodGroup::where('status', 1)->pluck('name', 'id')->toArray();
            $data['countries'] = Country::where('status', 1)->pluck('name', 'id')->toArray();
            $data['divisions'] = Division::where('status', 1)->pluck('name', 'id')->toArray();
            $data['districts'] = District::where('status', 1)->pluck('name', 'id')->toArray();
            $data['thanas'] = Thana::where('status', 1)->pluck('name', 'id')->toArray();
            $data['postOffices'] = PostOffice::where('status', 1)->pluck('name', 'id')->toArray();
            $data['states'] = State::where('status', 1)->pluck('name', 'id')->toArray();
            $data['travelledCountries'] = Country::where('status', 1)->pluck('name', 'id')->toArray();
        }

        // Render next form step
        $html = view('backend.pages.process.candidates.partials.form', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'step' => $step
        ]);
    }

    public function show(Candidate $candidate)
    {
        $countries = \App\Models\Supper_Admin\Location\Country::pluck('name', 'id')->toArray();
        $candidate->load([
            'personalInfo',
            'experiences',
            'passport',
            'location',
            'files',
        ]);

        return view('backend.pages.process.candidates.partials.candidate_profile_modal_data', compact('candidate', 'countries'));
    }

    public function showAgentProfile($agent_id)
    {
        $agent = Agent::with(['country'])->where('id', $agent_id)->first();

        return view('backend.pages.process.candidates.partials.agent_profile_modal_data', compact('agent'));
    }

    public function edit(Candidate $candidate)
    {
        //
    }

    public function update(Request $request, Candidate $candidate)
    {
        //
    }
    public function updateCandidatePhoto(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'candidate_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $candidate = \App\Models\Admin\Process\Candidate::findOrFail($request->candidate_id);
        $candidateFile = $candidate->files; // Assuming relation: files() in Candidate model


        if (!$candidateFile) {
            // If no file record exists, create one
            $candidateFile = new \App\Models\Admin\Process\CandidateFile();
            $candidateFile->candidate_id = $candidate->id;
        }

        if ($request->hasFile('candidate_photo')) {
            $path = $this->uploadFile('candidate', $request->file('candidate_photo'), 'candidate/files');
            $candidateFile->candidate_photo = $path;
            $candidateFile->save();
        }

        return response()->json([
            'status' => 'success',
            'photo_url' => asset($candidateFile->candidate_photo),
        ]);
    }

 public function getFieldsStatus($candidate_type_id)
{
    $fields = \Illuminate\Support\Facades\DB::table('candidate_type_fields')
        ->where('candidate_type_id', $candidate_type_id)
        ->pluck('is_enable', 'attr_value');
     //dd($fields);
    return response()->json($fields);
}





    public function typeTransfer(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'candidate_type_id' => 'required|exists:candidate_types,id',
        ]);

        $candidate = Candidate::findOrFail($request->candidate_id);
        $candidate->candidate_type_id = $request->candidate_type_id;
        $candidate->save();

        return response()->json(['status' => 'success']);
    }

    public function commissionSetup(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'commission' => 'required',
        ]);

        $candidate = Candidate::findOrFail($request->candidate_id);
        $candidate->commission = $request->commission;
        $candidate->save();

        return response()->json(['status' => 'success']);
    }

    public function getCandidateComment($id)
    {
        $candidate = Candidate::findOrFail($id);
        if (!$candidate) {
            return response()->json(['error' => 'Candidate not found.'], 404);
        }
        return response()->json(['comment' => $candidate->comments]);
    }

    public function saveCandidateComment(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'comments' => 'nullable|string|max:2000',
        ]);
        $candidate = Candidate::findOrFail($request->candidate_id);
        $candidate->comments = $request->comments;
        $candidate->save();
        return response()->json(['status' => 'success']);
    }

    public function storeCandidateTransaction(Request $request)
    {
        $validated = $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'transaction_type' => 'required|string',
            'payment_method' => 'required|string',
            'currency' => 'required|string',
            'transaction_purpose' => 'required|string',
            'amount' => 'required|numeric',
            'amount_bdt' => 'required|numeric',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240',
            'transaction_note' => 'nullable|string',
            'note' => 'nullable|string',
        ]);
        $data = $validated;
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $this->uploadFile('candidate', $request->file('attachment'), 'candidate/transaction');
        }
        $transaction = \App\Models\Admin\Process\CandidateTransaction::create($data);
        return response()->json(['status' => 'success', 'transaction' => $transaction]);
    }

    public function getCandidateTransactions(Request $request, $candidate_id)
    {
        $transactions = \App\Models\Admin\Process\CandidateTransaction::where('candidate_id', $candidate_id)
            ->orderByDesc('id')
            ->get();

        // Map to required columns
        $data = $transactions->map(function($t) {
            return [
                'id' => $t->id,
                'transaction_type' => ucfirst($t->transaction_type),
                'transaction_purpose' => $t->transaction_purpose,
                'payment_method' => $t->payment_method,
                'currency' => $t->currency,
                'amount' => $t->amount,
                'amount_bdt' => $t->amount_bdt,
                'transaction_note' => $t->transaction_note ?? '',
                'note' => $t->note ?? '',
                'date' => $t->created_at ? $t->created_at->format('Y-m-d') : '',
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function storeAgentTransaction(Request $request)
    {
        $validated = $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'agent_id' => 'required|exists:agents,id',
            'care_candidate_id' => 'required|exists:candidates,id',
            'transaction_type' => 'required|string',
            'payment_method' => 'required|string',
            'currency' => 'required|string',
            'amount' => 'required|numeric',
            'amount_bdt' => 'required|numeric',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240',
            'transaction_note' => 'nullable|string',
            'note' => 'nullable|string',
        ]);
        $data = $validated;
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $this->uploadFile('candidate', $request->file('attachment'), 'agent/transaction');
        }
        $transaction = AgentTransaction::create($data);
        return response()->json(['status' => 'success', 'transaction' => $transaction]);
    }

    public function getAgentTransactions(Request $request, $candidate_id)
    {
        $transactions = AgentTransaction::where('candidate_id', $candidate_id)
            ->orderByDesc('id')
            ->get();

        // Map to required columns
        $data = $transactions->map(function($t) {
            return [
                'id' => $t->id,
                'transaction_type' => ucfirst($t->transaction_type),
                'payment_method' => $t->payment_method,
                'currency' => $t->currency,
                'amount' => $t->amount,
                'amount_bdt' => $t->amount_bdt,
                'transaction_note' => $t->transaction_note ?? '',
                'note' => $t->note ?? '',
                'date' => $t->created_at ? $t->created_at->format('Y-m-d') : '',
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function destroy(string $id)
    {
        try {
            $candidate = Candidate::findOrFail($id);

            if(isset($candidate->personalInfo)){
                $candidate->personalInfo()->delete();
            }
            if(isset($candidate->experiences)){
                $candidate->experiences()->delete();
            }
            if(isset($candidate->passport)){
                $candidate->passport()->delete();
            }

            if(isset($candidate->location)){
                $candidate->location()->delete();
            }

            if(isset($candidate->files)){
                $candidate->files()->delete();
            }
            if(isset($candidate->transactions)){
                $candidate->transactions()->delete();
            }
            $candidate->delete();
            return response()->json(['status' => 'success', 'message' => 'Candidate deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
