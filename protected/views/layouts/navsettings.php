<style type="text/css">

  nav#settings ul {
    list-style: none;
    margin: 0;
    padding: 0px;
    width: 90%;
    height: auto;
    border-bottom:1px solid #aaa;
  }

  nav#settings ul li {
    border: 1px solid #aaa;
    border-bottom:0;
    background-color: #ddd;
    color: #666;
    height: auto;
    padding: 8px 10px ;
    font-size: 1em;
  }

  nav#settings ul li:hover { color:white; background-color: #8497B0; }

  nav#settings ul li ul {
    z-index: 1000;
    list-style: none;
    margin: 0;
    margin-left:150px;
    margin-top: -32px;
    padding: 0px;
    height: auto;
    display: none;
    border-bottom: 1px solid #ccc;
  }
  nav#settings ul li ul li {
    background-color: white;
    color: black;
    height: auto;
    padding:3px 8px;
    border:1px solid #ccc;
    border-bottom:0;
   }

  nav#settings a:link { text-decoration: none; }
  nav#settings ul li:hover ul { display: block; }
  nav#settings ul ul { position: absolute; display: none;}
  nav#settings ul ul li { background: #f1f1f1;  border-top: 0; }
  nav#settings ul ul li a { color: #333;  font-size: 12px;  text-transform: none;}
  nav#settings ul ul li:hover {background: white !important}
  nav#settings ul ul li a:hover { color:#125BA5; background: white }
  .title{font-weight: bold !important;}

</style>



