<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs = array(
    'ผลิตภัณฑ์' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Product', 'url' => array('index')),
    array('label' => 'Create Product', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#product-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>จัดการสินค้าในร้าน</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('ค้นหาสินค้า', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
//$assetsDir = dirname(__FILE__).'/../images/products/thumbs';
$url= 'http://'.Yii::app()->request->getServerName().'/'.$this->mainFolder;
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'product-grid',
    'dataProvider' => $model->search(),
    //'filter'=>$model,
    'columns' => array(
        array('name' => 'product_image',
            'type' => 'html',
            'value' => 'CHtml::image("'.$url.'/images/products/thumbs/".$data->product_image, "$data->product_name",array("width"=>100,"height"=>100))'),
        'product_code',
        'product_name',
        'category_name',
        'product_amount',
        'product_price',
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'delete' => array(
                    'label' => 'delete',
                    'url' => 'Yii::app()->createUrl("product/delete", array("id"=>$data->product_id,"img"=>$data->product_image))',
                ),
            )
        ),
    ),
));
?>
