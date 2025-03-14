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
                    array('model' => $model, 'counter' => $counter+6),
                    true
                )
            ),
            'Transaksi' => array(
                'content' => $this->renderPartial(
                    '_viewTransaction',
                    array('model' => $model, 'counter' => $counter+21),
                    true
                )
            ),
            'Operasional' => array(
                'content' => $this->renderPartial(
                    '_viewOperational',
                    array('model' => $model, 'counter' => $counter+60),
                    true
                )
            ),
            'Gudang' => array(
                'content' => $this->renderPartial(
                    '_viewInventory',
                    array('model' => $model, 'counter' => $counter+91),
                    true
                )
            ),
            'Management' => array(
                'content' => $this->renderPartial(
                    '_viewIdleManagement',
                    array('model' => $model, 'counter' => $counter+114),
                    true
                )
            ),
            'Accounting/Finance' => array(
                'content' => $this->renderPartial(
                    '_viewFinance',
                    array('model' => $model, 'counter' => $counter+127),
                    true
                )
            ),
            'HRD' => array(
                'content' => $this->renderPartial(
                    '_viewHumanResource',
                    array('model' => $model, 'counter' => $counter+133),
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
            'Laporan' => array(
                'content' => $this->renderPartial(
                    '_viewReport',
                    array('model' => $model, 'counter' => $counter+149),
                    true
                )
            ),
            'Setting Company' => array(
                'content' => $this->renderPartial(
                    '_viewCompany',
                    array('model' => $model, 'counter' => $counter+200),
                    true
                )
            ),
            'Setting Accounting' => array(
                'content' => $this->renderPartial(
                    '_viewAccounting',
                    array('model' => $model, 'counter' => $counter+234),
                    true
                )
            ),
            'Setting Product' => array(
                'content' => $this->renderPartial(
                    '_viewProduct',
                    array('model' => $model, 'counter' => $counter+250),
                    true
                )
            ),
            'Setting Service' => array(
                'content' => $this->renderPartial(
                    '_viewService',
                    array('model' => $model, 'counter' => $counter+287),
                    true
                )
            ),
            'Setting Vehicle' => array(
                'content' => $this->renderPartial(
                    '_viewVehicle',
                    array('model' => $model, 'counter' => $counter+324),
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