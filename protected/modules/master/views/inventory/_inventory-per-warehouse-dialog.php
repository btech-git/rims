<?php
/* @var $this ProductController */
/* @var $model Product */
?>

<div class="row">
	<?php //var_dump($model); ?>
	<div class="small-10 columns">
		<div id="maincontent">
			<table >
				<thead>
					<tr>
						<td>Product</td>
						<td>Warehouse</td>
					</tr>
				</thead>
			
				<?php foreach ($model as $key => $row): ?>
					<tr>
						<td>Test</td>
						<td>Test</td>							
					</tr>
				<?php endforeach ?>
			</table>
		</div>
	</div>
</div>