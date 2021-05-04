<?php

class PurchaseController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'view'
                || $filterChain->action->id === 'create'
                || $filterChain->action->id === 'update'
                || $filterChain->action->id === 'admin'
                || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('purchaseCreate') || Yii::app()->user->checkAccess('purchaseEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'admin' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('deleteTransaction')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $purchase = $this->instantiate(null);
        $purchase->header->requester_id = 1; //Yii::app()->user->id;
        $purchase->header->main_branch_id = 1;
        $purchase->header->payment_type = 'Cash';
        $purchase->header->total_quantity =  0;
        $purchase->header->price_before_discount = 0;
        $purchase->header->discount = 0;
        $purchase->header->subtotal = 0;
        $purchase->header->ppn_price = 0;
        $purchase->header->total_price = 0;

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();

        if (isset($_POST['Submit'])) {
            $this->loadState($purchase);
            $purchase->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($purchase->header->purchase_order_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($purchase->header->purchase_order_date)), $purchase->header->main_branch_id);
//            $purchase->header->date_created = date('Y-m-d');
            
            if ($purchase->save(Yii::app()->db)) 
                $this->redirect(array('view', 'id' => $purchase->header->id));
        }

        $this->render('create', array(
            'purchase' => $purchase,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
        ));
    }

    public function actionUpdate($id) {
        $purchase = $this->instantiate($id);
        $purchase->header->setCodeNumberByRevision('purchase_order_no');

        //update filter if one of product, color or category is selected

        $day = Yii::app()->dateFormatter->format('dd', strtotime($purchase->header->purchase_order_date));
        $month = Yii::app()->dateFormatter->format('MM', strtotime($purchase->header->purchase_order_date));
        $year = Yii::app()->dateFormatter->format('y', strtotime($purchase->header->purchase_order_date));

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();

        if (isset($_POST['Submit'])) {

            $this->loadState($purchase);
//            $purchase->header->cn_year = Yii::app()->dateFormatter->format('yy', strtotime($purchase->header->purchase_order_date));
//            $purchase->header->cn_month = Yii::app()->dateFormatter->format('M', strtotime($purchase->header->purchase_order_date));

            if ($purchase->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $purchase->header->id));
        }

        $this->render('update', array(
            'purchase' => $purchase,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
        ));
    }

    public function actionView($id) {
        $purchase = $this->loadModel($id);

        $supplier = $purchase->supplier(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('purchase_header_id', $purchase->id);
        $criteria->compare('t.is_inactive', 0);

        $detailsDataProvider = new CActiveDataProvider('TransactionPurchaseOrderDetail', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => count($purchase->purchaseDetails),
            ),
        ));

