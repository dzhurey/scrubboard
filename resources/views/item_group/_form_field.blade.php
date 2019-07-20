{{ csrf_field() }}
<div class="form-group">
    <label>Name</label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ !empty($item_group->id) ? $item_group->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>