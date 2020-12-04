<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\ware;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\shop\ShopOrder;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZHTextareaWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\user\UserCompany;
use zetsoft\models\shop\ShopCourier;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\models\ware\Ware;
use zetsoft\models\ware\WareExitItem;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\ware\WareTrans;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    WareExit
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $date
 * @property string $source
 * @property int $user_company_id
 * @property int $ware_id
 * @property int $shop_courier_id
 * @property int $responsible
 * @property string $comment
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class WareExit extends ZActiveRecord
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
    public $date;
    public $source;
    public $user_company_id;
    public $ware_id;
    public $shop_courier_id;
    public $responsible;
    public $comment;
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
        'date',
        'source',
        'user_company_id',
        'ware_id',
        'shop_courier_id',
        'responsible',
        'comment',
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

    /* @var array $_source*/
    public $_source;  
    public const source = [
        'exit' => 'exit',
        'trans' => 'trans',
        'banderol' => 'banderol',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Отгрузка товаров со склада';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_source = [
            'exit' => Az::l('Прямая выписка товара'),
            'trans' => Az::l('Перемещение между складами'),
            'banderol' => Az::l('Выход товара через бандероль'),
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
			'date',
			'source',
			'user_company_id',
			'ware_id',
			'shop_courier_id',
			'responsible',
			'comment',
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

            $config->addDel = 1;

            $config->titleId = 'Номер';

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $config->nameValue = static function ($model) {

                /** @var WareExit $model */

                Az::$app->forms->wiData->clean();
                Az::$app->forms->wiData->model = $model;
                Az::$app->forms->wiData->attribute = 'ware_id';
                $ware_id = Az::$app->forms->wiData->value();

                return "Списание со {$ware_id} №{$model->id} от {$model->date}";
            };

            $config->hasOne = [
                    'UserCompany' => [
                        'user_company_id' => 'id',
                    ],
                    'Ware' => [
                        'ware_id' => 'id',
                    ],
                    'ShopCourier' => [
                        'shop_courier_id' => 'id',
                    ],
                    'User' => [
                        'responsible' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'WareExitItem' => [
                        'ware_exit_id' => 'id',
                    ],
                    'WareTrans' => [
                        'ware_exit_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Отгрузка товаров со склада');

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

            'date' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Дата');
                $column->tooltip = Az::l('Дата');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;
                $column->showDyna = false;
                $column->readonlyWidget = true;
                return $column;
            },


            'source' => function (FormDb $column) {

                $column->title = Az::l('Источник');
                $column->tooltip = Az::l('Фармат расхода');
                $column->value = 'exit';
                $column->data = [
                    'exit' => Az::l('Прямая выписка товара'),
                    'trans' => Az::l('Перемещение между складами'),
                    'banderol' => Az::l('Выход товара через бандероль'),
                ];
                $column->value = 'exit';
                $column->defaultValue = 'exit';
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'user_company_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Магазин');
                $column->tooltip = Az::l('Магазин с которого минусуется товар');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkQuery = [
                    'type' => 'market',
                ];

                return $column;
            },


            'ware_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Склад');
                $column->tooltip = Az::l('Склад с которого минусуется товар');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];
                $column->widget = ZDepdropWidget::class;
                $column->options = [
                    'config' => [
                        'depend' => 'user_company_id',
                        'method' => 'getWaresByUserCompany',
                    ],
                ];
                $column->filterWidget = ZKSelect2Widget::class;

                return $column;
            },


            'shop_courier_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Курьер');
                $column->tooltip = Az::l('Курьер, который доставляет росходующий товар ');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'responsible' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Ответственный');
                $column->tooltip = Az::l('Ответственный - человек отвечающий за тот или иной расходующий товар');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user';
                $column->fkQuery = [
                    'role' => [
                        'manager',
                        'admin',
                        'logistics',
                        'warehouse',
                    ],
                ];

                return $column;
            },


            'comment' => function (FormDb $column) {

                $column->title = Az::l('Коментарий');
                $column->tooltip = Az::l('Коментарий');
                $column->dbType = dbTypeText;
                $column->widget = ZHTextareaWidget::class;
                $column->filterWidget = ZInputWidget::class;

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
        'date',
        'source',
        'user_company_id',
        'ware_id',
        'shop_courier_id',
        'responsible',
        'comment',
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
                                'date',
                                'responsible',
                            ],
                            [
                                'user_company_id',
                                'ware_id',
                            ],
                            [
                                'shop_courier_id',
                                'comment',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(WareExit $model = null)
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
//        $event->beforeSave = function (WareTrans $model) {
//        };
        /*
        $event->beforeDelete = function (ShopCatalog $model) {
        return null;
        };

        $event->afterDelete = function (ShopCatalog $model) {
        return null;
        };

        $event->beforeSave = function (ShopCatalog $model) {
        return null;
        };

        $event->afterSave = function (ShopCatalog $model) {
        return null;
        };

        $event->beforeValidate = function (ShopCatalog $model) {
        return null;
        };

        $event->afterValidate = function (ShopCatalog $model) {
        return null;
        };

        $event->afterRefresh = function (ShopCatalog $model) {
        return null;
        };

        $event->afterFind = function (ShopCatalog $model) {
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
     * Function  getUserCompany
     * @return bool|\yii\db\ActiveRecord|UserCompany|null
     */            
    public function getUserCompanyOne()
    {
        return $this->getOne(UserCompany::class, [
          'id' => 'user_company_id',
      ]);    
    }
    
     /**
     *
     * Function  getUserCompany
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getUserCompany()
    {
        return $this->hasOne(UserCompany::class, [
          'id' => 'user_company_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getWare
     * @return bool|\yii\db\ActiveRecord|Ware|null
     */            
    public function getWareOne()
    {
        return $this->getOne(Ware::class, [
          'id' => 'ware_id',
      ]);    
    }
    
     /**
     *
     * Function  getWare
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWare()
    {
        return $this->hasOne(Ware::class, [
          'id' => 'ware_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getShopCourier
     * @return bool|\yii\db\ActiveRecord|ShopCourier|null
     */            
    public function getShopCourierOne()
    {
        return $this->getOne(ShopCourier::class, [
          'id' => 'shop_courier_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopCourier
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopCourier()
    {
        return $this->hasOne(ShopCourier::class, [
          'id' => 'shop_courier_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getResponsible
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getResponsibleOne()
    {
        return $this->getOne(User::class, [
          'id' => 'responsible',
      ]);    
    }
    
     /**
     *
     * Function  getResponsible
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getResponsible()
    {
        return $this->hasOne(User::class, [
          'id' => 'responsible',
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
     * Function  getWareExitItemsWithWareExitIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareExitItem
     */            
    public function getWareExitItemsWithWareExitIdMany()
    {
       return $this->getMany(WareExitItem::class, [
            'ware_exit_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareExitItemsWithWareExitId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareExitItemsWithWareExitId()
    {
       return $this->hasMany(WareExitItem::class, [
            'ware_exit_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareTransWithWareExitIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareTrans
     */            
    public function getWareTransWithWareExitIdMany()
    {
       return $this->getMany(WareTrans::class, [
            'ware_exit_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareTransWithWareExitId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareTransWithWareExitId()
    {
       return $this->hasMany(WareTrans::class, [
            'ware_exit_id' => 'id',
        ]);     
    }


    #endregion


}
