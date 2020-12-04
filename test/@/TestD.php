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


use zetsoft\dbdata\data\FakeImageData;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\widgets\former\ZMultiWidget;
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
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\values\ZFormViewWidget;



/**
 * Class    TestD
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property string $sender
 * @property string $sender_slug
 * @property array $sender_lang
 * @property array $sender_history
 * @property array $date
 * @property array $image
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class TestD extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $name;
    public $sender;
    public $sender_slug;
    public $sender_lang;
    public $sender_history;
    public $date;
    public $image;
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
			'sender',
			'sender_slug',
			'sender_lang',
			'sender_history',
			'date',
			'image',
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
            $config->fakerCount = 100;


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
                  //fdgh
            'sender' => function (FormDb $column) {

                $column->title = Az::l('Отправитель');
                $column->faker = 'email';
                $column->slug = true;
                $column->lang = true;
                $column->history = true;

                return $column;
            },
            
           
            'date' => function (FormDb $column) {

                $column->title = Az::l('Email');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->faker = 'randomElement';
                $column->fakerFunc = [
                    [
                        153,
                        154,
                        155,
                        156,
                        157,
                    ],
                ];

                return $column;
            },
            
           
            'image' => function (FormDb $column) {

                $column->title = Az::l('Время удаления');
                $column->dbType = dbTypeJsonb;
                $column->fakerData = 'zetsoft\\dbdata\\data\\FakeImageData';

                return $column;
            },
            

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'sender',
        'sender_slug',
        'sender_lang',
        'sender_history',
        'date',
        'image',
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
                                'sender',
                            ],
                            [
                                'date',
                            ],
                            [
                                'image',
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
    public function value(TestD &$model = null)
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
        $event->beforeDelete = function (TestD $model) {
            return null;
        };

        $event->afterDelete = function (TestD $model) {
            return null;
        };

        $event->beforeSave = function (TestD $model) {
            return null;
        };

        $event->afterSave = function (TestD $model) {
            return null;
        };

        $event->beforeValidate = function (TestD $model) {
            return null;
        };

        $event->afterValidate = function (TestD $model) {
            return null;
        };

        $event->afterRefresh = function (TestD $model) {
            return null;
        };

        $event->afterFind = function (TestD $model) {
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
