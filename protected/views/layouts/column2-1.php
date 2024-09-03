<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main2'); ?>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-secondary">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="<?php echo Yii::app()->createUrl('frontEnd/default/index'); ?>" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">
                            <strong>RAPERIND MOTOR</strong>
                        </span>
                    </a>
                </div>
            </div>
            <div class="col-auto col-md-9 col-xl-10 py-3">
                <div class="container-fluid">
                    <div class="row d-print-none">
                        <div class="col d-flex justify-content-start">
                        </div>
                        <div class="col d-flex justify-content-end">
                        </div>
                    </div>
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>