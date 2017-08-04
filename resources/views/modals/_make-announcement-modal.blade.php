<div class="modal fade" id="make-announcement-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center" role="document">
            <div class="modal-content">
                <div class="modal-header no-border-bottom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title text-center bold" id="myModalLabel">Create Announcement</h4>
                </div>
                <div class="modal-body">
                    <form id="make-announcement-form">
                        <div class="form-group">
                            <label for="announce-subject" class="control-label">Brief Subject</label>
                            <input id="announce-subject" type="text" name="subject" class="form-control" placeholder="Brief Subject">
                        </div>
                        <div class="form-group">
                            <label for="announce-content" class="control-label">Announcement Details</label>
                            <textarea rows="3" id="announce-content" class="form-control countingdown" name="content" placeholder="Announcement Details"></textarea>
                            <span id="characters" class="bold"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer no-border-top">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="create-announcement">Send Announcement</button>
                </div>
            </div>
        </div>
    </div>
</div>
