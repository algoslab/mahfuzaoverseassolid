<div id="leave-details" class="modal fade modal-right" style="padding-right: 7px;" aria-modal="true" role="dialog">
    <div class="modal-dialog" style="min-width: 25%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title view_leave_modal_title">Leave Information: <b id="emp_name"></b></h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body view_leave_modal_body" style="overflow-x: hidden;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-body pt-0 pb-0">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img id="preview" src="" style="width: 100%;" class="image-responsive">
                                </div>
                                <div class="col-sm-8 pl-0">
                                    <table class="table table-sm candidate_details_table mb-0 small">
                                        <tbody>
                                        <tr><td>Department</td><td>:</td><td id="department"></td></tr>
                                        <tr><td>Leave type</td><td>:</td><td id="type"></td></tr>
                                        <tr><td>Shift</td><td>:</td><td id="leave_shift"></td></tr>
                                        <tr><td>NOD Was</td><td>:</td><td style="font-weight: bolder;" id="nod"></td></tr>
                                        <tr><td>Entry date</td><td>:</td><td id="entry_date"></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                </div>
                            </div>
                            <hr class="">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="box-body pt-0 pb-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <u><h5 class="modal-title">Leave Days</h5></u>
                                    <ol id="leaveDatesList" class="days-leave-tree mt-15">

                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
</div>
