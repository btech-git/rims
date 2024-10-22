<div class="container">
    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="card border-secondary text-bg-light">
            <div class="card-body">
                <div class="text-center"><strong>RAPERIND</strong> MOTOR</div>
                <br />
                <h5 class="card-title text-center text-primary mb-4">USER LOGIN</h5>
                <?php if (Yii::app()->user->hasFlash('loginMessage')): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php echo CHtml::beginForm(); ?>
                    <div class="input-group mb-3">
                        <div class="input-group-text bg-white">
                            <i class="bi-person-fill"></i>
                        </div>
                        <?php echo CHtml::activeTextField($model, 'username', array('autofocus' => 'autofocus', 'class' => 'form-control border-start-0', 'placeholder' => 'Username')); ?>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-text bg-white">
                            <i class="bi-lock-fill"></i>
                        </div>
                        <?php echo CHtml::activePasswordField($model, 'password', array('class' => 'form-control border-start-0', 'placeholder' => 'Password')) ?>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-text bg-white">
                            <i class="bi-lock-fill"></i>
                        </div>
                        <?php echo CHtml::activeDropDownList($model, 'branchId', CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array(
                            'class' => 'form-control border-start-0', 
                            'empty' => '-- Select Branch --'
                        )); ?>
                    </div>
                    <div class="d-grid">
                        <?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => 'btn btn-primary btn-sm')); ?>
                    </div>
                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
    </div>
</div>