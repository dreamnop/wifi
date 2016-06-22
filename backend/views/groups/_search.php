<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GroupsSearch */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="groups-search">
    <div class="row">
        <div class="col-lg-7">
            
        </div>
        <div class="col-lg-1" align="right">
            <?php echo "ชื่อกลุ่ม"; ?>
        </div>
        <div class="col-lg-3" align="right">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php //echo $form->field($model, 'groupname') ?>

    <?php //echo $form->field($model, 'gdesc') ?>
    
    <?= $form->field($model, 'gdesc')->label(false) ?>
    <?php //echo $form->field($model, 'gupload') ?>

    <?php //echo $form->field($model, 'gdownload') ?>

    <?php // echo $form->field($model, 'gtime') ?>

    <?php // echo $form->field($model, 'glimited') ?>

    <?php // echo $form->field($model, 'gprice') ?>

    <?php // echo $form->field($model, 'gstatus') ?>
</div>
        <div class="col-lg-1" align="right">
            <div class="form-group">
   
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php //echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

