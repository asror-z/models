<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\core;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\pays\PaysCurrency;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\models\place\PlaceCountry;
use zetsoft\dbitem\data\Event;
use zetsoft\models\shop\ShopCategory;
use zetsoft\models\shop\ShopOption;
use zetsoft\widgets\inputes\ZTextAreaWidget;
use zetsoft\models\shop\ShopBrand;
use zetsoft\models\shop\ShopElement;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CoreQueue
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property boolean $app
 * @property string $namespace
 * @property string $service
 * @property string $method
 * @property string $args
 * @property string $cmd
 * @property string $status
 * @property string $session
 * @property int $pid
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CoreQueue extends ZActiveRecord
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
    public $app;
    public $namespace;
    public $service;
    public $method;
    public $args;
    public $cmd;
    public $status;
    public $session;
    public $pid;
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
        'app',
        'namespace',
        'service',
        'method',
        'args',
        'cmd',
        'status',
        'session',
        'pid',
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
        'queue' => 'queue',
        'process' => 'process',
        'finished' => 'finished',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Системные очереди';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_status = [
            'queue' => Az::l('В очереди'),
            'process' => Az::l('В процессе'),
            'finished' => Az::l('Закончено'),
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
			'app',
			'namespace',
			'service',
			'method',
			'args',
			'cmd',
			'status',
			'session',
			'pid',
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
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Системные очереди');

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
           
            'app' => function (FormDb $column) {

                $column->title = Az::l('App');
                $column->dbType = dbTypeBoolean;
                $column->rules = validatorBoolean;

                return $column;
            },
            
           
            'namespace' => function (FormDb $column) {

                $column->title = Az::l('Namespace');
                $column->rules = validatorString;

                return $column;
            },
            
           
            'service' => function (FormDb $column) {

                $column->title = Az::l('Service');
                $column->rules = validatorString;

                return $column;
            },
            
           
            'method' => function (FormDb $column) {

                $column->title = Az::l('method');
                $column->rules = validatorString;

                return $column;
            },
            
           
            'args' => function (FormDb $column) {

                $column->title = Az::l('args');
                $column->rules = validatorString;

                return $column;
            },
            
           
            'cmd' => function (FormDb $column) {

                $column->title = Az::l('Командная строка');
                $column->dbType = dbTypeText;

                return $column;
            },
            
           
            'status' => function (FormDb $column) {

                $column->title = Az::l('args');
                $column->data = [
                    'queue' => Az::l('В очереди'),
                    'process' => Az::l('В процессе'),
                    'finished' => Az::l('Закончено'),
                ];
                $column->rules = validatorString;

                return $column;
            },
            
           
            'session' => function (FormDb $column) {

                $column->title = Az::l('Session');
                $column->rules = validatorString;

                return $column;
            },
            
           
            'pid' => function (FormDb $column) {

                $column->title = Az::l('Pid code');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

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
        'app',
        'namespace',
        'service',
        'method',
        'args',
        'cmd',
        'status',
        'session',
        'pid',
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
                                'id',
                            ],
                            [
                                'name',
                            ],
                            [
                                'App',
                            ],
                            [
                                'namespace',
                            ],
                            [
                                'service',
                            ],
                            [
                                'method',
                            ],
                            [
                                'args',
                            ],
                            [
                                'cmd',
                            ],
                            [
                                'status',
                            ],
                            [
                                'session',
                            ],
                            [
                                'pid',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(CoreQueue &$model = null)
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
        $event->beforeDelete = function (CoreQueue $model) {
            return null;
        };

        $event->afterDelete = function (CoreQueue $model) {
            return null;
        };

        $event->beforeSave = function (CoreQueue $model) {
            return null;
        };

        $event->afterSave = function (CoreQueue $model) {
            return null;
        };

        $event->beforeValidate = function (CoreQueue $model) {
            return null;
        };

        $event->afterValidate = function (CoreQueue $model) {
            return null;
        };

        $event->afterRefresh = function (CoreQueue $model) {
            return null;
        };

        $event->afterFind = function (CoreQueue $model) {
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
