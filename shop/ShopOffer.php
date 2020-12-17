<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\shop;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopOffer
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $shop_catalog_id
 * @property array $type
 * @property string $start
 * @property string $end
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopOffer extends ZActiveRecord
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
    public $shop_catalog_id;
    public $type;
    public $start;
    public $end;
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
        'shop_catalog_id',
        'type',
        'start',
        'end',
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
        'new' => 'new',
        'discount' => 'discount',
        'popular' => 'popular',
        'deal_of_day' => 'deal_of_day',
        'super_offer' => 'super_offer',
        'free_delivery' => 'free_delivery',
        'top_sell' => 'top_sell',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Специальные предложения';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_type = [
            'new' => Az::l('Новинка'),
            'discount' => Az::l('Скидка'),
            'popular' => Az::l('Популярные'),
            'deal_of_day' => Az::l('Товар дня'),
            'super_offer' => Az::l('Супер предложение'),
            'free_delivery' => Az::l('Бесплатная доставка'),
            'top_sell' => Az::l('Топ продаж'),
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
			'shop_catalog_id',
			'type',
			'start',
			'end',
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

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $config->nameValue = function (ShopOffer $offer) {
                $catalog = $offer->getShopCatalog()->one();
                if ($catalog === null)
                    return null;
                return $catalog->name;
            };

            $config->hasOne = [
                    'ShopCatalog' => [
                        'shop_catalog_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Специальные предложения');

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

            'shop_catalog_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Каталог товаров');
                $column->tooltip = Az::l('Каталог товаров для которого осуществляется предложение');
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
                $column->options = [
                    'config' => [
                        'ajax' => false,
                    ],
                ];

                return $column;
            },


            'type' => function (FormDb $column) {

                $column->title = Az::l('Тип предложения');
                $column->tooltip = Az::l('Возможные типы предложений которые можно предложить клиентам');
                $column->dbType = dbTypeJsonb;
                $column->data = [
                    'new' => Az::l('Новинка'),
                    'discount' => Az::l('Скидка'),
                    'popular' => Az::l('Популярные'),
                    'deal_of_day' => Az::l('Товар дня'),
                    'super_offer' => Az::l('Супер предложение'),
                    'free_delivery' => Az::l('Бесплатная доставка'),
                    'top_sell' => Az::l('Топ продаж'),
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },


            'start' => function (FormDb $column) {

                $column->title = Az::l('Начало');
                $column->tooltip = Az::l('Дата начала предложения');
                $column->dbType = dbTypeDateTime;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorDatetime,
                    ],
                ];
                $column->widget = ZKDateTimePickerWidget::class;

                return $column;
            },


            'end' => function (FormDb $column) {

                $column->title = Az::l('Конец');
                $column->tooltip = Az::l('Дата оканчивания предложения');
                $column->dbType = dbTypeDateTime;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorDatetime,
                    ],
                ];
                $column->widget = ZKDateTimePickerWidget::class;

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
        'shop_catalog_id',
        'type',
        'start',
        'end',
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
                                'shop_catalog_id',
                                'type',
                                'start',
                                'end',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(ShopOffer $model = null)
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
