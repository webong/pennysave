<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center">INVITE NEW ADMIN USER(S)</h4>
        </div>
        <form action="invite" method="POST">
            <div class="modal-body">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="email">Email Address(es)</label>
                  <textarea class="form-control" id="email" value="old('emails')" name="emails" rows="3" placeholder="Enter Email Addresses"></textarea>
                  <p class="help-block">You Can Enter Multiple Emails seperated by <kbd>,</kbd> (comma)</p>
                  <p class="text-warning"><strong>NB:</strong> All Invitations Sent Here Are For Default Admin Users; To send Invitations with Higher Admin Privileges, Use <a href="{{ route('manage-admins') }}">Admin Management</a></p>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
              <button type="submit" id="submitIV" class="btn btn-primary">Send Invitations</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
