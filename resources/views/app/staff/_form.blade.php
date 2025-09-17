<div class="mb-3">
    <label for="name" class="form-label">Staff Name</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $staff->name ?? '') }}" placeholder="e.g. Ramesh Kumar">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="father_name" class="form-label">Father Name</label>
    <input type="text" name="father_name" id="father_name"
        class="form-control @error('father_name') is-invalid @enderror"
        value="{{ old('father_name', $staff->father_name ?? '') }}">
    @error('father_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="phone" class="form-label">Phone Number</label>
    <input type="text" name="phone" id="phone"
        class="form-control @error('phone') is-invalid @enderror"
        value="{{ old('phone', $staff->phone ?? '') }}">
    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="aadhaar_number" class="form-label">Aadhaar Number</label>
    <input type="text" name="aadhaar_number" id="aadhaar_number"
        class="form-control @error('aadhaar_number') is-invalid @enderror"
        value="{{ old('aadhaar_number', $staff->aadhaar_number ?? '') }}">
    @error('aadhaar_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="designation" class="form-label">Designation</label>
    <input type="text" name="designation" id="designation"
        class="form-control @error('designation') is-invalid @enderror"
        value="{{ old('designation', $staff->designation ?? '') }}" placeholder="e.g. Manager">
    @error('designation') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', $staff->address ?? '') }}</textarea>
    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
