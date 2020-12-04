<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\test;


use zetsoft\dbdata\data\DbData;
use zetsoft\dbdata\eyuf\CurrencyData;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;



/**
 * Class    TestNurbek
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property int $test
 * @property int $user_id
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class TestNurbek extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $name;
    public $test;
    public $user_id;
    public $created_at;
    public $modified_at;
    public $created_by;
    public $modified_by;
    */

    #endregion

    #region Names

    #endregion

    #region Const

    #endregion

    ##region Init

    public static ?string $dbase = 'db';

    public function init()
    {
        parent::init();


    }

    #endregion

    #region Fields
    
   public function fields()
   {
       return [
			'id',
			'name',
			'test',
			'user_id',
			'created_at',
			'modified_at',
			'created_by',
			'modified_by',

       ];
   }

    #endregion

    #region Config
    
    /**
     * Function  config
     * @return  \Closure
     */

    public function config()
    {
        return static function (ConfigDB $config) {

            $config->name = 'Сектор образования';

            $config->title = Az::l('Test');

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
           
            'test' => function (FormDb $column) {

                $column->title = Az::l('Test');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorEmail,
                    ],
                ];

                return $column;
            },
            
           
            'user_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Клиент');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
						'config' =>[
							'ajax' => true,
						],
					];

                return $column;
            },
            

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'test',
        'user_id',
        'created_at',
        'modified_at',
        'created_by',
        'modified_by',

    */

    #endregion


    #region Cards

    /**
     * Function  blocks
     * @return  array
     */

    public function card()
    {
        return [
            [
                'title' => Az::l('Первый этап'),
                'shows' => true,
                'items' => [
                    [
                        'title' => Az::l('Форма'),
                        'shows' => true,
                        'items' => [
                            [
                                'name',
                                'user_id',
                                'created_at',
                                'modified_at',
                                'created_by',
                                'modified_by',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(TestNurbek &$model = null)
    {
        if ($model === null)
            $model = $this;

        // Todo: MyCode

        $model->save();
    }


    ##endregion

    #region Events

    /**
     * Function column
     * @return ZEvent
     */
    public function event()
    {

        $event = new Event();
    /*
        $event->beforeDelete = function (TestNurbek $model) {
            return null;
        };

        $event->afterDelete = function (TestNurbek $model) {
            return null;
        };

        $event->beforeSave = function (TestNurbek $model) {
            return null;
        };

        $event->afterSave = function (TestNurbek $model) {
            return null;
        };

        $event->beforeValidate = function (TestNurbek $model) {
            return null;
        };

        $event->afterValidate = function (TestNurbek $model) {
            return null;
        };

        $event->afterRefresh = function (TestNurbek $model) {
            return null;
        };

        $event->afterFind = function (TestNurbek $model) {
            return null;
        };
*/
        return $event;

    }


    #endregion


    #region Faker

    /**
     * Function column
     * @return bool
     */
    public function faker()
    {
        return null;
    }


    #endregion

    #region One



    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}
