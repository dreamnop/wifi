<?php

namespace backend\behaviors;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\db\ActiveRecord;
use backend\models\Radgroupcheck;
use backend\models\Radgroupreply;

/**
 * Description of GroupsBehaviors
 *
 * @author root
 */
class GroupsBehaviors extends \yii\behaviors\AttributeBehavior {

    public function events() {

        return[
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate'
        ];
    }

    public function beforeInsert() {
        if ($this->owner->isNewRecord) {
            $this->owner->groupname = 'group' . date('YmdHis') . $this->owner->groupname;
        }
    }

    public function afterSave() {

        //---------------------start radgroupcheck ------------------//         
        $radgroupcheck = new Radgroupcheck();
        $radgroupcheck->groupname = $this->owner->groupname;
        $radgroupcheck->attribute = "Auth-Type";
        $radgroupcheck->value = "Local";
        $radgroupcheck->save();

        if ($this->owner->simultaneous > 0) {

            $radgroupcheck = new Radgroupcheck();
            $radgroupcheck->groupname = $this->owner->groupname;
            $radgroupcheck->attribute = "Simultaneous-Use";
            $radgroupcheck->value = $this->owner->simultaneous;
            $radgroupcheck->save();
        }
        if ($this->owner->gtime > 0) {

            $radgroupcheck = new Radgroupcheck();
            $radgroupcheck->groupname = $this->owner->groupname;
            $radgroupcheck->attribute = "Max-All-Session";
            $radgroupcheck->value = ($this->owner->gtime * 60) * 60;
            $radgroupcheck->save(false);
        }


        //---------------------End radgroupcheck ------------------//       
        //---------------------start tables radgroupreply -------//
        $radgroupreply = new Radgroupreply();
        $radgroupreply->groupname = $this->owner->groupname;
        $radgroupreply->attribute = "Service-Type";
        $radgroupreply->value = "Login-User";
        $radgroupreply->save();

        //ต้องการให้ทำเงื่อนไข
        if ($this->owner->gupload > 0) {
            $radgroupreply = new Radgroupreply();
            $radgroupreply->groupname = $this->owner->groupname;
            $radgroupreply->attribute = "WISPr-Bandwidth-Max-Up";
            $radgroupreply->value = $this->owner->gupload;
            $radgroupreply->save();
        }

        if ($this->owner->gdownload > 0) {
            $radgroupreply = new Radgroupreply();
            $radgroupreply->groupname = $this->owner->groupname;
            $radgroupreply->attribute = "WISPr-Bandwidth-Max-Down";
            $radgroupreply->value = $this->owner->gdownload;
            $radgroupreply->save();
        }

        if ($this->owner->redirection != '') {
            $radgroupreply = new Radgroupreply();
            $radgroupreply->groupname = $this->owner->groupname;
            $radgroupreply->attribute = "WISPr-Redirection-URL";
            $radgroupreply->value = $this->owner->redirection;
            $radgroupreply->save();
        }


        $radgroupreply = new Radgroupreply();
        $radgroupreply->groupname = $this->owner->groupname;
        $radgroupreply->attribute = "Idle-Timeout";
        $radgroupreply->value = $this->owner->autologout;
        $radgroupreply->save();


        // $radgroupreply->value=$this->$autologout*60;
        $radgroupreply = new Radgroupreply();
        $radgroupreply->groupname = $this->owner->groupname;
        $radgroupreply->attribute = "Acct-Interim-Interval";
        $radgroupreply->value = "60";
        $radgroupreply->save();

        //---------------------END tables radgroupreply -------//        
    }