//        if (isset($_POST['Submit']) && (int) $purchase->is_approved !== 1) {
//            $purchase->is_approved = 1;
//            $purchase->admin_id_approval =  Yii::app()->user->id;
//            $purchase->date_approval = date('Y-m-d');
//            if ($purchase->save())
//                Yii::app()->user->setFlash('confirm', 'Your Purchase has been confirmed!!!');
//            else
//                Yii::app()->user->setFlash('confirm', 'Purchase failed to confirmed!!!');
//
//            $this->refresh();
//        }

        $this->render('view', array(
            'purchase' => $purchase,
            'supplier' => $supplier,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        $this->layout = '//layouts/memo';
        $purchase = $this->loadModel($id);

        $this->render('memo', array(
            'purchase' => $purchase,
        ));
    }

    public function actionAdmin() {
        $purchase = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : array());
        $date = (isset($_GET['Date'])) ? $_GET['Date'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $purchase->resetScope()->search();
        $dataProvider->criteria->with = array('supplier:resetScope');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';

        if ($startDate != '' || $endDate != '') {
            $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
            $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

            $dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        }

        $supplierCompany = (isset($_GET['TransactionPurchaseOrder']['supplierCompany'])) ? $_GET['TransactionPurchaseOrder']['supplierCompany'] : '';
        if (!empty($supplierCompany)) {
            $dataProvider->criteria->with = array('supplier:resetScope');
            $dataProvider->criteria->compare('supplier.id', $supplierCompany);
        }

        if (!empty($date))
            $dataProvider->criteria->compare('t.purchase_order_date', $date, TRUE);

        $this->render('admin', array(
            'purchase' => $purchase,
            'dataProvider' => $dataProvider,
            'date' => $date,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->instantiate($id);

            if ($model->header->purchaseReturnHeaders != NULL || $model->header->receiveHeaders != NULL) {
                Yii::app()->user->setFlash('message', 'Cannot DELETE this transaction');
            } else {
                
                foreach ($model->details as $detail) 
                    $detail->delete();
                
                $model->header->delete();

            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxJsonSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplierId = (isset($_POST['TransactionPurchaseOrder']['supplier_id'])) ? $_POST['TransactionPurchaseOrder']['supplier_id'] : '';

            $supplier = Supplier::model()->findByPk($supplierId);

            $object = array(
                'supplier_id' => CHtml::value($supplier, 'id'),
                'supplier_name' => CHtml::value($supplier, 'name'),
                'supplier_company' => CHtml::value($supplier, 'company'),
                'supplier_address' => CHtml::value($supplier, 'address'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $unitPrice = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->details[$index], 'unit_price')));
            $total = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->details[$index], 'total')));
            $subTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->subTotal));
            $totalQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchase->totalQuantity));
