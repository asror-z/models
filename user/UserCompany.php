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


use yii\helpers\Url;
use yii\web\Link;
use zetsoft\dbdata\auth\CompanyTypeData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\auth\AuthEmailForm;
use zetsoft\former\post\PostMplaceCallCenterForm;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZCKEditorWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputWidget;
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
use zetsoft\models\ware\WareEnter;
use zetsoft\models\ware\WareExit;
use zetsoft\models\ware\WareTrans;
use zetsoft\models\core\CoreAnalytics;
use zetsoft\models\ware\WareReturn;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\models\cpas\CpasOffer;
use zetsoft\models\shop\ShopBanner;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\core\CoreHistory;
use zetsoft\models\shop\ShopBrand;
use zetsoft\models\shop\ShopElement;
use zetsoft\models\shop\ShopProduct;
use zetsoft\models\ware\Ware;
use zetsoft\models\ware\WareAccept;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    UserCompany
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $text
 * @property string $text_short
 * @property string $phone
 * @property string $website
 * @property string $email
 * @property array $photo
 * @property string $type
 * @property float $rating
 * @property int $parent_id
 * @property string $auth_key
 * @property string $policy
 * @property string $inn
 * @property string $okonx
 * @property string $bank
 * @property string $bank_address
 * @property string $bank_account
 * @property string $mfo
 * @property string $patent
 * @property int $index
 * @property boolean $global
 * @property int $place_adress_id
 * @property array $postback_callcenter
 * @property array $postback_logistics
 * @property array $postback_accept
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class UserCompany extends ZActiveRecord
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
    public $text;
    public $text_short;
    public $phone;
    public $website;
    public $email;
    public $photo;
    public $type;
    public $rating;
    public $parent_id;
    public $auth_key;
    public $policy;
    public $inn;
    public $okonx;
    public $bank;
    public $bank_address;
    public $bank_account;
    public $mfo;
    public $patent;
    public $index;
    public $global;
    public $place_adress_id;
    public $postback_callcenter;
    public $postback_logistics;
    public $postback_accept;
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
        'text',
        'text_short',
        'phone',
        'website',
        'email',
        'photo',
        'type',
        'rating',
        'parent_id',
        'auth_key',
        'policy',
        'inn',
        'okonx',
        'bank',
        'bank_address',
        'bank_account',
        'mfo',
        'patent',
        'index',
        'global',
        'place_adress_id',
        'postback_callcenter',
        'postback_logistics',
        'postback_accept',
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
    public static ?string $title = Azl . 'Организации';
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
			'text',
			'text_short',
			'phone',
			'website',
			'email',
			'photo',
			'type',
			'rating',
			'parent_id',
			'auth_key',
			'policy',
			'inn',
			'okonx',
			'bank',
			'bank_address',
			'bank_account',
			'mfo',
			'patent',
			'index',
			'global',
			'place_adress_id',
			'postback_callcenter',
			'postback_logistics',
			'postback_accept',
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
                        'parent_id' => 'id',
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
                    'ShopBanner' => [
                        'user_company_id' => 'id',
                    ],
                    'ShopBrand' => [
                        'user_company_id' => 'id',
                    ],
                    'ShopCatalog' => [
                        'user_company_id' => 'id',
                    ],
                    'ShopCourier' => [
                        'user_company_id' => 'id',
                    ],
                    'ShopOrder' => [
                        'source' => 'id',
                    ],
                    'ShopOrderItem' => [
                        'user_company_id' => 'id',
                    ],
                    'ShopProduct' => [
                        'user_company_id' => 'id',
                    ],
                    'Ware' => [
                        'user_company_id' => 'id',
                    ],
                    'WareAccept' => [
                        'source' => 'id',
                    ],
                    'WareEnter' => [
                        'user_company_id' => 'id',
                    ],
                    'WareExit' => [
                        'user_company_id' => 'id',
                    ],
                    'WareTrans' => [
                        'user_company_id' => 'id',
                    ],
                    'User' => [
                        'user_company_id' => 'id',
                    ],
                    'UserCompany' => [
                        'parent_id' => 'id',
                    ],
                    'CoreAnalytics' => [
                        'user_company_id' => 'id',
                    ],
                    'CoreHistory' => [
                        'user_company_id' => 'id',
                    ],
                    'CoreSetting' => [
                        'user_company_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Организации');
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
           

           
            'text' => function (FormDb $column) {

                $column->title = Az::l('Описание');
                $column->tooltip = Az::l('Описание компании');
                $column->dbType = dbTypeText;
                $column->widget = ZCKEditorWidget::class;
                $column->width = '350px';

                return $column;
            },
            
           
            'text_short' => function (FormDb $column) {

                $column->title = Az::l('Краткое описание');
                $column->tooltip = Az::l('Краткое описание компании');
                $column->width = '150px';

                return $column;
            },
            
           
            'phone' => function (FormDb $column) {

                $column->title = Az::l('Телефон');
                $column->tooltip = Az::l('Телефон номер компании');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },

            'website' => function (FormDb $column) {

                $column->title = Az::l('Адрес сайта');
                $column->tooltip = Az::l('Адрес сайта компании');

                return $column;
            },
            
           
            'email' => function (FormDb $column) {

                $column->title = Az::l('E-mail');
                $column->tooltip = Az::l('Электронная почта компании');
                $column->rules = [
                    [
                        validatorEmail,
                    ],
                ];

                return $column;
            },
            
           
            'photo' => function (FormDb $column) {

                $column->title = Az::l('Фото');
                $column->tooltip = Az::l('Фото компании');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'type' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Тип компании');
                $column->tooltip = Az::l('Тип компании');
                $column->data = CompanyTypeData::class;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            

            'rating' => function (FormDb $column) {

                $column->title = Az::l('Рейтинг');
                $column->tooltip = Az::l('Рейтинг компании');
                $column->dbType = dbTypeFloat;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKStarRatingWidget::class;

                return $column;
            },




            'parent_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Вышестоящая компания');
                $column->tooltip = Az::l('Можно указать вышестоящую компанию для компании');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user_company';

                return $column;
            },



            'auth_key' => function (FormDb $column) {

                $column->title = Az::l('Ключ аутентификации');
                $column->tooltip = Az::l('Ключ аутентификации');


                return $column;
            },


            'policy' => function (FormDb $column) {

                $column->title = Az::l('Политика');
                $column->tooltip = Az::l('Политика компании');
                $column->dbType = dbTypeText;
                $column->widget = ZCKEditorWidget::class;
                $column->width = '350px';

                return $column;
            },


            'inn' => function (FormDb $column) {

                $column->title = Az::l('ИНН');
                $column->tooltip = Az::l('Идентификационный Номер Налогоплательщика');

                return $column;
            },
            
           
            'okonx' => function (FormDb $column) {

                $column->title = Az::l('ОКОНХ');
                $column->tooltip = Az::l('Общегосударственный Классификатор Отраслей Народного Хозяйства');

                return $column;
            },
            
           
            'bank' => function (FormDb $column) {

                $column->title = Az::l('Банк');
                $column->tooltip = Az::l('Обслуживаемый банк для компании');

                return $column;
            },
            
           
            'bank_address' => function (FormDb $column) {

                $column->title = Az::l('Адрес Банка');
                $column->tooltip = Az::l('Адрес обслуживаемого банка');

                return $column;
            },
            
           
            'bank_account' => function (FormDb $column) {

                $column->title = Az::l('Номер счета');
                $column->tooltip = Az::l('Номер счета');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'mfo' => function (FormDb $column) {

                $column->title = Az::l('МФО');
                $column->tooltip = Az::l('Межфилиальный Оборот');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'patent' => function (FormDb $column) {

                $column->title = Az::l('Патент');
                $column->tooltip = Az::l('Патент');

                return $column;
            },
            
           
            'index' => function (FormDb $column) {

                $column->title = Az::l('Индекс');
                $column->tooltip = Az::l('Индекс номер компании');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },
            
           
            'global' => function (FormDb $column) {

                $column->title = Az::l('Товары со всех компаний');
                $column->tooltip = Az::l('При создании новых каталогов, можно также выбрать существующие товары из других компаний');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'place_adress_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Адрес компании');
                $column->tooltip = Az::l('Адрес компании');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
      

           
            'postback_callcenter' => function (FormDb $column) {

                $column->title = Az::l('Постбэк для колл-центра');
                $column->tooltip = Az::l('Постбэк для колл-центра');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
						'config' =>[
							'formClass' => PostMplaceCallCenterForm::class,
						],
					];

                return $column;
            },
            
           
            'postback_logistics' => function (FormDb $column) {

                $column->title = Az::l('Постбэк для логистики');
                $column->tooltip = Az::l('Постбэк для логистики');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->options = [
						'config' =>[
							'formClass' => 'zetsoft\former\cpas\MplaceLogisticsForm',
						],
					];

                return $column;
            },
            
           
            'postback_accept' => function (FormDb $column) {

                $column->title = Az::l('Постбэк для приёмки');
                $column->tooltip = Az::l('Постбэк для приёмки');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->options = [
						'config' =>[
							'formClass' => 'zetsoft\former\cpas\MplaceAcceptForm',
						],
					];

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
        'text',
        'text_short',
        'phone',
        'website',
        'email',
        'photo',
        'type',
        'rating',
        'parent_id',
        'auth_key',
        'policy',
        'inn',
        'okonx',
        'bank',
        'bank_address',
        'bank_account',
        'mfo',
        'patent',
        'index',
        'global',
        'place_adress_id',
        'postback_callcenter',
        'postback_logistics',
        'postback_accept',
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
                                'name',
                                'title',
                                'text',
                                'text_short',
                                'policy',
                                'phone',
                                'auth_key',
                                'website',
                                'email',
                                'photo',
                                'type',
                                'rating',
                                'active',
                                'inn',
                                'okonx',
                                'bank',
                                'bank_address',
                                'bank_account',
                                'mfo',
                                'patent',
                                'index',
                                'global',
                                'place_adress_id',
                                'shop_brand_id',
                                'parent_id',
                                'postback_callcenter',
                                'postback_logistics',
                                'postback_accept',
                                'created_at',
                                'modified_at',
                                'created_by',
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
    public function value(UserCompany $model = null)
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
     * Function  getParent
     * @return bool|\yii\db\ActiveRecord|UserCompany|null
     */            
    public function getParentOne()
    {
        return $this->getOne(UserCompany::class, [
          'id' => 'parent_id',
      ]);    
    }
    
     /**
     *
     * Function  getParent
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getParent()
    {
        return $this->hasOne(UserCompany::class, [
          'id' => 'parent_id',
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
     * Function  getShopBannersWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopBanner
     */            
    public function getShopBannersWithUserCompanyIdMany()
    {
       return $this->getMany(ShopBanner::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopBannersWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopBannersWithUserCompanyId()
    {
       return $this->hasMany(ShopBanner::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopBrandsWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopBrand
     */            
    public function getShopBrandsWithUserCompanyIdMany()
    {
       return $this->getMany(ShopBrand::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopBrandsWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopBrandsWithUserCompanyId()
    {
       return $this->hasMany(ShopBrand::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopCatalogsWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopCatalog
     */            
    public function getShopCatalogsWithUserCompanyIdMany()
    {
       return $this->getMany(ShopCatalog::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopCatalogsWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopCatalogsWithUserCompanyId()
    {
       return $this->hasMany(ShopCatalog::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopCouriersWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopCourier
     */            
    public function getShopCouriersWithUserCompanyIdMany()
    {
       return $this->getMany(ShopCourier::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopCouriersWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopCouriersWithUserCompanyId()
    {
       return $this->hasMany(ShopCourier::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopOrdersWithSourceMany
     * @return  null|\yii\db\ActiveRecord[]|ShopOrder
     */            
    public function getShopOrdersWithSourceMany()
    {
       return $this->getMany(ShopOrder::class, [
            'source' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopOrdersWithSource
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopOrdersWithSource()
    {
       return $this->hasMany(ShopOrder::class, [
            'source' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopOrderItemsWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopOrderItem
     */            
    public function getShopOrderItemsWithUserCompanyIdMany()
    {
       return $this->getMany(ShopOrderItem::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopOrderItemsWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopOrderItemsWithUserCompanyId()
    {
       return $this->hasMany(ShopOrderItem::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopProductsWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopProduct
     */            
    public function getShopProductsWithUserCompanyIdMany()
    {
       return $this->getMany(ShopProduct::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopProductsWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopProductsWithUserCompanyId()
    {
       return $this->hasMany(ShopProduct::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWaresWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|Ware
     */            
    public function getWaresWithUserCompanyIdMany()
    {
       return $this->getMany(Ware::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWaresWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWaresWithUserCompanyId()
    {
       return $this->hasMany(Ware::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareAcceptsWithSourceMany
     * @return  null|\yii\db\ActiveRecord[]|WareAccept
     */            
    public function getWareAcceptsWithSourceMany()
    {
       return $this->getMany(WareAccept::class, [
            'source' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareAcceptsWithSource
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareAcceptsWithSource()
    {
       return $this->hasMany(WareAccept::class, [
            'source' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareEntersWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareEnter
     */            
    public function getWareEntersWithUserCompanyIdMany()
    {
       return $this->getMany(WareEnter::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareEntersWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareEntersWithUserCompanyId()
    {
       return $this->hasMany(WareEnter::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareExitsWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareExit
     */            
    public function getWareExitsWithUserCompanyIdMany()
    {
       return $this->getMany(WareExit::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareExitsWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareExitsWithUserCompanyId()
    {
       return $this->hasMany(WareExit::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareTransWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareTrans
     */            
    public function getWareTransWithUserCompanyIdMany()
    {
       return $this->getMany(WareTrans::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareTransWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareTransWithUserCompanyId()
    {
       return $this->hasMany(WareTrans::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUsersWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|User
     */            
    public function getUsersWithUserCompanyIdMany()
    {
       return $this->getMany(User::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUsersWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUsersWithUserCompanyId()
    {
       return $this->hasMany(User::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserCompaniesWithParentIdMany
     * @return  null|\yii\db\ActiveRecord[]|UserCompany
     */            
    public function getUserCompaniesWithParentIdMany()
    {
       return $this->getMany(UserCompany::class, [
            'parent_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserCompaniesWithParentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserCompaniesWithParentId()
    {
       return $this->hasMany(UserCompany::class, [
            'parent_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreAnalyticsWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|CoreAnalytics
     */            
    public function getCoreAnalyticsWithUserCompanyIdMany()
    {
       return $this->getMany(CoreAnalytics::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreAnalyticsWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreAnalyticsWithUserCompanyId()
    {
       return $this->hasMany(CoreAnalytics::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreHistoriesWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|CoreHistory
     */            
    public function getCoreHistoriesWithUserCompanyIdMany()
    {
       return $this->getMany(CoreHistory::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreHistoriesWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreHistoriesWithUserCompanyId()
    {
       return $this->hasMany(CoreHistory::class, [
            'user_company_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreSettingsWithUserCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|CoreSetting
     */            
    public function getCoreSettingsWithUserCompanyIdMany()
    {
       return $this->getMany(CoreSetting::class, [
            'user_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreSettingsWithUserCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreSettingsWithUserCompanyId()
    {
       return $this->hasMany(CoreSetting::class, [
            'user_company_id' => 'id',
        ]);     
    }


    #endregion


}
