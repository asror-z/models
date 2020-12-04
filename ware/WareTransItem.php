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
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\shop\ShopCatalogWare;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\system\validate\TransItemCountValidator;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\ware\WareTrans;
use zetsoft\models\ware\WareSeries;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    WareTransItem
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $ware_trans_id
 * @property int $shop_catalog_id
 * @property string $best_before
 * @property int $ware_series_id
 * @property int $price
 * @property int $price_all
 * @property int $amount
 * @property string $measure
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class WareTransItem extends ZActiveRecord
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
    public $ware_trans_id;
    public $shop_catalog_id;
    public $best_before;
    public $ware_series_id;
    public $price;
    public $price_all;
    public $amount;
    public $measure;
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
        'ware_trans_id',
        'shop_catalog_id',
        'best_before',
        'ware_series_id',
        'price',
        'price_all',
        'amount',
        'measure',
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

    /* @var array $_measure*/
    public $_measure;  
    public const measure = [
        'pcs' => 'pcs',
        'm' => 'm',
        'l' => 'l',
        'kg' => 'kg',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Товары для перемещения между складами';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_measure = [
            'pcs' => Az::l('Шт'),
            'm' => Az::l('М'),
            'l' => Az::l('Л'),
            'kg' => Az::l('Кг'),
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
			'ware_trans_id',
			'shop_catalog_id',
			'best_before',
			'ware_series_id',
			'price',
			'price_all',
			'amount',
			'measure',
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

            $config->nameValue = 'Перемещение c {ware_trans_id} от {created_at}';

            $config->hasOne = [
                    'WareTrans' => [
                        'ware_trans_id' => 'id',
                    ],
                    'ShopCatalog' => [
                        'shop_catalog_id' => 'id',
                    ],
                    'WareSeries' => [
                        'ware_series_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Товары для перемещения между складами');

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

            'ware_trans_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Акт перемещения складов');
                $column->tooltip = Az::l('Номер акта для перемещения между складами');
                $column->rules = 'zetsoft\\system\\validate\\ZRequiredValidator';
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },

            'shop_catalog_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Каталог товаров');
                $column->tooltip = Az::l('Каталог товаров для которых производится перемещение между складами');
                $column->rules = 'zetsoft\\system\\validate\\ZRequiredValidator';
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },

            'best_before' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Годен до');
                $column->tooltip = Az::l('Список срока годности выбранного каталога товаров для перемещения между складами');
                $column->dbType = dbTypeDate;
                $column->rules = 'zetsoft\\system\\validate\\ZRequiredValidator';
                $column->widget = ZDepdropWidget::class;
                $column->options = [
                    'config' => [
                        'depend' => 'shop_catalog_id',
                        'namespace' => 'inputs',
                        'service' => 'depend',
                        'method' => 'shelfLifeByCatalogId',
                    ],
                ];

                return $column;
            },

            'ware_series_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Серия');
                $column->tooltip = Az::l('Серия выбранного каталога товаров');
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'tags' => true,
                    ],
                ];

                return $column;
            },

            'price' => function (FormDb $column) {

                $column->title = Az::l('Цена продажи');
                $column->tooltip = Az::l('Цена продажи выбранного каталога товаров');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKTouchSpinWidget::class;
                $column->filterWidget = ZHInputWidget::class;
                $column->options = [];
                $column->width = '100px';

                return $column;
            },

            'price_all' => function (FormDb $column) {

                $column->title = Az::l('Общая сумма');
                $column->tooltip = Az::l('Общая сумма товаров');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKTouchSpinWidget::class;
                $column->options = [];
                return $column;
            },

            'amount' => function (FormDb $column) {

                $column->title = Az::l('Количество');
                $column->tooltip = Az::l('Количество отгруженных товаров');
                $column->dbType = dbTypeInteger;

                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKTouchSpinWidget::class;
                $column->history = true;

                return $column;
            },

            'measure' => function (FormDb $column) {

                $column->title = Az::l('Единица измерения');
                $column->tooltip = Az::l('Единица измерения товара');
                $column->data = [
                    'pcs' => Az::l('Шт'),
                    'm' => Az::l('М'),
                    'l' => Az::l('Л'),
                    'kg' => Az::l('Кг'),
                ];
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
        'ware_trans_id',
        'shop_catalog_id',
        'best_before',
        'ware_series_id',
        'price',
        'price_all',
        'amount',
        'measure',
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
                                'ware_trans_id',
                            ],
                            [
                                'shop_catalog_id',
                                'ware_series_id',
                            ],
                            [
                                'price',
                                'price_all',
                            ],
                            [
                                'amount',
                                'measure',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(WareTransItem $model = null)
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

        $event->beforeSave = function (WareTransItem $model) {
            if ($this->isNewRecord) {
                Az::$app->market->wares->trans($model);
            }
        };
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
     * Function  getWareTrans
     * @return bool|\yii\db\ActiveRecord|WareTrans|null
     */            
    public function getWareTransOne()
    {
        return $this->getOne(WareTrans::class, [
          'id' => 'ware_trans_id',
      ]);    
    }
    
     /**
     *
     * Function  getWareTrans
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWareTrans()
    {
        return $this->hasOne(WareTrans::class, [
          'id' => 'ware_trans_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getShopCatalog
     * @return bool|\yii\db\ActiveRecord|ShopCatalog|null
     */            
    public function getShopCatalogOne()
    {
        return $this->getOne(ShopCatalog::class, [
          'id' => 'shop_catalog_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopCatalog
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopCatalog()
    {
        return $this->hasOne(ShopCatalog::class, [
          'id' => 'shop_catalog_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getWareSeries
     * @return bool|\yii\db\ActiveRecord|WareSeries|null
     */            
    public function getWareSeriesOne()
    {
        return $this->getOne(WareSeries::class, [
          'id' => 'ware_series_id',
      ]);    
    }
    
     /**
     *
     * Function  getWareSeries
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWareSeries()
    {
        return $this->hasOne(WareSeries::class, [
          'id' => 'ware_series_id',
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
