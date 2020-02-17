<div id="modal-add-address" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="modal-customer-form--address" class="needs-validation">
              <input hidden class="form-check-input form-check-box" id="customer_id" type="text" name="customer_id">
              <input hidden class="form-check-input form-check-box" type="checkbox" name="is_billing" checked="true">
              <input hidden class="form-check-input form-check-box" type="checkbox" name="is_shipping" checked="true">
              <input hidden class="form-check-input form-check-box" type="checkbox" name="is_default" checked="true">
              <div class="modal-header">
                  <h2 class="modal-title">Add new address</h2>
              </div>
              <div class="modal-body">
                  <div class="row mt-4">
                      <div class="col-sm-12">
                          <h2 class="c-form--title">Address</h2>
                          <div class="form-group">
                              <label class="c-form--label" for="billing_address">Address</label>
                              <textarea class="form-control" id="billing_address" name="address" required></textarea>
                              <div class="invalid-feedback">Data invalid.</div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <label class="c-form--label" for="billing_district">District</label>
                                      <input class="form-control" id="billing_district" name="district" required>
                                      <div class="invalid-feedback">Data invalid.</div>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <label class="c-form--label" for="billing_city">City</label>
                                      <input class="form-control" id="billing_city" name="city" required>
                                      <div class="invalid-feedback">Data invalid.</div>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <label class="c-form--label" for="billing_country">Country</label>
                                      <input class="form-control" id="billing_country" name="country" required>
                                      <div class="invalid-feedback">Data invalid.</div>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <label class="c-form--label" for="billing_zip_code">Zip code</label>
                                      <input class="form-control" id="billing_zip_code" name="zip_code" required>
                                      <div class="invalid-feedback">Data invalid.</div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
        </div>
    </div>
</div>