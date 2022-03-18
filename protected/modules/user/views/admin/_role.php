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
            'Accounting/Finance' => array(
                'content' => $this->renderPartial(
                    '_viewFinance',
                    array('model' => $model, 'counter' => $counter+92),
                    true
                )
            ),
            'Head Department' => array(
                'content' => $this->renderPartial(
                    '_viewHeadDepartment',
                    array('model' => $model, 'counter' => $counter+110),
                    true
                )
            ),
            'Setting Company' => array(
                'content' => $this->renderPartial(
                    '_viewCompany',
                    array('model' => $model, 'counter' => $counter+132),
                    true
                )
            ),
            'Setting Accounting' => array(
                'content' => $this->renderPartial(
                    '_viewAccounting',
                    array('model' => $model, 'counter' => $counter+175),
                    true
                )
            ),
            'Setting Product' => array(
                'content' => $this->renderPartial(
                    '_viewProduct',
                    array('model' => $model, 'counter' => $counter+191),
                    true
                )
            ),
            'Setting Service' => array(
                'content' => $this->renderPartial(
                    '_viewService',
                    array('model' => $model, 'counter' => $counter+225),
                    true
                )
            ),
            'Setting Vehicle' => array(
                'content' => $this->renderPartial(
                    '_viewVehicle',
                    array('model' => $model, 'counter' => $counter+262),
                    true
                )
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