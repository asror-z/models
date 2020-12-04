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
 * Class    Cdr
 * @package zetsoft\models\App
 * 
 * @property string $calldate
 * @property string $clid
 * @property string $src
 * @property string $dst
 * @property string $dcontext
 * @property string $channel
 * @property string $dstchannel
 * @property string $lastapp
 * @property string $lastdata
 * @property int $duration
 * @property int $billsec
 * @property string $disposition
 * @property int $amaflags
 * @property string $accountcode
 * @property string $uniqueid
 * @property string $userfield
 * @property string $did
 * @property string $recordingfile
 * @property string $cnum
 * @property string $cnam
 * @property string $outbound_cnum
 * @property string $outbound_cnam
 * @property string $dst_cnam
 * @property string $linkedid
 * @property string $peeraccount
 * @property int $sequence
 */
class Cdr extends ZActiveRecord
{

    #region MVars

    /*
    
    public $calldate;
    public $clid;
    public $src;
    public $dst;
    public $dcontext;
    public $channel;
    public $dstchannel;
    public $lastapp;
    public $lastdata;
    public $duration;
    public $billsec;
    public $disposition;
    public $amaflags;
    public $accountcode;
    public $uniqueid;
    public $userfield;
    public $did;
    public $recordingfile;
    public $cnum;
    public $cnam;
    public $outbound_cnum;
    public $outbound_cnam;
    public $dst_cnam;
    public $linkedid;
    public $peeraccount;
    public $sequence;
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
            $config->addID = false;
            $config->addBy = false;
            $config->addName = false;
            $config->title = Az::l('Cdr');
            $config->makeMenu = false;
            $config->order = [];

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
           
            'calldate' => function (FormDb $column) {

                $column->defaultValue = '1000-01-01 00:00:00';
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('calldate');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;

                return $column;
            },
            
           
            'clid' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('clid');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'src' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('src');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'dst' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('dst');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'dcontext' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('dcontext');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'channel' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('channel');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'dstchannel' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('dstchannel');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'lastapp' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('lastapp');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'lastdata' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('lastdata');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'duration' => function (FormDb $column) {

                $column->length = 11;
                $column->notNull = true;
                $column->title = Az::l('duration');
                $column->dbType = dbTypeInteger;

                return $column;
            },
            
           
            'billsec' => function (FormDb $column) {

                $column->length = 11;
                $column->notNull = true;
                $column->title = Az::l('billsec');
                $column->dbType = dbTypeInteger;

                return $column;
            },
            
           
            'disposition' => function (FormDb $column) {

                $column->length = 45;
                $column->notNull = true;
                $column->title = Az::l('disposition');
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
                $column->index = true;
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
            
           
            'userfield' => function (FormDb $column) {

                $column->notNull = true;
                $column->title = Az::l('userfield');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'did' => function (FormDb $column) {

                $column->length = 50;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('did');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'recordingfile' => function (FormDb $column) {

                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('recordingfile');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'cnum' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('cnum');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'cnam' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('cnam');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'outbound_cnum' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('outbound_cnum');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'outbound_cnam' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('outbound_cnam');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'dst_cnam' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('dst_cnam');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'linkedid' => function (FormDb $column) {

                $column->length = 32;
                $column->notNull = true;
                $column->title = Az::l('linkedid');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'peeraccount' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('peeraccount');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'sequence' => function (FormDb $column) {

                $column->length = 11;
                $column->notNull = true;
                $column->title = Az::l('sequence');
                $column->dbType = dbTypeInteger;

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
                        'calldate',
                        'clid',
                        'src',
                        'dst',
                        'dcontext',
                        'channel',
                        'dstchannel',
                        'lastapp',
                        'lastdata',
                        'duration',
                        'billsec',
                        'disposition',
                        'amaflags',
                        'accountcode',
                        'uniqueid',
                        'userfield',
                        'did',
                        'recordingfile',
                        'cnum',
                        'cnam',
                        'outbound_cnum',
                        'outbound_cnam',
                        'dst_cnam',
                        'linkedid',
                        'peeraccount',
                        'sequence',
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
