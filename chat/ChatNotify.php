<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\chat;


use zetsoft\dbdata\auth\RoleData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ChatNotify
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $text
 * @property string $time
 * @property boolean $check
 * @property boolean $read
 * @property boolean $remove
 * @property string $link
 * @property string $type
 * @property string $source
 * @property int $user_id
 * @property string $user_role
 * @property boolean $user_all
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ChatNotify extends ZActiveRecord
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
    public $text;
    public $time;
    public $check;
    public $read;
    public $remove;
    public $link;
    public $type;
    public $source;
    public $user_id;
    public $user_role;
    public $user_all;
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
        'text',
        'time',
        'check',
        'read',
        'remove',
        'link',
        'type',
        'source',
        'user_id',
        'user_role',
        'user_all',
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

    /* @var array $_type*/
    public $_type;  
    public const type = [
        'info' => 'info',
        'danger' => 'danger',
        'success' => 'success',
        'warning' => 'warning',
    ];

    /* @var array $_source*/
    public $_source;  
    public const source = [
        'system' => 'system',
        'admin' => 'admin',
        'auth' => 'auth',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Уведомления';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_type = [
            'info' => Az::l('info'),
            'danger' => Az::l('danger'),
            'success' => Az::l('success'),
            'warning' => Az::l('warning'),
        ];
        
        $this->_source = [
            'system' => Az::l('От системы'),
            'admin' => Az::l('От администратор'),
            'auth' => Az::l('Аутентификация'),
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
			'text',
			'time',
			'check',
			'read',
			'remove',
			'link',
			'type',
			'source',
			'user_id',
			'user_role',
			'user_all',
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
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Уведомления');

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

            'text' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Текст');
                $column->tooltip = Az::l('Текст уведомления');
                $column->dbType = dbTypeText;

                return $column;
            },


            'time' => function (FormDb $column) {

                $column->title = Az::l('Время отправки');
                $column->dbType = dbTypeTime;

                return $column;
            },


            'check' => function (FormDb $column) {

                $column->defaultValue = false;
                $column->index = true;
                $column->title = Az::l('Check');
                $column->tooltip = Az::l('Проверка');
                $column->dbType = dbTypeBoolean;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },


            'read' => function (FormDb $column) {

                $column->defaultValue = false;
                $column->index = true;
                $column->title = Az::l('Читать');
                $column->tooltip = Az::l('Прочитать чат');
                $column->dbType = dbTypeBoolean;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },


            'remove' => function (FormDb $column) {

                $column->defaultValue = false;
                $column->index = true;
                $column->title = Az::l('Удалить');
                $column->tooltip = Az::l('Удалить чат');
                $column->dbType = dbTypeBoolean;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },


            'link' => function (FormDb $column) {

                $column->title = Az::l('Ссылка');
                $column->tooltip = Az::l('Ссылка чата');
                $column->rules = validatorString;

                return $column;
            },


            'type' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Тип уведомлений');
                $column->data = [
                    'info' => Az::l('info'),
                    'danger' => Az::l('danger'),
                    'success' => Az::l('success'),
                    'warning' => Az::l('warning'),
                ];
                $column->rules = validatorString;
                $column->widget = ZKSelect2Widget::class;
                $column->ajax = false;

                return $column;
            },

            'source' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Тип уведомлений');
                $column->data = [
                    'system' => Az::l('От системы'),
                    'admin' => Az::l('От администратор'),
                    'auth' => Az::l('Аутентификация'),
                ];
                $column->rules = validatorString;
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },


            'user_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Получатель');
                $column->tooltip = Az::l('Получатель уведомления');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },

            'user_role' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Роль');
                $column->tooltip = Az::l('Роль пользователя');
                $column->data = RoleData::class;
                $column->widget = ZKSelect2Widget::class;
                $column->dbType = dbTypeString;
                $column->ajax = false;

                return $column;
            },


            'user_all' => function (FormDb $column) {

                $column->dbType = dbTypeBoolean;
                $column->index = true;
                $column->title = Az::l('Всем юзерам');
                $column->widget = ZKSwitchInputWidget::class;
                $column->value = false;

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
        'text',
        'time',
        'check',
        'read',
        'remove',
        'link',
        'type',
        'source',
        'user_id',
        'user_role',
        'user_all',
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
                                'title',
                            ],
                            [
                                'text',
                            ],
                            [
                                'time',
                            ],
                            [
                                'check',
                            ],
                            [
                                'read',
                            ],
                            [
                                'remove',
                            ],
                            [
                                'link',
                            ],
                            [
                                'type',
                            ],
                            [
                                'user_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(ChatNotify $model = null)
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
        $event->beforeDelete = function (CoreNotify $model) {
        return null;
        };

        $event->afterDelete = function (CoreNotify $model) {
        return null;
        };

        $event->beforeSave = function (CoreNotify $model) {
        return null;
        };

        $event->afterSave = function (CoreNotify $model) {
        return null;
        };

        $event->beforeValidate = function (CoreNotify $model) {
        return null;
        };

        $event->afterValidate = function (CoreNotify $model) {
        return null;
        };

        $event->afterRefresh = function (CoreNotify $model) {
        return null;
        };

        $event->afterFind = function (CoreNotify $model) {
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
