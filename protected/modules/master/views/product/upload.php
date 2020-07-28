<form action="<?php echo Yii::app()->baseUrl.'/master/product/processUpload';?>" method="post" enctype="multipart/form-data">
	<h5>Upload Produk</h5>
	<input type="file" name="product">
	<input type="submit" value="Upload">
</form>