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
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHPasswordInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputMaskWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKStarRatingWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\user\UserCompany;
use zetsoft\models\drag\DragApp;
use zetsoft\models\user\UserBlocked;
use zetsoft\models\page\PageBlocks;
use zetsoft\models\page\PageBlocksType;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\shop\ShopCategory;
use zetsoft\models\drag\DragConfig;
use zetsoft\models\drag\DragConfigDb;
use zetsoft\models\pays\PaysCurrency;
use zetsoft\models\govs\GovsDegree;
use zetsoft\models\dyna\DynaConfig;
use zetsoft\models\govs\GovsEducation;
use zetsoft\models\faqs\Faqs;
use zetsoft\models\faqs\FaqsType;
use zetsoft\models\drag\DragForm;
use zetsoft\models\drag\DragFormDb;
use zetsoft\models\user\UserFriend;
use zetsoft\models\faqs\FaqsManual;
use zetsoft\models\news\News;
use zetsoft\models\news\NewsType;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\govs\GovsPosition;
use zetsoft\models\core\CoreQueue;
use zetsoft\models\core\CoreSession;
use zetsoft\models\core\CoreSetting;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\shop\ShopReview;
use zetsoft\models\shop\ShopQuestion;
use zetsoft\models\shop\ShopPayment;
use zetsoft\models\shop\ShopShipment;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\shop\ShopProduct;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopCoupon
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $type
 * @property int $price
 * @property string $currency
 * @property int $percent
 * @property int $useful_count
 * @property int $min_price_order
 * @property string $coupon_code
 * @property string $comment
 * @property string $published_at
 * @property string $expired_at
 * @property string $status
 * @property int $shop_category_id
 * @property int $shop_product_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopCoupon extends ZActiveRecord
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
    public $type;
    public $price;
    public $currency;
    public $percent;
    public $useful_count;
    public $min_price_order;
    public $coupon_code;
    public $comment;
    public $published_at;
    public $expired_at;
    public $status;
    public $shop_category_id;
    public $shop_product_id;
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
        'type',
        'price',
        'currency',
        'percent',
        'useful_count',
        'min_price_order',
        'coupon_code',
        'comment',
        'published_at',
        'expired_at',
        'status',
        'shop_category_id',
        'shop_product_id',
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
        'one_fixed' => 'one_fixed',
        'one_percent' => 'one_percent',
        'multi_fixed' => 'multi_fixed',
        'multi_percent' => 'multi_percent',
    ];

    /* @var array $_currency*/
    public $_currency;  
    public const currency = [
        'USD' => 'USD',
        'EUR' => 'EUR',
        'UZS' => 'UZS',
        'RUB' => 'RUB',
        'GBP' => 'GBP',
        'JPY' => 'JPY',
        'BHD' => 'BHD',
        'CAD' => 'CAD',
    ];

    /* @var array $_status*/
    public $_status;  
    public const status = [
        'expired' => 'expired',
        'used' => 'used',
        'active' => 'active',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Купоны';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_type = [
            'one_fixed' => Az::l('Нoминaльный одноразовый кyпoн'),
            'one_percent' => Az::l('Многоразовый кyпoн '),
            'multi_fixed' => Az::l('Kyпoны c нoминaлoм'),
            'multi_percent' => Az::l('Kyпoны c нoминaлoм'),
        ];
        
        $this->_currency = [
            'USD' => Az::l('USD (Доллар США)'),
            'EUR' => Az::l('EUR (Евро)'),
            'UZS' => Az::l('UZS (Узбекский сум)'),
            'RUB' => Az::l('RUB (Российский рубль)'),
            'GBP' => Az::l('GBP (Фунт стерлингов)'),
            'JPY' => Az::l('JPY (Иена)'),
            'BHD' => Az::l('BHD (Бахрейнский динар)'),
            'CAD' => Az::l('CAD (Канадский долла)'),
        ];
        
        $this->_status = [
            'expired' => Az::l('Срок истёк'),
            'used' => Az::l('Уже использован'),
            'active' => Az::l('Активный'),
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
			'type',
			'price',
			'currency',
			'percent',
			'useful_count',
			'min_price_order',
			'coupon_code',
			'comment',
			'published_at',
			'expired_at',
			'status',
			'shop_category_id',
			'shop_product_id',
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
                    'ShopProduct' => [
                        'min_price_order' => 'id',
                        'shop_product_id' => 'id',
                    ],
                    'ShopCategory' => [
                        'shop_category_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopOrder' => [
                        'shop_coupon_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Купоны');
            $config->info = [
                    'https://coupon.aliexpress.ru/buyer/coupon/listView.htm',
                ];

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
           
            'type' => function (FormDb $column) {

                $column->title = Az::l('Виды купона');
                $column->tooltip = Az::l('Виды купонов которые можно использовать');
                $column->data = [
                    'one_fixed' => Az::l('Нoминaльный одноразовый кyпoн'),
                    'one_percent' => Az::l('Многоразовый кyпoн '),
                    'multi_fixed' => Az::l('Kyпoны c нoминaлoм'),
                    'multi_percent' => Az::l('Kyпoны c нoминaлoм'),
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'price' => function (FormDb $column) {

                $column->title = Az::l('Цена');
                $column->tooltip = Az::l('Цена купона');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZHInputWidget::class;

                return $column;
            },
            
           
            'currency' => function (FormDb $column) {

                $column->title = Az::l('Валюта');
                $column->tooltip = Az::l('Все доступные валюты');
                $column->value = 'UZS';
                $column->data = [
                    'USD' => Az::l('USD (Доллар США)'),
                    'EUR' => Az::l('EUR (Евро)'),
                    'UZS' => Az::l('UZS (Узбекский сум)'),
                    'RUB' => Az::l('RUB (Российский рубль)'),
                    'GBP' => Az::l('GBP (Фунт стерлингов)'),
                    'JPY' => Az::l('JPY (Иена)'),
                    'BHD' => Az::l('BHD (Бахрейнский динар)'),
                    'CAD' => Az::l('CAD (Канадский долла)'),
                ];
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'percent' => function (FormDb $column) {

                $column->title = Az::l('Процент');
                $column->tooltip = Az::l('Процент скидки купона');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZHInputWidget::class;

                return $column;
            },
            
           
            'useful_count' => function (FormDb $column) {

                $column->title = Az::l('Полезный счёт');
                $column->tooltip = Az::l('Полезный счёт');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZHInputWidget::class;

                return $column;
            },
            
           
            'min_price_order' => function (FormDb $column) {

                $column->title = Az::l('Минимальная цена заказа');
                $column->tooltip = Az::l('Минимальная цена заказа для использования купона');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'shop_product';

                return $column;
            },
            
           
            'coupon_code' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Код купона');
                $column->tooltip = Az::l('Код купона');
                $column->widget = ZHInputWidget::class;

                return $column;
            },
            
           
            'comment' => function (FormDb $column) {

                $column->title = Az::l('Комментарий');
                $column->tooltip = Az::l('Комментарий');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'published_at' => function (FormDb $column) {

                $column->title = Az::l('Опубликовано в');
                $column->tooltip = Az::l('Дата когда началось действительность купона');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;

                return $column;
            },
            
           
            'expired_at' => function (FormDb $column) {

                $column->title = Az::l('Истек в');
                $column->tooltip = Az::l('Дата когда истечёт действительность купона');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;

                return $column;
            },
            
           
            'status' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Состояние');
                $column->tooltip = Az::l('Состояние купона на данный момент');
                $column->data = [
                    'expired' => Az::l('Срок истёк'),
                    'used' => Az::l('Уже использован'),
                    'active' => Az::l('Активный'),
                ];
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'shop_category_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Категория');
                $column->tooltip = Az::l('Категории для которых можно использовать купон');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'shop_category';

                return $column;
            },
            
           
            'shop_product_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Продукт');
                $column->tooltip = Az::l('Продукт для которых можно использовать купон');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'shop_product';

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
        'type',
        'price',
        'currency',
        'percent',
        'useful_count',
        'min_price_order',
        'coupon_code',
        'comment',
        'published_at',
        'expired_at',
        'status',
        'shop_category_id',
        'shop_product_id',
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
                                'type',
                                'price',
                                'currency',
                                'percent',
                                'useful_count',
                                'min_price_order',
                                'coupon_code',
                                'comment',
                                'published_at',
                                'expired_at',
                                'status',
                                'shop_category_id',
                                'shop_product_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
            public function value(ShopCoupon $model = null)
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
        $event->beforeDelete = function (User $model) {
        return null;
        };

        $event->afterDelete = function (User $model) {
        return null;
        };

        $event->beforeSave = function (User $model) {
        return null;
        };

        $event->afterSave = function (User $model) {
        return null;
        };

        $event->beforeValidate = function (User $model) {
        return null;
        };

        $event->afterValidate = function (User $model) {
        return null;
        };

        $event->afterRefresh = function (User $model) {
        return null;
        };

        $event->afterFind = function (User $model) {
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
     * Function  getMinPriceOrder
     * @return bool|\yii\db\ActiveRecord|ShopProduct|null
     */            
    public function getMinPriceOrderOne()
    {
        return $this->getOne(ShopProduct::class, [
          'id' => 'min_price_order',
      ]);    
    }
    
     /**
     *
     * Function  getMinPriceOrder
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getMinPriceOrder()
    {
        return $this->hasOne(ShopProduct::class, [
          'id' => 'min_price_order',
      ]);    
    }
    
    

    /**
     *
     * Function  getShopProduct
     * @return bool|\yii\db\ActiveRecord|ShopProduct|null
     */            
    public function getShopProductOne()
    {
        return $this->getOne(ShopProduct::class, [
          'id' => 'shop_product_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopProduct
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopProduct()
    {
        return $this->hasOne(ShopProduct::class, [
          'id' => 'shop_product_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getShopCategory
     * @return bool|\yii\db\ActiveRecord|ShopCategory|null
     */            
    public function getShopCategoryOne()
    {
        return $this->getOne(ShopCategory::class, [
          'id' => 'shop_category_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopCategory
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopCategory()
    {
        return $this->hasOne(ShopCategory::class, [
          'id' => 'shop_category_id',
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
     * Function  getShopOrdersWithShopCouponIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopOrder
     */            
    public function getShopOrdersWithShopCouponIdMany()
    {
       return $this->getMany(ShopOrder::class, [
            'shop_coupon_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopOrdersWithShopCouponId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopOrdersWithShopCouponId()
    {
       return $this->hasMany(ShopOrder::class, [
            'shop_coupon_id' => 'id',
        ]);     
    }


    #endregion


}
