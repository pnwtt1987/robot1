<h1>ยืนยันการสั่งซื้อ</h1>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
    <tr>
        <td bgcolor="#62C0FF"><strong>รหัสสินค้า</strong></td>
        <td bgcolor="#62C0FF"><strong>ชื่อสินค้า</strong></td>
        <td bgcolor="#62C0FF"><strong>ราคา/หน่วย</strong></td>
        <td bgcolor="#62C0FF"><strong>จำนวน</strong></td>
        <td bgcolor="#62C0FF"><strong>ราคารวม</strong></td>
    </tr>
    <?php
    $allQty = 0;
    $totalPrice = 0;
    if (!empty($showCarts)) {
        foreach ($showCarts as $showCart) {
            $price = $showCart->getPrice();
            $quantity = $showCart->getQuantity();
            $totalPrice+=($price * $quantity);
            $allQty+=$quantity;
            ?>
            <tr>
                <td><?= $showCart->getCode() ?></td>
                <td><?= $showCart->getName() ?></td>
                <td><?= $price ?></td>
                <td><?= $quantity ?></td>
                <td><?= $showCart->getSumPrice() ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="3" align="right"><strong>รวมทั้งหมด</strong></td>
            <td><strong>
                    <?= $allQty ?>
                </strong></td>
            <td><strong>
                    <?= $totalPrice ?>
                </strong></td>
        </tr>
    <?php } else { ?>
    <?php } ?>
</table>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'mycart-form',
    'action' => 'ordersave',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'clientOptions' => array('validateOnSubmit' => false),
        ));
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr>
        <td colspan="2" bgcolor="#FFFF66"><strong>ที่อยู่ในการจัดส่ง</strong></td>
    </tr>
    <tr>
        <td width="27%" align="right"><strong>ชื่อ-สกุล</strong></td>
        <td width="73%">
            <?php echo $form->textField($model_user, 'user_name', array('size' => 30, 'maxlength' => 50)); ?>
            <?php echo $form->error($model_user, 'user_name'); ?>
        </td>
    </tr>
    <tr>
        <td align="right"><strong>เบอร์โทร</strong></td>
        <td>
              <?php echo $form->textField($model_user, 'user_tel', array('size' => 20, 'maxlength' => 20)); ?>
            <?php echo $form->error($model_user, 'user_tel'); ?>
            
        </td>
    </tr>
    <tr>
        <td align="right"><strong>ที่อยู่</strong></td>
        <td>
              <?php echo $form->textArea($model_user, 'user_address', array('rows' => 6, 'cols' => 50, 'id' => 'user_address')); ?>
            <?php echo $form->error($model_user, 'user_address'); ?>
            </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="bt_ordersave" id="bt_ordersave" value="บันทึกข้อมูล" /></td>
    </tr>
</table>
<?php $this->endWidget(); ?>