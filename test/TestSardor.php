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
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    TestSardor
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $lastname
 * @property string $midname
 * @property string $description
 * @property string $address
 * @property string $email
 * @property string $amount
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class TestSardor extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $sort;
    public $name;
    public $title;
    public $tranz;
    public $accept;
    public $active;
    public $lastname;
    public $midname;
    public $description;
    public $address;
    public $email;
    public $amount;
    public $deleted_at;
    public $deleted_by;
    public $deleted_text;
    public $created_at;
    public $modified_at;
    public $created_by;
    public $modified_by;
    */

    #endregion

    #region Attrs

    public const attrs = [

        'id',
        'sort',
        'name',
        'title',
        'tranz',
        'accept',
        'active',
        'lastname',
        'midname',
        'description',
        'address',
        'email',
        'amount',
        'deleted_at',
        'deleted_by',
        'deleted_text',
        'created_at',
        'modified_at',
        'created_by',
        'modified_by',
    ];

    #endregion

    #region Names

    #endregion

    #region Const

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Test';
    public static ?string $icon = '';
    public static ?bool $menu = true;

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
			'sort',
			'name',
			'title',
			'tranz',
			'accept',
			'active',
			'lastname',
			'midname',
			'description',
			'address',
			'email',
			'amount',
			'deleted_at',
			'deleted_by',
			'deleted_text',
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
        return function (ConfigDB $config) {

            $config->faker = true;
            $config->name = 'Сообщения';

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

            'name' => function (FormDb $column) {

                $column->title = Az::l('Имя');

                return $column;
            },

            'lastname' => function (FormDb $column) {

                $column->lastname = Az::l('Имя');

                return $column;
            },
            'midname' => function (FormDb $column) {

                $column->title = Az::l('Otchestva');

                return $column;
            },


            'description' => function (FormDb $column) {

                $column->title = Az::l('Описание');

                return $column;
            },


            'address' => function (FormDb $column) {

                $column->title = Az::l('Адрес');

                return $column;
            },


            'email' => function (FormDb $column) {

                $column->title = Az::l('Эл. адрес');

                return $column;
            },
            'amount' => function (FormDb $column) {

                $column->title = Az::l('Количество');

                return $column;
            },



        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'sort',
        'name',
        'title',
        'tranz',
        'accept',
        'active',
        'lastname',
        'midname',
        'description',
        'address',
        'email',
        'amount',
        'deleted_at',
        'deleted_by',
        'deleted_text',
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


    #endregion

    #region One



    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}
