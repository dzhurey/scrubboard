{{ csrf_field() }}
<div class="form-group">
    <label class="c-form--label" for="number-plate">Number plate</label>
    <input class="form-control" id="number-plate" name="number" required>
    <div class="invalid-feedback">Data invalid.</div>
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