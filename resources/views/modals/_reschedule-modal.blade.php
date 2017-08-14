<div class="modal fade" id="reschedule-date-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-sm vertical-align-center" role="document">
            <div class="modal-content">
                <div class="modal-header no-border-bottom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title text-center" id="myModalLabel">Choose A New Date To Start <span class="text-primary">Etibe</span></h5>
                </div>
                <div class="modal-body">
                    <form id="reschedule-update-form">
                        <input type="date" name="update_date" id="update_date" class="form-control date" placeholder="Select New Start Date">
                    </form>
                </div>
                <p class="text-xs text-info text-center no-padding-top no-padding-bottom" id="new_date_confirm"></p>
                <div class="modal-footer no-border-top center-block">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="reschedule-confirm">Reschedule</button>
                </div>
            </div>
        </div>
    </div>
</div>
