<div class="modal fade" id="setup-field-position" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog" style="min-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title setup_field_position_title"><b id="form_name_show"></b>'s Fields position setup</h5>
                <button type="button" class="close text-danger" data-dismiss="modal"> <span aria-hidden="true">×</span> </button>
            </div>
            <div class="modal-body setup_field_position_body" style="overflow-x: hidden;"><meta content="width=device-width, initial-scale=1.0" name="viewport">
                <meta http-equiv="content-type" content="text-html; charset=utf-8">
                <div class="row">
                    <div class="col-sm-12 print_button_container">
                        <button type="button" class="btn btn-xs btn-warning" style="float: right;" id="print_button_new"><i class="fa fa-print"></i> &nbsp; Print</button>
                    </div>
                    <div class="col-sm-12">
                        <b class="message_data"></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <page size="A4" id="print-area-2" style="" id="field_list1">

                            <div class="draggable ui-draggable ui-draggable-handle" field-name="data" form-id="5" style="position: relative; left: 0px; top: -30px;">data</div>

                            <div class="draggable ui-draggable ui-draggable-handle" field-name="candidate_type_id" form-id="5" style="position: relative;">candidate_type_id</div>

                            <div class="draggable ui-draggable ui-draggable-handle" field-name="agent_id" form-id="5" style="position: relative;">agent_id</div>

                            <div class="draggable ui-draggable ui-draggable-handle" field-name="agent_id" form-id="5" style="position: relative;">agent_id</div>
                        </page>
                    </div>
                </div>
                <style>
                    page[size="A4"] {
                        background: white;
                        width: 21cm;
                        height: 29.7cm;
                        display: block;
                        margin: 0 auto;
                        margin-bottom: 0.5cm;
                        box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
                        background: url(http://erp.mahfuza-overseas.com/mahfuza_v2/assets/uploads/documents/human_resource/files_2023_12_03_1997361296435514606.jpg);
                        background-repeat: no-repeat;
                        background-size: contain;
                        background-position: top;
                    }
                    @media print {
                        body, page[size="A4"] {
                            margin: 0;
                            box-shadow: 0;
                        }
                    }
                    .draggable{
                        color: rgb(255, 0, 0);
                        border-bottom: dotted;
                        width: fit-content;
                        font-weight: bolder;
                    }
                </style>
                <script src="http://erp.mahfuza-overseas.com/mahfuza_v2/assets/home/js/print/printThis.js"></script>
                <script>
                    $(function(){
                        $(".draggable").draggable({
                            drag: function(e) {
                                $('.draggable').each(function(){
                                    var style = $(this).attr('style');
                                });
                            }, stop: function(e) {
                                var position_array = [];
                                $('.draggable').each(function(i){
                                    var field_name = $(this).attr('field-name');
                                    var form_id = $(this).attr('form-id');
                                    var style = $(this).attr('style');
                                    if(field_name != '' && form_id != '' && style != ''){
                                        position_array[i] = [field_name, form_id, style];
                                    }
                                });
                                if(position_array.length > 0){
                                    $.post({
                                        url: 'http://erp.mahfuza-overseas.com/mahfuza_v2/home-pages/candidate-process/dynamic-form',
                                        data: { dragable_position_save: 'active', information: position_array},
                                        beforeSend: function(){ $.skylo('start'); },
                                        success: function(data){ $.skylo('end');
                                            var value = jQuery.parseJSON(data);
                                            $('.message_data').html(value['message']);
                                        }
                                    });
                                }
                            }
                        });

                        $('.print_button_container').off();
                        $('.print_button_container').on('click', '#print_button_new', function () {
                            //$("#print-area-2").print();
                            $("#print-area-2").printThis({
                                debug: false,                   // show the iframe for debugging
                                importCSS: true,                // import parent page css
                                importStyle: true,             // import style tags
                                printContainer: true,           // grab outer container as well as the contents of the selector
                                // loadCSS: "path/to/my.css",      // path to additional css file - use an array [] for multiple
                                pageTitle: "",                  // add title to print page
                                removeInline: false,            // remove all inline styles from print elements
                                removeInlineSelector: "body *", // custom selectors to filter inline styles. removeInline must be true
                                printDelay: 333,                // variable print delay
                                header: null,                   // prefix to html
                                footer: null,                   // postfix to html
                                base: false,                    // preserve the BASE tag, or accept a string for the URL
                                formValues: true,               // preserve input/form values
                                canvas: false,                  // copy canvas elements
                                doctypeString: '',           // enter a different doctype for older markup
                                removeScripts: false,           // remove script tags from print content
                                copyTagClasses: false           // copy classes from the html & body tag
                                // beforePrintEvent: null,         // callback function for printEvent in iframe
                                // beforePrint: null,              // function called before iframe is filled
                                // afterPrint: null                // function called before iframe is removed
                            });

                        });
                    });
                </script></div>
        </div>
    </div>
</div>



