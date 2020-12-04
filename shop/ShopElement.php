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


use Closure;
use kartik\validators\JsonValidator;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\lang\LanguageForm;
use zetsoft\former\eyuf\EyufNeedForm;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\shop\ShopOption;
use zetsoft\models\user\UserCompany;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZIconPickerWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\models\menu\Menu;
use zetsoft\models\shop\ShopBrand;
use zetsoft\dbitem\data\Event;
use zetsoft\models\shop\ShopCategory;
use zetsoft\models\shop\ShopProduct;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\ware\WareEnterItem;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\models\shop\ShopCatalogWare;
use zetsoft\system\actives\ZActiveQuery;



/**
 * Class    ShopElement
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $shop_product_id
 * @property string $barcode
 * @property string $barcode_type
 * @property array $option_combine
 * @property array $option_simple
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopElement extends ZActiveRecord
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
    public $shop_product_id;
    public $barcode;
    public $barcode_type;
    public $option_combine;
    public $option_simple;
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
        'shop_product_id',
        'barcode',
        'barcode_type',
        'option_combine',
        'option_simple',
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

    /* @var array $_barcode_type*/
    public $_barcode_type;  
    public const barcode_type = [
        'TYPE_CODE_39E_CHECKSUM' => 'TYPE_CODE_39E_CHECKSUM',
        'TYPE_STANDARD_2_5' => 'TYPE_STANDARD_2_5',
        'TYPE_EAN_13' => 'TYPE_EAN_13',
        'TYPE_EAN_8' => 'TYPE_EAN_8',
        'TYPE_CODE_93' => 'TYPE_CODE_93',
        'TYPE_CODE_128' => 'TYPE_CODE_128',
        'TYPE_CODE_128_A' => 'TYPE_CODE_128_A',
        'TYPE_CODE_128_C' => 'TYPE_CODE_128_C',
        'TYPE_PHARMA_CODE' => 'TYPE_PHARMA_CODE',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Элементы продукта';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_barcode_type = [
            'TYPE_CODE_39E_CHECKSUM' => Az::l('code 93'),
            'TYPE_STANDARD_2_5' => Az::l('STANDARD 2.5'),
            'TYPE_EAN_13' => Az::l('ean13'),
            'TYPE_EAN_8' => Az::l('ean8'),
            'TYPE_CODE_93' => Az::l('code 93'),
            'TYPE_CODE_128' => Az::l('code 128'),
            'TYPE_CODE_128_A' => Az::l('code128a'),
            'TYPE_CODE_128_C' => Az::l('code128c'),
            'TYPE_PHARMA_CODE' => Az::l('Pharma code'),
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
			'shop_product_id',
			'barcode',
			'barcode_type',
			'option_combine',
			'option_simple',
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

            $config->indexSearch = 1;

                                                                                                                                                            $config->nameValue = static function (ShopElement $model) {
                /** @var ShopElement $model * */
                $product = ShopProduct::findOne($model->shop_product_id);

                if ($product === null)
                    return null;

                $name = $product->name;
                if (is_array($model->option_combine))
                    $shopOption = ShopOption::find()->where(['id' => $model->option_combine])->all();
                if (!empty($shopOption))
                    foreach ($shopOption as $option) {
                        $name .= ' | ' . $option->name;
                    }

                return $name;
            };

                                                                                                                                                            $config->query = function ($model) {

                if ($this->hasRole('seller'))
                    return static::find()
                        ->where([
                            'created_by' => $this->userIdentity()->id
                        ]);

                return null;

            };

            $config->hasOne = [
                    'ShopProduct' => [
                        'shop_product_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    1 => [
                        'option_combine' => 'id',
                        'option_simple' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopCatalog' => [
                        'shop_element_id' => 'id',
                    ],
                    'WareEnterItem' => [
                        'shop_element_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Элементы продукта');

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

            'shop_product_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Продукт');
                $column->tooltip = Az::l('Продукт к которому относится данный вид товара');
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

                return $column;
            },


            'barcode' => function (FormDb $column) {

                $column->index = true;
                $column->dbType = dbTypeString;
                $column->title = Az::l('Штрихкод');
                $column->tooltip = Az::l('Штрихкод товара');
                return $column;
            },


            'barcode_type' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Тип Штрихкода');

                $column->dbType = dbTypeString;

                $column->widget = ZKSelect2Widget::class;
                $column->data = [
                    'TYPE_CODE_39E_CHECKSUM' => 'code 93',
                    'TYPE_STANDARD_2_5' => 'STANDARD 2.5',
                    'TYPE_EAN_13' => 'ean13',
                    'TYPE_EAN_8' => 'ean8',
                    'TYPE_CODE_93' => 'code 93',
                    'TYPE_CODE_128' => 'code 128',
                    'TYPE_CODE_128_A' => 'code128a',
                    'TYPE_CODE_128_C' => 'code128c',
                    'TYPE_PHARMA_CODE' => 'Pharma code',
                ];

                return $column;
            },


            'option_combine' => function (FormDb $column) {

                $column->title = Az::l('Опции c комбинацией');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'shop_option';
                $column->fkMulti = true;
                $column->multiple = true;

                return $column;
            },

            'option_simple' => function (FormDb $column) {

                $column->title = Az::l('Опции обычные');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'shop_option';
                $column->fkMulti = true;

                $column->multiple = true;

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
        'shop_product_id',
        'barcode',
        'barcode_type',
        'option_combine',
        'option_simple',
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
                                'shop_product_id',
                                'barcode_type',
                                'barcode',
                                'shop_option_ids',
                                'active',
                                'deleted_at',
                                'deleted_by',
                                'deleted_text',
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
    public function value(ShopElement $model = null)
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
        $event->beforeDelete = function (CoreOptionType $model) {
        return null;
        };

        $event->afterDelete = function (CoreOptionType $model) {
        return null;
        };

        $event->beforeSave = function (CoreOptionType $model) {
        return null;
        };

        $event->afterSave = function (CoreOptionType $model) {
        return null;
        };

        $event->beforeValidate = function (CoreOptionType $model) {
        return null;
        };

        $event->afterValidate = function (CoreOptionType $model) {
        return null;
        };

        $event->afterRefresh = function (CoreOptionType $model) {
        return null;
        };



        $event->afterFind = function (CoreOptionType $model) {
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
     * Function  getShopOptionsFromOptionCombineMulti
     * @return  null|\yii\db\ActiveRecord[]|ShopOption
     */            
    public function getShopOptionsFromOptionCombineMulti()
    {
        return $this->getMulti(ShopOption::class, [
          'id' => 'option_combine',
      ]);    
    }

    /**
     *
     * Function  getShopOptionsFromOptionSimpleMulti
     * @return  null|\yii\db\ActiveRecord[]|ShopOption
     */            
    public function getShopOptionsFromOptionSimpleMulti()
    {
        return $this->getMulti(ShopOption::class, [
          'id' => 'option_simple',
      ]);    
    }


    #endregion
    
    #region Many


    /**
     *
     * Function  getShopCatalogsWithShopElementIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopCatalog
     */            
    public function getShopCatalogsWithShopElementIdMany()
    {
       return $this->getMany(ShopCatalog::class, [
            'shop_element_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopCatalogsWithShopElementId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopCatalogsWithShopElementId()
    {
       return $this->hasMany(ShopCatalog::class, [
            'shop_element_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareEnterItemsWithShopElementIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareEnterItem
     */            
    public function getWareEnterItemsWithShopElementIdMany()
    {
       return $this->getMany(WareEnterItem::class, [
            'shop_element_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareEnterItemsWithShopElementId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareEnterItemsWithShopElementId()
    {
       return $this->hasMany(WareEnterItem::class, [
            'shop_element_id' => 'id',
        ]);     
    }


    #endregion


}
