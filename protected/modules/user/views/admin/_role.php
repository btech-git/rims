<div id="head-role-panel">
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
</div>

<div id="main-role-panel" <?php if (!$model->is_main_access): ?>style="display: none"<?php endif; ?>>
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Pending' => array(
                    'content' => $this->renderPartial('_formPending', array(
                        'model' => $model, 
                        'counter' => $counter
                    ), true)
                ),
                'Resepsionis' => array(
                    'content' => $this->renderPartial('_formFrontDesk', array(
                        'model' => $model, 
                        'counter' => $counter+6
                    ), true)
                ),
                'Transaksi' => array(
                    'content' => $this->renderPartial('_formTransaction', array(
                        'model' => $model, 
                        'counter' => $counter+24
                    ), true)
                ),
                'Operasional' => array(
                    'content' => $this->renderPartial('_formOperational', array(
                        'model' => $model, 
                        'counter' => $counter+72
                    ), true)
                ),
                'Gudang' => array(
                    'content' => $this->renderPartial('_formInventory', array(
                        'model' => $model, 
                        'counter' => $counter+111
                    ), true)
                ),
                'Management' => array(
                    'content' => $this->renderPartial('_formIdleManagement', array(
                        'model' => $model, 
                        'counter' => $counter+138
                    ), true)
                ),
                'Accounting/Finance' => array(
                    'content' => $this->renderPartial(
                        '_formFinance',
                        array('model' => $model, 'counter' => $counter+151),
                        true
                    )
                ),
                'HRD' => array(
                    'content' => $this->renderPartial(
                        '_formHumanResource',
                        array('model' => $model, 'counter' => $counter+157),
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
                        '_formReport',
                        array('model' => $model, 'counter' => $counter+178),
                        true
                    )
                ),
                'Setting Company' => array(
                    'content' => $this->renderPartial(
                        '_formCompany',
                        array('model' => $model, 'counter' => $counter+254),
                        true
                    )
                ),
                'Setting Accounting' => array(
                    'content' => $this->renderPartial(
                        '_formAccounting',
                        array('model' => $model, 'counter' => $counter+299),
                        true
                    )
                ),
                'Setting Product' => array(
                    'content' => $this->renderPartial(
                        '_formProduct',
                        array('model' => $model, 'counter' => $counter+320),
                        true
                    )
                ),
                'Setting Service' => array(
                    'content' => $this->renderPartial(
                        '_formService',
                        array('model' => $model, 'counter' => $counter+369),
                        true
                    )
                ),
                'Setting Vehicle' => array(
                    'content' => $this->renderPartial(
                        '_formVehicle',
                        array('model' => $model, 'counter' => $counter+418),
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
</div>

<br /><br />

<?php $counter = 453; ?>
<div id="front-role-panel" <?php if (!$model->is_front_access): ?>style="display: none"<?php endif; ?>>
    <?php echo $this->renderPartial('_formRimsFront', array(
        'model'=>$model,
        'counter' => $counter,
    )); ?>
</div>