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

</style>



<nav id="settings">
  <ul>
    <li>Company
       <?php $this->widget('zii.widgets.CMenu',array(
          'items'=>array(
            //array('label'=>'Branch', 'url'=>array('/master/branch/admin')),
            array('label'=>'Customer', 'url'=>array('/master/customer/admin')),
            //array('label'=>'Supplier', 'url'=>array('/master/supplier/admin')),
            array('label'=>'Employee', 'url'=>array('/master/employee/admin')),
            array('label'=>'Position', 'url'=>array('/master/position/admin')),
            //array('label'=>'Division', 'url'=>array('/master/division/admin')),
            array('label'=>'Position-level', 'url'=>array('/master/level/admin')),
            array('label'=>'Unit', 'url'=>array('/master/unit/admin')),
            //array('label'=>'Payment-Type', 'url'=>array('/master/customer/admin')),
            
          ),
        )); ?>
    </li>                           
    <li>Accounting
      <ul>
        <li><a href="account.php">Charts of Account (COA)</a></li>
        <li><a href="account-category.php">Category</a></li>
        <li><a href="account-subcategory.php">Sub-Category</a></li>
      </ul>
    </li>
    <li>Product
      <ul>
        <li><a href="product.php">Product</a></li>
        <li><a href="product-category.php">Product Category</a></li>
        <li><a href="product-subcategory.php">Product Sub-Category</a></li>
        <li><a href="product-type.php">Product Type</a></li>
        <li><a href="specification-type.php">Specification Type</a></li>
        <li><a href="specification-info.php">Specification Info</a></li>
      </ul>
    </li>
    <li>Service
      <ul>
        <li><a href="service.php">Service</a></li>
        <li><a href="service-category.php">Service Category</a></li>
        <li><a href="service-type.php">Service Type</a></li>
        <li><a href="service-pricelist.php">Service Pricelist</a></li>
        <li><a href="service-flatrate.php">Service Flat Rate</a></li>
        <li><a href="inspection-item.php">Inspection Item</a></li>
        <li><a href="inspection-item-category.php">Inspection Item Category</a></li>
        <li><a href="quickservice-list.php">Quickservice List</a></li>
        <li><a href="quickservice-list-category.php">Quickservice List Category</a></li>
        <li><a href="standard-item-usage.php">Standard Item Usage</a></li>
      </ul>
    </li>
    <li>Vehicle
      <ul>
        <li><a href="vehicle.php">Manage Vehicle</a></li>
        <li><a href="vehicle-brand.php">Vehicle Brand</a></li>
        <li><a href="vehicle-subbrand.php">Vehicle Sub-Brand</a></li>
        <li><a href="vehicle-subbrand-detail.php">Vehicle Sub-Brand Detail</a></li>
        <li><a href="chassis-code.php">Chassis Code</a></li>
        <li><a href="color.php">Color</a></li>
        <li><a href="drivetrain.php">Drivetrain</a></li>
        <li><a href="power-cc.php">Power CC</a></li>
        <li><a href="transmission.php">Transmission</a></li>
      </ul>
    </li>

    <li>Warehouse
      <ul>
        <li><a href="warehouse.php">Warehouse</a></li>
        <li><a href="section.php">Section</a></li>
      </ul>
    </li> 
    <li>CRM
      <ul>
        <li><a href="point.php">Points</a></li>
        <li><a href="bonus.php">Bonus</a></li>
        <li><a href="promotion.php">Promotion/Program</a></li>
      </ul>
    </li>
  </ul>
</nav>