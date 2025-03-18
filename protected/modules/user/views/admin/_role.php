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
</div>

<br /><br />

<?php $counter = 351; ?>
<div id="front-role-panel" <?php if (!$model->is_front_access): ?>style="display: none"<?php endif; ?>>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; width: 50%">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][managerFront]", CHtml::resolveValue($model, "roles[managerFront]"), array('id' => 'User_roles_' . $counter, 'value' => 'managerFront')); ?>
                    <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
                </th>
                <th style="text-align: center">Create</th>
                <th style="text-align: center">Edit</th>
                <th style="text-align: center">Approval</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Kasir</td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][cashierFrontCreate]", CHtml::resolveValue($model, "roles[cashierFrontCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierFrontCreate')); ?>
                </td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][cashierFrontEdit]", CHtml::resolveValue($model, "roles[cashierFrontEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierFrontEdit')); ?>
                </td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][cashierFrontSupervisor]", CHtml::resolveValue($model, "roles[cashierFrontSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierFrontSupervisor')); ?>
                </td>
            </tr>
            <tr>
                <td>Registration</td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][registrationTransactionFrontCreate]", CHtml::resolveValue($model, "roles[registrationTransactionFrontCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'registrationTransactionFrontCreate')); ?>
                </td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][registrationTransactionFrontEdit]", CHtml::resolveValue($model, "roles[registrationTransactionFrontEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'registrationTransactionFrontEdit')); ?>
                </td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][registrationTransactionFrontSupervisor]", CHtml::resolveValue($model, "roles[registrationTransactionFrontSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'registrationTransactionFrontSupervisor')); ?>
                </td>
            </tr>
            <tr>
                <td>Estimasi</td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][saleEstimationFrontCreate]", CHtml::resolveValue($model, "roles[saleEstimationFrontCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleEstimationFrontCreate')); ?>
                </td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][saleEstimationFrontEdit]", CHtml::resolveValue($model, "roles[saleEstimationFrontEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleEstimationFrontEdit')); ?>
                </td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][saleEstimationFrontSupervisor]", CHtml::resolveValue($model, "roles[saleEstimationFrontSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleEstimationFrontSupervisor')); ?>
                </td>
            </tr>
            <tr>
                <td>Invoice</td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][saleInvoiceFrontCreate]", CHtml::resolveValue($model, "roles[saleInvoiceFrontCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceFrontCreate')); ?>
                </td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][saleInvoiceFrontEdit]", CHtml::resolveValue($model, "roles[saleInvoiceFrontEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceFrontEdit')); ?>
                </td>
                <td style="text-align: center">
                    <?php //echo $counter; ?>
                    <?php echo CHtml::checkBox("User[roles][saleInvoiceFrontSupervisor]", CHtml::resolveValue($model, "roles[saleInvoiceFrontSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceFrontSupervisor')); ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>