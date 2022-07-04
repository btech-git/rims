<?php
/* @var $this QuickServiceController */
/* @var $model QuickService */

$this->breadcrumbs = array(
    'Quick Services' => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List QuickService', 'url' => array('index')),
    array('label' => 'Create QuickService', 'url' => array('create')),
    array('label' => 'Update QuickService', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete QuickService', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage QuickService', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl . '/master/quickService/admin'; ?>"><span class="fa fa-th-list"></span>Manage Quick Service</a>
        <?php if (Yii::app()->user->checkAccess("masterQuickServiceEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php } ?>
        <h1>View Quick Service #<?php echo $model->id; ?></h1>

        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'code',
                'name',
                'status',
                'rate',
                'hour',
            ),
        ));
        ?>

    </div>
</div>

<br />
<hr />
<div class="detail">
<?php if (count($quickServiceDetails) > 0): ?>
        <table>
            <thead>
                <tr>
                    <td>Service</td>
                    <td>Price</td>
                    <td>Discount Price</td>
                    <td>Final Price</td>
                    <td>hour</td>
                </tr>
            </thead>
            <tbody>
    <?php foreach ($quickServiceDetails as $key => $quickServiceDetail): ?>
                    <tr>	
                        <td><?php echo $quickServiceDetail->service->name; ?></td>
                        <td><?php echo $quickServiceDetail->price; ?></td>
                        <td><?php echo $quickServiceDetail->discount_price; ?></td>
                        <td><?php echo $quickServiceDetail->final_price; ?></td>
                        <td><?php echo $quickServiceDetail->hour; ?></td>
                    </tr>
    <?php endforeach ?>

            </tbody>
        </table>
    <?php else: ?>
    <?php echo "NO Detail Available"; ?>
<?php endif ?>
</div>