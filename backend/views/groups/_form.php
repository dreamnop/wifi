<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Groups */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container">    

    <div id="loginbox" class="mainbox col-md-12 "> 
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-left">จัดการกลุ่มผู้ใช้งาน</div>
            </div>     

            <div class="panel-body" >
                <div class="groups-form">
                    <div class="row">

                        <?php $form = ActiveForm::begin(); ?>
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <?php //echo $form->field($model, 'groupname')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'gdesc')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <?=
                            $form->field($model, 'gupload')->dropDownList
                                    ([

                                64 * 1024 => '64 K',
                                128 * 1024 => '128 K',
                                256 * 1024 => '256 K',
                                512 * 1024 => '512 K',
                                1024 * 1024 => '1 M',
                                1536 * 1024 => '1.5 M',
                                2048 * 1024 => '2 M',
                                3072 * 1024 => '3 M',
                                5120 * 1024 => '5 M',
                                10240 * 1024 => '10 M',
                                0 => 'ไม่จำกัด '
                            ]);
                            ?>
                        </div>         
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <?=
                            $form->field($model, 'gdownload')->dropDownList
                                    ([

                                128 * 1024 => '128 K',
                                256 * 1024 => '256 K',
                                512 * 1024 => '512 K',
                                1024 * 1024 => '1 M',
                                1536 * 1024 => '1.5 M',
                                2048 * 1024 => '2 M',
                                3072 * 1024 => '3 M',
                                5120 * 1024 => '5 M',
                                8192 * 1024 => '8 M',
                                10240 * 1024 => '10 M',
                                12288 * 1024 => '12 M',
                                15360 * 1024 => '15 M',
                                20480 * 1024 => '20 M',
                                30720 * 1024 => '30 M',
                                40960 * 1024 => '40 M',
                                51200 * 1024 => '50 M',
                                0 => 'ไม่จำกัด '
                            ]);
                            ?>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <?php
                               // $model->gtime= 0;
                               // $model->glimited= 0;
                               // $model->gprice=0;
                            ?>
                            <?= $form->field($model, 'gtime')->textInput() ?>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <?= $form->field($model, 'glimited')->textInput() ?>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <?= $form->field($model, 'gprice')->textInput() ?>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <?=
                            $form->field($model, 'autologout')->dropDownList([

                                300 => '5 นาที',
                                600 => '10 นาที',
                                900 => '15 นาที',
                                1800 => '30 นาที',
                                3600 => '1 ชั่วโมง',
                                0 => 'ไม่จำกัด']);
                            ?>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <?=
                            $form->field($model, 'simultaneous')->dropDownList([
                                1 => '1 เครื่อง',
                                2 => '2 เครื่อง',
                                3 => '3 เครื่อง',
                                5 => '5 เครื่อง',
                                10 => '10 เครื่อง',
                                0 => 'ไม่จำกัด',
                            ]);
                            ?>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <?= $form->field($model, 'redirection')->textInput() ?>
                            <?php //echo $form->field($model, 'gstatus')->textInput()  ?>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-12 controls text-right">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>

                </div>
            </div>
        </div>
    </div>





