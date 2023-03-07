<table>
    <tr>
        <td>
            <?php echo CHtml::checkBox("User[roles][director]", CHtml::resolveValue($model, "roles[director]"), array('id' => 'User_roles_' . $counter, 'value' => 'director')); ?>
            <?php echo CHtml::label('Director', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
        </td>
        <td>
            <?php echo CHtml::checkBox("User[roles][generalManager]", CHtml::resolveValue($model, "roles[generalManager]"), array('id' => 'User_roles_' . $counter, 'value' => 'generalManager')); ?>
            <?php echo CHtml::label('General Manager', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
        </td>
    </tr>
</table>

<div>
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Pending' => array(
                'content' => $this->renderPartial(
                    '_viewPending',
                    array('model' => $model, 'counter' => $counter),
                    true
                )
            ),
            'Resepsionis' => array(
                'content' => $this->renderPartial(
                    '_viewFrontDesk',
                    array('model' => $model, 'counter' => $counter+5),
                    true
                )
            ),
            'Pembelian' => array(
                'content' => $this->renderPartial(
                    '_viewPurchase',
                    array('model' => $model, 'counter' => $counter+15),
                    true
                )
            ),
            'Penjualan' => array(
                'content' => $this->renderPartial(
                    '_viewSale',
                    array('model' => $model, 'counter' => $counter+22),
                    true
                )
            ),
            'Pelunasan' => array(
                'content' => $this->renderPartial(
                    '_viewPayment',
                    array('model' => $model, 'counter' => $counter+28),
                    true
                )
            ),
            'Tunai' => array(
                'content' => $this->renderPartial(
                    '_viewCash',
                    array('model' => $model, 'counter' => $counter+35),
                    true
                )
            ),
            'Operasional' => array(
                'content' => $this->renderPartial(
                    '_viewOperational',
                    array('model' => $model, 'counter' => $counter+42),
                    true
                )
            ),
            'Gudang' => array(
                'content' => $this->renderPartial(
                    '_viewInventory',
                    array('model' => $model, 'counter' => $counter+67),
                    true
                )
            ),
            'Idle Management' => array(
                'content' => $this->renderPartial(
                    '_viewIdleManagement',
                    array('model' => $model, 'counter' => $counter+85),
                    true
                )
            ),
        ),
        // additional javascript options for the tabs plugin
        'options' => array(
            'collapsible' => true,
        ),
        // set id for this widgets
        'id' => 'view_tab_transaction',
    )); ?>
</div>

<br /><br />

<div>
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Accounting/Finance' => array(
                'content' => $this->renderPartial(
                    '_viewFinance',
                    array('model' => $model, 'counter' => $counter+92),
                    true
                )
            ),
            'Laporan' => array(
                'content' => $this->renderPartial(
                    '_viewReport',
                    array('model' => $model, 'counter' => $counter+98),
                    true
                )
            ),
            'Setting Company' => array(
                'content' => $this->renderPartial(
                    '_viewCompany',
                    array('model' => $model, 'counter' => $counter+133),
                    true
                )
            ),
            'Setting Accounting' => array(
                'content' => $this->renderPartial(
                    '_viewAccounting',
                    array('model' => $model, 'counter' => $counter+176),
                    true
                )
            ),
            'Setting Product' => array(
                'content' => $this->renderPartial(
                    '_viewProduct',
                    array('model' => $model, 'counter' => $counter+192),
                    true
                )
            ),
            'Setting Service' => array(
                'content' => $this->renderPartial(
                    '_viewService',
                    array('model' => $model, 'counter' => $counter+226),
                    true
                )
            ),
            'Setting Vehicle' => array(
                'content' => $this->renderPartial(
                    '_viewVehicle',
                    array('model' => $model, 'counter' => $counter+263),
                    true
                )
            ),
        ),
        // additional javascript options for the tabs plugin
        'options' => array(
            'collapsible' => true,
        ),
        // set id for this widgets
        'id' => 'view_tab_master',
    )); ?>
</div>