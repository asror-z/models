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
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZKEditableWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKStarRatingWidget;
use zetsoft\widgets\inputes\ZCKEditorWidget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\shop\ShopBrand;
use zetsoft\models\shop\ShopProduct;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZReviewInput2Widget;
use zetsoft\widgets\inputes\ZReviewInputWidget;
use zetsoft\system\actives\ZActiveQuery;



/**
 * Class    ShopReview
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
 * @property int $shop_brand_id
 * @property int $shop_product_id
 * @property int $user_company_id
 * @property float $rating
 * @property int $parent_id
 * @property array $rating_option
 * @property string $text
 * @property string $virtues
 * @property string $drawbacks
 * @property string $experience
 * @property boolean $recommend
 * @property boolean $anonymous
 * @property int $like
 * @property int $dislike
 * @property array $photo
 * @property int $user_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopReview extends ZActiveRecord
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
    public $shop_brand_id;
    public $shop_product_id;
    public $user_company_id;
    public $rating;
    public $parent_id;
    public $rating_option;
    public $text;
    public $virtues;
    public $drawbacks;
    public $experience;
    public $recommend;
    public $anonymous;
    public $like;
    public $dislike;
    public $photo;
    public $user_id;
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
        'shop_brand_id',
        'shop_product_id',
        'user_company_id',
        'rating',
        'parent_id',
        'rating_option',
        'text',
        'virtues',
        'drawbacks',
        'experience',
        'recommend',
        'anonymous',
        'like',
        'dislike',
        'photo',
        'user_id',
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
        'brand' => 'brand',
        'product' => 'product',
        'company' => 'company',
    ];

    /* @var array $_experience*/
    public $_experience;  
    public const experience = [
        'less_week' => 'less_week',
        '1_4_week' => '1_4_week',
        '1_3_month' => '1_3_month',
        'less_year' => 'less_year',
        'more_year' => 'more_year',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Отзывы клиентов';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_type = [
            'brand' => Az::l('Марка'),
            'product' => Az::l('Продукт'),
            'company' => Az::l('Компания'),
        ];
        
        $this->_experience = [
            'less_week' => Az::l('Меньше недели'),
            '1_4_week' => Az::l('1-4 недель'),
            '1_3_month' => Az::l('1-3 месяца'),
            'less_year' => Az::l('Менее года'),
            'more_year' => Az::l('Более года'),
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
			'shop_brand_id',
			'shop_product_id',
			'user_company_id',
			'rating',
			'parent_id',
			'rating_option',
			'text',
			'virtues',
			'drawbacks',
			'experience',
			'recommend',
			'anonymous',
			'like',
			'dislike',
			'photo',
			'user_id',
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
                    'ShopBrand' => [
                        'shop_brand_id' => 'id',
                    ],
                    'ShopProduct' => [
                        'shop_product_id' => 'id',
                    ],
                    'User' => [
                        'user_company_id' => 'id',
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'ShopReview' => [
                        'parent_id' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopReview' => [
                        'parent_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Отзывы клиентов');

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

                $column->title = Az::l('Тип');
                $column->data = [
                    'brand' => Az::l('Марка'),
                    'product' => Az::l('Продукт'),
                    'company' => Az::l('Компания'),
                ];
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'shop_brand_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Марка');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'shop_product_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Продукт');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'user_company_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Компания');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user';

                return $column;
            },
            
           
            'rating' => function (FormDb $column) {

                $column->title = Az::l('Рейтинг');
                $column->dbType = dbTypeFloat;
                $column->widget = ZKStarRatingWidget::class;

                return $column;
            },
            
           
            'parent_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Ответ');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'shop_review';

                return $column;
            },
            
           
            'rating_option' => function (FormDb $column) {

                $column->title = Az::l('Рейтинг');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZReviewInputWidget::class;
                $column->filterWidget = ZReviewInputWidget::class;

                return $column;
            },
            
           
            'text' => function (FormDb $column) {

                $column->title = Az::l('Текст отзыва');
                $column->dbType = dbTypeText;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZCKEditorWidget::class;

                return $column;
            },
            
           
            'virtues' => function (FormDb $column) {

                $column->title = Az::l('Достоинства');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'drawbacks' => function (FormDb $column) {

                $column->title = Az::l('Недостатки');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'experience' => function (FormDb $column) {

                $column->title = Az::l('Опыт использования');
                $column->data = [
                    'less_week' => Az::l('Меньше недели'),
                    '1_4_week' => Az::l('1-4 недель'),
                    '1_3_month' => Az::l('1-3 месяца'),
                    'less_year' => Az::l('Менее года'),
                    'more_year' => Az::l('Более года'),
                ];
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'recommend' => function (FormDb $column) {

                $column->title = Az::l('Порекомендовали бы товар друзьям?');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'anonymous' => function (FormDb $column) {

                $column->title = Az::l('Оставить отзыв анонимно');
                $column->tooltip = Az::l('По умолчанию отзыв будет опубликован от вашего имени. Отметьте эту опцию, если вы хотите опубликовать отзыв анонимно.');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'like' => function (FormDb $column) {

                $column->title = Az::l('like');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },
            
           
            'dislike' => function (FormDb $column) {

                $column->title = Az::l('dislike');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },
            
           
            'photo' => function (FormDb $column) {

                $column->title = Az::l('Фото');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'user_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Пользователь');
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
        'type',
        'shop_brand_id',
        'shop_product_id',
        'user_company_id',
        'rating',
        'parent_id',
        'rating_option',
        'text',
        'virtues',
        'drawbacks',
        'experience',
        'recommend',
        'anonymous',
        'like',
        'dislike',
        'photo',
        'user_id',
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
                                'shop_brand_id',
                                'shop_product_id',
                                'user_company_id',
                                'rating',
                                'parent_id',
                                'rating_option',
                                'text',
                                'virtues',
                                'drawbacks',
                                'experience',
                                'recommend',
                                'anonymous',
                                'like',
                                'dislike',
                                'photo',
                                'user_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
            public function value(ShopReview $model = null)
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
        $event->beforeDelete = function (ShopReview $model) {
        return null;
        };

        $event->afterDelete = function (ShopReview $model) {
        return null;
        };

        $event->beforeSave = function (ShopReview $model) {
        return null;
        };

        $event->afterSave = function (ShopReview $model) {
        return null;
        };

        $event->beforeValidate = function (ShopReview $model) {
        return null;
        };

        $event->afterValidate = function (ShopReview $model) {
        return null;
        };

        $event->afterRefresh = function (ShopReview $model) {
        return null;
        };

        $event->afterFind = function (ShopReview $model) {
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
     * Function  getShopBrand
     * @return bool|\yii\db\ActiveRecord|ShopBrand|null
     */            
    public function getShopBrandOne()
    {
        return $this->getOne(ShopBrand::class, [
          'id' => 'shop_brand_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopBrand
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopBrand()
    {
        return $this->hasOne(ShopBrand::class, [
          'id' => 'shop_brand_id',
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
     * Function  getUserCompany
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getUserCompanyOne()
    {
        return $this->getOne(User::class, [
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
        return $this->hasOne(User::class, [
          'id' => 'user_company_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getUser
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getUserOne()
    {
        return $this->getOne(User::class, [
          'id' => 'user_id',
      ]);    
    }
    
     /**
     *
     * Function  getUser
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getUser()
    {
        return $this->hasOne(User::class, [
          'id' => 'user_id',
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
    
    

    /**
     *
     * Function  getParent
     * @return bool|\yii\db\ActiveRecord|ShopReview|null
     */            
    public function getParentOne()
    {
        return $this->getOne(ShopReview::class, [
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
        return $this->hasOne(ShopReview::class, [
          'id' => 'parent_id',
      ]);    
    }
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many


    /**
     *
     * Function  getShopReviewsWithParentIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopReview
     */            
    public function getShopReviewsWithParentIdMany()
    {
       return $this->getMany(ShopReview::class, [
            'parent_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopReviewsWithParentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopReviewsWithParentId()
    {
       return $this->hasMany(ShopReview::class, [
            'parent_id' => 'id',
        ]);     
    }


    #endregion


}
