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
 * Class    Queuelog
 * @package zetsoft\models\App
 * 
 * @property bigInteger $id
 * @property string $time
 * @property string $callid
 * @property string $queuename
 * @property string $serverid
 * @property string $agent
 * @property string $event
 * @property string $data1
 * @property string $data2
 * @property string $data3
 * @property string $data4
 * @property string $data5
 */
class Queuelog extends ZActiveRecord
{

    #region MVars

    /*
    
    public $id;
    public $time;
    public $callid;
    public $queuename;
    public $serverid;
    public $agent;
    public $event;
    public $data1;
    public $data2;
    public $data3;
    public $data4;
    public $data5;
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
            $config->addBy = true;
            $config->title = Az::l('Queuelog');
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
           
            'id' => function (FormDb $column) {

                $column->length = 20;
                $column->notNull = true;
                $column->unsigned = true;
                $column->index = true;
                $column->indexUnique = true;
                $column->isPKey = true;
                $column->title = Az::l('id');
                $column->dbType = dbTypeBigInteger;

                return $column;
            },
            
           
            'time' => function (FormDb $column) {

                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('time');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;

                return $column;
            },
            
           
            'callid' => function (FormDb $column) {

                $column->length = 40;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('callid');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'queuename' => function (FormDb $column) {

                $column->length = 20;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('queuename');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'serverid' => function (FormDb $column) {

                $column->length = 20;
                $column->notNull = true;
                $column->title = Az::l('serverid');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'agent' => function (FormDb $column) {

                $column->length = 40;
                $column->notNull = true;
                $column->title = Az::l('agent');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'event' => function (FormDb $column) {

                $column->length = 20;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('event');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'data1' => function (FormDb $column) {

                $column->length = 40;
                $column->notNull = true;
                $column->title = Az::l('data1');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'data2' => function (FormDb $column) {

                $column->length = 40;
                $column->notNull = true;
                $column->title = Az::l('data2');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'data3' => function (FormDb $column) {

                $column->length = 40;
                $column->notNull = true;
                $column->title = Az::l('data3');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'data4' => function (FormDb $column) {

                $column->length = 40;
                $column->notNull = true;
                $column->title = Az::l('data4');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'data5' => function (FormDb $column) {

                $column->length = 40;
                $column->notNull = true;
                $column->title = Az::l('data5');
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
                        'id',
                        'time',
                        'callid',
                        'queuename',
                        'serverid',
                        'agent',
                        'event',
                        'data1',
                        'data2',
                        'data3',
                        'data4',
                        'data5',
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
