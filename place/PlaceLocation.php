<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\place;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\widgets\inputes\ZTelInputWidget;
use zetsoft\models\place\PlaceRegion;
use zetsoft\models\shop\ShopOrder;
use zetsoft\widgets\navigat\ZButtonWidget;
use zetsoft\widgets\places\ZGoogleReadyWidget;
use zetsoft\widgets\values\ZAdressViewWidget;
use zetsoft\widgets\values\ZFormViewShahzodWidget;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\widgets\values\ZLocationViewWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\user\UserCompany;
use zetsoft\models\place\PlaceCountry;
use zetsoft\models\ware\Ware;
use zetsoft\models\shop\ShopCourier;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    PlaceLocation
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $shop_courier_id
 * @property string $datetime
 * @property string $adress
 * @property string $placeid
 * @property string $latitude
 * @property string $longtitude
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class PlaceLocation extends ZActiveRecord
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
    public $shop_courier_id;
    public $datetime;
    public $adress;
    public $placeid;
    public $latitude;
    public $longtitude;
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
        'shop_courier_id',
        'datetime',
        'adress',
        'placeid',
        'latitude',
        'longtitude',
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
    public static ?string $title = Azl . 'Местоположения';
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
			'shop_courier_id',
			'datetime',
			'adress',
			'placeid',
			'latitude',
			'longtitude',
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
                    'ShopCourier' => [
                        'shop_courier_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->editClass = 'zetsoft\system\column\ZEditablePanelColumn';

            $config->title = Az::l('Местоположения');

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
           
            'shop_courier_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Курьер');
                $column->tooltip = Az::l('Курьер присвоенный для данного местоположения');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'datetime' => function (FormDb $column) {

                $column->title = Az::l('Дата');
                $column->tooltip = Az::l('Дата создания');
                $column->auto = true;
                $column->value = function ($model) {
                    return Az::$app->cores->date->dateTime();
                };

                $column->dbType = dbTypeDateTime;

                return $column;
            },
            
           
            'adress' => function (FormDb $column) {

                $column->title = Az::l('adress');
                $column->tooltip = Az::l('Адрес');

                return $column;
            },
            
           
            'placeid' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Идентификатор Места');
                $column->tooltip = Az::l('Идентификатор Места');

                return $column;
            },
            
           
            'latitude' => function (FormDb $column) {

                $column->title = Az::l('Широта');
                $column->tooltip = Az::l('Широта');

                return $column;
            },
            
           
            'longtitude' => function (FormDb $column) {

                $column->title = Az::l('Долгота');
                $column->tooltip = Az::l('Долгота');

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
        'shop_courier_id',
        'datetime',
        'adress',
        'placeid',
        'latitude',
        'longtitude',
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
                            [
                                'place_country_id',
                            ],
                            [
                                'place_region_id',
                            ],
                            [
                                'street',
                            ],
                            [
                                'home',
                            ],
                            [
                                'orientation',
                            ],
                            [
                                'postal_code',
                            ],
                            [
                                'place',
                            ],
                            [
                                'location',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
        public function value(PlaceAdress $model = null)
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
        /*$event->beforeSave = function (PlaceAdress $model) {

            $user = User::findOne($this->userIdentity()->id);
            $places = $user->place_adress_ids;
            $places[] = $model->id;
            $user->place_adress_ids = $places;

            $user->save();

            return null;
        };*/
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
     * Function  getShopCourier
     * @return bool|\yii\db\ActiveRecord|ShopCourier|null
     */            
    public function getShopCourierOne()
    {
        return $this->getOne(ShopCourier::class, [
          'id' => 'shop_courier_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopCourier
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopCourier()
    {
        return $this->hasOne(ShopCourier::class, [
          'id' => 'shop_courier_id',
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



    #endregion


}
