<div class="mb-3">
    <label for="" class="form-label">{{ $label }}</label>
    <input 
        type="{{ $type }}"
        class="form-control @error($field) is-invalid @enderror"
        name="{{ $field }}"
        placeholder="Enter {{ $field }}..."
        value="{{ $value == '' ? old($field) : $value }}"
    >
    @error($field)
        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
    @enderror
</div>