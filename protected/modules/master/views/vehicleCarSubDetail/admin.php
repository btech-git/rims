<?php
/* @var $this VehicleCarSubDetailController */
/* @var $model VehicleCarSubDetail */

$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Vehicle Car Sub Details'=>array('admin'),
	'Manage Vehicle Car Sub Details',
);

$this->menu=array(
	array('label'=>'List VehicleCarSubDetail', 'url'=>array('index')),
	array('label'=>'Create VehicleCarSubDetail', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;
});
$('.search-form form').submit(function(){
	$('#vehicle-car-sub-detail-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarSubDetail/admin';?>">Vehicle Car Sub Detail</a>
			<span>Manage Vehicle Car Sub Detail</span>
		</div>
	</div>
</div>-->
	<div id="maincontent">
		<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.vehicleCarSubDetail.create")) { ?>
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarSubDetail/create';?>" data-reveal-id="vehicle-subbrand-det"><span class="fa fa-plus"></span>New Vehicle Car Sub Details</a>
			<?php }?>
					<h1>Manage Vehicle Car Sub Details</h1>
					<!-- begin pop up -->
					<!--<div id="vehicle-subbrand-det" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
						<div class="small-12 columns">
							<div id="maincontent">
								<div class="clearfix page-action">
									<a class="button cbutton right" href="vehicle-subbrand-detail.php"><span class="fa fa-th-list"></span>Manage Vehicle Sub Brand Detail</a>
									<h1>New Vehicle Sub Brand Detail</h1>
										<div class="form">

										   <form method="post" action="" id="popup-form">   <hr>
										   <p class="note">Fields with <span class="required">*</span> are required.</p>

										   
										   <div class="row">
										      <div class="small-12 medium-6 columns">

										         <div class="field">
										            <div class="row collapse">
										               <div class="small-4 columns">
										                  <label class="prefix">Code</label>
										                </div>
										               <div class="small-8 columns">
										                  <input type="text" maxlength="100" size="60" disabled="true">                                 
										                </div>
										            </div>
										         </div>

									         	<div class="field">
										            <div class="row collapse">
										               <div class="small-4 columns">
										                  <label class="prefix">Vehicle Brand</label>
										                </div>
										               <div class="small-8 columns">
										                	<select name="Customer[vehicle_brand]">
																<option value=""></option>
																<option value="1">Toyota</option>
																<option value="2">Honda</option>
																<option value="3">Nissan</option>
																<option value="4">VW</option>
																<option value="5">BMW</option>
																<option value="6">Daihatsu</option>
																<option value="7">Mercedes-Benz</option>
																<option value="8">Audi</option>
																<option value="9">Chevrolet</option>
																<option value="10">Isuzu</option>
																<option value="12">TestorBrand</option>
															</select>
										                </div>
										            </div>
										         </div>
										         <div class="field">
										            <div class="row collapse">
										               <div class="small-4 columns">
										                  <label class="prefix">Sub Brand</label>
										                </div>
										               <div class="small-8 columns">
										                	<select name="Customer[vehicle_sub_brand]">
																<option value=""></option>
																<option value="1">A-CLASS</option>
																<option value="2">B-CLASS</option>
																<option value="3">C-CLASS</option>
																<option value="4">CLA-CLASS</option>
																<option value="5">CLS-CLASS</option>
																<option value="6">E-CLASS</option>
																<option value="7">G-CLASS</option>
																<option value="8">GL-CLASS</option>
																<option value="9">GLA-CLASS</option>
																<option value="10">GLK-CLASS</option>
																<option value="11">M-CLASS</option>
																<option value="12">S-CLASS</option>
																<option value="13">SL-CLASS</option>
																<option value="14">SLK-CLASS</option>
																<option value="15">AMG-GT</option>
																<option value="16">V-Class</option>
																<option value="17">3 Series</option>
																<option value="18">7 Series</option>
																<option value="19">Z4</option>
																<option value="20">X3</option>
																<option value="21">5 Series</option>
																<option value="22">6 Series</option>
																<option value="23">X5</option>
																<option value="24">X6</option>
																<option value="25">1 Series</option>
																<option value="26">X1</option>
																<option value="27">A1</option>
																<option value="28">A3</option>
																<option value="29">R3</option>
																<option value="30">RS3</option>
																<option value="31">S3</option>
																<option value="32">A4</option>
																<option value="33">A5</option>
																<option value="34">A6</option>
																<option value="35">A7</option>
																<option value="36">A8</option>
																<option value="37">TT</option>
																<option value="38">R8</option>
																<option value="39">Q3</option>
																<option value="40">Q5</option>
																<option value="41">Q7</option>
																<option value="42">Accord</option>
																<option value="43">Brio</option>
																<option value="44">City</option>
																<option value="45">Civic</option>
																<option value="46">CR-V</option>
																<option value="47">Freed</option>
																<option value="48">Jazz</option>
																<option value="49">Mobilio</option>
																<option value="50">Odssey</option>
																<option value="51">Stream</option>
																<option value="52">Alphard</option>
																<option value="54">Avanza</option>
																<option value="55">Camry</option>
																<option value="56">Camry Hybrid</option>
																<option value="57">Corolla</option>
																<option value="58">Corolla Altis</option>
																<option value="59">Crown</option>
																<option value="60">Dyna</option>
																<option value="61">Fortuner</option>
																<option value="62">Hilux D-Cab</option>
																<option value="63">Hilux S-Cab</option>
																<option value="64">Innova</option>
																<option value="65">Land Cruiser</option>
																<option value="66">Rush</option>
																<option value="67">Vios</option>
																<option value="68">Yaris</option>
																<option value="69">Etios Valco</option>
																<option value="70">Agya</option>
																<option value="71">NAV1</option>
																<option value="72">RAV4</option>
																<option value="73">Hiace</option>
																<option value="74">86</option>
																<option value="75">Prius Hybrid</option>
																<option value="76">Wish</option>
																<option value="77">Kancil</option>
																<option value="78">Hijet</option>
																<option value="79">Zebra</option>
																<option value="80">Gran Max</option>
																<option value="81">Luxio</option>
																<option value="82">Sirion</option>
																<option value="83">Taruna</option>
																<option value="84">Terios</option>
																<option value="85">Xenia</option>
																<option value="86">Evalia</option>
																<option value="87">Grand Livina</option>
																<option value="88">Livina X-Gear</option>
																<option value="89">March</option>
																<option value="90">X-Trail</option>
																<option value="91">Juke</option>
																<option value="92">Serena</option>
																<option value="93">Teana</option>
																<option value="94">Terrano</option>
																<option value="95">Elgrand</option>
																<option value="97">TestorSubBrandUpdate</option>
															</select>
										                </div>
										            </div>
										         </div>

										         <div class="field">
										            <div class="row collapse">
										               <div class="small-4 columns">
										                  <label class="prefix">Style Name</label>
										                </div>
										               <div class="small-8 columns">
										                  <input type="text" maxlength="100" size="60">                                 
										                </div>
										            </div>
										         </div>

										         <div class="field">
										            <div class="row collapse">
										               <div class="small-4 columns">
										                  <label class="prefix">Assembly Year Start</label>
										                </div>
										               <div class="small-8 columns">
										                  <input type="text" maxlength="100" size="60">                                 
										                </div>
										            </div>
										         </div>
										         <div class="field">
										            <div class="row collapse">
										               <div class="small-4 columns">
										                  <label class="prefix">Assembly Year End</label>
										                </div>
										               <div class="small-8 columns">
										                  <input type="text" maxlength="100" size="60">                                 
										                </div>
										            </div>
										         </div>
										         <div class="field">
										            <div class="row collapse">
										               <div class="small-4 columns">
										                  <label class="prefix">Transmission</label>
										                </div>
										               <div class="small-8 columns">
										                	<select name="Customer[transmission]">
																<option value=""></option>
																<option value="1">MANUAL</option>
																<option value="2">AUTOMATIC</option>
																<option value="2">MANUAL / AUTOMATIC</option>
																<option value="2">SPORTS</option>
															</select>                                
										                </div>
										            </div>
										         </div>
										         <div class="field">
										            <div class="row collapse">
										               <div class="small-4 columns">
										                  <label class="prefix">Fuel Type</label>
										                </div>
										               <div class="small-8 columns">
										                <select name="Customer[transmission]">
																<option value=""></option>
																<option value="1">Bensin</option>
																<option value="2">Solar</option>
																<option value="2">Hybrid</option>
															</select>  
										                </div>
										            </div>
										         </div>

										        
										      </div>
										   </div>

										   <hr>

										   <div class="field buttons text-center">
										      <input type="button" value="Create" name="yt0" class="button cbutton">  
										    </div>

										   </form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>-->
					<!-- end pop up -->

					<div class="search-bar">
				<div class="clearfix button-bar">
      			<!--<div class="left clearfix bulk-action">
	         		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
	         		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
	         		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
         		</div>-->
      			<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>   
				<div class="clearfix"></div>
<div class="search-form" style="display:none">
				<?php $this->renderPartial('_search',array(
					'model'=>$model,
				)); ?>
				</div><!-- search-form -->	
      		</div>
      		</div>

				<div class="grid-view">

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'vehicle-car-sub-detail-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		// 'summaryText'=>'',
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
		   'cssFile'=>false,
		   'header'=>'',
		),
		'columns'=>array(
			array (
							'class' 		 => 'CCheckBoxColumn',
							'selectableRows' => '2',	
							'header'		 => 'Selected',	
							'value' => '$data->id',				
							),
			array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
		//'name',
		
		array('name'=>'car_make_id','value'=>'$data->carMake->name'),
		//
		array('name'=>'car_model_id','value'=>'$data->carModel->name'),
		'assembly_year_start',
		//'transmission_id',
	
		'fuel_type',
		/*
		'status',
		'power_id',
		'drivetrain',
		'chasis_id',
		'description',
		*/
		array(
				'class'=>'CButtonColumn',
				'template'=>'{edit}',
				'buttons'=>array
				(
					'edit' => array
					(
									'visible'=>'(Yii::app()->user->checkAccess("master.vehicleCarSubDetail.update"))',
						'label'=>'edit',
						'url'=>'Yii::app()->createUrl("master/vehicleCarSubDetail/update", array("id"=>$data->id))',
					),
				),
			),
		),
	)); ?>
	</div>
</div>
</div>