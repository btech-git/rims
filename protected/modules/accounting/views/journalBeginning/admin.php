<?php
$this->breadcrumbs = array(
    'Saldo Awal' => array('create'),
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
                <?php echo CHtml::link('<span class="fa fa-plus"></span>Saldo Awal', Yii::app()->baseUrl . '/accounting/journalBeginning/create', array(
                    'class' => 'button success right', 
                    'visible' => Yii::app()->user->checkAccess("director")
                )); ?>
                <h2>Kelola Saldo Awal Jurnal</h2>
            </div>

            <center>
                <?php
                $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
                $pageSizeDropDown = CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
                    'class' => 'change-pagesize',
                    'onchange' => "$.fn.yiiGridView.update('journal-beginning-header-grid',{data:{pageSize:$(this).val()}});",
                )); ?>

                <div class="page-size-wrap">
                    <span>Display by:</span><?php echo $pageSizeDropDown; ?>
                </div>
                
                <div class="search-bar">
                    <div class="clearfix button-bar">
                        <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>
                        <div class="clearfix"></div>
                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('_search', array(
                                'journalBeginning' => $journalBeginning,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                            )); ?>
                        </div>
                    </div>
                </div>
            </center>

            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'journal-beginning-header-grid',
                    'dataProvider' => $journalBeginningDataProvider,
                    'filter' => $journalBeginning,
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
                            'name' => 'transaction_date',
                            'filter' => false,
                            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::encode(CHtml::value($data, "transaction_date")))'
                        ),
                        'note',
                        array(
                            'name' => 'status',
                            'header' => 'Status',
                            'filter' => CHtml::activeDropDownList($journalBeginning,'status', array(
                                'Draft' => 'Draft',
                                'Approved' => 'Approved',
                                'Rejected' => 'Rejected',
                            ), array('empty' => '-- All --')),
                            'value' => '$data->status',
                        ),
                        'userIdCreated.username',
                        array(
                            'header' => 'Input',
                            'name' => 'created_datetime',
                            'filter' => false,
                            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                        ),
                        array(
                            'class' => 'CButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'label' => 'view',
                                    'url' => 'Yii::app()->createUrl("accounting/journalBeginning/view", array("id"=>$data->id))',
                                ),
                            ),
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
<?php echo CHtml::endForm(); ?>