<h1>สินค้าในตะกร้า</h1>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'mycart-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'clientOptions' => array('validateOnSubmit' => false),
            ));
    ?>
        <?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info,#info-error").animate({opacity: 1.0}, 3000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td bgcolor="#62C0FF"><strong>รหัสสินค้า</strong></td>
    <td bgcolor="#62C0FF"><strong>ชื่อสินค้า</strong></td>
    <td bgcolor="#62C0FF"><strong>ราคา/หน่วย</strong></td>
    <td bgcolor="#62C0FF"><strong>จำนวน</strong></td>
    <td bgcolor="#62C0FF"><strong>ราคารวม</strong></td>
    <td bgcolor="#62C0FF"><strong>ลบ</strong></td>
  </tr>
  <?php 
  $allQty=0;
  $totalPrice=0;
  if(!empty($showCarts)){
  foreach($showCarts as $showCart) {
	  $price=$showCart->getPrice();
	  $quantity=$showCart->getQuantity();
	  $totalPrice+=($price*$quantity);
	  $allQty+=$quantity;
  ?>
  <tr>
    <td><?=$showCart->getCode()?></td>
    <td><?=$showCart->getName()?></td>
    <td><?=$price?></td>
    <td><input type="text" name="quantity[<?=$showCart->getId()?>]" value="<?=$quantity?>"  style="width:50px;" /></td>
    <td><?=$showCart->getSumPrice()?></td>
    <td>
   <?php  //echo CHtml::link('[X]',array('product/showcart', 'remove'=>$showCart->getId()));
   echo CHtml::link('Delete','#',array('submit'=>array('product/showcart','remove'=>$showCart->getId()),'confirm' => 'Are you sure?'));
   ?>
    </td>
  </tr>
  <?php } ?>

  <tr>
    <td colspan="3" align="right"><strong>รวมทั้งหมด</strong></td>
    <td><strong>
      <?=$allQty?>
    </strong></td>
    <td><strong>
      <?=$totalPrice?>
    </strong></td>
    <td>&nbsp;</td>
  </tr>
  
    <tr>
      <td colspan="6" align="center"><?php echo CHtml::link('Delete All','#',array('submit'=>array('product/showcart','removeAll'=>'OK'),'confirm' => 'Are you sure?'));?>
      <input type="submit" name="btnUpdate" value="Update" /> 
      <?php echo CHtml::link('ซื้อสินค้าต่อ',array('product/index'));?>   <?php echo CHtml::link('ยืนยันการสั่งซื้อ',array('product/orderconfirm'));?></td>
    </tr>
    <?php }else{ ?>
    <tr>
    <td colspan="6" align="center"><strong>ไม่พบสินค้าในตะกร้า</strong></td>
  </tr>
  <?php } ?>
</table>
<?php $this->endWidget(); ?>
