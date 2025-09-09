<div id="expense-transaction-modal" class="modal center-modal fade view_profile_modal show" style="padding-right: 7px;" aria-modal="true">
    <div class="modal-dialog modal-xl" style="min-width: 75%;">
        <div class="modal-content" style="border-radius: 10px !important;">
            <div class="modal-header"><h5 class="modal-title view_profile_modal_title">Related transaction about <b id="expense_category_item_name"></b></h5>
                <button type="button" class="close text-danger" data-dismiss="modal"> <span aria-hidden="true">×</span> </button>
            </div>
            <div class="modal-body view_profile_modal_body" style="overflow-x: hidden;max-height: 80vh; overflow-y: scroll;">
                <div class="row" id="print-area-2">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <div id="data-table-transaction_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="data-table-transaction" class="table table-sm table-bordered table-hover display nowrap margin-top-10 w-p100 dataTable no-footer" role="grid" aria-describedby="data-table-transaction_info" style="width: 0px;">
                                            <thead>
                                            <tr>
                                                <th style="">ID</th>
                                                <th style="">Date</th>
                                                <th style="">Account</th>
                                                <th style="">Transaction Amount</th>
                                                <th style="">Note</th>
                                            </tr>
                                           </thead>
                                            <tbody id="view_salary_list">
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
</div>
