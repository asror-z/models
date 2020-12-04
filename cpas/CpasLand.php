<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\cpas;


use yii\base\Model;
use zetsoft\dbdata\cpas\LandingData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\lang\LanguageForm;
use zetsoft\former\eyuf\EyufNeedForm;
use zetsoft\models\cpas\CpasOffer;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDateRangePickerWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKStarRatingWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZIconPickerWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZPeriodPickerWidget;
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
use zetsoft\models\shop\ShopOrder;
use zetsoft\widgets\inputes\ZTextAreaWidget;
use zetsoft\models\place\PlaceCountry;
use zetsoft\models\cpas\CpasOfferItem;
use zetsoft\models\cpas\CpasStream;
use zetsoft\models\cpas\CpasSource;
use zetsoft\widgets\navigat\ZDownloadWidget;
use zetsoft\widgets\values\ZSuffixWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\cpas\CpasStreamItem;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CpasLand
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $cpas_offer_item_id
 * @property int $place_country_id
 * @property string $type
 * @property string $status
 * @property boolean $adaptive
 * @property string $path
 * @property array $archive
 * @property array $screen
 * @property int $visit
 * @property string $order
 * @property int $cr
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CpasLand extends ZActiveRecord
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
    public $cpas_offer_item_id;
    public $place_country_id;
    public $type;
    public $status;
    public $adaptive;
    public $path;
    public $archive;
    public $screen;
    public $visit;
    public $order;
    public $cr;
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
        'cpas_offer_item_id',
        'place_country_id',
        'type',
        'status',
        'adaptive',
        'path',
        'archive',
        'screen',
        'visit',
        'order',
        'cr',
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
        'land' => 'land',
        'trans' => 'trans',
        'trans_form' => 'trans_form',
    ];

    /* @var array $_status*/
    public $_status;  
    public const status = [
        'new' => 'new',
        'top' => 'top',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Лендинг';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_type = [
            'land' => Az::l('Лендинг'),
            'trans' => Az::l('Прелендинг'),
            'trans_form' => Az::l('Прелендинг с формой'),
        ];
        
        $this->_status = [
            'new' => Az::l('Новый'),
            'top' => Az::l('Топ'),
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
			'cpas_offer_item_id',
			'place_country_id',
			'type',
			'status',
			'adaptive',
			'path',
			'archive',
			'screen',
			'visit',
			'order',
			'cr',
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

                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $config->nameAuto = true;                                                                                                      $config->nameValue = function (CpasLand $model) {
                return PlaceCountry::findOne(CpasOfferItem::findOne($model->cpas_offer_item_id)->place_country_id)->name . '_' . $model->title . '_' . $model->created_at;
            };

            $config->hasOne = [
                    'CpasOfferItem' => [
                        'cpas_offer_item_id' => 'id',
                    ],
                    'PlaceCountry' => [
                        'place_country_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'CpasStreamItem' => [
                        'cpas_land_id' => 'id',
                        'cpas_trans' => 'id',
                        'cpas_trans_form' => 'id',
                    ],
                ];
            $config->title = Az::l('Лендинг');

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


            /**
             *
             * Core Data
             */

            'cpas_offer_item_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Товар');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },

            'place_country_id' => function (FormDb $column) {

                $column->index = true;
                $column->readonly = true;
                $column->title = Az::l('Страна');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZSelect2Widget::class;
                $column->auto = false;
                $column->autoValue = function () {
                    return $this->getCpasOfferItemOne()->place_country_id;
                };

                return $column;
            },



            'type' => function (FormDb $column) {

                $column->title = Az::l('Тип');
                $column->data = [
                    'land' => Az::l('Лендинг'),
                    'trans' => Az::l('Прелендинг'),
                    'trans_form' => Az::l('Прелендинг с формой'),
                ];
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];
                $column->widget = ZKSelect2Widget::class;
               

                return $column;
            },

            /**
             *
             * Choose
             */

            'status' => function (FormDb $column) {

                $column->title = Az::l('Статус');
                $column->data = [
                    'new' => Az::l('Новый'),
                    'top' => Az::l('Топ'),
                ];
                $column->rules = [
                    [
                        validatorString,
                    ],
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];

                $column->widget = ZKSelect2Widget::class;

                return $column;
            },

            'adaptive' => function (FormDb $column) {

                $column->title = Az::l('Адаптивный');
                $column->dbType = dbTypeBoolean;
                $column->rules = [
                    [
                        validatorBoolean,
                    ],
                ];

                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },


            'path' => function (FormDb $column) {

                $column->title = Az::l('Путь к лендингу');
                $column->dbType = dbTypeString;
                $column->showForm = false;
                

                return $column;
            },


            'archive' => function (FormDb $column) {

                $column->title = Az::l('Архив продукта');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->options = [
                    'config' => [
                        'required' => true,
                    ]
                ];
                /*$column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];*/
                return $column;
            },


            'screen' => function (FormDb $column) {

                $column->title = Az::l('Скриншот лендинга');
                $column->dbType = dbTypeJsonb;
                /*$column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];*/
                $column->options = [
                    'config' => [
                        'required' => true,
                    ]
                ];
                $column->widget = ZFileInputWidget::class;

                return $column;
            },
            

            /**
             *
             * Generate
             */


            'visit' => function (FormDb $column) {

                $column->title = Az::l('Посетители');
                $column->dbType = dbTypeInteger;

                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                $column->valueWidget = ZSuffixWidget::class;

                return $column;
            },

            'order' => function (FormDb $column) {

                $column->title = Az::l('Заказ');

                $column->dbType = dbTypeString;

                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                $column->valueWidget = ZSuffixWidget::class;

                return $column;
            },


            'cr' => function (FormDb $column) {

                $column->title = Az::l('СР');
                $column->dbType = dbTypeInteger;
                
             /*   $column->rules = [
                    [
                        validatorString,
                    ],
                ];*/

                $column->valueWidget = ZSuffixWidget::class;

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
        'cpas_offer_item_id',
        'place_country_id',
        'type',
        'status',
        'adaptive',
        'path',
        'archive',
        'screen',
        'visit',
        'order',
        'cr',
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
                                'cpas_offer_item_id',
                                'place_country_id',
                                'title',
                                'type',
                                'status',
                                'adaptive',
                                'path',
                                'archive',
                                'screen',
                                'visit',
                                'order',
                                'cr',
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
    public function value(CpasLand &$model = null)
    {
        if ($model === null)
            $model = $this;

        // Todo: MyCode

        $model->save();
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
            $event->beforeDelete = function (CpasSites $model) {
                return null;
            };

            $event->afterDelete = function (CpasSites $model) {
                return null;
            };

            $event->beforeSave = function (CpasSites $model) {
                return null;
            };

            $event->afterSave = function (CpasSites $model) {
                return null;
            };

            $event->beforeValidate = function (CpasSites $model) {
                return null;
            };

            $event->afterValidate = function (CpasSites $model) {
                return null;
            };

            $event->afterRefresh = function (CpasSites $model) {
                return null;
            };

            $event->afterFind = function (CpasSites $model) {
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
     * Function  getCpasOfferItem
     * @return bool|\yii\db\ActiveRecord|CpasOfferItem|null
     */            
    public function getCpasOfferItemOne()
    {
        return $this->getOne(CpasOfferItem::class, [
          'id' => 'cpas_offer_item_id',
      ]);    
    }
    
     /**
     *
     * Function  getCpasOfferItem
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCpasOfferItem()
    {
        return $this->hasOne(CpasOfferItem::class, [
          'id' => 'cpas_offer_item_id',
      ]);    
    }
    
    

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
     * Function  getCpasStreamItemsWithCpasLandIdMany
     * @return  null|\yii\db\ActiveRecord[]|CpasStreamItem
     */            
    public function getCpasStreamItemsWithCpasLandIdMany()
    {
       return $this->getMany(CpasStreamItem::class, [
            'cpas_land_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasStreamItemsWithCpasLandId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasStreamItemsWithCpasLandId()
    {
       return $this->hasMany(CpasStreamItem::class, [
            'cpas_land_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCpasStreamItemsWithCpasTransMany
     * @return  null|\yii\db\ActiveRecord[]|CpasStreamItem
     */            
    public function getCpasStreamItemsWithCpasTransMany()
    {
       return $this->getMany(CpasStreamItem::class, [
            'cpas_trans' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasStreamItemsWithCpasTrans
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasStreamItemsWithCpasTrans()
    {
       return $this->hasMany(CpasStreamItem::class, [
            'cpas_trans' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCpasStreamItemsWithCpasTransFormMany
     * @return  null|\yii\db\ActiveRecord[]|CpasStreamItem
     */            
    public function getCpasStreamItemsWithCpasTransFormMany()
    {
       return $this->getMany(CpasStreamItem::class, [
            'cpas_trans_form' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasStreamItemsWithCpasTransForm
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasStreamItemsWithCpasTransForm()
    {
       return $this->hasMany(CpasStreamItem::class, [
            'cpas_trans_form' => 'id',
        ]);     
    }


    #endregion


}
