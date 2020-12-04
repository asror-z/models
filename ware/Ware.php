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


use zetsoft\dbdata\auth\CompanyTypeData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\auth\AuthEmailForm;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZCKEditorWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\place\PlaceRegion;
use zetsoft\models\place\PlaceAdress;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKStarRatingWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\shop\ShopCourier;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\models\core\CoreSetting;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\ware\WareTrans;
use zetsoft\models\ware\WareEnter;
use zetsoft\models\shop\ShopCatalogWare;
use zetsoft\models\ware\WareExit;
use zetsoft\models\ware\WareReturn;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\pays\PaysSysClick;
use zetsoft\models\pays\PaysSysOson;
use zetsoft\models\pays\PaysSysPayme;
use zetsoft\models\pays\PaysSysPaysys;
use zetsoft\models\pays\PaysSysUzcard;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\user\UserCompany;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    Ware
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $user_company_id
 * @property string $text
 * @property string $phone
 * @property string $email
 * @property array $photo
 * @property string $type
 * @property int $place_adress_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class Ware extends ZActiveRecord
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
    public $user_company_id;
    public $text;
    public $phone;
    public $email;
    public $photo;
    public $type;
    public $place_adress_id;
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
        'user_company_id',
        'text',
        'phone',
        'email',
        'photo',
        'type',
        'place_adress_id',
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
        'primary' => 'primary',
        'regional' => 'regional',
        'defected' => 'defected',
        'outdated' => 'outdated',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Склады';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_type = [
            'primary' => Az::l('Основной склад'),
            'regional' => Az::l('Региональный склад'),
            'defected' => Az::l('Склад для бракованных товаров'),
            'outdated' => Az::l('Склад для просроченных товаров'),
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
			'user_company_id',
			'text',
			'phone',
			'email',
			'photo',
			'type',
			'place_adress_id',
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
                    'UserCompany' => [
                        'user_company_id' => 'id',
                    ],
                    'PlaceAdress' => [
                        'place_adress_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopCatalogWare' => [
                        'ware_id' => 'id',
                    ],
                    'ShopOrderItem' => [
                        'ware_id' => 'id',
                    ],
                    'WareEnter' => [
                        'ware_id' => 'id',
                    ],
                    'WareExit' => [
                        'ware_id' => 'id',
                    ],
                    'WareReturn' => [
                        'ware_id' => 'id',
                    ],
                    'WareTrans' => [
                        'warehouse_from' => 'id',
                        'warehouse_to' => 'id',
                    ],
                    'PaysSysClick' => [
                        'ware_id' => 'id',
                    ],
                    'PaysSysOson' => [
                        'ware_id' => 'id',
                    ],
                    'PaysSysPayme' => [
                        'ware_id' => 'id',
                    ],
                    'PaysSysPaysys' => [
                        'ware_id' => 'id',
                    ],
                    'PaysSysUzcard' => [
                        'ware_id' => 'id',
                    ],
                    'PlaceRegion' => [
                        'ware_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Склады');
            $config->info = [
                    'СПРАВОЧНИК ПРОЕКТЫ',
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

            'user_company_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Магазин');
                $column->tooltip = Az::l('Связь с таблицей "Магазин"');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkQuery = [
                    'type' => [
                        'market',
                        'logistics',
                    ],
                ];

                return $column;
            },


           
            'text' => function (FormDb $column) {

                $column->title = Az::l('Описание');
                $column->tooltip = Az::l('Подробное описание склада');
                $column->dbType = dbTypeText;
                $column->widget = ZCKEditorWidget::class;

                return $column;
            },
            
           
            'phone' => function (FormDb $column) {

                $column->title = Az::l('Телефон');
                $column->tooltip = Az::l('Телефон номер склада');

                return $column;
            },
            
           
            'email' => function (FormDb $column) {

                $column->title = Az::l('E-mail');
                $column->tooltip = Az::l('E-mail склада');
                $column->rules = [
                    [
                        validatorEmail,
                    ],
                ];

                return $column;
            },
            
           
            'photo' => function (FormDb $column) {

                $column->title = Az::l('Фото');
                $column->tooltip = Az::l('Фото склада');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'type' => function (FormDb $column) {

                $column->title = Az::l('Тип склада');
                $column->tooltip = Az::l('Тип склада');

                $column->data = [
                    'primary' => Az::l('Основной склад'),
                    'regional' => Az::l('Региональный склад'),
                    'defected' => Az::l('Склад для бракованных товаров'),
                    'outdated' => Az::l('Склад для просроченных товаров'),
                ];
                
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           

            
           
            'place_adress_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Адрес');
                $column->tooltip = Az::l('Адрес склада');
                $column->dbType = dbTypeInteger;
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
        'user_company_id',
        'text',
        'phone',
        'email',
        'photo',
        'type',
        'place_adress_id',
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
                                'title',
                                'text',
                                'phone',
                                'email',
                                'photo',
                                'type',
                                'active',
                                'place_adress_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                    public function value(Ware $model = null)
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
        $event->beforeDelete = function (UserCompany $model) {
        return null;
        };

        $event->afterDelete = function (UserCompany $model) {
        return null;
        };

        $event->beforeSave = function (UserCompany $model) {
        return null;
        };

        $event->afterSave = function (UserCompany $model) {
        return null;
        };

        $event->beforeValidate = function (UserCompany $model) {
        return null;
        };

        $event->afterValidate = function (UserCompany $model) {
        return null;
        };

        $event->afterRefresh = function (UserCompany $model) {
        return null;
        };

        $event->afterFind = function (UserCompany $model) {
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
     * Function  getPlaceAdress
     * @return bool|\yii\db\ActiveRecord|PlaceAdress|null
     */            
    public function getPlaceAdressOne()
    {
        return $this->getOne(PlaceAdress::class, [
          'id' => 'place_adress_id',
      ]);    
    }
    
     /**
     *
     * Function  getPlaceAdress
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPlaceAdress()
    {
        return $this->hasOne(PlaceAdress::class, [
          'id' => 'place_adress_id',
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
     * Function  getShopCatalogWaresWithWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopCatalogWare
     */            
    public function getShopCatalogWaresWithWareIdMany()
    {
       return $this->getMany(ShopCatalogWare::class, [
            'ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopCatalogWaresWithWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopCatalogWaresWithWareId()
    {
       return $this->hasMany(ShopCatalogWare::class, [
            'ware_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopOrderItemsWithWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopOrderItem
     */            
    public function getShopOrderItemsWithWareIdMany()
    {
       return $this->getMany(ShopOrderItem::class, [
            'ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopOrderItemsWithWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopOrderItemsWithWareId()
    {
       return $this->hasMany(ShopOrderItem::class, [
            'ware_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareEntersWithWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareEnter
     */            
    public function getWareEntersWithWareIdMany()
    {
       return $this->getMany(WareEnter::class, [
            'ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareEntersWithWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareEntersWithWareId()
    {
       return $this->hasMany(WareEnter::class, [
            'ware_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareExitsWithWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareExit
     */            
    public function getWareExitsWithWareIdMany()
    {
       return $this->getMany(WareExit::class, [
            'ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareExitsWithWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareExitsWithWareId()
    {
       return $this->hasMany(WareExit::class, [
            'ware_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareReturnsWithWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareReturn
     */            
    public function getWareReturnsWithWareIdMany()
    {
       return $this->getMany(WareReturn::class, [
            'ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareReturnsWithWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareReturnsWithWareId()
    {
       return $this->hasMany(WareReturn::class, [
            'ware_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareTransWithWarehouseFromMany
     * @return  null|\yii\db\ActiveRecord[]|WareTrans
     */            
    public function getWareTransWithWarehouseFromMany()
    {
       return $this->getMany(WareTrans::class, [
            'warehouse_from' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareTransWithWarehouseFrom
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareTransWithWarehouseFrom()
    {
       return $this->hasMany(WareTrans::class, [
            'warehouse_from' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareTransWithWarehouseToMany
     * @return  null|\yii\db\ActiveRecord[]|WareTrans
     */            
    public function getWareTransWithWarehouseToMany()
    {
       return $this->getMany(WareTrans::class, [
            'warehouse_to' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareTransWithWarehouseTo
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareTransWithWarehouseTo()
    {
       return $this->hasMany(WareTrans::class, [
            'warehouse_to' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysClicksWithWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysClick
     */            
    public function getPaysSysClicksWithWareIdMany()
    {
       return $this->getMany(PaysSysClick::class, [
            'ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysClicksWithWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysClicksWithWareId()
    {
       return $this->hasMany(PaysSysClick::class, [
            'ware_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysOsonsWithWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysOson
     */            
    public function getPaysSysOsonsWithWareIdMany()
    {
       return $this->getMany(PaysSysOson::class, [
            'ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysOsonsWithWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysOsonsWithWareId()
    {
       return $this->hasMany(PaysSysOson::class, [
            'ware_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaymesWithWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPayme
     */            
    public function getPaysSysPaymesWithWareIdMany()
    {
       return $this->getMany(PaysSysPayme::class, [
            'ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaymesWithWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaymesWithWareId()
    {
       return $this->hasMany(PaysSysPayme::class, [
            'ware_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaysysWithWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPaysys
     */            
    public function getPaysSysPaysysWithWareIdMany()
    {
       return $this->getMany(PaysSysPaysys::class, [
            'ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaysysWithWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaysysWithWareId()
    {
       return $this->hasMany(PaysSysPaysys::class, [
            'ware_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysUzcardsWithWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysUzcard
     */            
    public function getPaysSysUzcardsWithWareIdMany()
    {
       return $this->getMany(PaysSysUzcard::class, [
            'ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysUzcardsWithWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysUzcardsWithWareId()
    {
       return $this->hasMany(PaysSysUzcard::class, [
            'ware_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceRegionsWithWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceRegion
     */            
    public function getPlaceRegionsWithWareIdMany()
    {
       return $this->getMany(PlaceRegion::class, [
            'ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceRegionsWithWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceRegionsWithWareId()
    {
       return $this->hasMany(PlaceRegion::class, [
            'ware_id' => 'id',
        ]);     
    }


    #endregion


}
