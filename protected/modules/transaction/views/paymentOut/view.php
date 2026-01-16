<?php
/* @var $this PaymentOutController */
/* @var $model PaymentOut */

$this->breadcrumbs = array(
    'Payment Outs' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List PaymentOut', 'url' => array('index')),
    array('label' => 'Create PaymentOut', 'url' => array('create')),
    array('label' => 'Update PaymentOut', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete PaymentOut', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage PaymentOut', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Payment Out', Yii::app()->baseUrl . '/transaction/paymentOut/admin', array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.paymentOut.admin"))) ?>
        <?php if (!($model->status == 'Approved' || $model->status == 'Rejected')): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/transaction/paymentOut/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.update"))) ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/transaction/paymentOut/updateApproval?headerId=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.paymentOut.updateApproval"))) ?>
        <?php endif; ?>
        <?php //if (Yii::app()->user->checkAccess("paymentOutSupervisor")): ?>
            <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("/transaction/paymentOut/cancel", "id" => $model->id), array(
                'class' => 'button alert right', 
                'style' => 'margin-right:10px', 
            )); ?>
        <?php //endif; ?>
        
        <h1>View Payment Out #<?php echo $model->id; ?></h1>
    </div>
    
    <div class="row">
        <div class="large-12 columns">
            <fieldset>
                <legend>Payment</legend>
                <div class="row">
                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Payment #</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->payment_number; ?>"> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Payment Date</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo Yii::app()->dateFormatter->format("d MMM yyyy", strtotime($model->payment_date)); ?>"> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Payment Amount</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->payment_amount; ?>"> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Payment Type</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->paymentType->name; ?>"> 
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($model->payment_type == "Giro"): ?>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">No giro</span>
                                    </div>
                                    
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $model->nomor_giro; ?>"> 
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Status</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->status; ?>"> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">User</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->user->username; ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Branch</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->branch->name; ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Notes</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <textarea name="" id="" cols="30" rows="4" readonly="true"><?php echo $model->notes; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Approval Status</legend>
                <table>
                    <thead>
                        <tr>
                            <th>Approval type</th>
                            <th>Revision</th>
                            <th>date</th>
                            <th>note</th>
                            <th>supervisor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($revisionHistories as $key => $history): ?>
                            <tr>
                                <td><?php echo $history->approval_type; ?></td>
                                <td><?php echo $history->revision; ?></td>
                                <td><?php echo $history->date; ?></td>
                                <td><?php echo $history->note; ?></td>
                                <td><?php echo $history->supervisor->username; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </fieldset>

            <?php if (!empty($model->purchase_order_id)): ?>
                <fieldset>
                    <legend>Purchase Order</legend>
                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Purchase Date</span>
                                </div>

                                <div class="small-8 columns">
                                    <input type="text" readonly="true" id="Purchase_purchase_order_date" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->purchase_order_date : '' ?>" > 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Status</span>
                                </div>

                                <div class="small-8 columns">
                                    <input type="text" readonly="true" id="Purchase_status_document" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->status_document : '' ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Payment Status</span>
                                </div>

                                <div class="small-8 columns">
                                    <input type="text" readonly="true" id="Purchase_payment_status" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->payment_status : '' ?>"> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Total Price</span>
                                </div>

                                <div class="small-8 columns">
                                    <input type="text" readonly="true" id="Purchase_total_price" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->total_price : '' ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Payment Amount</span>
                                </div>

                                <div class="small-8 columns">
                                    <input type="text" readonly="true" id="Purchase_payment_amount" value="<?php echo empty($model->purchase_order_id) ? 0 : $model->purchaseOrder->payment_amount; ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Payment Left</span>
                                </div>

                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo empty($model->purchase_order_id) ? 0 : $model->purchaseOrder->payment_left; ?>"> 
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            <?php endif; ?>
            
            <fieldset>
                <legend>Supplier</legend>
                <div class="large-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <span class="prefix">Name</span>
                            </div>
                            
                            <div class="small-8 columns">
                                <input type="text" readonly="true" id="Supplier_supplier_name" value="<?php echo CHtml::encode(CHtml::value($supplier, 'name')); ?>"> 
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <span class="prefix">Email</span>
                            </div>
                            
                            <div class="small-8 columns">
                                <input type="text" readonly="true" id="Supplier_email_personal" value="<?php echo CHtml::encode(CHtml::value($supplier, 'email_personal')); ?>"> 
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <span class="prefix">Company</span>
                            </div>
                            
                            <div class="small-8 columns">
                                <input type="text" readonly="true" id="Supplier_company" value="<?php echo CHtml::encode(CHtml::value($supplier, 'company')); ?>"> 
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <span class="prefix">Email Company</span>
                            </div>
                            
                            <div class="small-8 columns">
                                <input type="text" readonly="true" id="Supplier_email_company" value="<?php echo CHtml::encode(CHtml::value($supplier, 'email_company')); ?>"> 
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <span class="prefix">Company Attribute</span>
                            </div>
                            
                            <div class="small-8 columns">
                                <input type="text" readonly="true" id="Supplier_company_attribute" value="<?php echo CHtml::encode(CHtml::value($supplier, 'company_attribute')); ?>"> 
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <span class="prefix">Address</span>
                            </div>
                            
                            <div class="small-8 columns">
                                <textarea name="" id="Supplier_supplier_address" cols="30" rows="5" readonly="true">
                                    <?php echo CHtml::encode(CHtml::value($supplier, 'address')) . ', ' . CHtml::encode(CHtml::value($supplier, 'province.name')) . ', ' . CHtml::encode(CHtml::value($supplier, 'city.name')) . ', ' . CHtml::encode(CHtml::value($supplier, 'zipcode')); ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div> <!-- end div large -->

                <div class="large-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <span class="prefix">Phone</span>
                            </div>
                            
                            <div class="small-8 columns">
                                <?php $getPhone = ""; ?>
                                <?php if ($model->supplier_id != ""): ?>
                                    <?php $phones = SupplierPhone::model()->findAllByAttributes(array(
                                        'supplier_id' => $model->supplier_id, 
                                        'status' => 'Active'
                                    )); ?>

                                    <?php if (count($phones) > 0): ?>

                                        <?php foreach ($phones as $key => $phone): ?>
                                            <?php $getPhone = $phone->phone_no . '&#13;&#10;'; ?>
                    <!-- <input type="text" readonly="true" value="<?php // ?>">  -->
                                        <?php endforeach; ?>
                                        <!--</textarea>-->
                                    <?php endif; ?>

                                <?php endif; ?>
                                <textarea name="" id="Supplier_phones" cols="30" rows="5" readonly="true"><?php echo $getPhone; ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <span class="prefix">Mobile</span>
                            </div>
                            
                            <div class="small-8 columns">
                                <?php $getMobile = "" ?>
                                <?php if ($model->supplier_id != ""): ?>
                                    <?php $mobiles = SupplierMobile::model()->findAllByAttributes(array(
                                        'supplier_id' => $model->supplier_id, 
                                        'status' => 'Active'
                                    )); ?>
                                    <?php if (count($mobiles) > 0): ?>
                                        <?php foreach ($mobiles as $key => $mobile): ?>
                                            <?php $getMobile .= $mobile->mobile_no . '&#13;&#10;'; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <textarea name="" id="Supplier_mobiles" cols="30" rows="5" readonly="true"><?php echo $getMobile ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            
            <?php if (!empty($model->purchase_order_id)): ?>
                <fieldset>
                    <legend>Product</legend>
                    <table>
                        <thead>
                            <tr>
                                <td>Manufacture Code</td>
                                <td>Name</td>
                                <td>Qty</td>
                                <td>Unit</td>
                                <td>Unit Price</td>
                                <td>Total</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $purchaseOrderHeader = TransactionPurchaseOrder::model()->findByPk($model->purchase_order_id); ?>
                            <?php foreach ($purchaseOrderHeader->transactionPurchaseOrderDetails as $purchaseOrderDetail): ?>
                                <tr>
                                    <?php $product = Product::model()->findByPK($purchaseOrderDetail->product_id); ?>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($purchaseOrderDetail, 'quantity')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseOrderDetail, 'unit_price'))); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseOrderDetail, 'total_price'))); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </fieldset>

                <fieldset>
                    <legend>Attached Images</legend>

                    <?php foreach ($postImages as $postImage):
                        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentOut/' . $model->id . '/' . $postImage->filename;
                        $src = Yii::app()->baseUrl . '/images/uploads/paymentOut/' . $model->id . '/' . $postImage->filename;
                    ?>
                        <div class="row">
                            <div class="small-3 columns">
                                <div style="margin-bottom:.5rem">
                                    <?php echo CHtml::image($src, $model->payment_number . "Image"); ?>
                                </div>
                            </div>

                            <div class="small-8 columns">
                                <div style="padding:.375rem .5rem; border:1px solid #ccc; background:#fff; font-size:.8125rem; line-height:1.4; margin-bottom:.5rem;">
                                    <?php echo (Yii::app()->baseUrl . '/images/uploads/paymentOut/' . $model->id . '/' . $postImage->filename); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
            <?php endif; ?>
        </div>
    </div>
</div>
