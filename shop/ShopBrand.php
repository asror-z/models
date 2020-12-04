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
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\lang\LanguageForm;
use zetsoft\former\eyuf\EyufNeedForm;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKStarRatingWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZIconPickerWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\models\menu\Menu;
use zetsoft\dbitem\data\Event;
use zetsoft\models\shop\ShopProduct;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\core\CoreQueue;
use zetsoft\models\shop\ShopCategory;
use zetsoft\models\shop\ShopOption;
use zetsoft\models\shop\ShopReview;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\shop\ShopQuestion;
use zetsoft\models\shop\ShopOverview;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\user\UserCompany;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopBrand
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $location
 * @property array $image
 * @property float $rating
 * @property int $user_company_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopBrand extends ZActiveRecord
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
    public $location;
    public $image;
    public $rating;
    public $user_company_id;
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
        'location',
        'image',
        'rating',
        'user_company_id',
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

    /* @var array $_location*/
    public $_location;  
    public const location = [
        'right' => 'right',
        'bottom' => 'bottom',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Бренды';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_location = [
            'right' => Az::l('right'),
            'bottom' => Az::l('bottom'),
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
			'location',
			'image',
			'rating',
			'user_company_id',
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
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopOverview' => [
                        'shop_brand_id' => 'id',
                    ],
                    'ShopProduct' => [
                        'shop_brand_id' => 'id',
                    ],
                    'ShopQuestion' => [
                        'shop_brand_id' => 'id',
                    ],
                    'ShopReview' => [
                        'shop_brand_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Бренды');

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
           
            'location' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Расположение');
                $column->tooltip = Az::l('Расположение бренда');
                $column->data = [
                    'right' => Az::l('right'),
                    'bottom' => Az::l('bottom'),
                ];
                $column->rules = validatorString;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'image' => function (FormDb $column) {

                $column->title = Az::l('Изображение');
                $column->tooltip = Az::l('Изображение бренда');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'rating' => function (FormDb $column) {

                $column->title = Az::l('Рейтинг');
                $column->tooltip = Az::l('Рейтинг бренда');
                $column->dbType = dbTypeFloat;
               // $column->rules = 'float';
                $column->widget = ZKStarRatingWidget::class;

                return $column;
            },


            'user_company_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Компания бренда');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
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
        'location',
        'image',
        'rating',
        'user_company_id',
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
                                'location',
                                'image',
                                'rating',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                                            public function value(ShopBrand $model = null)
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
        $event->beforeDelete = function (ShopBrand $model) {
        return null;
        };

        $event->afterDelete = function (ShopBrand $model) {
        return null;
        };

        $event->beforeSave = function (ShopBrand $model) {
        return null;
        };

        $event->afterSave = function (ShopBrand $model) {
        return null;
        };

        $event->beforeValidate = function (ShopBrand $model) {
        return null;
        };

        $event->afterValidate = function (ShopBrand $model) {
        return null;
        };

        $event->afterRefresh = function (ShopBrand $model) {
        return null;
        };

        $event->afterFind = function (ShopBrand $model) {
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
     * Function  getShopOverviewsWithShopBrandIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopOverview
     */            
    public function getShopOverviewsWithShopBrandIdMany()
    {
       return $this->getMany(ShopOverview::class, [
            'shop_brand_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopOverviewsWithShopBrandId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopOverviewsWithShopBrandId()
    {
       return $this->hasMany(ShopOverview::class, [
            'shop_brand_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopProductsWithShopBrandIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopProduct
     */            
    public function getShopProductsWithShopBrandIdMany()
    {
       return $this->getMany(ShopProduct::class, [
            'shop_brand_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopProductsWithShopBrandId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopProductsWithShopBrandId()
    {
       return $this->hasMany(ShopProduct::class, [
            'shop_brand_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopQuestionsWithShopBrandIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopQuestion
     */            
    public function getShopQuestionsWithShopBrandIdMany()
    {
       return $this->getMany(ShopQuestion::class, [
            'shop_brand_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopQuestionsWithShopBrandId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopQuestionsWithShopBrandId()
    {
       return $this->hasMany(ShopQuestion::class, [
            'shop_brand_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopReviewsWithShopBrandIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopReview
     */            
    public function getShopReviewsWithShopBrandIdMany()
    {
       return $this->getMany(ShopReview::class, [
            'shop_brand_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopReviewsWithShopBrandId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopReviewsWithShopBrandId()
    {
       return $this->hasMany(ShopReview::class, [
            'shop_brand_id' => 'id',
        ]);     
    }


    #endregion


}
