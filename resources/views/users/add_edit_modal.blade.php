<div class="modal fade text-left" id="user_add_edit_modal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Add User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" class="js_user_add_from">
                @csrf
                <input type="hidden" name="old_email" class="js_old_email" value="" />
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label for="section">Section</label>
                            <select name="section_id" class="form-control js_section" id="section">

                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" name="full_name" class="form-control js_full_name" id="full_name" />
                            <div class="invalid-feedback">The full name field is required.</div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prefix">Phone</label>
                            <input type="text" name="phone" class="form-control js_phone phone-mask" id="prefix" placeholder="+998901234567" />
                            <div class="invalid-feedback">The phone field is required.</div>
                        </div>


                        <div class="col-md-6 form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control js_status">
                                <option value="1">Active</option>
                                <option value="0">No active</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control js_email" id="email" placeholder="a.admin@etc.uz" />
                            <div class="invalid-feedback">The email field is required.</div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="password">Password</label>
                            <input type="text" name="password" class="form-control js_password" id="password" />
                            <div class="invalid-feedback">The password field is required.</div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="saveBtn">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
