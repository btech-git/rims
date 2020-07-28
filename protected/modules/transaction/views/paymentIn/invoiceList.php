<h1>List Invoice Pending</h1>
   
<div id="link">
    <?php echo CHtml::link('Manage', array('admin'), array('class' => 'button success primary')); ?>
</div>

<div>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'invoice-grid',
        // 'dataProvider'=>$vehicleDataProvider,
        'dataProvider' => $invoiceDataProvider,
        'filter' => $invoice,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
            jQuery("#PaymentIn_invoice_id").val(jQuery.fn.yiiGridView.getSelection(id));
            jQuery("#invoice-dialog").dialog("close");
            jQuery.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxInvoice', array('invoiceId' => '')) . '" + jQuery.fn.yiiGridView.getSelection(id),
                data: $("form").serialize(),
                success: function(data) {

                    jQuery("#PaymentIn_invoice_number").val(data.invoice_number);
                    jQuery("#PaymentIn_customer_id").val(data.customer_id);
                    jQuery("#PaymentIn_vehicle_id").val(data.vehicle_id);
                    $("#PaymentIn_invoice_id").attr("rel",data.count);
                    jQuery("#Invoice_invoice_date").val(data.invoice_number);
                    jQuery("#Invoice_due_date").val(data.due_date);
                    jQuery("#Invoice_reference_type").val(data.reference_type);
                    jQuery("#Invoice_reference_number").val(data.reference_num);
                    jQuery("#Invoice_status").val(data.status);
                    jQuery("#Invoice_total_price").val(data.total_price);
                    jQuery("#Invoice_payment_amount").val(data.payment_amount);
                    jQuery("#Invoice_payment_left").val(data.payment_left);
                    jQuery("#Customer_customer_name").val(data.customer_name);
                    jQuery("#Customer_customer_type").val(data.type);
                    jQuery("#Customer_customer_address").text(data.address+"\n"+data.province+"\n"+data.city );
                    console.log(data.address+"\n"+data.province+"\n"+data.city);
                    jQuery("#Customer_email").val(data.email);
                    var phones = data.phones;
                    jQuery("#Customer_phones").text("");
                    jQuery("#Customer_mobiles").text("");
                    for (i=0; i < phones.length; i++) { 
                        console.log(phones[i]);
                        var obj = phones[i];

                        for(var prop in obj){
                            if(obj.hasOwnProperty(prop)){
                                if(prop == "phone_no"){
                                    console.log(prop + " = " + obj[prop]);
                                    jQuery("#Customer_phones").text(jQuery("#Customer_phones").val()+"\n"+obj[prop]);
                                }

                            }
                        }
                    }
                    var mobiles = data.mobiles;
                    for (i=0; i < mobiles.length; i++) { 
                        console.log(mobiles[i]);
                        var obj = mobiles[i];
                        for(var prop in obj){
                            if(obj.hasOwnProperty(prop)){
                                if(prop == "mobile_no"){
                                    console.log(prop + " = " + obj[prop]);
                                    jQuery("#Customer_mobiles").text(jQuery("#Customer_mobiles").val()+"\n"+obj[prop]);
                                }

                            }
                        }
                    }

                    jQuery("#Vehicle_plate_number").val(data.plate);
                    jQuery("#Vehicle_machine_number").val(data.machine);
                    jQuery("#Vehicle_frame_number").val(data.frame);
                    jQuery("#Vehicle_chasis_code").val(data.chasis);
                    jQuery("#Vehicle_power").val(data.power);
                    jQuery("#Vehicle_car_make_name").val(data.carMake);
                    jQuery("#Vehicle_car_model_name").val(data.carModel);
                    jQuery("#Vehicle_car_sub_model_name").val(data.carSubModel);
                    jQuery("#Vehicle_car_color_name").val(data.carColor);

                    if($("#PaymentIn_customer_id").val() != ""){
                        $(".detail").show();
                        $("#invoice-Detail").show();
                        $("#customer").show();
                        $("#vehicle").hide();
                    }
                    if($("#PaymentIn_vehicle_id").val() != ""){
                        $(".detail").show();
                        $("#invoice-Detail").show();
                        $("#customer").show();
                        $("#vehicle").show();
                    }
                },
            });

            jQuery("#invoice-grid").find("tr.selected").each(function(){
                $(this).removeClass( "selected" );
            });
        }',
        'columns' => array(
            'invoice_number',
            'invoice_date',
            'due_date',
            'status',
            array('name' => 'reference_type', 'value' => '$data->reference_type == 1 ? "Sales Order" : "Retail Sales"'),
            array('name' => 'customer_name', 'value' => '$data->customer->name'),
            array(
                'name' => 'total_price',
                'value' => 'number_format($data->total_price, 2)',
            ),
            array(
                'name' => 'payment_amount',
                'value' => 'number_format($data->payment_amount, 2)',
            ),
            array(
                'name' => 'payment_left',
                'value' => 'number_format($data->payment_left, 2)',
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("create", "invoiceId"=>$data->id))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>