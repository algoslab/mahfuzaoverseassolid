@php
$steps = [
    1 => 'New Candidate',
    2 => 'Personal Information',
    3 => 'Experience Information',
    4 => 'Passport Information',
    5 => 'Location',
    6 => 'Files',
    7 => 'Review',
];
@endphp

<div class="step-nav d-flex justify-content-between mb-4">
    @foreach($steps as $i => $label)
        <div class="step-item {{ $step == $i ? 'active' : '' }}" style="flex:1; text-align:center; font-weight:{{ $step == $i ? 'bold' : 'normal' }};">
            {{ $i }} - {{ $label }}
        </div>
    @endforeach
</div>

<form id="candidateForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="step" value="{{ $step }}">

    @if($step == 1)
        @include('backend.pages.process.candidates.steps.step_1')
    @elseif($step == 2)
        @include('backend.pages.process.candidates.steps.step_2')
    @elseif($step == 3)
        @include('backend.pages.process.candidates.steps.step_3')
    @elseif($step == 4)
        @include('backend.pages.process.candidates.steps.step_4')
    @elseif($step == 5)
        @include('backend.pages.process.candidates.steps.step_5')
    @elseif($step == 6)
        @include('backend.pages.process.candidates.steps.step_6')
    @elseif($step == 7)
        @include('backend.pages.process.candidates.steps.step_7')
    @endif

    <div class="d-flex justify-content-between mt-4">
        @if($step > 1)
            <button type="button" id="prevBtn" class="btn btn-secondary">Previous</button>
        @else
            <div></div>
        @endif
        <button type="submit" class="btn btn-primary" id="finalSubmitBtn" @if($step == 7) disabled @endif>
            {{ $step < 7 ? 'Next' : 'Submit' }}
        </button>
    </div>
</form>