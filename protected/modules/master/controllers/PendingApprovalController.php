<?php

class PendingApprovalController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('accountingHead')) || !(Yii::app()->user->checkAccess('financeHead')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionIndex() {

        $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : date('Y-m-d');
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : date('Y-m-d');

        $coa = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : '');
        $coaDataProvider = $coa->search();
        $coaDataProvider->criteria->addCondition('t.is_approved = 0');
        
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : '');
        $customerDataProvider = $customer->search();
        $customerDataProvider->criteria->addCondition('t.is_approved = 0');

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : '');
        $supplierDataProvider = $supplier->search();
        $supplierDataProvider->criteria->addCondition('t.is_approved = 0');

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
        $productDataProvider = $product->search();
        $productDataProvider->criteria->addCondition('t.is_approved = 0');

        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');
        $serviceDataProvider = $service->search();
        $serviceDataProvider->criteria->addCondition('t.is_approved = 0');

        $warehouse = Search::bind(new Warehouse('search'), isset($_GET['Warehouse']) ? $_GET['Warehouse'] : '');
        $warehouseDataProvider = $warehouse->search();
        $warehouseDataProvider->criteria->addCondition('t.is_approved = 0');

        $this->render('index', array(
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_sampai' => $tanggal_sampai,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'warehouse' => $warehouse,
            'warehouseDataProvider' => $warehouseDataProvider,
        ));
    }
}
