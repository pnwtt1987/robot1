<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->product_name=>array('view','id'=>$model->product_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'View Product', 'url'=>array('view', 'id'=>$model->product_id)),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>แก้ไขสินค้า :: <?php echo $model->product_name; ?></h1>

<?php echo $this->renderPartial('_formupdate', array('model'=>$model)); ?>