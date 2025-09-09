<div id="transaction-details" class="modal center-modal fade view_profile_modal show" style="padding-right: 7px;"
     aria-modal="true">
    <div class="modal-dialog modal-xl" style="min-width: 25%;">
        <div class="modal-content" style="border-radius: 10px !important;">
            <div class="modal-header"><h5 class="modal-title view_profile_modal_title">Related transaction about <b id="sponsor_name_transaction"></b></h5>
                <button type="button" class="close text-danger" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body view_profile_modal_body"
                 style="overflow-x: hidden;max-height: 80vh; overflow-y: scroll;">
                <meta content="width=device-width, initial-scale=1.0" name="viewport">
                <div class="row">
                    <div class="col-sm-12 print_button_container">
                        <button type="button" class="btn btn-xs btn-warning" style="float: right;"
                                id="print_button_new"><i class="fa fa-print"></i> &nbsp; Print
                        </button>
                    </div>
                </div>
                <div class="row" id="print-area-2">
                    <div class="col-sm-3" style="max-width: 30%;">
                        <img id="previewTransaction" src="" style="" class="image-responsive">
                    </div>
                    <div class="col-sm-9" style="max-width: 70%;">
                        <table class="table table-sm candidate_details_table">
                            <tbody>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td id="sponsor_name_transaction1"><b></b></td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td id="cell_number_transaction"><b></b></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td id="email_transaction"><b></b></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td id="address_transaction"><b></b>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="customModalDataTable" style="table-layout: fixed; width: 100%;"
                                           class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Account</th>
                                            <th>B:Balance</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>A:Balance</th>
                                            <th>Note</th>
                                        </tr>
                                        </thead>
                                        <tbody id="transaction_data_list">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
