@extends('layouts.sidebar')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Resident Information</h2>

    <form action="{{ route('admin.residents.update', $resident->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Basic Info -->
            <div class="col-md-4 mb-3">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" name="fname" class="form-control" value="{{ old('fname', $resident->fname) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="mname" class="form-label">Middle Name</label>
                <input type="text" name="mname" class="form-control" value="{{ old('mname', $resident->mname) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" name="lname" class="form-control" value="{{ old('lname', $resident->lname) }}" required>
            </div>

            <div class="col-md-2 mb-3">
                <label for="suffix" class="form-label">Suffix</label>
                <input type="text" name="suffix" class="form-control" value="{{ old('suffix', $resident->suffix) }}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $resident->birthdate?->format('Y-m-d')) }}">
            </div>

            <div class="col-md-2 mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" name="age" class="form-control" value="{{ old('age', $resident->age) }}">
            </div>

            <div class="col-md-2 mb-3">
                <label for="sex" class="form-label">Sex</label>
                <select name="sex" class="form-select">
                    <option value="">Select</option>
                    <option value="male" {{ old('sex', $resident->sex) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('sex', $resident->sex) == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('sex', $resident->sex) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="civil_status" class="form-label">Civil Status</label>
                <select name="civil_status" class="form-select">
                    <option value="">Select</option>
                    <option value="single" {{ old('civil_status', $resident->civil_status) == 'single' ? 'selected' : '' }}>Single</option>
                    <option value="married" {{ old('civil_status', $resident->civil_status) == 'married' ? 'selected' : '' }}>Married</option>
                    <option value="widowed" {{ old('civil_status', $resident->civil_status) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                </select>
            </div>

            <!-- Contact -->
            <div class="col-md-4 mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $resident->phone_number) }}">
            </div>

            <!-- Address -->
            <div class="col-md-4 mb-3">
                <label for="region" class="form-label">Region</label>
                <input type="text" name="region" class="form-control" value="{{ old('region', $resident->region) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="province" class="form-label">Province</label>
                <input type="text" name="province" class="form-control" value="{{ old('province', $resident->province) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="municipality" class="form-label">Municipality</label>
                <input type="text" name="municipality" class="form-control" value="{{ old('municipality', $resident->municipality) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="barangay" class="form-label">Barangay</label>
                <input type="text" name="barangay" class="form-control" value="{{ old('barangay', $resident->barangay) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="sitio" class="form-label">Sitio</label>
                <input type="text" name="sitio" class="form-control" value="{{ old('sitio', $resident->sitio) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="purok" class="form-label">Purok</label>
                <input type="text" name="purok" class="form-control" value="{{ old('purok', $resident->purok) }}">
            </div>

            <!-- Status Flags -->
            <div class="col-md-12 mt-3">
                <h5>Special Categories</h5>
                @foreach ([
                    'solo_parent' => 'Solo Parent',
                    'ofw' => 'OFW',
                    'is_pwd' => 'PWD',
                    'is_4ps' => '4Ps Member',
                    'out_of_school_children' => 'Out of School Children',
                    'osa' => 'OSA',
                    'unemployed' => 'Unemployed',
                    'laborforce' => 'Labor Force',
                    'isy_isc' => 'ISY/ISC',
                    'senior_citizen' => 'Senior Citizen',
                    'voter' => 'Voter',
                ] as $field => $label)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="{{ $field }}" value="1"
                               {{ old($field, $resident->$field) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $label }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Mother’s Maiden Name -->
            <div class="col-md-6 mt-3">
                <label for="mother_maiden_name" class="form-label">Mother’s Maiden Name</label>
                <input type="text" name="mother_maiden_name" class="form-control" value="{{ old('mother_maiden_name', $resident->mother_maiden_name) }}">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update Resident</button>
            <a href="{{ route('admin.residents.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