<nav id="settings">
  <ul>
    <li>Company
      <?php $this->widget('zii.widgets.CMenu',array(
          'items'=>array(
            array('label'=>'User', 'url'=>array('/user/admin'), 'visible'=>Yii::app()->user->checkAccess('User.Admin')),
            array('label'=>'Company', 'url'=>array('/master/company/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Company.Admin')),
            array('label'=>'Insurance Company', 'url'=>array('/master/insuranceCompany/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.InsuranceCompany.Admin')),
            array('label'=>'Branch', 'url'=>array('/master/branch/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Branch.Admin')),
            array('label'=>'Customer', 'url'=>array('/master/customer/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Customer.Admin')),
            array('label'=>'Supplier', 'url'=>array('/master/supplier/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Supplier.Admin')),
            array('label'=>'Employee', 'url'=>array('/master/employee/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Employee.Admin')),
            array('label'=>'Deduction', 'url'=>array('/master/deduction/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Deduction.Admin')),
            array('label'=>'Incentive', 'url'=>array('/master/incentive/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Incentive.Admin')),
            array('label'=>'Position', 'url'=>array('/master/position/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Position.Admin')),
            array('label'=>'Division', 'url'=>array('/master/division/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Division.Admin')),
            array('label'=>'Level', 'url'=>array('/master/level/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Level.Admin')),
            array('label'=>'Unit', 'url'=>array('/master/unit/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Unit.Admin')),
            array('label'=>'Unit Conversion', 'url'=>array('/master/unitConversion/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.UnitConversion.Admin')),
            array('label'=>'Public Holiday', 'url'=>array('/master/publicDayOff/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.PublicDayOff.Admin')),
            //array('label'=>'Payment-Type', 'url'=>array('/master/customer/admin')),

          ),
        )); ?>
    </li>
    <li>Accounting
       <?php $this->widget('zii.widgets.CMenu',array(
          'items'=>array(
            array('label'=>'Bank', 'url'=>array('/master/bank/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Bank.Admin')),
            array('label'=>'COA', 'url'=>array('/accounting/coa/admin'), 'visible'=>Yii::app()->user->checkAccess('Accounting.Coa.Admin')),
            array('label'=>'COA Category', 'url'=>array('/master/coaCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Accounting.CoaCategory.Admin')),
            array('label'=>'COA Sub Category', 'url'=>array('/master/coaSubCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Accounting.CoaSubCategory.Admin')),
          ),
        )); ?>
     <!--  <ul>
        <li><a href="account.php">Charts of Account (COA)</a></li>
        <li><a href="account-category.php">Category</a></li>
        <li><a href="account-subcategory.php">Sub-Category</a></li>
      </ul> -->
    </li>
    <li>Product
     <!--  <ul>
        <li><a href="product.php">Product</a></li>
        <li><a href="product-category.php">Product Category</a></li>
        <li><a href="product-subcategory.php">Product Sub-Category</a></li>
        <li><a href="product-type.php">Product Type</a></li>
        <li><a href="specification-type.php">Specification Type</a></li>
        <li><a href="specification-info.php">Specification Info</a></li>
      </ul> -->
    <?php $this->widget('zii.widgets.CMenu',array(
          'items'=>array(
            array('label'=>'Inventory', 'url'=>array('/master/inventory/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Inventory.Admin')),
            //array('label'=>'Inventory Detail', 'url'=>array('/master/inventoryDetail/admin')),
            array('label'=>'Product', 'url'=>array('/master/product/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Product.Admin')),
            // array('label'=>'Find Product', 'url'=>array('/master/findProduct/index')),
            array('label'=>'Product Category', 'url'=>array('/master/productMasterCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ProductMasterCategory.Admin')),
            array('label'=>'Product Sub-Master Category', 'url'=>array('/master/productSubMasterCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ProductSubMasterCategory.Admin')),
            array('label'=>'Product Sub-Category', 'url'=>array('/master/productSubCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ProductSubCategory.Admin')),
            //array('label'=>'Specification Type', 'url'=>array('/master/productSpecificationType/admin')),
            //array('label'=>'Specification Info', 'url'=>array('/master/productSpecificationInfo/admin')),
            array('label'=>'Brand', 'url'=>array('/master/brand/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Brand.Admin')),
            array('label'=>'Sub-Brand', 'url'=>array('/master/subBrand/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.SubBrand.Admin')),
            array('label'=>'Sub-Brand Series', 'url'=>array('/master/subBrandSeries/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.SubBrandSeries.Admin')),
            array('label'=>'Equipments', 'url'=>array('/master/equipments/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Equipments.Admin')),
            array('label'=>'Equipment Types', 'url'=>array('/master/equipmentType/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.EquipmentType.Admin')),
            array('label'=>'Equipment Sub-types', 'url'=>array('/master/equipmentSubType/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.EquipmentSubType.Admin')),
            //array('label'=>'Equipment Branches', 'url'=>array('/master/equipmentBranch/admin')),
            //array('label'=>'Equipment Tasks', 'url'=>array('/master/equipmentTask/admin')),
            //array('label'=>'Equipment Maintenance', 'url'=>array('/master/equipmentMaintenance/admin')),
             ),
        )); ?>
    </li>
    <li>Service
    <?php $this->widget('zii.widgets.CMenu',array(
          'items'=>array(
            array('label'=>'Service', 'url'=>array('/master/service/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Service.Admin')),
            array('label'=>'Service Category', 'url'=>array('/master/serviceCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ServiceCategory.Admin')),
            array('label'=>'Service Type', 'url'=>array('/master/serviceType/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ServiceType.Admin')),
            array('label'=>'Service Pricelist', 'url'=>array('/master/servicePricelist/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ServicePricelist.Admin')),
            array('label'=>'Service Standard Pricelist', 'url'=>array('/master/serviceStandardPricelist/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ServiceStandardPricelist.Admin')),
            array('label'=>'Standard Flat Rate', 'url'=>array('/master/generalStandardFr/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.GeneralStandardFr.Admin')),
            array('label'=>'Standard Value', 'url'=>array('/master/generalStandardValue/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.GeneralStandardValue.Admin')),
            array('label'=>'Quick Service', 'url'=>array('/master/quickService/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.QuickService.Admin')),
            array('label'=>'Inspection', 'url'=>array('/master/inspection/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Inspection.Admin')),
            array('label'=>'Inspection Section', 'url'=>array('/master/inspectionSection/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.InspectionSection.Admin')),
            array('label'=>'Inspection Module', 'url'=>array('/master/inspectionModule/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.InspectionModule.Admin')),
            array('label'=>'Inspection Checklist Type', 'url'=>array('/master/inspectionChecklistType/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.InspectionChecklistType.Admin')),
            array('label'=>'Inspection Checklist Module', 'url'=>array('/master/inspectionChecklistModule/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.InspectionChecklistModule.Admin')),
            //array('label'=>'Equipment', 'url'=>array('/master/equipment/admin')),
            //array('label'=>'Service Material Usage', 'url'=>array('/master/serviceMaterialUsage/admin')),

             ),
        )); ?>
     <!--  <ul>
        <li><a href="service.php">Service</a></li>
        <li><a href="service-category.php">Service Category</a></li>
        <li><a href="service-type.php">Service Type</a></li>
        <li><a href="service-pricelist.php">Service Pricelist</a></li>
        <li><a href="service-flatrate.php">Service Flat Rate</a></li>
        <li><a href="inspection-item.php">Inspevction Item</a></li>
        <li><a href="inspection-item-category.php">Inspection Item Category</a></li>
        <li><a href="quickservice-list.php">Quickservice List</a></li>
        <li><a href="quickservice-list-category.php">Quickservice List Category</a></li>
        <li><a href="standard-item-usage.php">Standard Item Usage</a></li>
      </ul> -->
    </li>
    <li>Vehicle
   <?php $this->widget('zii.widgets.CMenu',array(
          'items'=>array(
            array('label'=>'Manage Customer Vehicle', 'url'=>array('/master/vehicle/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Vehicle.Admin')),
            array('label'=>'Vehicle Car Make', 'url'=>array('/master/vehicleCarMake/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.VehicleCarMake.Admin')),
            array('label'=>'Vehicle Car Model', 'url'=>array('/master/vehicleCarModel/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.VehicleCarModel.Admin')),
            array('label'=>'Vehicle Car Sub Model', 'url'=>array('/master/vehicleCarSubModel/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.VehicleCarSubModel.Admin')),
            array('label'=>'Vehicle Car Sub Model Detail', 'url'=>array('/master/vehicleCarSubModelDetail/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.VehicleCarSubModelDetail.Admin')),
            //array('label'=>'Chassis Code', 'url'=>array('/master/chasisCode/admin')),
            array('label'=>'Color', 'url'=>array('/master/Colors/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Colors.Admin')),
            //array('label'=>'Power CC', 'url'=>array('/master/powercc/admin')),
             ),
        )); ?>
     <!--  <ul>
        <li><a href="vehicle.php">Manage Vehicle</a></li>
        <li><a href="vehicle-brand.php">Vehicle Brand</a></li>
        <li><a href="vehicle-subbrand.php">Vehicle Sub-Brand</a></li>
        <li><a href="vehicle-subbrand-detail.php">Vehicle Sub-Brand Detail</a></li>
        <li><a href="chassis-code.php">Chassis Code</a></li>
        <li><a href="color.php">Color</a></li>
        <li><a href="drivetrain.php">Drivetrain</a></li>
        <li><a href="power-cc.php">Power CC</a></li>
        <li><a href="transmission.php">Transmission</a></li>
      </ul> -->
    </li>

    <li>Warehouse
     <?php $this->widget('zii.widgets.CMenu',array(
          'items'=>array(
              array('label'=>'Warehouse', 'url'=>array('/master/warehouse/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Warehouse.Admin')),
              //array('label'=>'Section', 'url'=>array('/master/section/admin')),
              //array('label'=>'Section Detail', 'url'=>array('/master/sectionDetail/admin')),
             ),
        )); ?>
    </li>
    <li>CRM
      <!-- <ul>
        <li><a href="point.php">Points</a></li>
        <li><a href="bonus.php">Bonus</a></li>
        <li><a href="promotion.php">Promotion/Program</a></li>
      </ul> -->
    </li>
  </ul>
</nav>
