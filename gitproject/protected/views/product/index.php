<?php
/* @var $this ProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'ผลิตภัณฑ์',
);

$this->menu = array(
    array('label' => 'Create Product', 'url' => array('create')),
    array('label' => 'Manage Product', 'url' => array('admin')),
);
?>

<h1>ผลิตภัณฑ์ของเรา</h1>

<?php
$this->widget('ext.widgets.EColumnListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'columns' => 2
));
?>
