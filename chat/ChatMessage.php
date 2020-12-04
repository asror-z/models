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
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\chat\ChatGroup;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ChatMessage
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $sender
 * @property int $receiver
 * @property string $text
 * @property boolean $read
 * @property array $file
 * @property string $time
 * @property int $chat_group_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ChatMessage extends ZActiveRecord
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
    public $sender;
    public $receiver;
    public $text;
    public $read;
    public $file;
    public $time;
    public $chat_group_id;
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
        'sender',
        'receiver',
        'text',
        'read',
        'file',
        'time',
        'chat_group_id',
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
    public static ?string $title = Azl . 'Сообщения';
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
			'sender',
			'receiver',
			'text',
			'read',
			'file',
			'time',
			'chat_group_id',
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
                        'sender' => 'id',
                        'receiver' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'ChatGroup' => [
                        'chat_group_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Сообщения');

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
           
            'sender' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Отправитель');
                $column->tooltip = Az::l('Человек отправляющий письмо');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user';

                return $column;
            },
            
           
            'receiver' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Получатель');
                $column->tooltip = Az::l('Человек получающий письмо');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user';

                return $column;
            },
            
           
            'text' => function (FormDb $column) {

                $column->title = Az::l('Текст');
                $column->tooltip = Az::l('Текст письма');
                $column->rules = validatorString;
                $column->dbType = dbTypeText;
                return $column;
            },
            
           
            'read' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Прочитано?');
                $column->tooltip = Az::l('Статус (Прочитано?) письма- показывает прочитано ли письмо');
                $column->dbType = dbTypeBoolean;
                $column->defaultValue = false;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'file' => function (FormDb $column) {

                $column->title = Az::l('Файл');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },

             'time' => function (FormDb $column) {

                $column->title = Az::l('Время');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;
                $column->mergeHeader = true;

                return $column;
            },

           
            'chat_group_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Групповой чат');
                $column->tooltip = Az::l('Определенное количество человек переписывающихся в группе');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;

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
        'sender',
        'receiver',
        'text',
        'read',
        'file',
        'time',
        'chat_group_id',
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
                                'sender',
                            ],
                            [
                                'receiver',
                            ],
                            [
                                'text',
                            ],
                            [
                                'time',
                            ],
                            [
                                'read',
                            ],
                            [
                                'file',
                            ],
                            [
                                'user_group_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                    public function value(ChatMessage $model = null)
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
 $event->beforeDelete = function (CoreMessage $model) {
 return null;
 };

 $event->afterDelete = function (CoreMessage $model) {
 return null;
 };

 $event->beforeSave = function (CoreMessage $model) {
 return null;
 };

 $event->afterSave = function (CoreMessage $model) {
 return null;
 };

 $event->beforeValidate = function (CoreMessage $model) {
 return null;
 };

 $event->afterValidate = function (CoreMessage $model) {
 return null;
 };

 $event->afterRefresh = function (CoreMessage $model) {
 return null;
 };

 $event->afterFind = function (CoreMessage $model) {
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
     * Function  getSender
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getSenderOne()
    {
        return $this->getOne(User::class, [
          'id' => 'sender',
      ]);    
    }
    
     /**
     *
     * Function  getSender
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getSender()
    {
        return $this->hasOne(User::class, [
          'id' => 'sender',
      ]);    
    }
    
    

    /**
     *
     * Function  getReceiver
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getReceiverOne()
    {
        return $this->getOne(User::class, [
          'id' => 'receiver',
      ]);    
    }
    
     /**
     *
     * Function  getReceiver
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getReceiver()
    {
        return $this->hasOne(User::class, [
          'id' => 'receiver',
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
    
    

    /**
     *
     * Function  getChatGroup
     * @return bool|\yii\db\ActiveRecord|ChatGroup|null
     */            
    public function getChatGroupOne()
    {
        return $this->getOne(ChatGroup::class, [
          'id' => 'chat_group_id',
      ]);    
    }
    
     /**
     *
     * Function  getChatGroup
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getChatGroup()
    {
        return $this->hasOne(ChatGroup::class, [
          'id' => 'chat_group_id',
      ]);    
    }
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}
