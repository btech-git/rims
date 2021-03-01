<?php

class StockAnalysisController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'check' || 
            $filterChain->action->id === 'detail' || 
            $filterChain->action->id === 'redirectTransaction'
        ) {
            if (!(Yii::app()->user->checkAccess('inventoryHead')) || !(Yii::app()->user->checkAccess('consignmentOutEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        $inventoryDetail = Search::bind(new InventoryDetail(), isset($_GET['InventoryDetail']) ? $_GET['InventoryDetail'] : '');
        $inventoryDetailDataProvider = $inventoryDetail->search();

        $this->render('summary', array(
            'inventoryDetail' => $inventoryDetail,
            'inventoryDetailDataProvider' => $inventoryDetailDataProvider,
        ));
    }
}