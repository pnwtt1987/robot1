<?php

class ProductController extends Controller {

    public $layout = '//layouts/column2';

    //public function beforeAction($action) {

        //Yii::app()->theme = 'admin';
       // return true;
    //}

    public function filters() {
        return array(
            // 'accessControl', // perform access control for CRUD operations
            // 'postOnly + delete', // we only allow deletion via POST request
            'rights'
        );
    }

    /*  public function accessRules() {
      return array(
      array('allow', // allow all users to perform 'index' and 'view' actions
      'actions' => array('index', 'view'),
      'users' => array('*'),
      ),
      array('allow', // allow authenticated user to perform 'create' and 'update' actions
      'actions' => array('create', 'update'),
      'users' => array('@'),
      ),
      array('allow', // allow admin user to perform 'admin' and 'delete' actions
      'actions' => array('admin', 'delete'),
      'users' => array('admin'),
      ),
      array('deny', // deny all users
      'users' => array('*'),
      ),
      );
      } */

    public function actionAddtocart($cartId = 0) {
        $model = new Product;
        $qty_total = 0;
        $qty_in_cart = 0;
        $qty_in_db = 0;
        $cart = Yii::app()->shoppingCart;
        $product = $model->findByPk($cartId);
        $cart->put($product);
        $posi_quantity = $cart->itemAt($cartId);
        $qty_in_cart = $posi_quantity->getQuantity();
        $qty_in_db = $product->product_amount;
        $qty_total = $qty_in_cart + $qty_in_db;
        if ($qty_in_cart > $qty_in_db) {//จำนวนในตะกร้ามากกว่าในฐานข้อมูล 
            $cart->update($product, $qty_in_db); //กำหนดให้เท่ากับจำนวนในฐานข้อมูล
            Yii::app()->user->setFlash('error', "สั่งสินค้าเกิน");
            $this->redirect(array('showcart'));
        } else {
            if (!empty($product)) {
                Yii::app()->user->setFlash('success', "หยิบสินค้าลงในตะกร้าเรียบร้อยแล้ว");
                $this->redirect(array('showcart'));
            } else {
                $this->redirect(array('index'));
            }
        }
    }

    public function actionShowcart($remove = null, $removeAll = null) {
        $btnUpdates = isset($_POST['btnUpdate']) ? $_POST['btnUpdate'] : 0;
        $quantitys = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
        if (!empty($remove)) {
            $this->cartRemove($remove);
            Yii::app()->user->setFlash('success', "ลบรายการสินค้าในตะกร้าเรียบร้อยแล้ว");
            $this->redirect(array('showcart'));
        } else if (!empty($removeAll)) {
            Yii::app()->shoppingCart->clear();
            Yii::app()->user->setFlash('success', "เคลียร์รายการสินค้าในตะกร้าเรียบร้อยแล้ว");
            $this->redirect(array('showcart'));
        } else if (!empty($btnUpdates)) {
            Yii::app()->user->setFlash('success', "อัพเดทรายการสินค้าในตะกร้าเรียบร้อยแล้ว");
            foreach ($quantitys as $qtyId => $qtyVal) {
                if (!empty($qtyVal)) {
                    $product = Product::model()->findByPk($qtyId);
                    $cart = Yii::app()->shoppingCart;
                    $cart->update($product, $qtyVal);
                    $posi_quantity = $cart->itemAt($qtyId);
                    $qty_in_cart = $posi_quantity->getQuantity();
                    $qty_in_db = $product->product_amount;
                    if ($qty_in_cart > $qty_in_db) {//จำนวนในตะกร้ามากกว่าในฐานข้อมูล 
                        $cart->update($product, $qty_in_db); //กำหนดให้เท่ากับจำนวนในฐานข้อมูล
                        Yii::app()->user->setFlash('error', "สั่งสินค้าเกิน");
                    }
                } else {
                    $this->cartRemove($qtyId);
                }
            }
            $this->redirect(array('showcart'));
        } else {
            $showCarts = Yii::app()->shoppingCart->getPositions();
            $this->render('showcart', array('showCarts' => $showCarts));
        }
    }

    public function actionOrderConfirm() {
        $userId = Yii::app()->user->id;
        $showUser = User::model()->findByPk($userId);
        // $showUser =User::model()->loadModel($userId);
        $showCarts = Yii::app()->shoppingCart->getPositions();
        $this->render('orderconfirm', array('showCarts' => $showCarts, 'model_user' => $showUser));
    }

