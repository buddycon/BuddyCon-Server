<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Command
 * Date: 03.10.12
 * Time: 13:53
 * To change this template use File | Settings | File Templates.
 */
class FilterChat extends CFormModel
{
    public $guild;
    public $bg;
    public $say;
    public $yell;

    function __construct($filter) {
        $json = CJSON::decode($filter);

        $this->bg = $json['bg'];
        $this->say = $json['say'];
        $this->guild =$json['guild'];
        $this->yell = $json['yell'];
    }

    public function toSave(){
        return CJSON::encode(array(
            'bg'=>$this->bg,
            'guild'=>$this->guild,
            'yell'=>$this->yell,
            'say'=>$this->say,
        ));

    }

    public function attributeLabels()
    {
        return array(
            'guild'=>'Guild',
            'bg'=>'BG',
            'say'=>'Say',
            'yell'=>'Yell',
        );
    }
}
