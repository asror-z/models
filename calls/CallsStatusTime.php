<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\calls;


use zetsoft\dbitem\data\Form;
use zetsoft\models\shop\ShopOrder;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\widgets\inputes\ZKDateRangePickerWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CallsStatusTime
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $user_id
 * @property string $date
 * @property string $online
 * @property string $offline
 * @property string $away
 * @property string $dnd
 * @property string $lunch
 * @property string $process
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CallsStatusTime extends ZActiveRecord
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
    public $user_id;
    public $date;
    public $online;
    public $offline;
    public $away;
    public $dnd;
    public $lunch;
    public $process;
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
        'user_id',
        'date',
        'online',
        'offline',
        'away',
        'dnd',
        'lunch',
        'process',
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
    public static ?string $title = Azl . 'Звонки колл центра';
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
			'user_id',
			'date',
			'online',
			'offline',
			'away',
			'dnd',
			'lunch',
			'process',
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

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $config->nameValue = function (CallsStatusTime $model) {

                $user = User::findOne($model->user_id);
                if ($user)
                    return $user->name;
            };

            $config->hasOne = [
                    'User' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Звонки колл центра');

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

            'user_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Оператор');
                $column->tooltip = Az::l('Оператор колл центра');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkQuery = [
                    'role' => 'operator',
                ];

                return $column;
            },


            'date' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Время');
                $column->tooltip = Az::l('Время звонка колл центра');
                $column->dbType = dbTypeDate;

                return $column;
            },


            'online' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Время');
                $column->tooltip = Az::l('Время звонка колл центра');
                $column->dbType = dbTypeTime;


                return $column;
            },


            'offline' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Отключен');
                $column->tooltip = Az::l('Отключен звонок колл центра');
                $column->dbType = dbTypeTime;

                return $column;
            },


            'away' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Отошел');
                $column->tooltip = Az::l('Статус (Отошел) звонка колл центра');
                $column->dbType = dbTypeTime;


                return $column;
            },


            'dnd' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Не беспокоить');
                $column->tooltip = Az::l('Статус (Не беспокоить) колл центра');
                $column->dbType = dbTypeTime;


                return $column;
            },


            'lunch' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Перерыв на обед');
                $column->tooltip = Az::l('Статус (Перерыв на обед) колл центра');
                $column->dbType = dbTypeTime;

                return $column;
            },


            'process' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Обработка');
                $column->tooltip = Az::l('Статус (Обработка) колл центра');
                $column->dbType = dbTypeTime;

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
        'user_id',
        'date',
        'online',
        'offline',
        'away',
        'dnd',
        'lunch',
        'process',
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
                                'user_id',
                            ],
                            [
                                'date',
                            ],
                            [
                                'online',
                            ],
                            [
                                'offline',
                            ],
                            [
                                'away',
                            ],
                            [
                                'dnd',
                            ],
                            [
                                'lunch',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(CallsStatusTime $model = null)
    {

        if ($model === null)
            $model = $this;

        return null;
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
            $event->beforeDelete = function (CallsCdr $model) {
                return null;
            };

            $event->afterDelete = function (CallsCdr $model) {
                return null;
            };

            $event->beforeSave = function (CallsCdr $model) {
                return null;
            };

            $event->afterSave = function (CallsCdr $model) {
                return null;
            };

            $event->beforeValidate = function (CallsCdr $model) {
                return null;
            };

            $event->afterValidate = function (CallsCdr $model) {
                return null;
            };

            $event->afterRefresh = function (CallsCdr $model) {
                return null;
            };

            $event->afterFind = function (CallsCdr $model) {
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


    /**
     *
     * Function  getUser
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getUserOne()
    {
        return $this->getOne(User::class, [
          'id' => 'user_id',
      ]);    
    }
    
     /**
     *
     * Function  getUser
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getUser()
    {
        return $this->hasOne(User::class, [
          'id' => 'user_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getDeletedBy
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getDeletedByOne()
    {
        return $this->getOne(User::class, [
          'id' => 'deleted_by',
      ]);    
    }
    
     /**
     *
     * Function  getDeletedBy
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getDeletedBy()
    {
        return $this->hasOne(User::class, [
          'id' => 'deleted_by',
      ]);    
    }
    
    

    /**
     *
     * Function  getCreatedBy
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getCreatedByOne()
    {
        return $this->getOne(User::class, [
          'id' => 'created_by',
      ]);    
    }
    
     /**
     *
     * Function  getCreatedBy
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, [
          'id' => 'created_by',
      ]);    
    }
    
    

    /**
     *
     * Function  getModifiedBy
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getModifiedByOne()
    {
        return $this->getOne(User::class, [
          'id' => 'modified_by',
      ]);    
    }
    
     /**
     *
     * Function  getModifiedBy
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getModifiedBy()
    {
        return $this->hasOne(User::class, [
          'id' => 'modified_by',
      ]);    
    }
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}
