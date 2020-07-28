<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="language" content="en">
	<link rel="icon" type="image/png" href="/app/images/favicon.png">

		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foundation.min.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/fontface.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foundation-datepicker.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/rims.css" />
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/modernizr.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jquery.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/foundation-datepicker.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/bootstrap-hover-dropdown.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/isotope.pkgd.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/imagesloaded.pkgd.min.js"></script>
			<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
			<style type="text/css">
			#utilities { background:#ccc; padding:5px 0; }
			#utilities .row div {font-size:12px; text-align: right; padding:0 20px;}
			#utilities .row div a { color:#213782;  }
			#utilities .row div a:hover {text-decoration: underline;}
			/*Added 19-09-2015*/
			#utilities .row ul{text-decoration: none; margin:0;}
			#utilities .row ul li{display:inline; }
			#mainmenu ul ul {min-width: 110px}
			
			#rcorners4 {
	
			    border-radius: 100%;
			    background: #FF0000;
			    padding: 2px; 
			    width: 12px;
			    height: 13px;    
				font-size:9px;
				font-weight: bold;
			    color:white;
			    text-align:center;
			    position: absolute; /* Position the badge within the relatively positioned button */
				top: 0;
				
			}
			.leftside{
				text-align :left !important;
				
			}
			.dropdown{
				/*display:none;*/
				z-index: 99;
				border-bottom:none;
				list-style-type: none;

			}
			.dropdown ul li{
				display: block !important;
				text-align: left !important;
				color:#000;
			}
			

		</style>
		<script>
		  $(document).ready(function(){
		  	$('[data-hover="dropdown"]').bootstrapDropdownHover();
		  });
		  </script>
		<?php $id=2;?>

		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<?php $is_login = ($ccontroller == "login") ? true:false; ?>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		</head>
		<body class="<?php //echo ($is_login) ? "login" : "";?>">
		<?php //var_dump($ccontroller. $ccaction . $is_login) ?>
			

			<?php 
				$count = 0;
				if(!Yii::app()->user->isGuest ){
					$branchId = User::model()->findByPk(Yii::app()->user->getId())->branch_id;
					$date=date_create(date('d-m-Y'));
					date_sub($date,date_interval_create_from_date_string("7 days"));
					//echo date_format($date,"Y-m-d");
					
					if($branchId){
						$requestCriteria = new CDbCriteria;
						$requestCriteria->addCondition(" main_branch_id = ".$branchId. " AND DATE(request_order_date) >= (NOW() - INTERVAL 7 DAY)");
						$requestOrder = TransactionRequestOrder::model()->findAll($requestCriteria);
						$purchaseCriteria = new CDbCriteria;
						$purchaseCriteria->addCondition(" main_branch_id = ".$branchId. " AND DATE(purchase_order_date) >= (NOW() - INTERVAL 7 DAY)");
						$purchase = TransactionPurchaseOrder::model()->findAll($purchaseCriteria);
						
						$salesCriteria = new CDbCriteria;
						$salesCriteria->addCondition(" requester_branch_id = ".$branchId. " AND DATE(sale_order_date) >= (NOW() - INTERVAL 7 DAY)");
						$sales = TransactionSalesOrder::model()->findAll($salesCriteria);

						$transferCriteria = new CDbCriteria;
						$transferCriteria->addCondition(" destination_branch_id = ".$branchId. " AND DATE(transfer_request_date) >= (NOW() - INTERVAL 7 DAY)");
						$transfer = TransactionTransferRequest::model()->findAll($transferCriteria);

						$sentCriteria = new CDbCriteria;
						$sentCriteria->addCondition(" destination_branch_id = ".$branchId. " AND DATE(sent_request_date) >= (NOW() - INTERVAL 7 DAY)");
						$sent = TransactionSentRequest::model()->findAll($sentCriteria);

						$consignmentCriteria = new CDbCriteria;
						$consignmentCriteria->addCondition(" branch_id = ".$branchId. " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
						$consignment = ConsignmentOutHeader::model()->findAll($consignmentCriteria);

						$consignmentInCriteria = new CDbCriteria;
						$consignmentInCriteria->addCondition(" receive_branch = ".$branchId. " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
						$consignmentIn = ConsignmentInHeader::model()->findAll($consignmentInCriteria);

						$movementCriteria = new CDbCriteria;
						$movementCriteria->addCondition(" branch_id = ".$branchId. " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
						$movement = MovementOutHeader::model()->findAll($movementCriteria);

						$movementInCriteria = new CDbCriteria;
						$movementInCriteria->addCondition(" branch_id = ".$branchId. " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
						$movementIn = MovementInHeader::model()->findAll($movementInCriteria);


						$count = count($requestOrder)+ count($purchase) + count($sales) + count($transfer) + count($sent) + count($consignment) + count($consignmentIn) + count($movement) + count($movementIn);
					}
				}
				
				
			 ?>

			<div id="utilities">
				<div class="row">
					<div class="small-12 columns ">
						<div class="small-1 columns leftside ">
						<?php if (!Yii::app()->user->isGuest): ?>
							
							<li class="dropdown" >
							    <a href="<?php echo Yii::app()->baseUrl.'/transaction/pendingTransaction';?>" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="false">
							        <i class="fa fa-bell" style="font-size:16px;" ><i id="rcorners4"><?php echo $count; ?></i></i></b>
							    </a>
							    <ul class="dropdown-menu">
							        <li>Request (<?php echo count($requestOrder); ?>)</li>
										<li>Purchase (<?php echo count($purchase); ?>)</li>
										<li>Sales (<?php echo count($sales); ?>)</li>
										<li>Transfer (<?php echo count($transfer); ?>)</li>
										<li>Sent (<?php echo count($sent); ?>)</li>
										<li>Consignment In (<?php echo count($consignmentIn); ?>)</li>
										<li>Consignment Out (<?php echo count($consignment); ?>)</li>
										<li>Movement In (<?php echo count($movementIn); ?>)</li>
										<li>Movement Out (<?php echo count($movement); ?>)</li>
							    </ul>
							</li>
						<?php endif ?>
						
							
						</div>
						<div class="small-11 columns">
						
						<?php $this->widget('zii.widgets.CMenu',array(
								'items'=>array(
									array('label'=>'Home', 'url'=>array('/site/index')),
									array('label'=>'Setting', 'url'=>array('/site/setting'),'template'=>'/ {menu}'),
									//array('label'=>'Help', 'url'=>array('/site/contact'),'template'=>'/ {menu}'),
									//array('label'=>'Login', 'url'=>array('/site/login'),'template'=>'/ {menu}', 'visible'=>Yii::app()->user->isGuest),
									//array('label'=>'Logout ('.Yii::app()->user->name.')','template'=>'/ {menu}' , 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
									array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login"), 'template'=>'/ {menu}', 'visible'=>Yii::app()->user->isGuest),
									array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'template'=>'/ {menu}', 'visible'=>!Yii::app()->user->isGuest),
								),
							)); ?>
							</div>
					</div>
				</div>
			</div>
			<div id="header">
				<div class="row">
					<div class="small-12 medium-3 columns">
						<div class="logo">
							<a href="index.php"><img src="/app/images/rims-logo.png"></a>
							<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>" style="color:white; font-size:14px"><strong style="font-size:20px">RAPERIND</strong> MOTOR</a>
						</div>
					</div>
					<?php if(!$is_login) : ?>
					<div class="small-12 medium-9 columns">
						<nav class="clearfix" id="mainmenu">
							<?php include 'menu.php';?>
						</nav>
					</div>
					<?php endif;?>
				</div>
			</div>
			<br />		
			<?php if(isset($this->breadcrumbs)):?>
				<div id="site_breadcrumb">
					<div class="row">
						<div class="small-12 columns">
					<?php $this->widget('zii.widgets.CBreadcrumbs', array(
						'links'=>$this->breadcrumbs,
						'separator'=>'',
					)); ?><!-- breadcrumbs -->
						</div>
					</div>
				</div>
			<?php endif?>

			<?php echo $content;?>

			<!-- end content -->
			<?php include 'footer.php';?>

		</div>
		
		<?php /*
		<script>
		  $(document).ready(function(){
		    $('#sidebar').stickyMojo({footerID: '#footer', contentID: '#content'});
		  });
		</script>*/
		?>



		</body>
</html>
