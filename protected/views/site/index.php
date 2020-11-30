<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;
?>
<style>
  
.custom-radios div {
  display: inline-block;
}
.custom-radios input[type="radio"] {
  display: none;
}
.custom-radios input[type="radio"] + label {
  color: #333;
  font-family: Arial, sans-serif;
  font-size: 14px;
}
.custom-radios input[type="radio"] + label span {
  display: inline-block;
  width: 40px;
  height: 40px;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor: pointer;
  border-radius: 50%;
  border: 2px solid #FFFFFF;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
  background-repeat: no-repeat;
  background-position: center;
  text-align: center;
  line-height: 44px;
}
.custom-radios input[type="radio"] + label span img {
  opacity: 0;
  transition: all .3s ease;
}
.custom-radios input[type="radio"]#color-1 + label span {
  background-color: #2ecc71;
}
.custom-radios input[type="radio"]#color-2 + label span {
  background-color: #3498db;
}
.custom-radios input[type="radio"]#color-3 + label span {
  background-color: #f1c40f;
}
.custom-radios input[type="radio"]#color-4 + label span {
  background-color: #e74c3c;
}
.custom-radios input[type="radio"]:checked + label span img {
  opacity: 1;
}
</style>
<div style="font-size:16px; text-align:center">
	<div style="font-size:30px">Raperind Information Management System (RIMS)</div>
	<br/><br/>

	<img src="<?php echo Yii::app()->baseUrl.'/images/rap-logo.png';?>">
	<br/><br/>
	<?php 
	
	if(Yii::app()->user->isGuest){ ?>
	Please login to access RIMS	

	<br/><br/>
	
	<a href="<?php echo Yii::app()->baseUrl.'/site/login';?>" class="button cbutton">CLICK HERE</a>
	<?php } ?>
	<br/><br/>
  
</div>

  <div class="custom-radios">
  <div>
    <input type="radio" id="color-1" name="color" value="color-1" checked>
    <label for="color-1">
      <span>
      </span>
    </label>
  </div>
  
  <div>
    <input type="radio" id="color-2" name="color" value="color-2">
    <label for="color-2">
      <span>
        <img src="<?php echo Yii::app()->baseUrl.'/images/icons/tick.png';?>" alt="Checked Icon" />
      </span>
    </label>
  </div>
  
  <div>
    <input type="radio" id="color-3" name="color" value="color-3">
    <label for="color-3">
      <span>
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/242518/check-icn.svg" alt="Checked Icon" />
      </span>
    </label>
  </div>

  <div>
    <input type="radio" id="color-4" name="color" value="color-4">
    <label for="color-4">
      <span>
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/242518/check-icn.svg" alt="Checked Icon" />
      </span>
    </label>
  </div>
</div>