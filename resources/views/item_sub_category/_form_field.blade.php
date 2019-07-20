{{ csrf_field() }}
<div class="form-group">
    <label>Nama</label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ !empty($item_sub_category->id) ? $item_sub_category->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Bank</label>
    {{ Form::select('item_group_id', $item_groups, !empty($item_sub_category->id) ? $item_sub_category->item_group_id : old('item_group_id'), ['class' => 'form-control '.($errors->has('item_group_id') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('item_group_id'))
        <div class="invalid-feedback">{{ $errors->first('item_group_id') }}</div>
    @endif
</div>
