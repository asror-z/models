<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\user;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    UserFriend
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $person
 * @property int $friend
 * @property string $time
 * @property string $text
 * @property int $status
 * @property boolean $remove
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class UserFriend extends ZActiveRecord
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
    public $person;
    public $friend;
    public $time;
    public $text;
    public $status;
    public $remove;
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
        'person',
        'friend',
        'time',
        'text',
        'status',
        'remove',
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

    /* @var array $_status*/
    public $_status;  
    public const status = [
        'В ожидании' => 'В ожидании',
        'Принят' => 'Принят',
        'Отклонен' => 'Отклонен',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Друзья';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_status = [
            'В ожидании' => Az::l('В ожидании'),
            'Принят' => Az::l('Принят'),
            'Отклонен' => Az::l('Отклонен'),
        ];
        

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
			'person',
			'friend',
			'time',
			'text',
			'status',
			'remove',
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

            $config->hasOne = [
                    'User' => [
                        'person' => 'id',
                        'friend' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->name = 'text';

            $config->title = Az::l('Друзья');

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
           
            'person' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Отправитель');
                $column->tooltip = Az::l('Отправитель запроса добавления в друзья');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user';

                return $column;
            },
            
           
            'friend' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Получатель');
                $column->tooltip = Az::l('Получатель запроса добавления в друзья');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user';

                return $column;
            },
            
           
            'time' => function (FormDb $column) {

                $column->title = Az::l('Время отправки');
                $column->tooltip = Az::l('Время отправки запроса');
                $column->widget = ZKDateTimePickerWidget::class;

                return $column;
            },
            
           
            'text' => function (FormDb $column) {

                $column->title = Az::l('Текст');
                $column->tooltip = Az::l('Дополнительный текст для запроса');
                $column->dbType = dbTypeText;

                return $column;
            },
            
           
            'status' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Статус');
                $column->tooltip = Az::l('Статус запроса');
                $column->dbType = dbTypeInteger;
                $column->data = [
                    'В ожидании' => Az::l('В ожидании'),
                    'Принят' => Az::l('Принят'),
                    'Отклонен' => Az::l('Отклонен'),
                ];
                $column->widget = ZHRadioButtonGroupWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'remove' => function (FormDb $column) {

                $column->defaultValue = false;
                $column->title = Az::l('Удалить');
                $column->tooltip = Az::l('Удалить запрос');
                $column->dbType = dbTypeBoolean;

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
        'person',
        'friend',
        'time',
        'text',
        'status',
        'remove',
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
                                'person',
                            ],
                            [
                                'friend',
                            ],
                            [
                                'time',
                            ],
                            [
                                'text',
                            ],
                            [
                                'status',
                            ],
                            [
                                'remove',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                    public function value(UserFriend $model = null)
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
 $event->beforeDelete = function (CoreFriend $model) {
 return null;
 };

 $event->afterDelete = function (CoreFriend $model) {
 return null;
 };

 $event->beforeSave = function (CoreFriend $model) {
 return null;
 };

 $event->afterSave = function (CoreFriend $model) {
 return null;
 };

 $event->beforeValidate = function (CoreFriend $model) {
 return null;
 };

 $event->afterValidate = function (CoreFriend $model) {
 return null;
 };

 $event->afterRefresh = function (CoreFriend $model) {
 return null;
 };

 $event->afterFind = function (CoreFriend $model) {
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
     * Function  getPerson
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getPersonOne()
    {
        return $this->getOne(User::class, [
          'id' => 'person',
      ]);    
    }
    
     /**
     *
     * Function  getPerson
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPerson()
    {
        return $this->hasOne(User::class, [
          'id' => 'person',
      ]);    
    }
    
    

    /**
     *
     * Function  getFriend
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getFriendOne()
    {
        return $this->getOne(User::class, [
          'id' => 'friend',
      ]);    
    }
    
     /**
     *
     * Function  getFriend
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getFriend()
    {
        return $this->hasOne(User::class, [
          'id' => 'friend',
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
