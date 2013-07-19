<?php
/* @var $this ProductController */
/* @var $model Product */
$url= 'http://'.Yii::app()->request->getServerName().'/'.$this->mainFolder;
$this->breadcrumbs = array(
    'Products' => array('index'),
    $model->product_id,
);

$this->menu = array(
    array('label' => 'List Product', 'url' => array('index')),
    array('label' => 'Create Product', 'url' => array('create')),
    array('label' => 'Update Product', 'url' => array('update', 'id' => $model->product_id)),
    array('label' => 'Delete Product', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->product_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Product', 'url' => array('admin')),
);
?>

<h1>View Product #<?php echo $model->product_id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'product_id',
       array('name'=> 'category_name',
	   // 'type' => 'raw',
	   'value'=>$model->category->category_name
	   ),
        'product_code',
        'product_name',
        'product_amount',
        'product_price',
        array('name' => 'product_image',
            'type' => 'image',
            'value' => "$url/images/products/larges/" . $model->product_image
        ),
        array('name' => 'product_detail',
            'type' => 'raw'
        ),
    ),
));
?>