    public function actionOrderSave() {
        //บันทึกลง order กับ orderview และ update จำนวนสินค้าใน product
        if (isset($_POST['User'])) {
            $model_order = new Order();
            $model_orderv = new Orderview();
            $model_order->attributes = $_POST['User'];
            $userId = Yii::app()->user->id; //รหัสสมาชิก
            $name = trim($model_order['user_name']); //ชื่อสมาชิก
            $tel = trim($model_order['user_tel']); //เบอร์โทรสมาชิก
            $address = trim(nl2br($model_order['user_tel'])); //ที่อยู่สมาชิก
            $model_order->user_id = $userId;
            $model_order->user_name = $name;
            $model_order->user_tel = $tel;
            $model_order->user_address = $address;
            $model_order->od_date = date('Y-m-d');
            if ($model_order->save()) {
                $last_order_id = Yii::app()->db->getLastInsertID(); //หา Id ล่าสุด
                $showCarts = Yii::app()->shoppingCart->getPositions();
                //insert ลง orderview
                foreach ($showCarts as $showCart) {
                    $model_orderv->setIsNewRecord(true);
                    $model_orderv->setPrimaryKey(NULL);
                    $model_orderv->od_id = $last_order_id; //รหัสใบสั่งซื้อ
                    $pd_id = $showCart->getId(); //รหัสสินค้า
                    $pd_qty = $showCart->getQuantity();
                    $model_orderv->product_id = $pd_id;
                    $model_orderv->product_name = $showCart->getName();
                    $model_orderv->odv_price = $showCart->getPrice(); //ราคา/ชิ้น
                    $model_orderv->odv_amount = $pd_qty; //จำนวน/ชิ้น
                    if ($model_orderv->save(false)) {
                        $model_pd = Product::model()->findByPk($pd_id);
                        $model_pd->product_amount = ($model_pd->product_amount - $pd_qty);
                        $model_pd->save(); //update จำนวนสินค้า
                    }
                }
                Yii::app()->shoppingCart->clear();
                $this->redirect(array('index'));
            }
        } else {
            $this->redirect(array('showcart'));
        }
    }

    private function cartRemove($remove) {
        Yii::app()->shoppingCart->remove($remove);
    }

    public function actionCreate() {
        Yii::app()->theme = 'admin';
        $model = new Product;
        $rnd = date('dmYHis');
        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $uploadedFile = CUploadedFile::getInstance($model, 'product_image');
            $filetype = end(explode('.', $uploadedFile));
            $fileName = "{$rnd}.{$filetype}";
            $model->product_image = $fileName;
            $model->product_create = date('Y-m-d H:i:s');
            $model->product_update = date('Y-m-d H:i:s');
            if ($model->save()) {
                $uploadedFile->saveAs(dirname(__FILE__) . '/../../images/products/larges/' . $fileName);
                Yii::import('ext.phpthumb.EasyPhpThumb');
                $thumbs = new EasyPhpThumb();
                $thumbs->init();
                $thumbs->setThumbsDirectory('/images/products/thumbs');
                $thumbs->load(Yii::getPathOfAlias('webroot') . '/images/products/larges/' . $fileName)->resize(200, 0)->save($fileName, strtoupper($filetype));
                chmod(dirname(__FILE__) . '/../../images/products/larges/' . $fileName, 0777);
                chmod(dirname(__FILE__) . '/../../images/products/thumbs/' . $fileName, 0777);
                $this->redirect(array('view', 'id' => $model->product_id));
            }
        }
        
        $this->render('create', array(
            'model' => $model,
        ));
        
    }

    public function actionUpdate($id) {
         Yii::app()->theme = 'admin';
        $model = $this->loadModel($id);
        if (isset($_POST['Product'])) {
            //$model->attributes = $_POST['Product'];
           /* $uploadedFile = CUploadedFile::getInstance($model, 'product_image');
            if (!empty($uploadedFile->name)) {
                if (!empty($model->product_old_image)) {
                    @unlink(Yii::app()->basePath . "/../images/products/thumbs/" . $model->product_old_image); //ลบไฟล์เดิมทิ้ง
                    @unlink(Yii::app()->basePath . "/../images/products/larges/" . $model->product_old_image); //ลบไฟล์เดิมทิ้ง
                }
                $rnd = date('dmYHis');
                $uppath = explode('.', $uploadedFile);
                $filetype = end($uppath);
                $fileName = "{$rnd}.{$filetype}";
                $model->product_image = $fileName;
                $uploadedFile->saveAs(dirname(__FILE__) . '/../../images/products/larges/' . $fileName);
                Yii::import('ext.phpthumb.EasyPhpThumb');
                $thumbs = new EasyPhpThumb();
                $thumbs->init();
                $thumbs->setThumbsDirectory('/images/products/thumbs');
                $thumbs->load(Yii::getPathOfAlias('webroot') . '/images/products/larges/' . $fileName)->resize(200, 0)->save($fileName, strtoupper($filetype));
                chmod(dirname(__FILE__) . '/../../images/products/thumbs/' . $fileName, 0777);
                chmod(dirname(__FILE__) . '/../../images/products/larges/' . $fileName, 0777);
            }*/
            $model->product_name = $_POST['Product']['product_name'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->product_id));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id, $img) {
        $this->loadModel($id)->delete();
        @unlink(Yii::app()->basePath . "/../images/products/thumbs/" . $img); //ลบไฟล์เดิมทิ้ง
        @unlink(Yii::app()->basePath . "/../images/products/larges/" . $img); //ลบไฟล์เดิมทิ้ง
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionIndex() {
        $criteria = new CDbCriteria;
        //$criteria->together = true;
        $criteria->with = array('category');
        $criteria->select = 'category.category_name as category_name,t.product_code,t.product_name,t.product_amount,t.product_price,t.product_image';
        $dataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $criteria));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
         Yii::app()->theme = 'admin';
        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $model->attributes = $_GET['Product'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    private function loadModel($id) {

        $model = Product::model()->with(array('category' => array(
                        'select' => 'category_name')))->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function getCategoryOptions() {
        $records = Category::model()->findAll();
        $list = CHtml::listData($records, 'category_id', 'category_name');
        return $list;
    }

}