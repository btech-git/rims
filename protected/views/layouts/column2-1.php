<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main2'); ?>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-secondary">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="<?php echo Yii::app()->createUrl('frontEnd/default/index'); ?>" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">
                            <img src="<?php echo Yii::app()->baseUrl . '/images/logo.jpg' ?>" width="250px" />
                        </span>
                    </a>
                    <?php $activeClass = 'bg-light border border-3 border-primary rounded'; ?>
                    <?php $activeTextClass = 'text-dark'; ?>
                    <?php $inactiveTextClass = 'text-light'; ?>
                    <div class="mb-sm-auto mb-0 overflow-auto" style="max-height: 512px">
                        <ul class="nav nav-pills flex-column align-items-center align-items-sm-start" id="menu">
                            <?php if (true): ?>
                                <?php $isActive = Yii::app()->controller->id === 'saleEstimation' && (
                                        Yii::app()->controller->action->id === 'admin' ||
                                        Yii::app()->controller->action->id === 'view' ||
                                        Yii::app()->controller->action->id === 'update' ||
                                        Yii::app()->controller->action->id === 'create'
                                ); ?>
                                <li class="w-100 <?php if ($isActive): ?><?php echo $activeClass; ?><?php endif ;?>">
                                    <a href="<?php echo Yii::app()->createUrl('frontEnd/saleEstimation/admin'); ?>" class="nav-link px-0 align-middle">
                                        <span class="ps-1 d-none d-sm-inline <?php if ($isActive): ?><?php echo $activeTextClass; ?><?php else: ?><?php echo $inactiveTextClass; ?><?php endif ;?>">
                                            Estimasi
                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                                
                            <?php if (true): ?>
                                <?php $isActive = Yii::app()->controller->id === 'registrationTransaction' && (
                                    Yii::app()->controller->action->id === 'admin' || 
                                    Yii::app()->controller->action->id === 'view' || 
                                    Yii::app()->controller->action->id === 'saleEstimationList' || 
                                    Yii::app()->controller->action->id === 'create' || 
                                    Yii::app()->controller->action->id === 'update'
                                ); ?>
                                <li class="w-100 <?php if ($isActive): ?><?php echo $activeClass; ?><?php endif ;?>">
                                    <a href="<?php echo Yii::app()->createUrl('frontEnd/registrationTransaction/saleEstimationList'); ?>" class="nav-link px-0 align-middle">
                                        <span class="ps-1 d-none d-sm-inline <?php if ($isActive): ?><?php echo $activeTextClass; ?><?php else: ?><?php echo $inactiveTextClass; ?><?php endif ;?>">
                                            GR/BR Registration
                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                                
                            <?php if (true): ?>
                                <?php $isActive = Yii::app()->controller->id === 'vehicleInspection' && (
                                    Yii::app()->controller->action->id === 'admin' || 
                                    Yii::app()->controller->action->id === 'create'
                                ); ?>
                                <li class="w-100 <?php if ($isActive): ?><?php echo $activeClass; ?><?php endif ;?>">
                                    <a href="<?php echo Yii::app()->createUrl('frontEnd/vehicleInspection/admin'); ?>" class="nav-link px-0 align-middle">
                                        <span class="ps-1 d-none d-sm-inline <?php if ($isActive): ?><?php echo $activeTextClass; ?><?php else: ?><?php echo $inactiveTextClass; ?><?php endif ;?>">
                                            Inspeksi Kendaraan
                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                                
                            <?php if (true): ?>
                                <?php $isActive = Yii::app()->controller->id === 'invoice' && (
                                    Yii::app()->controller->action->id === 'admin' || 
                                    Yii::app()->controller->action->id === 'registrationList' || 
                                    Yii::app()->controller->action->id === 'view' || 
                                    Yii::app()->controller->action->id === 'update' || 
                                    Yii::app()->controller->action->id === 'create'
                                ); ?>
                                <li class="w-100 <?php if ($isActive): ?><?php echo $activeClass; ?><?php endif ;?>">
                                    <a href="<?php echo Yii::app()->createUrl('frontEnd/invoice/registrationList'); ?>" class="nav-link px-0 align-middle">
                                        <span class="ps-1 d-none d-sm-inline <?php if ($isActive): ?><?php echo $activeTextClass; ?><?php else: ?><?php echo $inactiveTextClass; ?><?php endif ;?>">
                                            Invoice
                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                                
                            <?php if (true): ?>
                                <?php $isActive = Yii::app()->controller->id === 'cashier' && (
                                    Yii::app()->controller->action->id === 'admin' || 
                                    Yii::app()->controller->action->id === 'memo' || 
                                    Yii::app()->controller->action->id === 'invoiceList' || 
                                    Yii::app()->controller->action->id === 'create' || 
                                    Yii::app()->controller->action->id === 'view'
                                ); ?>
                                <li class="w-100 <?php if ($isActive): ?><?php echo $activeClass; ?><?php endif ;?>">
                                    <a href="<?php echo Yii::app()->createUrl('frontEnd/cashier/invoiceList'); ?>" class="nav-link px-0 align-middle">
                                        <span class="ps-1 d-none d-sm-inline <?php if ($isActive): ?><?php echo $activeTextClass; ?><?php else: ?><?php echo $inactiveTextClass; ?><?php endif ;?>">
                                            Kasir
                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                                
                            <?php if (true): ?>
                                <?php $isActive = Yii::app()->controller->id === 'followUp' && (
                                        Yii::app()->controller->action->id === 'adminSales'
                                ); ?>
                                <li class="w-100 <?php if ($isActive): ?><?php echo $activeClass; ?><?php endif ;?>">
                                    <a href="<?php echo Yii::app()->createUrl('frontEnd/followUp/adminSales'); ?>" class="nav-link px-0 align-middle">
                                        <span class="ps-1 d-none d-sm-inline <?php if ($isActive): ?><?php echo $activeTextClass; ?><?php else: ?><?php echo $inactiveTextClass; ?><?php endif ;?>">
                                            Follow Up Customer
                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                                
                            <?php if (true): ?>
                                <?php $isActive = Yii::app()->controller->id === 'followUp' && (
                                        Yii::app()->controller->action->id === 'adminService'
                                ); ?>
                                <li class="w-100 <?php if ($isActive): ?><?php echo $activeClass; ?><?php endif ;?>">
                                    <a href="<?php echo Yii::app()->createUrl('frontEnd/followUp/adminService'); ?>" class="nav-link px-0 align-middle">
                                        <span class="ps-1 d-none d-sm-inline <?php if ($isActive): ?><?php echo $activeTextClass; ?><?php else: ?><?php echo $inactiveTextClass; ?><?php endif ;?>">
                                            Follow Up Service
                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-auto col-md-9 col-xl-10 py-3">
                <div class="container-fluid">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>