<div class="mb-3">
    <label for="name" class="form-label">Branch Name</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $branch->name ?? '') }}" placeholder="e.g. Main Branch">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="contact_number" class="form-label">Contact Number</label>
    <input type="text" name="contact_number" id="contact_number"
        class="form-control @error('contact_number') is-invalid @enderror"
        value="{{ old('contact_number', $branch->contact_number ?? '') }}">
    @error('contact_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="gst_number" class="form-label">GST Number</label>
    <input type="text" name="gst_number" id="gst_number"
        class="form-control @error('gst_number') is-invalid @enderror"
        value="{{ old('gst_number', $branch->gst_number ?? '') }}">
    @error('gst_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', $branch->address ?? '') }}</textarea>
    @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3 form-check">
    <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input"
        {{ old('is_active', $branch->is_active ?? false) ? 'checked' : '' }}>
    <label for="is_active" class="form-check-label">Active</label>
</div>
