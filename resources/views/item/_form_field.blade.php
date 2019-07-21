{{ csrf_field() }}
<div class="form-group">
    <label>Item Type</label>
    {{ Form::select('item_type', App\Item::ITEM_TYPES, !empty($item->id) ? $item->item_type : old('item_type'), ['class' => 'form-control'.($errors->has('item_type') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('item_type'))
        <div class="invalid-feedback">{{ $errors->first('item_type') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Deskripsi</label>
    <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ !empty($item->id) ? $item->description : old('description') }}</textarea>
    @if ($errors->has('description'))
        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Item Type</label>
    {{ Form::select('item_group_id', $item_groups, !empty($item->id) ? $item->itemSubCategory->item_group_id : old('item_group'), ['class' => 'form-control'.($errors->has('item_group_id') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('item_group_id'))
        <div class="invalid-feedback">{{ $errors->first('item_group_id') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Item Sub Category</label>
    {{ Form::select('item_sub_category_id', $item_sub_categories, !empty($item->id) ? $item->item_sub_category_id : old('item_sub_category_id'), ['class' => 'form-control'.($errors->has('item_sub_category_id') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('item_sub_category_id'))
        <div class="invalid-feedback">{{ $errors->first('item_sub_category_id') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Produk</label>
    <input class="form-control @error('product') is-invalid @enderror" type="text" name="product" value="{{ !empty($item->id) ? $item->product : old('product') }}">
    @if ($errors->has('product'))
        <div class="invalid-feedback">{{ $errors->first('product') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Service</label>
    <input class="form-control @error('service') is-invalid @enderror" type="text" name="service" value="{{ !empty($item->id) ? $item->service : old('service') }}">
    @if ($errors->has('service'))
        <div class="invalid-feedback">{{ $errors->first('service') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Price</label>
    <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" value="{{ !empty($item->id) ? $item->price : old('price') }}">
    @if ($errors->has('price'))
        <div class="invalid-feedback">{{ $errors->first('price') }}</div>
    @endif
</div>