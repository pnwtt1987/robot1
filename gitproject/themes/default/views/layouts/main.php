<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <script type="text/javascript">
            $(document).ready(function() {
                var imgPathLast;
                var imgFileHover;
                $('#headersub a ').find('img').hover(function() {
                    var imgPath = $(this).attr('src');
                    var imgPathArr = imgPath.split("/");
                    imgPathLast = imgPathArr.slice(-1)[0];
                    var imgFileCurent = imgPathLast.split(".");
                    imgFileHover = imgFileCurent[0] + "_hover." + imgFileCurent[1];
                        $(this).attr("src", "<?php echo Yii::app()->request->baseUrl; ?>/css/images/" + imgFileHover).fadeIn();
                }, function() {
                    $(this).attr("src", "<?php echo Yii::app()->request->baseUrl; ?>/css/images/" + imgPathLast);
                });
            });
          
        </script>
    </head>
    <body>
        <div class="container" id="page">
            <div id="header">
                 <div id="headersub">
                     <div align="right" style="margin-top:20px;position:absolute;">
                         <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/images/login.png" border="0"/></a>
                     </div>
                <div id="navi_menu">
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/site"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/images/navi_home.png" border="0"/></a>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/product"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/images/navi_ourproducts.png" border="0"/></a>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/site/contact"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/images/navi_contactus.png" border="0"/></a>
                </div>
                 </div>
            </div><!-- header -->

           <!-- <div id="mainmenu">
                <?php
               // $this->widget('zii.widgets.CMenu', array(
                    //'items' => array(
                     //   array('label' => 'Home', 'url' => array('/site/index')),
                    //    array('label' => 'ผลิตภัณฑ์', 'url' => array('/product/index')),
                    //    array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
                    //    array('label' => 'Contact', 'url' => array('/site/contact')),
                     //   array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                   //     array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                    //    array('label' => 'ตะกร้าสินค้า', 'url' => array('/product/showcart')),
                   // ),
                //));
                ?>
            </div>-->
            
            <!-- mainmenu -->
            <div id="maincontent">
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div id="info">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
                <div class="clear"></div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('error')): ?>
                <div id="info-error">
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
                <div class="clear"></div>
            <?php endif; ?>
            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>

            <?php echo $content; ?>

            <div class="clear"></div>

            <div id="footer">
                Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
                All Rights Reserved.<br/>
                <?php echo Yii::powered(); ?>
            </div><!-- footer -->
            </div>
        </div><!-- page -->

    </body>
</html>
