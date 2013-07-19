<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>
<script src="<?php echo Yii::app()->baseUrl . '/js/ckeditor/ckeditor.js'; ?>"></script>
<script src="<?php echo Yii::app()->baseUrl . '/js/jsfunc.js'; ?>"></script>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        )
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'product_code'); ?>
        <?php echo $form->textField($model, 'product_code', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'product_code'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'category_id'); ?>
        <?php echo $form->dropDownList($model,'category_id', $this->getCategoryOptions(), array('empty' => 'เลือกหมวด')); // echo $form->textField($model,'category_id'); ?>
        <?php echo $form->error($model, 'category_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'product_name'); ?>
        <?php echo $form->textField($model, 'product_name', array('size' => 60, 'maxlength' => 80)); ?>
        <?php echo $form->error($model, 'product_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'product_amount'); ?>
        <?php echo $form->textField($model, 'product_amount', array('size' => 5, 'maxlength' => 5)); ?>
        <?php echo $form->error($model, 'product_amount'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'product_price'); ?>
        <?php echo $form->textField($model, 'product_price', array('size' => 11, 'maxlength' => 11)); ?>
        <?php echo $form->error($model, 'product_price'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'product_detail'); ?>
        <?php /* $this->widget('ext.ckeditor.CKEditorWidget',array(
          'model'=>$model,                # Data-Model (form model)
          'attribute'=>'product_detail',         # Attribute in the Data-Model
          "config" => array(
          "height"=>"400px",
          "width"=>"100%",
          "toolbar"=>"Basic",
          ),
          "ckEditor"=>Yii::app()->basePath."/../ckeditor/ckeditor.php",
          "ckBasePath"=>Yii::app()->baseUrl."/ckeditor/",
          )); */
        echo $form->textArea($model, 'product_detail', array('rows' => 6, 'cols' => 50, 'id' => 'product_detail')); ?>
        <?php echo $form->error($model, 'product_detail'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'product_image'); ?>
        <?php echo CHtml::activeFileField($model, 'product_image'); ?>
        <?php echo $form->error($model, 'product_image'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    loadCkeditor();
</script>