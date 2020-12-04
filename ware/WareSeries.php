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


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\shop\ShopOfferForm;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\system\validate\IdenticalValidator;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZHTextareaWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\user\UserCompany;
use zetsoft\models\shop\ShopElement;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\shop\ShopOffer;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\ware\WareExitItem;
use zetsoft\models\ware\WareEnterItem;
use zetsoft\models\ware\WareTransItem;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    WareSeries
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class WareSeries extends ZActiveRecord
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
    public static ?string $title = Azl . 'Излишки или недостатки товаров в складе';
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
            $config->hasMany = [
                    'WareEnterItem' => [
                        'ware_series_id' => 'id',
                    ],
                    'WareExitItem' => [
                        'ware_series_id' => 'id',
                    ],
                    'WareTransItem' => [
                        'ware_series_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Излишки или недостатки товаров в складе');

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
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                    public function value(WareSeries $model = null)
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
       /* $event->beforeSave = function (WareTrans $model) {
            $first = UserCompany::findOne($model->warehouse_from)->name;
            $second = UserCompany::findOne($model->warehouse_to)->name;
            $model->name = "перемещения с $first на $second";
        };*/
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
     * Function  getWareEnterItemsWithWareSeriesIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareEnterItem
     */            
    public function getWareEnterItemsWithWareSeriesIdMany()
    {
       return $this->getMany(WareEnterItem::class, [
            'ware_series_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareEnterItemsWithWareSeriesId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareEnterItemsWithWareSeriesId()
    {
       return $this->hasMany(WareEnterItem::class, [
            'ware_series_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareExitItemsWithWareSeriesIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareExitItem
     */            
    public function getWareExitItemsWithWareSeriesIdMany()
    {
       return $this->getMany(WareExitItem::class, [
            'ware_series_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareExitItemsWithWareSeriesId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareExitItemsWithWareSeriesId()
    {
       return $this->hasMany(WareExitItem::class, [
            'ware_series_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareTransItemsWithWareSeriesIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareTransItem
     */            
    public function getWareTransItemsWithWareSeriesIdMany()
    {
       return $this->getMany(WareTransItem::class, [
            'ware_series_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareTransItemsWithWareSeriesId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareTransItemsWithWareSeriesId()
    {
       return $this->hasMany(WareTransItem::class, [
            'ware_series_id' => 'id',
        ]);     
    }


    #endregion


}
