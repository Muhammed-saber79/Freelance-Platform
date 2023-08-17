<div class="mb-3">
    @if(isset($label)) <label for="" class="form-label">{{ $label }}</label> @endif
    <input 
        type="{{ $type }}"
        name="{{ $field }}"
        class="form-control @error($field) is-invalid @enderror"
        placeholder="Enter {{ $field }}..."
        value="{{ $value == '' ? old($field) : $value }}"
    >
    @error($field)
        <small id="helpId" class="form-text danger">{{ $message }}</small>
    @enderror
</div>