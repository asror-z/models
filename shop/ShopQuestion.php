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
use zetsoft\former\chat\ChatAnswerForm;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZCKEditorWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZHTextareaWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\shop\ShopProduct;
use zetsoft\models\shop\ShopBrand;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopQuestion
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
 * @property string $target
 * @property int $shop_brand_id
 * @property int $shop_product_id
 * @property int $user_company_id
 * @property string $text
 * @property int $parent_id
 * @property int $votes
 * @property int $user_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopQuestion extends ZActiveRecord
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
    public $target;
    public $shop_brand_id;
    public $shop_product_id;
    public $user_company_id;
    public $text;
    public $parent_id;
    public $votes;
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
        'target',
        'shop_brand_id',
        'shop_product_id',
        'user_company_id',
        'text',
        'parent_id',
        'votes',
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
        'question' => 'question',
        'answers' => 'answers',
        'comment' => 'comment',
    ];

    /* @var array $_target*/
    public $_target;  
    public const target = [
        'brand' => 'brand',
        'product' => 'product',
        'company' => 'company',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Вопросы и ответы';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_type = [
            'question' => Az::l('вопрос'),
            'answers' => Az::l('ответ'),
            'comment' => Az::l('комментарий'),
        ];
        
        $this->_target = [
            'brand' => Az::l('Марка'),
            'product' => Az::l('Продукт'),
            'company' => Az::l('Компания'),
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
			'target',
			'shop_brand_id',
			'shop_product_id',
			'user_company_id',
			'text',
			'parent_id',
			'votes',
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
                    'ShopQuestion' => [
                        'parent_id' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopQuestion' => [
                        'parent_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Вопросы и ответы');

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

                $column->title = Az::l('Вопрос');
                $column->tooltip = Az::l('Вопрос');
                $column->data = [
                    'question' => Az::l('вопрос'),
                    'answers' => Az::l('ответ'),
                    'comment' => Az::l('комментарий'),
                ];
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'target' => function (FormDb $column) {

                $column->title = Az::l('Тип');
                $column->tooltip = Az::l('Тип вопроса');
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
                $column->title = Az::l('Бренд');
                $column->tooltip = Az::l('Бренд для которого пишется вопрос');
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
                $column->tooltip = Az::l('Продукт для которого пишется вопрос');
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
                $column->title = Az::l('Продавец');
                $column->tooltip = Az::l('Продавец для которого пишется вопрос');
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
            
           
            'text' => function (FormDb $column) {

                $column->title = Az::l('Текст');
                $column->tooltip = Az::l('Текст');
                $column->dbType = dbTypeText;
                $column->widget = ZCKEditorWidget::class;
                $column->filterWidget = ZCKEditorWidget::class;

                return $column;
            },
            
           
            'parent_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Ответ');
                $column->tooltip = Az::l('Ответ для вопроса');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'shop_question';

                return $column;
            },
            
           
            'votes' => function (FormDb $column) {

                $column->title = Az::l('Голоса');
                $column->tooltip = Az::l('Количество голосов');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKTouchSpinWidget::class;

                return $column;
            },
            
           
            'user_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Пользователь');
                $column->tooltip = Az::l('Пользователь задавший вопрос');
                $column->rules = [
                    [
                        validatorString,
                    ],
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user';

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
        'target',
        'shop_brand_id',
        'shop_product_id',
        'user_company_id',
        'text',
        'parent_id',
        'votes',
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
                                'target',
                                'shop_brand_id',
                                'shop_product_id',
                                'user_company_id',
                                'text',
                                'parent_id',
                                'votes',
                                'user_id',
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
            public function value(ShopQuestion $model = null)
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
 $event->beforeDelete = function (CoreQuestion $model) {
  return null;
 };

 $event->afterDelete = function (CoreQuestion $model) {
  return null;
 };

 $event->beforeSave = function (CoreQuestion $model) {
  return null;
 };

 $event->afterSave = function (CoreQuestion $model) {
  return null;
 };

 $event->beforeValidate = function (CoreQuestion $model) {
  return null;
 };

 $event->afterValidate = function (CoreQuestion $model) {
  return null;
 };

 $event->afterRefresh = function (CoreQuestion $model) {
  return null;
 };

 $event->afterFind = function (CoreQuestion $model) {
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
     * @return bool|\yii\db\ActiveRecord|ShopQuestion|null
     */            
    public function getParentOne()
    {
        return $this->getOne(ShopQuestion::class, [
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
        return $this->hasOne(ShopQuestion::class, [
          'id' => 'parent_id',
      ]);    
    }
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many


    /**
     *
     * Function  getShopQuestionsWithParentIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopQuestion
     */            
    public function getShopQuestionsWithParentIdMany()
    {
       return $this->getMany(ShopQuestion::class, [
            'parent_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopQuestionsWithParentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopQuestionsWithParentId()
    {
       return $this->hasMany(ShopQuestion::class, [
            'parent_id' => 'id',
        ]);     
    }


    #endregion


}
