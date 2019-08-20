{{ csrf_field() }}
<div class="form-group">
    <label>Nama</label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ !empty($price->id) ? $price->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>
<div class="form-group">
    <label>List Harga</label>
    <div class="c-table--outer m-0">
        <table id="" class="c-table table table-striped">
            <thead>
                <tr>
                    <th width="10%">
                        <!-- <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="checkAll">
                        </div> -->
                    </th>
                    <th width="60%">Description</th>
                    <th width="30%">Price</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($items as $item)
                <tr>
                    <th>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="input-checkbox-{{ $item->id }}">
                            <input type="hidden" id="input-checkbox-{{ $item->id }}" name="price_lines[{{ $item->id }}][item_id]" value="{{ $item->id }}">
                            @isset($price)
                                <input type="hidden" id="input-checkbox-{{ $item->id }}" name="price_lines[{{ $item->id }}][price_id]" value="{{ $price->id }}">
                            @endif
                        </div>
                    </th>
                    <td>{{ $item->description }}</td>
                    <td>
                        <input class="form-control" id="input-amount-{{ $item->id }}" name="price_lines[{{ $item->id }}][amount]" required="">
                        <div class="invalid-feedback">Data invalid.</div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
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