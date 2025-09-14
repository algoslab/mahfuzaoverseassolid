<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Hazz & Umrah</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- The Form -->
            <form id="hazzUmrahForm" action="{{ route('supper_admin.hazz-umrah.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-700 font-size-16" for="service">Flight Date</label>
                                <input type="date" id="days" name="flight_date" class="form-control" required>
                            </div>
                        </div>
                        <!-- Country Name -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-700 font-size-16" for="service">Services</label>
                                <select name="services" id="service" class="form-control">
                                    <option value="" disabled selected>Select a service</option>
                                    <option value="Hazz">Hazz</option>
                                    <option value="Umrah">Umrah</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-700 font-size-16" for="packages">Packages</label>
                                <select name="packages" id="packages" class="form-control">
                                    <option value="" disabled selected>Select a Packages</option>
                                    <option value="Silver">Silver</option>
                                    <option value="Gold">Gold</option>
                                    <option value="Diamond">Diamond</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-700 font-size-16" for="transit">Air Transit</label>
                                <select name="transit" id="transit" class="form-control">
                                    <option value="" disabled selected>Select a Transit</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-700 font-size-16" for="hotel_category">Hotel Category</label>
                                <select name="hotel_category" id="hotel_category" class="form-control">
                                    <option value="" disabled selected>Select a Category</option>
                                    <option value="Three Star Quality">Three Star Quality</option>
                                    <option value="Three Star">Three Star</option>
                                    <option value="Four Star">Four Star</option>
                                    <option value="Five Star">Five Star</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-700 font-size-16" for="mokka_modina_transport">Mokka to Modina Transport</label>
                                <select name="mokka_modina_transport" id="mokka_modina_transport" class="form-control">
                                    <option value="" disabled selected>Select a Transport</option>
                                    <option value="Bus">Bus</option>
                                    <option value="Bullet Train">Bullet Train</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-700 font-size-16" for="meal">Meal</label>
                                <select name="meal" id="meal" class="form-control">
                                    <option value="" disabled selected>Select a meal</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-700 font-size-16" for="days">Days</label>
                                <input type="number" id="days" name="days" class="form-control" placeholder="Enter Days" required>
                            </div>
                        </div>

                        <!-- Note -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-700 font-size-16" for="B2C">B2C Amount</label>
                                <input type="number" id="B2C" name="amount_b2c" class="form-control" placeholder="B2B Amount" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-700 font-size-16" for="B2B">B2B Amount</label>
                                <input type="number" id="B2B" name="amount_b2B" class="form-control" placeholder="B2B Amount" required>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox"  id="status" name="status" class="chk-col-success" value="1" checked>
                                <label  for="status">Active/Inactive</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer modal-footer-uniform">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
