<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\App\market\db2;


use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\system\actives\ZModel;
use zetsoft\dbitem\data\FormDb;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\system\actives\ZActiveRecord;



/**
 * Class    Cel
 * @package zetsoft\models\App
 * 
 * @property string $eventtype
 * @property string $eventtime
 * @property string $cid_name
 * @property string $cid_num
 * @property string $cid_ani
 * @property string $cid_rdnis
 * @property string $cid_dnid
 * @property string $exten
 * @property string $context
 * @property string $channame
 * @property string $appname
 * @property string $appdata
 * @property int $amaflags
 * @property string $accountcode
 * @property string $uniqueid
 * @property string $linkedid
 * @property string $peer
 * @property string $userdeftype
 * @property string $extra
 */
class Cel extends ZActiveRecord
{

    #region MVars

    /*
    
    public $eventtype;
    public $eventtime;
    public $cid_name;
    public $cid_num;
    public $cid_ani;
    public $cid_rdnis;
    public $cid_dnid;
    public $exten;
    public $context;
    public $channame;
    public $appname;
    public $appdata;
    public $amaflags;
    public $accountcode;
    public $uniqueid;
    public $linkedid;
    public $peer;
    public $userdeftype;
    public $extra;
    */

    #endregion

    #region Names

    #endregion

    #region Const

    #endregion


    public static ?string $dbase = 'db2';
    
    public function init()
    {
        parent::init();



    }


    #region Config
    
    /**
     * Function  config
     * @return  \Closure
     */

    public function config()
    {
        return static function (ConfigDB $config) {

            $config->dbase = 'db2';
            $config->addBy = true;
            $config->title = Az::l('Cel');

            return $config;
        };
    }


    #endregion

    #region Column

    /**
     * Function column
     * @return array
     */

    public function column()
    {
        if (!empty($this->configs->column))
            return $this->configs->column;

        return ZArrayHelper::merge(parent::column(), [
           
            'eventtype' => function (FormDb $column) {

                $column->length = 30;
                $column->notNull = true;
                $column->title = Az::l('eventtype');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'eventtime' => function (FormDb $column) {

                $column->notNull = true;
                $column->title = Az::l('eventtime');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;

                return $column;
            },
            
           
            'cid_name' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('cid_name');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'cid_num' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('cid_num');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'cid_ani' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('cid_ani');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'cid_rdnis' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('cid_rdnis');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'cid_dnid' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('cid_dnid');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'exten' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('exten');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'context' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('context');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'channame' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('channame');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'appname' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('appname');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'appdata' => function (FormDb $column) {

                $column->notNull = true;
                $column->title = Az::l('appdata');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'amaflags' => function (FormDb $column) {

                $column->length = 11;
                $column->notNull = true;
                $column->title = Az::l('amaflags');
                $column->dbType = dbTypeInteger;

                return $column;
            },
            
           
            'accountcode' => function (FormDb $column) {

                $column->length = 20;
                $column->notNull = true;
                $column->title = Az::l('accountcode');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'uniqueid' => function (FormDb $column) {

                $column->length = 32;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('uniqueid');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'linkedid' => function (FormDb $column) {

                $column->length = 32;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('linkedid');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'peer' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('peer');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'userdeftype' => function (FormDb $column) {

                $column->notNull = true;
                $column->title = Az::l('userdeftype');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'extra' => function (FormDb $column) {

                $column->length = 512;
                $column->notNull = true;
                $column->title = Az::l('extra');
                $column->dbType = dbTypeString;

                return $column;
            },
            

        ], $this->configs->replace);
    }


    #endregion

    #region Cards

    /**
     * Function  blocks
     * @return  array
     */

    public function card()
    {
        return [
            Az::l('OneStep') => [
                Az::l('OneBlock') => [
                    [
                        'eventtype',
                        'eventtime',
                        'cid_name',
                        'cid_num',
                        'cid_ani',
                        'cid_rdnis',
                        'cid_dnid',
                        'exten',
                        'context',
                        'channame',
                        'appname',
                        'appdata',
                        'amaflags',
                        'accountcode',
                        'uniqueid',
                        'linkedid',
                        'peer',
                        'userdeftype',
                        'extra',
                    ],
                ],
            ],
        ];
    }

    #endregion


    #region One



    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion

}
