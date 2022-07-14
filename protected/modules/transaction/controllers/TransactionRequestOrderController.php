<?php

class TransactionRequestOrderController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('requestOrderCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('requestOrderEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('requestOrderApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if (
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'showProduct' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'view'
        ) {
            if (
                !(Yii::app()->user->checkAccess('requestOrderCreate')) || 
                !(Yii::app()->user->checkAccess('requestOrderEdit')) || 
                !(Yii::app()->user->checkAccess('requestOrderApproval'))
            ) {
                $this->redirect(array('/site/login'));
            }
        }
        
        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->layout = '//layouts/column1';

        $requestDetails = TransactionRequestOrderDetail::model()->findAllByAttributes(array('request_order_id' => $id));
        //$requestTransfers = TransactionRequestTransfer::model()->findAllByAttributes(array('request_order_id'=>$id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            //'requestTransfers'=>$requestTransfers,
            'requestDetails' => $requestDetails,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //$model=new TransactionRequestOrder;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // $product = new Product('search');
        // $product->unsetAttributes();  // clear any default values
        // if (isset($_GET['Product']))
        // $product->attributes = $_GET['Product'];

        // $productCriteria = new CDbCriteria;
        // $productCriteria->compare('name',$product->name,true);
        // $productCriteria->together=true;
        // $productCriteria->with = array('productSubMasterCategory','productMasterCategory');
        // $productCriteria->compare('productMasterCategory.name',$product->product_master_category_name == NULL ? $product->product_master_category_name : $product->product_master_category_name , true);
        // $productCriteria->compare('productSubMasterCategory.name',$product->product_sub_master_category_name == NULL ? $product->product_sub_master_category_name : $product->product_sub_master_category_name , true);
        // $productCriteria->compare('productSubCategory.name',$product->product_sub_category_name == NULL ? $product->product_sub_category_name : $product->product_sub_category_name , true);

        // 	$productDataProvider = new CActiveDataProvider('Product', array(
        //   	'criteria'=>$productCriteria,
        // 	));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('t.id', $product->id);
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('t.manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->together = true;
        $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.company as product_supplier';
        $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
//        $productCriteria->group = 't.id';
        $productCriteria->distinct = true;
        $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
        $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
        $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
        $productCriteria->compare('rims_supplier.company', $product->product_supplier, true);
        $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);

        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria
        ));

        $supplier = new Supplier('search');
        $supplier->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier'])) {
            $supplier->attributes = $_GET['Supplier'];
        }

        $supplierCriteria = new CDbCriteria;
        $supplierCriteria->compare('t.name', $supplier->name, true);
        $supplierCriteria->compare('t.company', $supplier->company, true);

        $supplierCriteria->select = 't.*,rims_supplier_product.supplier_id, rims_product.name as product_name';
        $supplierCriteria->join = 'LEFT OUTER JOIN `rims_supplier_product`ON t.id = rims_supplier_product.supplier_id LEFT OUTER JOIN `rims_product`ON rims_supplier_product.product_id = rims_product.id ';

        $supplierCriteria->compare('rims_product.name ', $supplier->product_name, true);

        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
            'criteria' => $supplierCriteria,
        ));

        $price = new ProductPrice('search');
        $price->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductPrice'])) {
            $price->attributes = $_GET['ProductPrice'];
        }

        $priceCriteria = new CDbCriteria;

        $priceCriteria->compare('product_id', $price->product_id);
        $priceCriteria->compare('supplier_id', $price->supplier_id);
        $priceCriteria->with = array('product', 'supplier');
        $priceCriteria->together = true;
        $priceCriteria->compare('product.name', $price->product_name, true);
        $priceCriteria->compare('supplier.name', $price->supplier_name, true);
        $priceDataProvider = new CActiveDataProvider('ProductPrice', array(
            'criteria' => $priceCriteria,
        ));

        $requestOrder = $this->instantiate(null);
        $requestOrder->header->requester_branch_id = $requestOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $requestOrder->header->requester_branch_id;
        $requestOrder->header->request_order_date = date('Y-m-d H:i:s');
