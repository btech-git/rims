<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs = array(
    'Company',
    'Companies' => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List Company', 'url' => array('index')),
    array('label' => 'Create Company', 'url' => array('create')),
    array('label' => 'Update Company', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Company', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Company', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl . '/master/company/admin'; ?>"><span class="fa fa-th-list"></span>Manage Company</a>
        <?php if (Yii::app()->user->checkAccess("masterCompanyEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php } ?>
        <h1>Company <?php echo $model->name ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'name',
                'address',
                'phone',
                'npwp',
                'tax_status',
            ),
        )); ?>
    </div>
</div>

<div class="row">
    <div class="small-12 columns">
        <h3>Company Bank Accounts</h3>
        <table>
            <thead>
                <tr>
                    <th>Bank Name</th>
                    <th>Account Name</th>
                    <th>Account No</th>
                    <th>Swift Code</th>
                    <th>COA NAME & CODE</th>				
                    <th>Action</th>
                </tr>
            </thead>
                <?php foreach ($companyBanks as $key => $companyBank): ?>
                <tr>
                    <?php $bank = Bank::model()->findByPk($companyBank->bank_id); ?>
                    <td><?php echo $bank->name ?></td>
                    <td><?php echo $companyBank->account_name; ?></td>
                    <td><?php echo $companyBank->account_no; ?></td>
                    <td><?php echo $companyBank->swift_code; ?></td>
                    <td><?php echo $companyBank->coa_id != "" ? $companyBank->coa->name . ' & ' . $companyBank->coa->code : ''; ?></td>
                    <td><a class="button cbutton left" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/updateBank', array('companyId' => $model->id, 'bankId' => $companyBank->id)); ?>"><span class="fa fa-pencil"></span>edit</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="small-12 columns">
        <h3>Branches</h3>
        <table>
            <thead>
                <tr>
                    <td>Branch Name</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($companyBranches as $key => $companyBranch): ?>
                    <tr>
                        <?php $branch = Branch::model()->findByPK($companyBranch->branch_id); ?>
                        <td><?php echo $branch->name; ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>