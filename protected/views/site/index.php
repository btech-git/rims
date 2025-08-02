<?php
/* @var $this SiteController */
    $this->pageTitle=Yii::app()->name;
?>
<style>
  
.custom-radios div {
  display: inline-block;
}
.custom-radios input[type="radio"] {
  display: none;
}
.custom-radios input[type="radio"] + label {
  color: #333;
  font-family: Arial, sans-serif;
  font-size: 14px;
}
.custom-radios input[type="radio"] + label span {
  display: inline-block;
  width: 40px;
  height: 40px;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor: pointer;
  border-radius: 50%;
  border: 2px solid #FFFFFF;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
  background-repeat: no-repeat;
  background-position: center;
  text-align: center;
  line-height: 44px;
}
.custom-radios input[type="radio"] + label span img {
  opacity: 0;
  transition: all .3s ease;
}
.custom-radios input[type="radio"]#color-1 + label span {
  background-color: #2ecc71;
}
.custom-radios input[type="radio"]#color-2 + label span {
  background-color: #3498db;
}
.custom-radios input[type="radio"]#color-3 + label span {
  background-color: #f1c40f;
}
.custom-radios input[type="radio"]#color-4 + label span {
  background-color: #e74c3c;
}
.custom-radios input[type="radio"]:checked + label span img {
  opacity: 1;
}
</style>

<div style="font-size:16px; text-align:center">
    <div style="font-size:30px">Raperind Information Management System (RIMS) Dashboard</div>
    <br /><br/>
    
    <?php /*$this->renderPartial('_viewVehicle', array(
        'vehicleDataProvider' => $vehicleDataProvider, 
        'vehicle' => $vehicle, 
    ));*/ ?>
<!--    <fieldset>
        <legend>Permintaan Harga</legend>
        <div class="grid-view">
            <?php /*$this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'product-pricing-grid',
                'dataProvider' => $pricingRequestDataProvider,
                'filter' => $pricingRequest,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'name' => 'product_name', 
                        'value' => '$data->product_name',
                    ),
                    array(
                        'name' => 'request_date',
                        'value' => '$data->request_date',
                    ),
                    array(
                        'name' => 'quantity',
                        'value' => '$data->quantity',
                    ),
                    array(
                        'name' => 'user_id_request',
                        'header' => 'User Request',
                        'value' => '$data->userIdRequest->username',
                    ),
                    array(
                        'name' => 'request_note',
                        'value' => '$data->request_note',
                    ),
                    array(
                        'name' => 'branch_id_request',
                        'header' => 'Branch Request',
                        'value' => '$data->branchIdRequest->code',
                    ),
                    array(
                        'name' => 'reply_date',
                        'value' => '$data->reply_date',
                    ),
                    array(
                        'name' => 'recommended_price',
                        'value' => '$data->recommended_price',
                    ),
                    array(
                        'name' => 'user_id_reply',
                        'header' => 'User Reply',
                        'value' => 'empty($data->user_id_reply) ? "" : $data->userIdReply->username',
                    ),
                    array(
                        'name' => 'branch_id_reply',
                        'header' => 'Branch Reply',
                        'value' => 'empty($data->branch_id_reply) ? "" : $data->branchIdReply->code',
                    ),
                    array(
                        'name' => 'reply_note',
                        'value' => '$data->reply_note',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{reply} &nbsp; {show}',
                        'buttons' => array(
                            'reply' => array(
                                'label' => 'reply',
                                'url' => 'Yii::app()->createUrl("frontDesk/productPricingRequest/update", array("id"=>$data->id))',
                            ),
                            'show' => array(
                                'label' => 'show',
                                'url' => 'Yii::app()->createUrl("frontDesk/productPricingRequest/view", array("id"=>$data->id))',
                            ),
                        ),
                    ),
                ),
            ));*/ ?>
        </div>
    </fieldset>-->
</div>
