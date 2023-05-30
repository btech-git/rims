<?php
$this->breadcrumbs = array(
    'Jurnal Umum' => array('create'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('release-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>
<?php echo CHtml::beginForm(array(''), 'get'); ?>
<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <?php echo CHtml::link('<span class="fa fa-plus"></span>New Jurnal Umum', Yii::app()->baseUrl . '/accounting/journalAdjustment/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("adjustmentJournalCreate"))) ?>
                <h2>Kelola Jurnal Umum</h2>
            </div>

            <center>
                <?php
                $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
                $pageSizeDropDown = CHtml::dropDownList(
                    'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
                        'class' => 'change-pagesize',
                        'onchange' => "$.fn.yiiGridView.update('journal-adjustment-header-grid',{data:{pageSize:$(this).val()}});",
                    )
                );
                ?>

                <div class="page-size-wrap">
                    <span>Display by:</span><?php echo $pageSizeDropDown; ?>
                </div>
                
                <div class="search-bar">
                    <div class="clearfix button-bar">
                        <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>
                        <div class="clearfix"></div>
                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('_search', array(
                                'model' => $journalAdjustmentHeader,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                            )); ?>
                        </div>
                    </div>
                </div>
            </center>

            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'journal-adjustment-header-grid',
                    'dataProvider' => $journalAdjustmentHeaderDataProvider,
                    'filter' => $journalAdjustmentHeader,
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager'=>array(
                       'cssFile'=>false,
                       'header'=>'',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'transaction_number',
                            'header' => 'Jurnal #',
                            'value' => '$data->transaction_number',
                        ),
                        array(
                            'header' => 'Tanggal',
                            'name' => 'date',
                            'filter' => false,
                            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::encode(CHtml::value($data, "date")))'
                        ),
                        'note',
                        'user.username',
//                        'branch.name',
                        'status',
                        array(
                            'header' => 'Input',
                            'name' => 'created_datetime',
                            'filter' => false,
                            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                        ),
                        array(
                            'class' => 'CButtonColumn',
                            'template' => '{view}{update}',
                            'buttons' => array(
//                                'update' => array(
//                                    'visible' => '$data->status == "Draft"',
//                                ),
                            ),
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
<?php echo CHtml::endForm(); ?>