//            $discountAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->getDiscountAmount()));
//            $taxPercentage = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->getTaxPercentage()));
//            $taxValue = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->getCalculatedTax()));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->getGrandTotal()));
            $taxValue = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->getCalculatedTax()));

            echo CJSON::encode(array(
                'unitPrice' => $unitPrice,
                'total' => $total,
                'subTotal' => $subTotal,
                'totalQuantity' => $totalQuantity,
                'grandTotal' => $grandTotal,
                'taxValue' => $taxValue,
//                'discountPercentage' => $discountPercentage,
//                'discountAmount' => $discountAmount,
//                'taxPercentage' => $taxPercentage,
            ));
        }
    }

    public function actionAjaxJsonTaxTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $discountAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->header->discount_value));
            $taxPercentage = CHtml::encode($purchase->getTaxPercentage());
            $taxValue = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->getCalculatedTax()));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->getGrandTotal()));

            if ($purchase->header->downpayment_percentage > 0)
                $purchase->header->downpayment_value = $purchase->getGrandTotal() * $purchase->header->downpayment_percentage / 100;

            $downPaymentValue = CHtml::activeTextField($purchase->header, "downpayment_value", array('size' => 10, 'maxLength' => 20,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonDownPaymentPercentage', array('id' => $purchase->header->id)),
                            'success' => 'function(data) {
                                                $("#downPaymentPercentage").html(data.downPaymentPercentage);
                                            }',
                        )),
                    ));

            echo CJSON::encode(array(
                'discountAmount' => $discountAmount,
                'taxPercentage' => $taxPercentage,
                'taxValue' => $taxValue,
                'grandTotal' => $grandTotal,
                'downPaymentValue' => $downPaymentValue
            ));
        }
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);
            $this->loadState($purchase);

            if (isset($_POST['ProductId']))
                $purchase->addDetail($_POST['ProductId']);

            $this->renderPartial('_detail', array(
                'purchase' => $purchase,
            ));
        }
    }

    public function actionAjaxHtmlRemoveProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $purchase->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'purchase' => $purchase,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProducts($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $this->renderPartial('_detail', array(
                'purchase' => $purchase,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $purchase = new Purchase(new TransactionPurchaseOrder(), array());
        else {
            $purchaseHeader = $this->loadModel($id);
            $purchase = new Purchase($purchaseHeader, $purchaseHeader->transactionPurchaseOrderDetails);
        }

        return $purchase;
    }

    public function loadModel($id) {
        $model = TransactionPurchaseOrder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($purchase) {
        if (isset($_POST['TransactionPurchaseOrder'])) {
            $purchase->header->attributes = $_POST['TransactionPurchaseOrder'];
        }
        if (isset($_POST['TransactionPurchaseOrderDetail'])) {
            foreach ($_POST['TransactionPurchaseOrderDetail'] as $i => $item) {
                if (isset($purchase->details[$i]))
                    $purchase->details[$i]->attributes = $item;
                else {
                    $detail = new TransactionPurchaseOrderDetail();
                    $detail->attributes = $item;
                    $purchase->details[] = $detail;
                }
            }
            if (count($_POST['TransactionPurchaseOrderDetail']) < count($purchase->details))
                array_splice($purchase->details, $i + 1);
        }
        else
            $purchase->details = array();
    }

    public function actionAjaxJsonDiscountValue($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $purchase->header->discount_value = $purchase->getSubTotal() * $purchase->header->discount_percentage / 100;

            $discountValue = CHtml::activeTextField($purchase->header, "discount_value", array('size' => 10, 'maxLength' => 20,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonDiscountPercentage', array('id' => $purchase->header->id)),
                            'success' => 'function(data) {
                                                $("#discountPercentage").html(data.discountPercentage);
                                                $("#taxValue").html(data.taxValue);
                                                $("#grand_total").html(data.grandTotal);
                                            }',
                        )),
                    ));

            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->getGrandTotal()));
            $taxValue = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->getCalculatedTax()));

            echo CJSON::encode(array(
                'grandTotal' => $grandTotal,
                'taxValue' => $taxValue,
                'discountValue' => $discountValue,
            ));
        }
    }

    public function actionAjaxJsonDiscountPercentage($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);
            $this->loadState($purchase);

            $purchase->header->discount_percentage = $purchase->header->discount_value / $purchase->getSubTotal() * 100;

            $discountPercentage = CHtml::activeTextField($purchase->header, "discount_percentage", array('size' => 1, 'maxLength' => 20,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonDiscountValue', array('id' => $purchase->header->id)),
                            'success' => 'function(data) {
                                               $("#discountValue").html(data.discountValue);
                                                $("#taxValue").html(data.taxValue);
                                                $("#grand_total").html(data.grandTotal);
                                            }',
                        )),
                    ));

            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->getGrandTotal()));
            $taxValue = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->getCalculatedTax()));

            echo CJSON::encode(array(
                'grandTotal' => $grandTotal,
                'taxValue' => $taxValue,
                'discountPercentage' => $discountPercentage,
            ));
        }
    }

    public function actionAjaxJsonDownPaymentValue($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $purchase->header->downpayment_value = $purchase->getGrandTotal() * $purchase->header->downpayment_percentage / 100;

            $downPaymentValue = CHtml::activeTextField($purchase->header, "downpayment_value", array('size' => 10, 'maxLength' => 20,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonDownPaymentPercentage', array('id' => $purchase->header->id)),
                            'success' => 'function(data) {
                                                $("#downPaymentPecentage").html(data.downPaymentPecentage);
                                             
                                            }',
                        )),
                    ));
            echo CJSON::encode(array(
                'downPaymentValue' => $downPaymentValue,
            ));
        }
    }

    public function actionAjaxJsonDownPaymentPercentage($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);
            $this->loadState($purchase);

            $purchase->header->downpayment_percentage = $purchase->header->downpayment_value / $purchase->getGrandTotal() * 100;

            $downPaymentPercentage = CHtml::activeTextField($purchase->header, "downpayment_percentage", array('size' => 1, 'maxLength' => 20,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonDownPayemtnValue', array('id' => $purchase->header->id)),
                            'success' => 'function(data) {
                                               $("#downPaymentValue").html(data.downPaymentValue);
                                            }',
                        )),
                    ));



            echo CJSON::encode(array(
                'downPaymentPercentage' => $downPaymentPercentage,
            ));
        }
    }

}