    public function afterUpdate() {
        //---------------------config Howmany User Login ------------------//         

        if ($this->owner->simultaneous > 0) {

            $radgroupchecks = Radgroupcheck::find()->where([
                        'groupname' => $this->owner->groupname,
                        'attribute' => 'Simultaneous-Use'
                    ])->all();
            if (count($radgroupchecks) == 0) {
                $radgroupcheck = new Radgroupcheck();
                $radgroupcheck->groupname = $this->owner->groupname;
                $radgroupcheck->attribute = "Simultaneous-Use";
                $radgroupcheck->value = $this->owner->simultaneous;
                $radgroupcheck->save();
            }
            //  \yii\helpers\VarDumper::dump($radgroupchecks,10,true);
            //  echo $this->owner->simultaneous;
            else {
                foreach ($radgroupchecks as $radgroupcheck) {

                    $radgroupcheck->value = $this->owner->simultaneous;
                    // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                    $radgroupcheck->save(false);
                }
            }


            //exit;
        }

        if ($this->owner->simultaneous == 0) {

            $radgroupchecks = Radgroupcheck::find()->where([
                        'groupname' => $this->owner->groupname,
                        'attribute' => 'Simultaneous-Use'
                    ])->all();
            foreach ($radgroupchecks as $radgroupcheck) {

                $radgroupcheck->value = $this->owner->simultaneous;
                // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                $radgroupcheck->delete(false);
            }
        }
        //----------------End User Login -----//
        //--- กำหนดระยะเวลาการใช้งาน ชม.---//
        if ($this->owner->gtime > 0) {

            $radgroupchecks = Radgroupcheck::find()->where([

                        'groupname' => $this->owner->groupname,
                        'attribute' => 'Max-All-Session'
                    ])->all();
            if (count($radgroupchecks) == 0) {
                $radgroupcheck = new Radgroupcheck();
                $radgroupcheck->groupname = $this->owner->groupname;
                $radgroupcheck->attribute = "Max-All-Session";
                $radgroupcheck->value = ($this->owner->gtime * 60) * 60;
                $radgroupcheck->save(false);
            } else {
                foreach ($radgroupchecks as $radgroupcheck) {

                    $radgroupcheck->value = ($this->owner->gtime * 60) * 60;
                    // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                    $radgroupcheck->save(false);
                }
            }
        }
        if ($this->owner->gtime == 0) {

            $radgroupchecks = Radgroupcheck::find()->where([
                        'groupname' => $this->owner->groupname,
                        'attribute' => 'Max-All-Session'
                    ])->all();
            foreach ($radgroupchecks as $radgroupcheck) {

                $radgroupcheck->value = $this->owner->gtime;
                // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                $radgroupcheck->delete(false);
            }
        }

        //---------------------End radgroupcheck ------------------//  
        //---------------------start tables radgroupreply -------//
        //ต้องการให้ทำเงื่อนไข

        if ($this->owner->gupload > 0) {

            $radgroupreplys = Radgroupreply::find()->where([

                        'groupname' => $this->owner->groupname,
                        'attribute' => 'WISPr-Bandwidth-Max-Up'
                    ])->all();
            if (count($radgroupreplys) == 0) {
                $radgroupreply = new Radgroupreply();
                $radgroupreply->groupname = $this->owner->groupname;
                $radgroupreply->attribute = 'WISPr-Bandwidth-Max-Up';
                $radgroupreply->value = $this->owner->gupload;
                $radgroupreply->save(false);
            } else {
                foreach ($radgroupreplys as $radgroupreply) {

                    $radgroupreply->value = $this->owner->gupload;
                    // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                    $radgroupreply->save(false);
                }
            }
        }
        if ($this->owner->gupload == 0) {

            $radgroupreplys = Radgroupreply::find()->where([
                        'groupname' => $this->owner->groupname,
                        'attribute' => 'WISPr-Bandwidth-Max-Up'
                    ])->all();
            foreach ($radgroupreplys as $radgroupreply) {

                $radgroupreply->value = $this->owner->gupload;
                // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                $radgroupreply->delete(false);
            }
        }
        //-----------------------End Upload ------------//
        
        //-----------------------Begin Download---------------//
        
        if ($this->owner->gdownload > 0) {

            $radgroupreplys = Radgroupreply::find()->where([

                        'groupname' => $this->owner->groupname,
                        'attribute' => 'WISPr-Bandwidth-Max-Down'
                    ])->all();
            if (count($radgroupreplys) == 0) {
                $radgroupreply = new Radgroupreply();
                $radgroupreply->groupname = $this->owner->groupname;
                $radgroupreply->attribute = 'WISPr-Bandwidth-Max-Down';
                $radgroupreply->value = $this->owner->gdownload;
                $radgroupreply->save(false);
            } else {
                foreach ($radgroupreplys as $radgroupreply) {

                    $radgroupreply->value = $this->owner->gdownload;
                    // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                    $radgroupreply->save(false);
                }
            }
        }
        if ($this->owner->gdownload == 0) {

            $radgroupreplys = Radgroupreply::find()->where([
                        'groupname' => $this->owner->groupname,
                        'attribute' => 'WISPr-Bandwidth-Max-Down'
                    ])->all();
            foreach ($radgroupreplys as $radgroupreply) {

                $radgroupreply->value = $this->owner->gdownload;
                // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                $radgroupreply->delete(false);
            }
        }
        //-----------------------------End Download -------------//
        
        //-----------------------Begin Redirect---------------//
        
        if ($this->owner->redirection != "") {

            $radgroupreplys = Radgroupreply::find()->where([

                        'groupname' => $this->owner->groupname,
                        'attribute' => 'WISPr-Redirection-URL'
                    ])->all();
            if (count($radgroupreplys) == 0) {
                $radgroupreply = new Radgroupreply();
                $radgroupreply->groupname = $this->owner->groupname;
                $radgroupreply->attribute = 'WISPr-Redirection-URL';
                $radgroupreply->value = $this->owner->redirection;
                $radgroupreply->save(false);
            } else {
                foreach ($radgroupreplys as $radgroupreply) {

                    $radgroupreply->value = $this->owner->redirection;
                    // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                    $radgroupreply->save(false);
                }
            }
        }
        if ($this->owner->redirection == "") {

            $radgroupreplys = Radgroupreply::find()->where([
                        'groupname' => $this->owner->groupname,
                        'attribute' => 'WISPr-Redirection-URL'
                    ])->all();
            foreach ($radgroupreplys as $radgroupreply) {

                $radgroupreply->value = $this->owner->redirection;
                // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                $radgroupreply->delete(false);
            }
        }
        //-----------------------------End Redirect -------------//
     
        //-----------------------Begin AutoLogout---------------//
        
        if ($this->owner->autologout > 0) {

            $radgroupreplys = Radgroupreply::find()->where([

                        'groupname' => $this->owner->groupname,
                        'attribute' => 'Idle-Timeout'
                    ])->all();
            if (count($radgroupreplys) == 0) {
                $radgroupreply = new Radgroupreply();
                $radgroupreply->groupname = $this->owner->groupname;
                $radgroupreply->attribute = 'Idle-Timeout';
                $radgroupreply->value = $this->owner->autologout;
                $radgroupreply->save(false);
            } else {
                foreach ($radgroupreplys as $radgroupreply) {

                    $radgroupreply->value = $this->owner->autologout;
                    // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                    $radgroupreply->save(false);
                }
            }
        }
        if ($this->owner->autologout == 0) {

            $radgroupreplys = Radgroupreply::find()->where([
                        'groupname' => $this->owner->groupname,
                        'attribute' => 'Idle-Timeout'
                    ])->all();
            foreach ($radgroupreplys as $radgroupreply) {

                $radgroupreply->value = $this->owner->autologout;
                // \yii\helpers\VarDumper::dump($radgroupcheck,10,true);
                $radgroupreply->delete(false);
            }
        }
        //-----------------------------End AutoLogout -------------//
        
    }

}
