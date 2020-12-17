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
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZIconPickerWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\models\menu\Menu;
use zetsoft\models\shop\ShopBrand;
use zetsoft\dbitem\data\Event;
use zetsoft\models\shop\ShopCategory;
use zetsoft\models\shop\ShopOption;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\models\shop\ShopOptionBranch;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopOptionType
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $shop_option_branch_id
 * @property boolean $show
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopOptionType extends ZActiveRecord
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
    public $shop_option_branch_id;
    public $show;
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
        'shop_option_branch_id',
        'show',
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
    public static ?string $title = Azl . 'Параметры продукта';
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
			'shop_option_branch_id',
			'show',
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

                                                                                                                                                                                    $config->query = function ($model) {

                if ($this->hasRole('seller'))
                    return static::find()
                        ->where([
                            'created_by' => $this->userIdentity()->id
                        ]);

                return null;

            };

            $config->hasOne = [
                    'ShopOptionBranch' => [
                        'shop_option_branch_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopOption' => [
                        'shop_option_type_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Параметры продукта');

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
            
           
            'shop_option_branch_id' => function (FormDb $column) {

                $column->title = Az::l('Категории параметров');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
            'show' => function (FormDb $column) {

                $column->title = Az::l('Показать в фильтре');
                $column->tooltip = Az::l('Добавить в список фильтра ');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

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
        'shop_option_branch_id',
        'show',
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
                                'shop_option_branch_id',
                                'show',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
            public function value(ShopOptionType $model = null)
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
     * Function  getShopOptionBranch
     * @return bool|\yii\db\ActiveRecord|ShopOptionBranch|null
     */            
    public function getShopOptionBranchOne()
    {
        return $this->getOne(ShopOptionBranch::class, [
          'id' => 'shop_option_branch_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopOptionBranch
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopOptionBranch()
    {
        return $this->hasOne(ShopOptionBranch::class, [
          'id' => 'shop_option_branch_id',
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
     * Function  getShopOptionsWithShopOptionTypeIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopOption
     */            
    public function getShopOptionsWithShopOptionTypeIdMany()
    {
       return $this->getMany(ShopOption::class, [
            'shop_option_type_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopOptionsWithShopOptionTypeId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopOptionsWithShopOptionTypeId()
    {
       return $this->hasMany(ShopOption::class, [
            'shop_option_type_id' => 'id',
        ]);     
    }


    #endregion


}
