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


use zetsoft\dbitem\data\ALLApp;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\shop\ShopOptionTypeForm;
use zetsoft\models\place\PlaceRegion;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\system\validate\ZRequiredValidator;
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
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\widgets\inputes\ZTelInputWidget;
use zetsoft\models\shop\ShopOrder;
use zetsoft\widgets\navigat\ZButtonWidget;
use zetsoft\widgets\places\ZGoogleReadyWidget;
use zetsoft\widgets\places\ZGoogleReadyWidgetPlace;
use zetsoft\widgets\values\ZAdressViewWidget;
use zetsoft\widgets\values\ZFormViewShahzodWidget;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\widgets\values\ZLocationViewWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\user\UserCompany;
use zetsoft\models\place\PlaceCountry;
use zetsoft\models\ware\Ware;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    PlaceAdressTwo
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $place_country_id
 * @property array $region_form
 * @property array $home
 * @property int $place_region_id
 * @property string $street
 * @property string $orientation
 * @property string $postal_code
 * @property string $place
 * @property array $location
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class PlaceAdressTwo extends ZActiveRecord
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
    public $place_country_id;
    public $region_form;
    public $home;
    public $place_region_id;
    public $street;
    public $orientation;
    public $postal_code;
    public $place;
    public $location;
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
        'place_country_id',
        'region_form',
        'home',
        'place_region_id',
        'street',
        'orientation',
        'postal_code',
        'place',
        'location',
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
    public static ?string $title = Azl . 'Адреса';
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
			'place_country_id',
			'region_form',
			'home',
			'place_region_id',
			'street',
			'orientation',
			'postal_code',
			'place',
			'location',
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

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $config->nameValue = static function (PlaceAdressTwo $model) {

                if (empty($model->place_region_id))
                    return null;

                $place_region = PlaceRegion::findOne($model->place_region_id);

                $name = null;
                if ($place_region)
                    $name = $place_region->name;

                $regions = [
                    $name,
                    $model->street,
                ];

                return implode(' | ', $regions);
            };

            $config->hasOne = [
                    'PlaceCountry' => [
                        'place_country_id' => 'id',
                    ],
                    'PlaceRegion' => [
                        'place_region_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Адреса');

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

            'place_country_id' => function (FormDb $column) {

                $column->index = true;

                $column->title = Az::l('Страна');
                $column->tooltip = Az::l('Страна куда идёт доставка');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->changeSave = true;
                $column->changeReload = true;
                // $column->rules = ZRequiredValidator::class;

                return $column;
            },

            'region_form' => function (FormDb $column) {

                $column->title = Az::l('Регионы');
                $column->dbType = dbTypeJsonb;
                $column->changeSave = true;
                $column->changeReload = true;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;

                if (!$this->callableCan())
                    return $column;

                $app = new ALLApp();

                $configs = new Config();
                $configs->changeSave = true;
                $configs->changeReload = true;

                $configs->formId = $this->configs->formId;
                $configs->changeReloadId = $this->paramGet(paramChangeReloadId);


                $app->parentAttr = 'region_form';
                $app->parentClass = self::class;
                $app->parentId = $this->id;
                $app->configs = $configs;

                //start|DavlatovRavshan|2020.10.11

                $formEx = new Form();
                $formEx->title = Az::l('Основной регион');
                $formEx->changeSave = true;
                $formEx->changeReload = true;
                $formEx->fkTable = 'place_region';
                $formEx->fkQuery = [
                    'parent_id' => null,
                    'place_country_id' => (int)$this->place_country_id
                ];
                $formEx->widget = ZKSelect2Widget::class;
                /*$formEx->options = [
                    'config' => [
                        'multiple' => true
                    ]
                ];*/

                $app->columns['region_0'] = $formEx;

                $values = $this->region_form;
                // vd($values);
                $i = 1;
                $bool = false;
                if (!empty($values)) {

                    foreach ($values as $value) {

                        $parentValue = ZArrayHelper::getValue($values, 'region_0');
                        if (empty($parentValue)) {
                            $bool = true;
                            continue;
                        }

                        $region = null;
                        if (!empty($value))
                            $region = PlaceRegion::findAll([
                                'parent_id' => $value
                            ]);

                        if (!empty($region)) {

                            $form = clone $formEx;
                            $form->title = Az::l('Регион уровня #' . $i);
                            $form->fkQuery = [
                                'parent_id' => $value
                            ];
                            $app->columns['region_' . $i] = $form;

                        }

                        $i++;
                    }

                }

                if ($bool) {
                    $this->region_form = null;
                }

                $object = Az::$app->forms->former->model($app, null, $values);


                //end|DavlatovRavshan|2020.10.11

                $column->options = [
                    'config' => [
                        'formObject' => $object,
                    ],
                ];

                return $column;
            },


            'home' => function (FormDb $column) {

                $column->dbType = dbTypeJsonb;
                $column->tooltip = Az::l('Дом, Этаж, № квартиры куда идёт доставка заказа');

                $column->changeSave = true;
                $column->changeReload = true;
                
                $column->widget = ZFormWidget::class;
                $column->options = [
                    'config' => [
                        'model' => $this,
                        'attribute' => 'home',
                        'formClass' => ShopOptionTypeForm::class,
                    ],
                ];

                return $column;
            },


            'place_region_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Регион');
                $column->tooltip = Az::l('Регион куда идёт доставка');
                $column->dbType = dbTypeInteger;
                $column->readonly = true;
                $column->readonlyWidget = true;
                $column->changeSave = true;
                $column->changeReload = true;
                $column->auto = true;

                //start|DavlatovRavshan|2020.10.15
                $column->autoValue = function ($model) {

                    $values = $model->region_form;

                    $value = null;
                    if (!empty($values))
                        $value = end($values);

                    return $value;

                };
                //end|DavlatovRavshan|2020.10.12
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'depend' => 'place_country_id',
                        'method' => 'getRegion',
                    ],
                ];

                return $column;
            },


            'street' => function (FormDb $column) {

                $column->title = Az::l('Улица/Переулок');
                $column->tooltip = Az::l('Улица/Переулок доставки заказа');
                return $column;
            },


            'orientation' => function (FormDb $column) {

                $column->title = Az::l('Ориентир');
                $column->tooltip = Az::l('Ближайшее место куда идёт заказ');

                return $column;
            },


            'postal_code' => function (FormDb $column) {

                $column->title = Az::l('Почтовый индекс');
                $column->tooltip = Az::l('Почтовый индекс района доставки заказа');
                // start|MuminovUmid|2020-10-19
                $column->dbType = dbTypeString;
                $column->rules = validatorString;
                // end|MuminovUmid|2020-10-19
                /*
                                $column->widget = [

                                    'config' => [
                                        'type' => ZHInputWidget::type['number'],
                                    ]

                                ];*/

                return $column;
            },


            'place' => function (FormDb $column) {

                $column->title = Az::l('Место');
                $column->tooltip = Az::l('Место доставки куда идёт заказ');

                return $column;
            },


            'location' => function (FormDb $column) {

                $column->title = Az::l('Локация');
                $column->tooltip = Az::l('Место куда нужно доставить заказ');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZGoogleReadyWidgetPlace::class;
                $column->options = [
                    'config' => [
                        'height' => '1000',
                        'width' => '100',
                        'searchAutoComplete' => true,
                        'searchPlaceImageShow' => false,
                        'zoom' => '12',
                        'markerCount' => '1',
                        'limitWayPoints' => '0',
                        'optimizeWaypoints' => false,
                        'draggable' => true,
                        'mapUseType' => 'write',
                        'dependPlace' => true,
                        'depend_id' => 'place',
                    ],
                ];
                $column->width = '450px';

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
        'place_country_id',
        'region_form',
        'home',
        'place_region_id',
        'street',
        'orientation',
        'postal_code',
        'place',
        'location',
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
                                'region_form',
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
     * Function  getPlaceCountry
     * @return bool|\yii\db\ActiveRecord|PlaceCountry|null
     */            
    public function getPlaceCountryOne()
    {
        return $this->getOne(PlaceCountry::class, [
          'id' => 'place_country_id',
      ]);    
    }
    
     /**
     *
     * Function  getPlaceCountry
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPlaceCountry()
    {
        return $this->hasOne(PlaceCountry::class, [
          'id' => 'place_country_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getPlaceRegion
     * @return bool|\yii\db\ActiveRecord|PlaceRegion|null
     */            
    public function getPlaceRegionOne()
    {
        return $this->getOne(PlaceRegion::class, [
          'id' => 'place_region_id',
      ]);    
    }
    
     /**
     *
     * Function  getPlaceRegion
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPlaceRegion()
    {
        return $this->hasOne(PlaceRegion::class, [
          'id' => 'place_region_id',
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
