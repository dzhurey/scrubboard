{{ csrf_field() }}
<div class="form-group">
    <label>Nama</label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ !empty($courier->id) ? $courier->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>
<div class="form-group">
    <label>No. Handphone</label>
    <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" value="{{ !empty($courier->id) ? $courier->phone_number : old('phone_number') }}">
    @if ($errors->has('phone_number'))
        <div class="invalid-feedback">{{ $errors->first('phone_number') }}</div>
    @endif
</div>
<hr class="my-4">
<div class="row">
    <div class="col-sm-6 text-left">
        <button id="button-delete" class="btn btn-danger" type="button">Delete</button>
    </div>
    <div class="col-sm-6 text-right">
        <button class="btn btn-light mr-2" type="button">Cancel</button>
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>
</div>