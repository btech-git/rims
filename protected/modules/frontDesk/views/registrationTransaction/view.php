<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'General Repair Transactions' => array('admin'),
    $model->id,
);
?>

<?php echo CHtml::beginForm(); ?>
<div class="small-12 columns">
    <div id="maincontent">
        <div class="clearfix page-action">

            <?php $ccontroller = Yii::app()->controller->id; ?>
            <?php $ccaction = Yii::app()->controller->action->id; ?>
            <?php $invoices = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id' => $model->id, 'user_id_cancelled' => null)); ?>

            <h1>View Registration Transaction #<?php echo $model->transaction_number; ?></h1>

            <fieldset>
                <legend>Information</legend>
                <div class="row" style="height: 700px">
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Registration' => array(
                                'id' => 'info1',
                                'content' => $this->renderPartial('_viewRegistration', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'Customer Vehicle' => array(
                                'id' => 'info3',
                                'content' => $this->renderPartial('_viewCustomer', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'DP Info' => array(
                                'id' => 'info3',
                                'content' => $this->renderPartial('_viewDownpayment', array(
                                    'model' => $model,
                                ), true)
                            ),
                        ),
                        // additional javascript options for the tabs plugin
                        'options' => array(
                            'collapsible' => true,
                        ),
                        // set id for this widgets
                        'id' => 'view_tab',
                    )); ?>  
                </div>
            </fieldset>
        </div>
    </div>
    
    <hr />
    
    <div class="detail">
        <fieldset>
            <legend>Parts</legend>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Product name</th>
                        <th>Quantity</th>
                        <th>Retail Price</th>
                        <th>Sale Price</th>
                        <th>Discount Type</th>
                        <th>Discount</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $i => $product): ?>
                            <tr>
                                <td><?php echo $product->product_id; ?></td>
                                <td><?php echo $product->product->manufacturer_code; ?></td>
                                <td><?php echo $product->product->name; ?></td>
                                <td><?php echo $product->quantity; ?></td>
                                <td style="text-align: right"><?php echo number_format($product->retail_price,2); ?></td>
                                <td style="text-align: right"><?php echo number_format($product->sale_price,2); ?></td>
                                <td><?php echo $product->discount_type; ?></td>
                                <td><?php echo $product->discount_type == 'Percent' ? $product->discount : number_format($product->discount,0); ?></td>
                                <td style="text-align: right"><?php echo number_format($product->total_price,2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </fieldset>
        
        <fieldset>
            <legend>Jasa</legend>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service name</th>
                        <th>Hour</th>
                        <th>Status</th>
                        <th>Duration</th>
                        <th>Note</th>
                        <th>Price</th>
                        <th>Discount Type</th>
                        <th>Discount</th>
                        <th>Total Price</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (count($services) > 0): ?>
                        <?php foreach ($services as $i => $service): ?>
                            <tr>
                                <td><?php echo $service->service_id; ?></td>
                                <td><?php echo $service->service->name; ?></td>
                                <td><?php echo $service->hour; ?></td>
                                <td><?php echo $service->status; ?></td>
                                <td><?php echo $service->hour; ?></td>
                                <td><?php echo $service->note; ?></td>
                                <td style="text-align: right"><?php echo number_format($service->price,2); ?></td>
                                <td><?php echo $service->discount_type; ?></td>
                                <td><?php echo $service->discount_type == 'Percent' ? $service->discount_price : number_format($service->discount_price,2); ?></td>
                                <td style="text-align: right"><?php echo number_format($service->total_price,2); ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </fieldset>
        <fieldset>
            <div class="row">
                <div class="large-12 columns">
                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Sub Total Parts</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo number_format($model->subtotal_product, 2); ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Discount Parts</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo number_format($model->discount_product, 2); ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Total Parts Price</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo number_format($model->total_product_price, 2); ?>"> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Sub Total Jasa</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo number_format($model->subtotal_service, 2); ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Jasa Discount</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo number_format($model->discount_service, 2); ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Total Jasa Price</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo number_format($model->total_service_price, 2); ?>"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Total Parts</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->total_product; ?>"> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Total Jasa</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->total_service; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Sub Total Parts + Jasa</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo number_format($model->totalProductService, 2); ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">PPN Price</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo number_format($model->ppn_price, 2); ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Grand Total</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo number_format($model->grand_total, 2); ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Downpayment</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo number_format($model->downpayment_amount, 2); ?>"> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<?php echo CHtml::endForm(); ?>