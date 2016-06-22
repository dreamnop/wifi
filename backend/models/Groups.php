<?php

namespace backend\models;

use Yii;
use backend\models\Radgroupcheck;
use backend\models\Radgroupreply;
use backend\behaviors\GroupsBehaviors;
/**
 * This is the model class for table "groups".
 *
 * @property integer $id
 * @property string $groupname
 * @property string $gdesc
 * @property integer $gupload
 * @property integer $gdownload
 * @property integer $gtime
 * @property integer $glimited
 * @property integer $gprice
 * @property integer $gstatus
 *
 * @property Radgroupcheck[] $radgroupchecks
 * @property Radgroupreply[] $radgroupreplies
 * @property Radusergroup[] $radusergroups
 */
class Groups extends \yii\db\ActiveRecord
{
    //public $autologout;
    //public $simultaneous;
   // public $redirection;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'groups';
    }
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gupload','autologout','simultaneous', 'gdownload', 'gtime', 'glimited', 'gprice', 'gstatus'], 'integer'],
            [['groupname'], 'string', 'max' => 64],
            [['gdesc','redirection'], 'string', 'max' => 200],
            [['groupname'], 'unique'],
            [['gdesc'], 'unique'],
            [['gdesc','gupload', 'gdownload', 'gtime', 'glimited', 'gprice'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupname' => 'กลุ่ม',
            'gdesc' => 'ชื่อกลุ่ม',
            'gupload' => 'อัพโหลด',
            'gdownload' => 'ดาว์โหลด',
            'gtime' => 'จำนวนชั่วโมง',
            'glimited' => 'จำนวนวัน',
            'gprice' => 'ราคา',
            'gstatus' => 'Gstatus',        
            'autologout'=>'ออโต้ล็อกเอาท์',
            'simultaneous'=>'จำนวนเครื่องที่ใช้งาน',
            'redirection'=>'หน้าที่ต้องการเมื่อล็อกอินสำเร็จ'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRadgroupchecks()
    {
        return $this->hasMany(Radgroupcheck::className(), ['groupname' => 'groupname']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRadgroupreplies()
    {
        return $this->hasMany(Radgroupreply::className(), ['groupname' => 'groupname']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRadusergroups()
    {
        return $this->hasMany(Radusergroup::className(), ['groupname' => 'groupname']);
    }
    /** public function beforeSave($insert) {
        if ($this->isNewRecord){
            $this->groupname='group'.date('YmdHis').$this->groupname;
            
        }
                
        
        return parent::beforeSave($insert);
    }  */
      
   /** public function afterSave($insert, $changedAttributes) {
        if ($insert){
     //---------------------start radgroupcheck ------------------//         
            $radgroupcheck=new Radgroupcheck();
            $radgroupcheck->groupname=  $this->groupname;
            $radgroupcheck->attribute="Auth-Type";
            $radgroupcheck->value="Local";
            $radgroupcheck->save();
            if ($this->simultaneous>0){
                
            $radgroupcheck=new Radgroupcheck();
            $radgroupcheck->groupname=  $this->groupname;
            $radgroupcheck->attribute="Simultaneous-Use";
            $radgroupcheck->value=$this->simultaneous;
            $radgroupcheck->save(); 
            
            }
            if ($this->gtime>0){
                
            $radgroupcheck=new Radgroupcheck();
            $radgroupcheck->groupname=  $this->groupname;
            $radgroupcheck->attribute="Max-All-Session";
            $radgroupcheck->value=$this->gtime*60*60;
            $radgroupcheck->save(); 
            }
            
            
     //---------------------End radgroupcheck ------------------//       
            
    //---------------------start tables radgroupreply -------//
            $radgroupreply=new Radgroupreply();
            $radgroupreply->groupname=  $this->groupname;
            $radgroupreply->attribute="Service-Type";
            $radgroupreply->value="Login-User";
            $radgroupreply->save();
         
            //ต้องการให้ทำเงื่อนไข
            if ($this->gupload>0){
            $radgroupreply=new Radgroupreply();
            $radgroupreply->groupname=  $this->groupname;
            $radgroupreply->attribute="WISPr-Bandwidth-Max-Up";
            $radgroupreply->value=$this->gupload;
            $radgroupreply->save();
            }
            
            if ($this->gdownload>0){
            $radgroupreply=new Radgroupreply();
            $radgroupreply->groupname=  $this->groupname;
            $radgroupreply->attribute="WISPr-Bandwidth-Max-Down";
            $radgroupreply->value=$this->gdownload ;
            $radgroupreply->save();
                
            }
            
            if ($this->redirection!=''){
            $radgroupreply=new Radgroupreply();
            $radgroupreply->groupname=  $this->groupname;
            $radgroupreply->attribute="WISPr-Redirection-URL";
            $radgroupreply->value=$this->redirection;
            $radgroupreply->save();
            }
            
            
            $radgroupreply=new Radgroupreply();
            $radgroupreply->groupname=  $this->groupname;
            $radgroupreply->attribute="Idle-Timeout";
            $radgroupreply->value=$this->autologout;
            $radgroupreply->save();
               
           
            // $radgroupreply->value=$this->$autologout*60;
            $radgroupreply=new Radgroupreply();
            $radgroupreply->groupname=  $this->groupname;
            $radgroupreply->attribute="Acct-Interim-Interval";
            $radgroupreply->value="60";
            $radgroupreply->save();
            
    //---------------------END tables radgroupreply -------//        
        }
        
        
        return parent::afterSave($insert, $changedAttributes);
    }
    */
    public function behaviors() {
        return[
            GroupsBehaviors::className()
        ];
    }
            
}
