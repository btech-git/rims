<table style="border: 0px solid">
    <tr>
        <td style="border: 0px solid" colspan="4"><h1>List Customer</h1></td>
        <td style="border: 0px solid" colspan="2">
            <a class="button info right" href="<?php echo Yii::app()->baseUrl.'/master/customer/create';?>">
                <span class="fa fa-plus"></span>New Customer
            </a>
        </td>
        <td style="border: 0px solid">
            <?php echo CHtml::link('<span class="fa fa-archive"></span>Manage GR', array('/frontDesk/general/admin'), array('class'=>'button success right')); ?>
        </td>
        <td style="border: 0px solid" colspan="2">
            <?php echo CHtml::link('<span class="fa fa-archive"></span>Manage BR', array('/frontDesk/bodyRepair/admin'), array('class'=>'button success left')); ?>
        </td>
    </tr>
    <tr>
        <td>Customer</td>
        <td colspan="3">
            <?php echo CHtml::activeTextField($customer, 'name', array(
                'onchange' => '
                    $.fn.yiiGridView.update("customer-grid", {data: {
                        Customer: {
                            name: $(this).val(),
                            type: $("#' . CHtml::activeId($customer, 'customer_type') . '").val(),
                            mobile_phone: $("#' . CHtml::activeId($customer, 'mobile_phone') . '").val(),
                            email: $("#' . CHtml::activeId($customer, 'email') . '").val(),
                        }
                    }});
                ',
            )); ?>
        </td>
        <td>Type</td>
        <td colspan="3">
            <?php echo CHtml::activeDropDownList($customer, 'customer_type', array(
                'Individual' => 'Individual', 
                'Company' => 'Company',
            ), array(
                'empty' => '-- All --',
                'onchange' => '
                    $.fn.yiiGridView.update("customer-grid", {data: {
                        Customer: {
                            name: $("#' . CHtml::activeId($customer, 'name') . '").val(),
                            mobile_phone: $("#' . CHtml::activeId($customer, 'mobile_phone') . '").val(),
                            email: $("#' . CHtml::activeId($customer, 'email') . '").val(),
                            customer_type: $(this).val(),
                        }
                    }});
                ',
            )); ?>
        </td>
    </tr>
    <tr>
        <td>HP</td>
        <td colspan="3">
            <?php echo CHtml::activeTextField($customer, 'mobile_phone', array(
                'onchange' => '
                    $.fn.yiiGridView.update("customer-grid", {data: {
                        Customer: {
                            mobile_phone: $(this).val(),
                            type: $("#' . CHtml::activeId($customer, 'customer_type') . '").val(),
                            name: $("#' . CHtml::activeId($customer, 'name') . '").val(),
                            email: $("#' . CHtml::activeId($customer, 'email') . '").val(),
                        }
                    }});
                ',
            )); ?>
        </td>
        <td>Email</td>
        <td colspan="3">
            <?php echo CHtml::activeTextField($customer, 'email', array(
                'onchange' => '
                    $.fn.yiiGridView.update("customer-grid", {data: {
                        Customer: {
                            name: $("#' . CHtml::activeId($customer, 'name') . '").val(),
                            type: $("#' . CHtml::activeId($customer, 'customer_type') . '").val(),
                            mobile_phone: $("#' . CHtml::activeId($customer, 'mobile_phone') . '").val(),
                            email: $(this).val(),
                        }
                    }});
                ',
            )); ?>
        </td>
    </tr>
</table>

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'customer-grid',
        'dataProvider' => $customerDataProvider,
        'filter' => null,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            'id',
            array(
                'name' => 'name',
                'value' => 'CHtml::link($data->name, array("/master/customer/view", "id"=>$data->id), array("target" => "_blank"))',
                'type'=>'raw',
            ),
            'mobile_phone',
            array(
                'name' => 'email',
                'value' => '$data->email',
            ),
            array(
                'name' => 'customer_type',
                'value' => 'CHtml::value($data, "customer_type")',
            ),
            'note',
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("+ vehicle", array("/master/customer/addVehicle", "id"=>$data->id))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>