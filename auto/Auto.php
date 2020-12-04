<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\auto;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZKColorInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\models\shop\ShopCourier;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\models\auto\AutoType;
use zetsoft\models\auto\AutoModel;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    Auto
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $number
 * @property int $year
 * @property string $color
 * @property int $auto_type_id
 * @property int $auto_model_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class Auto extends ZActiveRecord
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
    public $number;
    public $year;
    public $color;
    public $auto_type_id;
    public $auto_model_id;
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
        'number',
        'year',
        'color',
        'auto_type_id',
        'auto_model_id',
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
    public static ?string $title = Azl . 'Транспортные средства';
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
			'number',
			'year',
			'color',
			'auto_type_id',
			'auto_model_id',
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
                    'AutoType' => [
                        'auto_type_id' => 'id',
                    ],
                    'AutoModel' => [
                        'auto_model_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopCourier' => [
                        'auto_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Транспортные средства');

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

            'number' => function (FormDb $column) {

                $column->title = Az::l('Регистрационный номер');
                $column->tooltip = Az::l('Регистрационный номер автомобиля');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },


            'year' => function (FormDb $column) {

                $column->title = Az::l('Год регистрации');
                $column->tooltip = Az::l('Год регистрации автомобиля');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },


            'color' => function (FormDb $column) {

                $column->title = Az::l('Цвет');
                $column->tooltip = Az::l('Цвет автомобиля');
                $column->rules = validatorString;
                $column->filterWidget = ZKColorInputWidget::class;

                return $column;
            },


            'auto_type_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Тип транспортного средства');
                $column->tooltip = Az::l('Тип транспортного средства, который используется для логистики');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'auto_model_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Модель транспортного средства');
                $column->tooltip = Az::l('Модель транспортного средства, который используется для логистики');
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
        'number',
        'year',
        'color',
        'auto_type_id',
        'auto_model_id',
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
                                'number',
                            ],
                            [
                                'year',
                            ],
                            [
                                'color',
                            ],
                            [
                                'status',
                            ],
                            [
                                'auto_type_id',
                            ],
                            [
                                'auto_model_id',
                            ],
                            [
                                'created_at',
                            ],
                            [
                                'modified_at',
                            ],
                            [
                                'created_by',
                            ],
                            [
                                'modified_by',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(Auto $model = null)
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
        $event->beforeDelete = function (Auto $model) {
        return null;
        };

        $event->afterDelete = function (Auto $model) {
        return null;
        };

        $event->beforeSave = function (Auto $model) {
        return null;
        };

        $event->afterSave = function (Auto $model) {
        return null;
        };

        $event->beforeValidate = function (Auto $model) {
        return null;
        };

        $event->afterValidate = function (Auto $model) {
        return null;
        };

        $event->afterRefresh = function (Auto $model) {
        return null;
        };

        $event->afterFind = function (Auto $model) {
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
     * Function  getAutoType
     * @return bool|\yii\db\ActiveRecord|AutoType|null
     */            
    public function getAutoTypeOne()
    {
        return $this->getOne(AutoType::class, [
          'id' => 'auto_type_id',
      ]);    
    }
    
     /**
     *
     * Function  getAutoType
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getAutoType()
    {
        return $this->hasOne(AutoType::class, [
          'id' => 'auto_type_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getAutoModel
     * @return bool|\yii\db\ActiveRecord|AutoModel|null
     */            
    public function getAutoModelOne()
    {
        return $this->getOne(AutoModel::class, [
          'id' => 'auto_model_id',
      ]);    
    }
    
     /**
     *
     * Function  getAutoModel
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getAutoModel()
    {
        return $this->hasOne(AutoModel::class, [
          'id' => 'auto_model_id',
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


    /**
     *
     * Function  getShopCouriersWithAutoIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopCourier
     */            
    public function getShopCouriersWithAutoIdMany()
    {
       return $this->getMany(ShopCourier::class, [
            'auto_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopCouriersWithAutoId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopCouriersWithAutoId()
    {
       return $this->hasMany(ShopCourier::class, [
            'auto_id' => 'id',
        ]);     
    }


    #endregion


}
