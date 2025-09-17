<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text"
           name="title" id="title"
           class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $expense->title ?? '') }}"
           placeholder="e.g. Office Supplies">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="amount" class="form-label">Amount</label>
    <input type="number"
           name="amount" id="amount"
           step="0.01" min="0"
           class="form-control @error('amount') is-invalid @enderror"
           value="{{ old('amount', isset($expense) ? $expense->amount : '') }}"
           placeholder="e.g. 1500.00">
    @error('amount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Optional notes (uncomment if you add column) --}}
{{--
<div class="mb-3">
    <label for="notes" class="form-label">Notes</label>
    <textarea name="notes" id="notes" rows="3"
              class="form-control @error('notes') is-invalid @enderror"
    >{{ old('notes', $expense->notes ?? '') }}</textarea>
    @error('notes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
--}}
