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


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\models\chat\ChatMessage;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZSelect2AjaxingWidget;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ChatGroup
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $owner
 * @property array $photo
 * @property array $user_ids
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ChatGroup extends ZActiveRecord
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
    public $owner;
    public $photo;
    public $user_ids;
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
        'owner',
        'photo',
        'user_ids',
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
    public static ?string $title = Azl . 'Группы';
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
			'owner',
			'photo',
			'user_ids',
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
                        'owner' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'User' => [
                        'user_ids' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ChatMessage' => [
                        'chat_group_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Группы');

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

            'owner' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Создатель');
                $column->tooltip = Az::l('Создатель группы чата');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZSelect2AjaxingWidget::class;
                $column->options = [
                    'event' => [
                        'clicking' => 'function (event) {
                         location.href = "/cruds/user/create.aspx";
                   }',
                    ],
                ];
                $column->fkTable = 'user';
                $column->fkQuery = [
                    'id' => 88888,
                ];

                return $column;
            },





            'photo' => function (FormDb $column) {

                $column->title = Az::l('Логотип');
                $column->tooltip = Az::l('Логотип группы чата');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },


            'user_ids' => function (FormDb $column) {

                $column->title = Az::l('Группы');
                $column->tooltip = Az::l('Группы чатов');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

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
        'owner',
        'photo',
        'user_ids',
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
                                'owner',
                            ],
                            [
                                'title',
                            ],
                            [
                                'photo',
                            ],
                            [
                                'user_ids',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(ChatGroup $model = null)
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
        $event->beforeDelete = function (CoreGroup $model) {
        return null;
        };

        $event->afterDelete = function (CoreGroup $model) {
        return null;
        };

        $event->beforeSave = function (CoreGroup $model) {
        return null;
        };

        $event->afterSave = function (CoreGroup $model) {
        return null;
        };

        $event->beforeValidate = function (CoreGroup $model) {
        return null;
        };

        $event->afterValidate = function (CoreGroup $model) {
        return null;
        };

        $event->afterRefresh = function (CoreGroup $model) {
        return null;
        };

        $event->afterFind = function (CoreGroup $model) {
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
     * Function  getOwner
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getOwnerOne()
    {
        return $this->getOne(User::class, [
          'id' => 'owner',
      ]);    
    }
    
     /**
     *
     * Function  getOwner
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getOwner()
    {
        return $this->hasOne(User::class, [
          'id' => 'owner',
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


    /**
     *
     * Function  getUsersFromUserIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|User
     */            
    public function getUsersFromUserIdsMulti()
    {
        return $this->getMulti(User::class, [
          'id' => 'user_ids',
      ]);    
    }


    #endregion
    
    #region Many


    /**
     *
     * Function  getChatMessagesWithChatGroupIdMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMessage
     */            
    public function getChatMessagesWithChatGroupIdMany()
    {
       return $this->getMany(ChatMessage::class, [
            'chat_group_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMessagesWithChatGroupId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMessagesWithChatGroupId()
    {
       return $this->hasMany(ChatMessage::class, [
            'chat_group_id' => 'id',
        ]);     
    }


    #endregion


}
