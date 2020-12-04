<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\disc;


use zetsoft\dbdata\eyuf\OperatorData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\widgets\inputes\ZTelInputWidget;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\shop\ShopPayment;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\models\shop\ShopShipment;
use zetsoft\models\shop\ShopCoupon;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    DiscAmount
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property array $shop_catalog_ids
 * @property int $min_amount
 * @property int $max_amount
 * @property array $kind
 * @property int $number
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DiscAmount extends ZActiveRecord
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
    public $shop_catalog_ids;
    public $min_amount;
    public $max_amount;
    public $kind;
    public $number;
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
        'shop_catalog_ids',
        'min_amount',
        'max_amount',
        'kind',
        'number',
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

    /* @var array $_kind*/
    public $_kind;  
    public const kind = [
        'percent' => 'percent',
        'sum' => 'sum',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Скидки';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_kind = [
            'percent' => Az::l('Процентная скидка'),
            'sum' => Az::l('Скидка на определенную сумму'),
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
			'shop_catalog_ids',
			'min_amount',
			'max_amount',
			'kind',
			'number',
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
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'ShopCatalog' => [
                        'shop_catalog_ids' => 'id',
                    ],
                ];
            $config->title = Az::l('Скидки');

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

            'shop_catalog_ids' => function (FormDb $column) {
                $column->title = Az::l('Каталог');
                $column->tooltip = Az::l('Каталог товаров для которых устанавливается скидки (наценка)');
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'multiple' => true,
                    ]
                ];
                $column->rules = 'zetsoft\\system\\validate\\ZRequiredValidator';
                return $column;
            },

            'min_amount' => function (FormDb $column) {

                $column->indexUnique = true;
                $column->title = Az::l('Минимальное количество');
                $column->tooltip = Az::l('Минимальное количество товара для использования скидки (наценки)');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKTouchSpinWidget::class;
                $column->rules = validatorInteger;

                return $column;
            },

            'max_amount' => function (FormDb $column) {

                $column->indexUnique = true;
                $column->title = Az::l('Максималное количество');
                $column->tooltip = Az::l('Максималное количество товара для использования скидки (наценки)');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKTouchSpinWidget::class;
                $column->rules = validatorInteger;

                return $column;
            },

            'kind' => function (FormDb $column) {

                $column->title = Az::l('Вид скидки');
                $column->tooltip = Az::l('Возможные виды скидок которые можно предложить клиентам');
                $column->dbType = dbTypeJsonb;
                $column->data = [
                    'percent' => Az::l('Процентная скидка'),
                    'sum' => Az::l('Скидка на определенную сумму'),
                ];
                $column->rules = 'zetsoft\\system\\validate\\ZRequiredValidator';
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },

            'number' => function (FormDb $column) {

                $column->title = Az::l('Число');
                $column->tooltip = Az::l('Число для процента или сумму для скидки');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
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
        'shop_catalog_ids',
        'min_amount',
        'max_amount',
        'kind',
        'number',
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
                                'min_price',
                                'discount_percent',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(ShopDiscount $model = null)
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

        $event->beforeSave = function (DiscAmount $model) {
        };


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


    /**
     *
     * Function  getShopCatalogsFromShopCatalogIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|ShopCatalog
     */            
    public function getShopCatalogsFromShopCatalogIdsMulti()
    {
        return $this->getMulti(ShopCatalog::class, [
          'id' => 'shop_catalog_ids',
      ]);    
    }


    #endregion
    
    #region Many



    #endregion


}
