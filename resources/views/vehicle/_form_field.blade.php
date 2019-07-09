{{ csrf_field() }}
<div class="form-group">
    <label>Nomor</label>
    <input class="form-control @error('number') is-invalid @enderror" type="text" name="number" value="{{ !empty($vehicle->id) ? $vehicle->number : old('number') }}">
    @if ($errors->has('number'))
        <div class="invalid-feedback">{{ $errors->first('number') }}</div>
    @endif
</div>