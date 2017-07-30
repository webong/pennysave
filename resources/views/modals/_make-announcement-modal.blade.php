<div class="modal fade" id="make-announcement-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center" role="document">
            <div class="modal-content">
                <div class="modal-header no-border-bottom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title text-center bold" id="myModalLabel">Create Announcement</h5>
                </div>
                <div class="modal-body">
                    <form id="make-announcement-form">
                        <div class="form-group">
                            <input type="text" name="subject" class="form-control" placeholder="Brief Subject">
                        </div>
                        <div class="form-group">
                            <textarea rows="3" class="form-control countingdown" name="content" placeholder="Announcement Details"></textarea>
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
