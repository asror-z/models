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
use zetsoft\models\user\User;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    UserContact
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
 * @property int $blocked
 * @property string $text
 * @property string $status
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class UserContact extends ZActiveRecord
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
    public $blocked;
    public $text;
    public $status;
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
        'blocked',
        'text',
        'status',
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
        'await' => 'await',
        'accepted' => 'accepted',
        'rejected' => 'rejected',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Контакты';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_status = [
            'await' => Az::l('В ожидании'),
            'accepted' => Az::l('Принят'),
            'rejected' => Az::l('Отклонен'),
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
			'blocked',
			'text',
			'status',
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

            $config->title = Az::l('Контакты');

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
                $column->tooltip = Az::l('Отправитель запроса');
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
                $column->tooltip = Az::l('Получатель запроса');
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

            'blocked' => function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->defaultValue = 0;
                return $column;
            },
            
           
            'text' => function (FormDb $column) {

                $column->title = Az::l('Текст');
                $column->tooltip = Az::l('Дополнительный текст');
                $column->options = [
						'config' =>[
							'hasIcon' => true,
							'icon' => 'fab fa-telegram-plane',
						],
					];
                $column->filterOptions = [
						'config' =>[
							'hasIcon' => true,
							'icon' => 'fab fa-telegram-plane',
						],
					];

                return $column;
            },
            
           
            'status' => function (FormDb $column) {

                $column->title = Az::l('Статус');
                $column->tooltip = Az::l('Статус запроса');
                $column->data = [
                    'await' => Az::l('В ожидании'),
                    'accepted' => Az::l('Принят'),
                    'rejected' => Az::l('Отклонен'),
                ];
                $column->widget = ZHRadioButtonGroupWidget::class;
                $column->defaultValue = self::status['await'];
                $column->mergeHeader = true;

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
        'blocked',
        'text',
        'status',
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
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                    public function value(UserContact $model = null)
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
        $event->beforeDelete = function (CoreContact $model) {
            return null;
        };

        $event->afterDelete = function (CoreContact $model) {
            return null;
        };

        $event->beforeSave = function (CoreContact $model) {
            return null;
        };

        $event->afterSave = function (CoreContact $model) {
            return null;
        };

        $event->beforeValidate = function (CoreContact $model) {
            return null;
        };

        $event->afterValidate = function (CoreContact $model) {
            return null;
        };

        $event->afterRefresh = function (CoreContact $model) {
            return null;
        };

        $event->afterFind = function (CoreContact $model) {
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
