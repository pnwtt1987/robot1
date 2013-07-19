<?php
/* @var $this ProductController */
/* @var $data Product */
//echo YiiBase::getPathOfAlias('webroot');
//echo Yii::app()->basePath;
$url = 'http://' . Yii::app()->request->getServerName() . '/' . $this->mainFolder;
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/prettyphoto/css/prettyPhoto.css" />
<script src="<?php echo Yii::app()->baseUrl . '/js/prettyphoto/js/jquery.prettyPhoto.js'; ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".image_zoom:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed: 'fast',social_tools:false});
        $(".image_zoom:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed: 'fast',social_tools:false});
        $(".image_zoom ").hover(function() {
            $(".icon_zoom ", this).show("300");
        }, function() {
            $(".icon_zoom ", this).hide("300");
        });
    });
</script>
<div class="view">
    
    <div style="float:left;" class="image_zoom">

        <a href="<?php echo "$url/images/products/larges/" . CHtml::encode($data->product_image); ?>" rel="prettyPhoto" title="<?=$data->product_name?>">
            <div class="icon_zoom" style="display: none;">
                <?php echo CHtml::image("$url/images/icons/zoom.png","",array("border"=>0)) ?>
            </div>
            <?php
            echo CHtml::image("$url/images/products/thumbs/" . CHtml::encode($data->product_image), "$data->product_name", array("width" => 180))
            ?>
        </a>
    </div>
    <div style="float:left;margin-left:10px;">
        <b><?php echo CHtml::encode($data->getAttributeLabel('product_code')); ?>:</b>
        <?php echo CHtml::link(CHtml::encode($data->product_code), array('view', 'id' => $data->product_id)); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('category_name')); ?>:</b>
        <?php echo CHtml::encode($data->category_name); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('product_name')); ?>:</b>
        <?php echo CHtml::encode($data->product_name); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('product_amount')); ?>:</b>
        <?php echo CHtml::encode($data->product_amount); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('product_price')); ?>:</b>
        <?php echo CHtml::encode($data->product_price); ?>
        <br />
        <?php
        echo CHtml::link('หยิบใส่ตะกร้า', array('product/addtocart',
            'cartId' => $data->product_id));
        ?>

    </div><br style="clear:both;" />
</div>