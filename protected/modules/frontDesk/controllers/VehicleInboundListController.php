<?php

class VehicleInboundListController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'view' 
        ) {
            if (!(Yii::app()->user->checkAccess('workOrderApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionIndex() {
        $vehicles = Vehicle::model()->findAll(array('condition' => 't.status_location = "Masuk Bengkel"'));
        
        $this->render('index', array(
            'vehicles' => $vehicles,
        ));
    }
}