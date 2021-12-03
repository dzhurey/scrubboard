<div id="modal-export" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="modal-export-form" class="needs-validatio">
                <div class="modal-header">
                    <h2 class="modal-title">Export Data</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="c-form--label" for="date_from">Date From</label>
                                <input class="form-control datetimepicker" id="date_from" name="date_from" required>
                                <div class="invalid-feedback">Data invalid.</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="c-form--label" for="date_to">Date To</label>
                                <input class="form-control datetimepicker" id="date_to" name="date_to" required>
                                <div class="invalid-feedback">Data invalid.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>
