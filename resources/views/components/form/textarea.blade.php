@props([
    'id' => '', 
    'label',
    'field' => '',
    'value' => ''
])

<div class="mb-3">
    @if(isset($label)) <label for="" class="form-label">{{ $label }}</label> @endif
    <textarea 
        name="{{ $field }}"
        class="form-control @error($field) is-invalid @enderror"
        placeholder="Enter {{ $field }}..."
    >
    {{ $value == '' ? old($field) : $value }}
    </textarea>
    @error($field)
        <small id="helpId" class="form-text danger">{{ $message }}</small>
    @enderror
</div>