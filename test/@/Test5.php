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


use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\service\search\SphinxService;
use zetsoft\service\smart\Fake;
use zetsoft\system\actives\ZActiveData;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZKDateRangePickerWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;



/**
 * Class    Test5
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property string $first_name
 * @property string $second_name
 * @property string $address
 * @property string $email
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class Test5 extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $name;
    public $first_name;
    public $second_name;
    public $address;
    public $email;
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
			'first_name',
			'second_name',
			'address',
			'email',
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

            $config->faker = true;
            $config->name = 'Сообщения';

            $config->title = Az::l('TestD');
            $config->fakerCount = 2000;


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
           
            'first_name' => function (FormDb $column) {

                $column->title = Az::l('first_name');
                $column->faker = 'name';
                $column->indexSearch = true;

                return $column;
            },
            
           
            'second_name' => function (FormDb $column) {

                $column->title = Az::l('second_name');
                $column->faker = 'lastName';
                $column->indexSearch = true;

                return $column;
            },
            
           
            'address' => function (FormDb $column) {

                $column->title = Az::l('address');
                $column->faker = 'address';

                return $column;
            },
            
           
            'email' => function (FormDb $column) {

                $column->title = Az::l('email');
                $column->faker = 'email';
                $column->indexSearch = true;

                return $column;
            },
            

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'first_name',
        'second_name',
        'address',
        'email',
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
                            ],
                            [
                                'first_name',
                            ],
                            [
                                'second_name',
                            ],
                            [
                                'address',
                            ],
                            [
                                'email',
                            ],
                            [
                                'deleted_at',
                            ],
                            [
                                'deleted_by',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(Test5 &$model = null)
    {
        if ($model === null)
            $model = $this;

        // Todo: MyCode

        $model->save();
    }


    #endregion

    #region Events

    /**
     * Function column
     * @return ZEvent
     */
    public function event()
    {

        $event = new Event();
    /*
        $event->beforeDelete = function (Test5 $model) {
            return null;
        };

        $event->afterDelete = function (Test5 $model) {
            return null;
        };

        $event->beforeSave = function (Test5 $model) {
            return null;
        };

        $event->afterSave = function (Test5 $model) {
            return null;
        };

        $event->beforeValidate = function (Test5 $model) {
            return null;
        };

        $event->afterValidate = function (Test5 $model) {
            return null;
        };

        $event->afterRefresh = function (Test5 $model) {
            return null;
        };

        $event->afterFind = function (Test5 $model) {
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