//        $requestOrder->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($requestOrder->header->request_order_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($requestOrder->header->request_order_date)), $requestOrder->header->requester_branch_id);
        $this->performAjaxValidation($requestOrder->header);

        if (isset($_POST['Cancel'])) 
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionRequestOrder'])) {
            $this->loadState($requestOrder);
            $requestOrder->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($requestOrder->header->request_order_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($requestOrder->header->request_order_date)), $requestOrder->header->requester_branch_id);

            if ($requestOrder->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $requestOrder->header->id));
            }
        }

        $this->render('create', array(
            'requestOrder' => $requestOrder,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'price' => $price,
            'priceDataProvider' => $priceDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        //$model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->together = true;
        //$productCriteria->with = array('productSubMasterCategory','productMasterCategory','brand');
        // $productCriteria->with = array('productPrices');
        // $productCriteria->compare('productMasterCategory.name',$product->product_master_category_name == NULL ? $product->product_master_category_name : $product->product_master_category_name , true);
        // $productCriteria->compare('productSubMasterCategory.name',$product->product_sub_master_category_name == NULL ? $product->product_sub_master_category_name : $product->product_sub_master_category_name , true);
        // $productCriteria->compare('productSubCategory.name',$product->product_sub_category_name == NULL ? $product->product_sub_category_name : $product->product_sub_category_name , true);
        // $productCriteria->compare('brand.name',$product->product_brand_name == NULL ? $product->product_brand_name : $product->product_brand_name , true);
        $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
        $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
        $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
        $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,
            true);
        $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
        $productCriteria->compare('rims_supplier.name', $product->product_supplier, true);
        $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
        // $productCriteria->join = '';
        //$productCriteria->with = array('productSubMasterCategory','productMasterCategory','brand');

        // $productCriteria->compare('productPrices.purchase_price',$product->product_purchase_price == NULL ? $product->product_purchase_price : $product->product_purchase_price , true);

        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));


        // $supplier = new SupplierProductView('search');
        //     	$supplier->unsetAttributes();  // clear any default values
        //     	if (isset($_GET['SupplierProductView']))
        //       	$supplier->attributes = $_GET['SupplierProductView'];

        // $supplierCriteria = new CDbCriteria;
        // $supplierCriteria->compare('name',$supplier->name,true);
        // $supplierCriteria->compare('product',$supplier->product,true);

        // 	$supplierDataProvider = new CActiveDataProvider('SupplierProductView', array(
        //   	'criteria'=>$supplierCriteria,
        // 	));
        $supplier = new Supplier('search');
        $supplier->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier'])) {
            $supplier->attributes = $_GET['Supplier'];
        }

        $supplierCriteria = new CDbCriteria;
        $supplierCriteria->compare('t.name', $supplier->name, true);
        $supplierCriteria->compare('t.company', $supplier->company, true);

        $supplierCriteria->select = 't.*,rims_supplier_product.supplier_id, rims_product.name as product_name';
        $supplierCriteria->join = 'LEFT OUTER JOIN `rims_supplier_product`ON t.id = rims_supplier_product.supplier_id LEFT OUTER JOIN `rims_product`ON rims_supplier_product.product_id = rims_product.id ';
        $supplierCriteria->compare('rims_product.name ', $supplier->product_name, true);


        //$supplierCriteria->compare('product',$supplier->product,true);
        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
            'criteria' => $supplierCriteria,
        ));

        $price = new ProductPrice('search');
        $price->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductPrice'])) {
            $price->attributes = $_GET['ProductPrice'];
        }

        $priceCriteria = new CDbCriteria;
        $priceCriteria->compare('product_id', $price->product_id);
        $priceCriteria->compare('supplier_id', $price->supplier_id);
        $priceCriteria->with = array('product', 'supplier');
        $priceCriteria->together = true;
        $priceCriteria->compare('product.name', $price->product_name, true);
        $priceCriteria->compare('supplier.name', $price->supplier_name, true);
        $priceDataProvider = new CActiveDataProvider('ProductPrice', array(
            'criteria' => $priceCriteria,
        ));


        $requestOrder = $this->instantiate($id);
        $requestOrder->header->setCodeNumberByRevision('request_order_no');

        $this->performAjaxValidation($requestOrder->header);

        if (isset($_POST['Cancel'])) 
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionRequestOrder'])) {
            // $model->attributes=$_POST['TransactionRequestOrder'];
            // if($model->save())
            // 	$this->redirect(array('view','id'=>$model->id));

            $this->loadState($requestOrder);
            if ($requestOrder->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $requestOrder->header->id));
            } else {
                foreach ($requestOrder->details as $detail) {
                    echo $detail->quantity;
                }
            }

        }

        $this->render('update', array(
            'requestOrder' => $requestOrder,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'price' => $price,
            'priceDataProvider' => $priceDataProvider,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }
    
    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $requestOrder = $this->instantiate($id);

            $this->loadState($requestOrder);

            $discount1Nominal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($requestOrder->details[$index], 'discount1Amount')));
            $discount2Nominal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($requestOrder->details[$index], 'discount2Amount')));
            $discount3Nominal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($requestOrder->details[$index], 'discount3Amount')));
            $discount4Nominal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($requestOrder->details[$index], 'discount4Amount')));
            $discount5Nominal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($requestOrder->details[$index], 'discount5Amount')));
            $priceAfterDiscount1 = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($requestOrder->details[$index], 'unitPriceAfterDiscount1')));
            $priceAfterDiscount2 = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($requestOrder->details[$index], 'unitPriceAfterDiscount2')));
            $priceAfterDiscount3 = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($requestOrder->details[$index], 'unitPriceAfterDiscount3')));
            $priceAfterDiscount4 = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($requestOrder->details[$index], 'unitPriceAfterDiscount4')));
            $priceAfterDiscount5 = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($requestOrder->details[$index], 'unitPriceAfterDiscount5')));
            $unitPriceAfterDiscount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($requestOrder->details[$index], 'unitPrice')));
            $totalQuantityDetail = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($requestOrder->details[$index], 'quantityAfterBonus')));
            $subTotalDetail = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($requestOrder->details[$index], 'subTotal')));
            $subTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $requestOrder->subTotal));
            $totalQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $requestOrder->totalQuantity));

            echo CJSON::encode(array(
                'discount1Nominal' => $discount1Nominal,
                'discount2Nominal' => $discount2Nominal,
                'discount3Nominal' => $discount3Nominal,
                'discount4Nominal' => $discount4Nominal,
                'discount5Nominal' => $discount5Nominal,
                'priceAfterDiscount1' => $priceAfterDiscount1,
                'priceAfterDiscount2' => $priceAfterDiscount2,
                'priceAfterDiscount3' => $priceAfterDiscount3,
                'priceAfterDiscount4' => $priceAfterDiscount4,
                'priceAfterDiscount5' => $priceAfterDiscount5,
                'totalQuantityDetail' => $totalQuantityDetail,
                'unitPriceAfterDiscount' => $unitPriceAfterDiscount,
                'subTotalDetail' => $subTotalDetail,
                'subTotal' => $subTotal,
                'totalQuantity' => $totalQuantity,
            ));
        }
    }

    public function actionAjaxSupplier($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            //$requestOrder = $this->instantiate($id);
            $supplier = Supplier::model()->findByPk($id);
            $tanggal = empty($_POST['TransactionRequestOrder']['request_order_date']) ? date('Y-m-d') : $_POST['TransactionRequestOrder']['request_order_date'];
            $tanggal_jatuh_tempo = date('Y-m-d', strtotime($tanggal . '+' . $supplier->tenor . ' days'));
            $paymentEstimation = $tanggal_jatuh_tempo;
            //$supplier = Supplier::model()->findByPk($productPrice->supplier_id);

            $object = array(
                //'id'=>$supplier->id,
                'name' => $supplier->company,
                'paymentEstimation' => $paymentEstimation,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxPrice($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $price = ProductPrice::model()->findByPk($id);
            //$supplier = Supplier::model()->findByPk($productPrice->supplier_id);

            $object = array(
                //'id'=>$supplier->id,
                'price' => $price->purchase_price,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxProduct($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Product::model()->findByPk($id);
            $unitName = Unit::model()->findByPk($product->unit_id)->name;
//            $productUnit = ProductUnit::model()->findByAttributes(array(
//                'product_id' => $product->id,
//                'unit_type' => 'Main'
//            ));
//            if (count($productUnit) != 0) {
//                $unit = $productUnit->unit_id;
//            }

            $object = array(
                'id' => $product->id,
                'name' => $product->name,
                'retail_price' => $product->retail_price,
                'unit' => $product->unit_id,
                'unit_name' => $unitName,
                'code' => $product->manufacturer_code,
                'category' => $product->masterSubCategoryCode,
                'brand' => $product->brand->name,
                'sub_brand' => $product->subBrand->name,
                'sub_brand_series' => $product->subBrandSeries->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxGetSupplier($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Product::model()->findByPk($id);
            $supplier = ProductPrice::model()->findByPk($product->product_id);

            $object = array(
                'id' => $supplier->id,
                ''
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxGetPrice($quantity, $retail)
    {

        $price = $quantity * $retail;
        $object = array(
            'price' => $price,
        );
        echo CJSON::encode($object);
    }

    public function actionAjaxGetSubtotal(
        $step,
        $disc1type,
        $disc1nom,
        $disc2type,
        $disc2nom,
        $disc3type,
        $disc3nom,
        $disc4type,
        $disc4nom,
        $disc5type,
        $disc5nom,
        $quantity,
        $retail
    ) {
        $price = $quantity * $retail;
        $discount = 0;
        $subtotal1 = 0;
        $subtotal2 = 0;
        $subtotal3 = 0;
        $subtotal4 = 0;
        $subtotal5 = 0;
        $subtotal = 0;
        $newquantity = 0;
        $totalquantity = 0;
        $newPrice = 0;


        switch ($step) {
            case 1:
                if ($disc1type == 1) {
                    $discount = ($price * $disc1nom / 100);
                    $subtotal1 = $price - $discount;
                    $totalquantity = $quantity;

                } else {
                    if ($disc1type == 2) {
                        $subtotal1 = $price - $disc1nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc1nom;
                        $retail = $price / $newquantity;
                        $subtotal1 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                $newPrice = $subtotal1 / $quantity;
                $subtotal = $subtotal1;
                break;

            case 2:
                if ($disc1type == 1) {
                    $discount = ($price * $disc1nom / 100);
                    $subtotal1 = $price - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc1type == 2) {
                        $subtotal1 = $price - $disc1nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc1nom;
                        $retail = $price / $newquantity;
                        $subtotal1 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc2type == 1) {
                    $discount = ($subtotal1 * $disc2nom / 100);
                    $subtotal2 = $subtotal1 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc2type == 2) {
                        $subtotal2 = $subtotal1 - $disc2nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc2nom;
                        $retail = $subtotal1 / $newquantity;
                        $subtotal2 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                $newPrice = $subtotal2 / $quantity;
                $subtotal = $subtotal2;
                break;
            case 3:
                if ($disc1type == 1) {
                    $discount = ($price * $disc1nom / 100);
                    $subtotal1 = $price - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc1type == 2) {
                        $subtotal1 = $price - $disc1nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc1nom;
                        //$retail = $price / $newquantity;
                        $subtotal1 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc2type == 1) {
                    $discount = ($subtotal1 * $disc2nom / 100);
                    $subtotal2 = $subtotal1 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc2type == 2) {
                        $subtotal2 = $subtotal1 - $disc2nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc2nom;
                        //$retail = $subtotal1 / $newquantity;
                        $subtotal2 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc3type == 1) {
                    $discount = ($subtotal2 * $disc3nom / 100);
                    $subtotal3 = $subtotal2 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc3type == 2) {
                        $subtotal3 = $subtotal2 - $disc3nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc3nom;
                        //$retail = $subtotal2 / $newquantity;
                        $subtotal3 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                $newPrice = $subtotal3 / $quantity;
                $subtotal = $subtotal3;
                break;
            case 4:
                if ($disc1type == 1) {
                    $discount = ($price * $disc1nom / 100);
                    $subtotal1 = $price - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc1type == 2) {
                        $subtotal1 = $price - $disc1nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc1nom;
                        //$retail = $price / $newquantity;
                        $subtotal1 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc2type == 1) {
                    $discount = ($subtotal1 * $disc2nom / 100);
                    $subtotal2 = $subtotal1 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc2type == 2) {
                        $subtotal2 = $subtotal1 - $disc2nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc2nom;
                        //$retail = $subtotal1 / $newquantity;
                        $subtotal2 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc3type == 1) {
                    $discount = ($subtotal2 * $disc3nom / 100);
                    $subtotal3 = $subtotal2 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc3type == 2) {
                        $subtotal3 = $subtotal2 - $disc3nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc3nom;
                        //$retail = $subtotal2 / $newquantity;
                        $subtotal3 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                if ($disc4type == 1) {
                    $discount = ($subtotal3 * $disc4nom / 100);
                    $subtotal4 = $subtotal3 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc4type == 2) {
                        $subtotal4 = $subtotal3 - $disc4nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc4nom;
                        //$retail = $subtotal3 / $newquantity;
                        $subtotal4 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                $newPrice = $subtotal4 / $quantity;
                $subtotal = $subtotal4;
                break;
            case 5 :
                if ($disc1type == 1) {
                    $discount = ($price * $disc1nom / 100);
                    $subtotal1 = $price - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc1type == 2) {
                        $subtotal1 = $price - $disc1nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc1nom;
                        //$retail = $price / $newquantity;
                        $subtotal1 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc2type == 1) {
                    $discount = ($subtotal1 * $disc2nom / 100);
                    $subtotal2 = $subtotal1 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc2type == 2) {
                        $subtotal2 = $subtotal1 - $disc2nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc2nom;
                        //$retail = $subtotal1 / $newquantity;
                        $subtotal2 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc3type == 1) {
                    $discount = ($subtotal2 * $disc3nom / 100);
                    $subtotal3 = $subtotal2 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc3type == 2) {
                        $subtotal3 = $subtotal2 - $disc3nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc3nom;
                        //$retail = $subtotal2 / $newquantity;
                        $subtotal3 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                if ($disc4type == 1) {
                    $discount = ($subtotal3 * $disc4nom / 100);
                    $subtotal4 = $subtotal3 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc4type == 2) {
                        $subtotal4 = $subtotal3 - $disc4nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc4nom;
                        //$retail = $subtotal3 / $newquantity;
                        $subtotal4 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                if ($disc5type == 1) {
                    $discount = ($subtotal4 * $disc5nom / 100);
                    $subtotal5 = $subtotal4 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc5type == 2) {
                        $subtotal5 = $subtotal4 - $disc5nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc5nom;
                        //$retail = $subtotal4 / $newquantity;
                        $subtotal5 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                $newPrice = $subtotal5 / $quantity;
                $subtotal = $subtotal5;
                break;

            default:
                $subtotal = $quantity * $price;
                $newPrice = $subtotal / $quantity;
                $totalquantity = $quantity;
                break;


        }
        $object = array(
            'step' => $step,
            'disc1type' => $disc1type,
            'disc1nom' => $disc1nom,
            'disc2type' => $disc2type,
            'disc2nom' => $disc2nom,
            'subtotal' => $subtotal,
            'subtotal1' => $subtotal1,
            'subtotal2' => $subtotal2,
            'subtotal3' => $subtotal3,
            'subtotal4' => $subtotal4,
            'subtotal5' => $subtotal5,
            'retail' => $retail,
            'newPrice' => $newPrice,
            'totalquantity' => $totalquantity,
        );

        echo CJSON::encode($object);

    }

    public function actionAjaxGetTotal($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $requestOrder = $this->instantiate($id);
            $this->loadState($requestOrder);
            //$requestType =$requestOrder->header->request_type;
            $total = 0;
            $totalItems = 0;
            // if($requestType == 'Request for Purchase'){
            // 	foreach ($requestOrder->details as $key => $detail) {
            // 		$totalItems += $detail->total;
            // 		$total += $detail->subtotal;_quantity;
            // 	}
            // } else if($requestType == 'Request for Transfer'){
            // 	foreach ($requestOrder->transferDetails as $key => $transferDetail) {
            // 		$totalItems += $transferDetail->quantity;
            // 	}
            // }
            foreach ($requestOrder->details as $key => $detail) {
                $totalItems += $detail->total_quantity;
                $total += $detail->total_price;
            }
            $object = array('total' => $total, 'totalItems' => $totalItems);
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxCountAmount($discountType, $discountAmount, $retail, $quantity)
    {
        $price = $quantity * $retail;
        $discount = 0;

        $subtotal = 0;
        $newquantity = 0;
        $totalquantity = 0;
        $newPrice = 0;
        switch ($discountType) {
            case 1:
                $discount = ($price * $discountAmount / 100);
                $subtotal = $price - $discount;
                $totalquantity = $quantity;
                break;
            case 2:
                $subtotal = $price - $discountAmount;
                $totalquantity = $quantity;
                break;
            case 3:
                $newquantity = $quantity + $discountAmount;
                // $retail = $price / $newquantity;
                // $subtotal= $retail * $quantity;
                $subtotal = $price;
                $totalquantity = $newquantity;
                break;

        }
        $newPrice = $subtotal / $quantity;
        $object = array(
            'subtotal' => $subtotal,
            'totalquantity' => $totalquantity,
            'newPrice' => $newPrice,
        );
        echo CJSON::encode($object);
    }

    public function actionAjaxCountAmountStep($discountType, $discountAmount, $retail, $quantity, $price)
    {

        $discount = 0;

        $subtotal = 0;
        $newquantity = 0;
        $totalquantity = 0;
        $newPrice = 0;
        switch ($discountType) {
            case 1:
                $discount = ($price * $discountAmount / 100);
                $subtotal = $price - $discount;
                $totalquantity = $quantity;
                break;
            case 2:
                $subtotal = $price - $discountAmount;
                $totalquantity = $quantity;
                break;
            case 3:
                $newquantity = $quantity + $discountAmount;
                // $retail = $price / $newquantity;
                // $subtotal= $retail * $quantity;
                $subtotal = $price;
                $totalquantity = $newquantity;
                break;

        }
        $newPrice = $subtotal / $quantity;
        $object = array(
            'subtotal' => $subtotal,
            'totalquantity' => $totalquantity,
            'newPrice' => $newPrice,
        );
        echo CJSON::encode($object);
    }

    public function actionAjaxCountTotal($totalquantity, $totalprice)
    {
        $unitprice = $totalprice / $totalquantity;
        //$unitprice = 20/5;
        $object = array('unitprice' => $unitprice);
        echo CJSON::encode($object);
    }

    public function actionAjaxCountTotalNonDiscount($totalquantity, $totalprice)
    {
        $price = $totalprice * $totalquantity;
        $unitprice = $totalprice;
        $object = array('unitprice' => $unitprice, 'price' => $price);
        echo CJSON::encode($object);
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('TransactionRequestOrder');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id)
    {

        // var_dump($id); //die("S");
        if (Yii::app()->request->isAjaxRequest) {
            $requestOrder = $this->instantiate($id);
            $this->loadState($requestOrder);
            // $product = new ProductSupplierView('search');
            //     	$product->unsetAttributes();  // clear any default values
            //     	if (isset($_GET['ProductSupplierView']))
            //       	$product->attributes = $_GET['ProductSupplierView'];
            //   $productCriteria = new CDbCriteria;
            //   $productCriteria->compare('id',$product->id);
            //   $productCriteria->compare('name',$product->name,true);
            //   $productCriteria->compare('supplier',$product->supplier,true);
            //   $productCriteria->compare('subCategory',$product->subCategory,true);
            //   $productCriteria->compare('masterCategory',$product->masterCategory,true);
            //   $productCriteria->compare('subMaster',$product->subMaster,true);
            //   $productCriteria->compare('manufacturer_code',$product->manufacturer_code,true);
            //   $productCriteria->compare('brand',$product->brand,true);


            // 	$productDataProvider = new CActiveDataProvider('ProductSupplierView', array(
            //   	'criteria'=>$productCriteria,
            // 	));
            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }


            // $supplier = new SupplierProductView('search');
            //     	$supplier->unsetAttributes();  // clear any default values
            //     	if (isset($_GET['SupplierProductView']))
            //       	$supplier->attributes = $_GET['SupplierProductView'];

            // $supplierCriteria = new CDbCriteria;
            // $supplierCriteria->compare('name',$supplier->name,true);
            // $supplierCriteria->compare('product',$supplier->product,true);

            // 	$supplierDataProvider = new CActiveDataProvider('SupplierProductView', array(
            //   	'criteria'=>$supplierCriteria,
            // 	));
            $supplier = new Supplier('search');
            $supplier->unsetAttributes();  // clear any default values
            if (isset($_GET['Supplier'])) {
                $supplier->attributes = $_GET['Supplier'];
            }

            $price = new ProductPrice('search');
            $price->unsetAttributes();  // clear any default values
            if (isset($_GET['ProductPrice'])) {
                $price->attributes = $_GET['ProductPrice'];
            }

            $priceCriteria = new CDbCriteria;
            $priceCriteria->compare('product_id', $price->product_id);
            $priceCriteria->compare('supplier_id', $price->supplier_id);
            $priceCriteria->with = array('product', 'supplier');
            $priceCriteria->together = true;
            $priceCriteria->compare('product.name', $price->product_name, true);
            $priceCriteria->compare('supplier.name', $price->supplier_name, true);
            $priceDataProvider = new CActiveDataProvider('ProductPrice', array(
                'criteria' => $priceCriteria,
            ));

            $requestOrder->addDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailRequestOrder_alt', array(
                'requestOrder' => $requestOrder,
                'supplier' => $supplier,
                'product' => $product,
                'price' => $price,
                'priceDataProvider' => $priceDataProvider,
            ), false, true);
        }
    }

    // public function actionAjaxHtmlAddDetailApproval($id)
    // {
    // 	if (Yii::app()->request->isAjaxRequest)
    // 	{
    // 		$requestOrder = $this->instantiate($id);
    // 		$this->loadState($requestOrder);
    // 		$requestOrderDetail = $requestOrder->details;

    // 		$product = new Product('search');
    //       	$product->unsetAttributes();  // clear any default values
    //       	if (isset($_GET['Product']))
    //         	$product->attributes = $_GET['Product'];

    // 		$productCriteria = new CDbCriteria;
    // 		$productCriteria->compare('name',$product->name,true);
    // 		$productCriteria->compare('manufacturer_code',$product->manufacturer_code,true);
    // 		$productCriteria->together=true;

    // 		$productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
    // 		$productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
    // 		$productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,true);
    // 		$productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,true);
    // 		$productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name,true);
    // 		$productCriteria->compare('rims_supplier.name', $product->product_supplier,true);
    // 		$productCriteria->compare('rims_brand.name', $product->product_brand_name,true);


    //   	$productDataProvider = new CActiveDataProvider('Product', array(
    //     	'criteria'=>$productCriteria,));


    //   	$supplier = new Supplier('search');
    //   		$supplier->unsetAttributes();  // clear any default values
    //       	if (isset($_GET['Supplier']))
    //         	$supplier->attributes = $_GET['Supplier'];

    //   	$supplierCriteria = new CDbCriteria;
    // 		$supplierCriteria->compare('name',$supplier->name,true);

    // 		$supplierCriteria->select = 't.*,rims_supplier_product.supplier_id, rims_product.name as product_name';
    // 		$supplierCriteria->join = 'LEFT OUTER JOIN `rims_supplier_product`ON t.id = rims_supplier_product.supplier_id LEFT OUTER JOIN `rims_product`ON rims_supplier_product.product_id = rims_product.id ';
    // 		$supplierCriteria->compare('rims_product.name ',$supplier->product_name,true);


    // 		//$supplierCriteria->compare('product',$supplier->product,true);
    // 		$supplierDataProvider = new CActiveDataProvider('Supplier', array(
    //    		'criteria'=>$supplierCriteria,
    //  		));

    //   	$price = new ProductPrice('search');
    //       	$price->unsetAttributes();  // clear any default values
    //       	if (isset($_GET['ProductPrice']))
    //         	$price->attributes = $_GET['ProductPrice'];

    //     $priceCriteria = new CDbCriteria;
    //     $priceCriteria->compare('product_id',$price->product_id);
    //     $priceCriteria->compare('supplier_id',$price->supplier_id);
    //     $priceCriteria->with = array('product','supplier');
    //    	$priceCriteria->together = true;
    //     $priceCriteria->compare('product.name',$price->product_name,true);
    //     $priceCriteria->compare('supplier.name',$price->supplier_name,true);
    // 		$priceDataProvider = new CActiveDataProvider('ProductPrice', array(
    //     	'criteria'=>$priceCriteria,
    //   	));

    // 		$requestOrder->addDetailApproval();
    // 		Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
    //   			Yii::app()->clientscript->scriptMap['jquery.js'] = false;
    //      $this->renderPartial('_detailRequestOrder', array('requestOrder'=>$requestOrder,
    //      	'supplier'=>$supplier,
    //      	'supplierDataProvider'=>$supplierDataProvider,
    //      	'product'=>$product,
    //      	'productDataProvider'=>$productDataProvider,
    //      	'price'=>$price,
    //      	'priceDataProvider'=>$priceDataProvider,
    //      	), false, true);
    // 	}
    // }

    //Delete Detail
    public function actionAjaxHtmlRemoveDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $requestOrder = $this->instantiate($id);
            $this->loadState($requestOrder);


            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->together = true;
            //$productCriteria->with = array('productSubMasterCategory','productMasterCategory','brand');
            // $productCriteria->with = array('productPrices');
            // $productCriteria->compare('productMasterCategory.name',$product->product_master_category_name == NULL ? $product->product_master_category_name : $product->product_master_category_name , true);
            // $productCriteria->compare('productSubMasterCategory.name',$product->product_sub_master_category_name == NULL ? $product->product_sub_master_category_name : $product->product_sub_master_category_name , true);
            // $productCriteria->compare('productSubCategory.name',$product->product_sub_category_name == NULL ? $product->product_sub_category_name : $product->product_sub_category_name , true);
            // $productCriteria->compare('brand.name',$product->product_brand_name == NULL ? $product->product_brand_name : $product->product_brand_name , true);
            $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,
                true);
            $productCriteria->compare('rims_product_sub_master_category.name',
                $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_supplier.name', $product->product_supplier, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            // $productCriteria->join = '';
            //$productCriteria->with = array('productSubMasterCategory','productMasterCategory','brand');

            // $productCriteria->compare('productPrices.purchase_price',$product->product_purchase_price == NULL ? $product->product_purchase_price : $product->product_purchase_price , true);

            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));


            // $supplier = new SupplierProductView('search');
            //     	$supplier->unsetAttributes();  // clear any default values
            //     	if (isset($_GET['SupplierProductView']))
            //       	$supplier->attributes = $_GET['SupplierProductView'];

            // $supplierCriteria = new CDbCriteria;
            // $supplierCriteria->compare('name',$supplier->name,true);
            // $supplierCriteria->compare('product',$supplier->product,true);

            // 	$supplierDataProvider = new CActiveDataProvider('SupplierProductView', array(
            //   	'criteria'=>$supplierCriteria,
            // 	));
            $supplier = new Supplier('search');
            $supplier->unsetAttributes();  // clear any default values
            if (isset($_GET['Supplier'])) {
                $supplier->attributes = $_GET['Supplier'];
            }

            $supplierCriteria = new CDbCriteria;
            $supplierCriteria->compare('name', $supplier->name, true);

            $supplierCriteria->select = 't.*,rims_supplier_product.supplier_id, rims_product.name as product_name';
            $supplierCriteria->join = 'LEFT OUTER JOIN `rims_supplier_product`ON t.id = rims_supplier_product.supplier_id LEFT OUTER JOIN `rims_product`ON rims_supplier_product.product_id = rims_product.id ';
            $supplierCriteria->compare('rims_product.name ', $supplier->product_name, true);


            //$supplierCriteria->compare('product',$supplier->product,true);
            $supplierDataProvider = new CActiveDataProvider('Supplier', array(
                'criteria' => $supplierCriteria,
            ));

            $price = new ProductPrice('search');
            $price->unsetAttributes();  // clear any default values
            if (isset($_GET['ProductPrice'])) {
                $price->attributes = $_GET['ProductPrice'];
            }

            $priceCriteria = new CDbCriteria;
            $priceCriteria->compare('product_id', $price->product_id);
            $priceCriteria->compare('supplier_id', $price->supplier_id);
            $priceCriteria->with = array('product', 'supplier');
            $priceCriteria->together = true;
            $priceCriteria->compare('product.name', $price->product_name, true);
            $priceCriteria->compare('supplier.name', $price->supplier_name, true);
            $priceDataProvider = new CActiveDataProvider('ProductPrice', array(
                'criteria' => $priceCriteria,
            ));
            //print_r(CJSON::encode($requestOrder->details));
            $requestOrder->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailRequestOrder_alt', array(
                'requestOrder' => $requestOrder,
                'supplier' => $supplier,
                // 'supplierDataProvider'=>$supplierDataProvider,
                'product' => $product,
                // 'productDataProvider'=>$productDataProvider,
                'price' => $price,
                'priceDataProvider' => $priceDataProvider,
            ), false, true);
        }
    }

    //Add Detail
    public function actionAjaxHtmlAddTransferDetail($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $requestOrder = $this->instantiate($id);
            $this->loadState($requestOrder);
            // $product = new ProductSupplierView('search');
            //     	$product->unsetAttributes();  // clear any default values
            //     	if (isset($_GET['ProductSupplierView']))
            //       	$product->attributes = $_GET['ProductSupplierView'];


            //   $productCriteria = new CDbCriteria;
            //   $productCriteria->compare('id',$product->id);
            //   $productCriteria->compare('name',$product->name,true);
            //   $productCriteria->compare('supplier',$product->supplier,true);
            //   $productCriteria->compare('subCategory',$product->subCategory,true);
            //   $productCriteria->compare('masterCategory',$product->masterCategory,true);
            //   $productCriteria->compare('subMaster',$product->subMaster,true);
            //   $productCriteria->compare('manufacturer_code',$product->manufacturer_code,true);
            //   $productCriteria->compare('brand',$product->brand,true);


            // 	$productDataProvider = new CActiveDataProvider('ProductSupplierView', array(
            //   	'criteria'=>$productCriteria,
            // 	));
            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->together = true;
            $productCriteria->with = array('productSubMasterCategory', 'productMasterCategory', 'brand');
            $productCriteria->compare('productMasterCategory.name',
                $product->product_master_category_name == null ? $product->product_master_category_name : $product->product_master_category_name,
                true);
            $productCriteria->compare('productSubMasterCategory.name',
                $product->product_sub_master_category_name == null ? $product->product_sub_master_category_name : $product->product_sub_master_category_name,
                true);
            $productCriteria->compare('productSubCategory.name',
                $product->product_sub_category_name == null ? $product->product_sub_category_name : $product->product_sub_category_name,
                true);
            $productCriteria->compare('brand.name',
                $product->product_brand_name == null ? $product->product_brand_name : $product->product_brand_name,
                true);
            // $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
            // $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
            // $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,true);
            // $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,true);
            // $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name,true);
            // $productCriteria->compare('rims_supplier.name', $product->product_supplier,true);
            // $productCriteria->compare('rims_brand.name', $product->product_brand_name,true);


            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));


            $requestOrder->addTransferDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailRequestTransfer', array(
                'requestOrder' => $requestOrder,

                'product' => $product,
                'productDataProvider' => $productDataProvider,

            ), false, true);
        }
    }

    //Delete Detail
    public function actionAjaxHtmlRemoveTransferDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $requestOrder = $this->instantiate($id);
            $this->loadState($requestOrder);
            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->together = true;
            $productCriteria->with = array('productSubMasterCategory', 'productMasterCategory', 'brand');
            $productCriteria->compare('productMasterCategory.name',
                $product->product_master_category_name == null ? $product->product_master_category_name : $product->product_master_category_name,
                true);
            $productCriteria->compare('productSubMasterCategory.name',
                $product->product_sub_master_category_name == null ? $product->product_sub_master_category_name : $product->product_sub_master_category_name,
                true);
            $productCriteria->compare('productSubCategory.name',
                $product->product_sub_category_name == null ? $product->product_sub_category_name : $product->product_sub_category_name,
                true);
            $productCriteria->compare('brand.name',
                $product->product_brand_name == null ? $product->product_brand_name : $product->product_brand_name,
                true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));
            //print_r(CJSON::encode($requestOrder->details));
            $requestOrder->removeTransferDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailRequestTransfer', array(
                'requestOrder' => $requestOrder,
                'product' => $product,
                'productDataProvider' => $productDataProvider
            ), false, true);
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new TransactionRequestOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionRequestOrder'])) {
            $model->attributes = $_GET['TransactionRequestOrder'];
        }

        $dataProvider = $model->search();
        $dataProvider->criteria->addInCondition('main_branch_id', Yii::app()->user->branch_ids);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

	public function actionAjaxHtmlUpdateProductSubBrandSelect()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
            ));
        }
    }
    
	public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }
    
	public function actionAjaxHtmlUpdateProductSubMasterCategorySelect()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }
    
	public function actionAjaxHtmlUpdateProductSubCategorySelect()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TransactionRequestOrder the loaded model
     * @throws CHttpException
     */

    public function instantiate($id)
    {
        if (empty($id)) {
            $requestOrder = new RequestOrders(new TransactionRequestOrder(), array(), array());
            //print_r("test");
        } else {
            $requestOrderModel = $this->loadModel($id);
            $requestOrder = new RequestOrders($requestOrderModel, $requestOrderModel->transactionRequestOrderDetails,
                $requestOrderModel->transactionRequestTransfers);
            //print_r("test");
        }
        return $requestOrder;
    }

    public function detailInstantiate($id)
    {
        if (empty($id)) {
            $requestOrderDetail = new RequestOrderDetails(new TransactionRequestOrderDetail(), array());
            //print_r("test");
        } else {
            $requestOrderDetailModel = TransactionRequestOrderDetail::model()->findByPk($id);
            $requestOrderDetail = new RequestOrderDetails($requestOrderDetailModel,
                $requestOrderDetailModel->transactionRequestOrderApprovals);
            //print_r("test");
        }
        return $requestOrderDetail;
    }

    public function loadDetailState($requestOrderDetail)
    {
        if (isset($_POST['TransactionRequestApproval'])) {
            foreach ($_POST['TransactionRequestApproval'] as $i => $item) {
                if (isset($requestOrder->detailApprovals[$i])) {
                    $requestOrder->detailApprovals[$i]->attributes = $item;

                } else {
                    $detail = new TransactionRequestApproval();
                    $detail->attributes = $item;
                    $requestOrder->detailApprovals[] = $detail;

                }
            }
            if (count($_POST['TransactionRequestTransfer']) < count($requestOrder->detailApprovals)) {
                array_splice($requestOrder->detailApprovals, $i + 1);
            }
        } else {
            $requestOrder->detailApprovals = array();

        }
    }

    public function loadState($requestOrder)
    {
        if (isset($_POST['TransactionRequestOrder'])) {
            $requestOrder->header->attributes = $_POST['TransactionRequestOrder'];
        }


        if (isset($_POST['TransactionRequestOrderDetail'])) {
            foreach ($_POST['TransactionRequestOrderDetail'] as $i => $item) {
                if (isset($requestOrder->details[$i])) {
                    $requestOrder->details[$i]->attributes = $item;

                } else {
                    $detail = new TransactionRequestOrderDetail();
                    $detail->attributes = $item;
                    $requestOrder->details[] = $detail;

                }
            }
            if (count($_POST['TransactionRequestOrderDetail']) < count($requestOrder->details)) {
                array_splice($requestOrder->details, $i + 1);
            }
        } else {
            $requestOrder->details = array();

        }

        if (isset($_POST['TransactionRequestTransfer'])) {
            foreach ($_POST['TransactionRequestTransfer'] as $i => $item) {
                if (isset($requestOrder->transferDetails[$i])) {
                    $requestOrder->transferDetails[$i]->attributes = $item;

                } else {
                    $detail = new TransactionRequestTransfer();
                    $detail->attributes = $item;
                    $requestOrder->transferDetails[] = $detail;

                }
            }
            if (count($_POST['TransactionRequestTransfer']) < count($requestOrder->transferDetails)) {
                array_splice($requestOrder->transferDetails, $i + 1);
            }
        } else {
            $requestOrder->transferDetails = array();

        }


    }

    // public function ajaxAddStep()
    // {
    // 	$step1 .=
    // }
    public function actionUpdateStatus($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['TransactionRequestOrder'])) {
            $model->approved_status = $_POST['TransactionRequestOrder']['approved_status'];
            $model->approved_by = $_POST['TransactionRequestOrder']['approved_by'];
            $model->decline_memo = $_POST['TransactionRequestOrder']['decline_memo'];


            if ($model->update(array('approved_status', 'approved_by', 'decline_memo'))) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('updateStatus', array(
            'model' => $model,
            //'jenisPersediaan'=>$jenisPersediaan,
            //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));

    }

    public function actionUpdateApproval($headerId)
    {
        $requestOrder = TransactionRequestOrder::model()->findByPk($headerId);
        //$requestOrderDetail = TransactionRequestOrderDetail::model()->findByPk($detailId);
        $historis = TransactionRequestOrderApproval::model()->findAllByAttributes(array('request_order_id' => $headerId));
        $model = new TransactionRequestOrderApproval;
        $model->date = date('Y-m-d H:i:s');
        //$model = $this->loadModelDetail($detailId);
        if (isset($_POST['TransactionRequestOrderApproval'])) {
            $model->attributes = $_POST['TransactionRequestOrderApproval'];
            if ($model->save()) {
                $requestOrder->status_document = $model->approval_type;
                if ($model->approval_type == 'Approved') {
                    $requestOrder->approved_by = $model->supervisor_id;
                }
                $requestOrder->save(false);
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'requestOrder' => $requestOrder,
            //'requestOrderDetail'=>$requestOrderDetail,
            'historis' => $historis,
            //'jenisPersediaan'=>$jenisPersediaan,
            //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));
    }

    public function actionUpdateStatusBranch($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['TransactionRequestOrder'])) {
            $model->branch_approved_id = $_POST['TransactionRequestOrder']['branch_approved_id'];
            $model->branch_approved_status = $_POST['TransactionRequestOrder']['branch_approved_status'];
            $model->branch_approved_notes = $_POST['TransactionRequestOrder']['branch_approved_notes'];


            if ($model->update(array('branch_approved_id', 'branch_approved_status', 'branch_approved_notes'))) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('updateStatusBranch', array(
            'model' => $model,
            //'jenisPersediaan'=>$jenisPersediaan,
            //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));

    }

    public function loadModel($id)
    {
        $model = TransactionRequestOrder::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }


    /**
     * Performs the AJAX validation.
     * @param TransactionRequestOrder $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transaction-request-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionShowProduct($productId, $branchId)
    {
        $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $branchId));
        $this->render('showProduct', array(
            'warehouses' => $warehouses,
            'productId' => $productId,
        ));
    }
}
