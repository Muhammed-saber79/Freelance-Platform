@props([
    'id' => '', 
    'label',
    'name',
    'options' => [],
    'selected' => ''
])

<div class="mb-3">
    @if(isset($label)) <label for="" class="form-label">{{ $label }}</label> @endif
    <select name="{{ $name }}" class="form-control @error($name) is-invalid @enderror">
        <option value="">No Selection</option>
        @foreach ($options as $key => $value)
        <option value="{{ $key }}" {{ $key == $selected ? 'selected' : ''}} > {{ $value }} </option>
        @endforeach
    </select>
    @error($name)
        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
    @enderror
</div>