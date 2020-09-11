<?php $this->breadcrumbs = array(
    'Kas Harian' => array('summary'),
    'View',
); ?>


<div id="link">
    <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage', Yii::app()->baseUrl.'/accounting/cashDailySummary/admin' , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.admin"))) ?>
</div>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->transaction_date),
        ),
        array(
            'label' => 'Amount',
            'value' => number_format($model->amount, 0),
        ),
        array(
            'label' => 'Branch',
            'value' => $model->branch->name,
        ),
        array(
            'label' => 'Payment Type',
            'value' => $model->paymentType->name,
        ),
        array(
            'label' => 'Approved By',
            'value' => $model->user->username,
        ),
        array(
            'label' => 'Memo',
            'value' => $model->memo,
        ),
    ),
));
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <fieldset>
            <legend>Attached Images</legend>

            <?php foreach ($postImages as $postImage):
                $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/cashDaily/' . $postImage->filename;
                $src = Yii::app()->baseUrl . '/images/uploads/cashDaily/' . $postImage->filename;
            ?>
                <div class="row">
                    <div class="small-3 columns">
                        <div style="margin-bottom:.5rem">
                            <?php echo CHtml::image($src, $model->id . "Image"); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </fieldset>
    </div>
</div>