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


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\post\PostCpasPostbackForm;
use zetsoft\models\place\PlaceCountry;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTimePickerWidget;
use zetsoft\widgets\inputes\ZTextAreaWidget;
use zetsoft\models\cpas\CpasSource;
use zetsoft\models\cpas\CpasOfferItem;
use zetsoft\models\cpas\CpasStream;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\models\cpas\CpasCompany;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\cpas\CpasTracker;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CpasOffer
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $desc
 * @property string $company
 * @property string $text
 * @property string $substance
 * @property string $catalog
 * @property int $source
 * @property string $composition
 * @property int $deliver
 * @property array $photo
 * @property array $photos
 * @property array $promo
 * @property int $call_center
 * @property int $cpas_company_id
 * @property int $recommended_trafic
 * @property int $not_recommended_traffic
 * @property string $work_time_start
 * @property string $work_time_end
 * @property boolean $api
 * @property string $audience
 * @property int $limit
 * @property string $status
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CpasOffer extends ZActiveRecord
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
    public $desc;
    public $company;
    public $text;
    public $substance;
    public $catalog;
    public $source;
    public $composition;
    public $deliver;
    public $photo;
    public $photos;
    public $promo;
    public $call_center;
    public $cpas_company_id;
    public $recommended_trafic;
    public $not_recommended_traffic;
    public $work_time_start;
    public $work_time_end;
    public $api;
    public $audience;
    public $limit;
    public $status;
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
        'desc',
        'company',
        'text',
        'substance',
        'catalog',
        'source',
        'composition',
        'deliver',
        'photo',
        'photos',
        'promo',
        'call_center',
        'cpas_company_id',
        'recommended_trafic',
        'not_recommended_traffic',
        'work_time_start',
        'work_time_end',
        'api',
        'audience',
        'limit',
        'status',
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

    /* @var array $_status*/
    public $_status;  
    public const status = [
        'new' => 'new',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Офферы';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_status = [
            'new' => Az::l('Новый'),
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
			'desc',
			'company',
			'text',
			'substance',
			'catalog',
			'source',
			'composition',
			'deliver',
			'photo',
			'photos',
			'promo',
			'call_center',
			'cpas_company_id',
			'recommended_trafic',
			'not_recommended_traffic',
			'work_time_start',
			'work_time_end',
			'api',
			'audience',
			'limit',
			'status',
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

            $config->nameValue = '{title} - {created_at}';

            $config->hasOne = [
                    'PlaceCountry' => [
                        'deliver' => 'id',
                        'call_center' => 'id',
                    ],
                    'CpasCompany' => [
                        'cpas_company_id' => 'id',
                    ],
                    'CpasSource' => [
                        'recommended_trafic' => 'id',
                        'not_recommended_traffic' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'CpasOfferItem' => [
                        'cpas_offer_id' => 'id',
                    ],
                    'CpasStream' => [
                        'cpas_offer_id' => 'id',
                    ],
                    'CpasTracker' => [
                        'cpas_offer_id' => 'id',
                    ],
                ];
            $config->name = 'title';

            $config->title = Az::l('Офферы');

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

            'title' => static function (FormDb $column) {

                $column->title = Az::l('Названия');
                $column->rules = [
                    [
                        validatorString,
                    ],
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ],
                    [
                        validatorUnique
                    ]
                ];
                $column->widget = ZInputWidget::class;

                return $column;
            },

            'desc' => static function (FormDb $column) {

                $column->title = Az::l('Описания товара');

                $column->rules = [
                    [
                        validatorString,
                    ],
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->dbType = dbTypeText;
                $column->widget = ZTextAreaWidget::class;

                return $column;
            },

            'company' => static function (FormDb $column) {

                $column->title = Az::l('Производитель');

                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                $column->widget = ZTextAreaWidget::class;

                return $column;
            },


            'text' => static function (FormDb $column) {

                $column->title = Az::l('Описания оффера');
                $column->dbType = dbTypeText;
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZTextAreaWidget::class;

                return $column;
            },


            'substance' => static function (FormDb $column) {

                $column->title = Az::l('Форм фактор');
                $column->rules = [
                    [
                        validatorString,
                    ],
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'catalog' => static function (FormDb $column) {
                $column->index = true;
                $column->showform = true;
                $column->title = Az::l('Ид товара');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];

                return $column;
            },


            'source' => static function (FormDb $column) {
                $column->index = true;
                $column->title = Az::l('Источник');
                $column->dbType = dbTypeInteger;
                return $column;
            },


            'composition' => static function (FormDb $column) {

                $column->title = Az::l('Состав');
                $column->dbType = dbTypeText;
                $column->showForm = false;
                /*$column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];*/
                $column->widget = ZTextAreaWidget::class;

                return $column;
            },


            'deliver' => static function (FormDb $column) {

                $column->title = Az::l('Доставки');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];
                $column->options = [
                    'config' => [
                        'multiple' => true,
                    ],
                ];
                $column->fkTable = 'place_country';

                return $column;
            },


            'photo' => static function (FormDb $column) {

                $column->title = Az::l('Фото продукта');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;

                return $column;
            },

            'photos' => static function (FormDb $column) {

                $column->title = Az::l('Картинки продукта');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                return $column;
            },


            'promo' => static function (FormDb $column) {

                $column->title = Az::l('Прома продукта');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;

                return $column;
            },


            'call_center' => static function (FormDb $column) {

                $column->title = Az::l('Call Центр');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];
                $column->options = [
                    'config' => [
                        'multiple' => true,
                    ],
                ];
                $column->fkTable = 'place_country';

                return $column;
            },


            'cpas_company_id' => static function (FormDb $column) {

                $column->title = Az::l('Компании партнеры');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];
                /*$column->data = [
                    '1' => '1',
                    '2' => '2',
                ];*/
                return $column;
            },


            'recommended_trafic' => static function (FormDb $column) {

                $column->title = Az::l('Источники траффика рекомендуемый');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'multiple' => true,
                    ],
                ];
                $column->fkTable = 'cpas_source';

                return $column;
            },


            'not_recommended_traffic' => static function (FormDb $column) {

                $column->title = Az::l('Источники траффика не рекомендуемый');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'multiple' => true,
                    ],
                ];
                $column->fkTable = 'cpas_source';

                return $column;
            },


            'work_time_start' => static function (FormDb $column) {

                $column->title = Az::l('КЦ начало рабочего времени');


                return $column;
            },


            'work_time_end' => static function (FormDb $column) {

                $column->title = Az::l('КЦ конец рабочего времени');
//                $column->widget = ZKTimePickerWidget::class;

                return $column;
            },


            'api' => static function (FormDb $column) {

                $column->title = Az::l('По API');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },


            'audience' => static function (FormDb $column) {

                $column->title = Az::l('Аудитория');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },


            'limit' => static function (FormDb $column) {

                $column->title = Az::l('Лимит лидов');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },


            'status' => static function (FormDb $column) {

                $column->title = Az::l('Статус');

                $column->data = [
                    'new' => Az::l('Новый'),
//                    'not_accepted' => Az::l('не одобрено'),
//                    'blocked' => Az::l('блокированный'),
//                    'active' => Az::l('активный'),
                ];

                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

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
        'desc',
        'company',
        'text',
        'substance',
        'catalog',
        'source',
        'composition',
        'deliver',
        'photo',
        'photos',
        'promo',
        'call_center',
        'cpas_company_id',
        'recommended_trafic',
        'not_recommended_traffic',
        'work_time_start',
        'work_time_end',
        'api',
        'audience',
        'limit',
        'status',
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
                                'title',
                                'desc',
                                'company',
                                'text',
                                'substance',
                                'catalog',
                                'source',
                                'composition',
                                'deliver',
                                'photo',
                                'photos',
                                'promo',
                                'call_center',
                                'cpas_company_id',
                                'recommended_trafic',
                                'not_recommended_traffic',
                                'work_time_start',
                                'work_time_end',
                                'api',
                                'audience',
                                'limit',
                                'status',
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
    public function value(CpasOffer $model = null)
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

        $event->beforeSave = function (CpasOffer $model) {
            Az::$app->cpas->cpa->createOfferFolder($model->title);
            return true;
        };
        /*
        $event->beforeDelete = function (ShopBrand $model) {
        return null;
        };

        $event->afterDelete = function (ShopBrand $model) {
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
     * Function  getDeliver
     * @return bool|\yii\db\ActiveRecord|PlaceCountry|null
     */            
    public function getDeliverOne()
    {
        return $this->getOne(PlaceCountry::class, [
          'id' => 'deliver',
      ]);    
    }
    
     /**
     *
     * Function  getDeliver
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getDeliver()
    {
        return $this->hasOne(PlaceCountry::class, [
          'id' => 'deliver',
      ]);    
    }
    
    

    /**
     *
     * Function  getCallCenter
     * @return bool|\yii\db\ActiveRecord|PlaceCountry|null
     */            
    public function getCallCenterOne()
    {
        return $this->getOne(PlaceCountry::class, [
          'id' => 'call_center',
      ]);    
    }
    
     /**
     *
     * Function  getCallCenter
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCallCenter()
    {
        return $this->hasOne(PlaceCountry::class, [
          'id' => 'call_center',
      ]);    
    }
    
    

    /**
     *
     * Function  getCpasCompany
     * @return bool|\yii\db\ActiveRecord|CpasCompany|null
     */            
    public function getCpasCompanyOne()
    {
        return $this->getOne(CpasCompany::class, [
          'id' => 'cpas_company_id',
      ]);    
    }
    
     /**
     *
     * Function  getCpasCompany
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCpasCompany()
    {
        return $this->hasOne(CpasCompany::class, [
          'id' => 'cpas_company_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getRecommendedTrafic
     * @return bool|\yii\db\ActiveRecord|CpasSource|null
     */            
    public function getRecommendedTraficOne()
    {
        return $this->getOne(CpasSource::class, [
          'id' => 'recommended_trafic',
      ]);    
    }
    
     /**
     *
     * Function  getRecommendedTrafic
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getRecommendedTrafic()
    {
        return $this->hasOne(CpasSource::class, [
          'id' => 'recommended_trafic',
      ]);    
    }
    
    

    /**
     *
     * Function  getNotRecommendedTraffic
     * @return bool|\yii\db\ActiveRecord|CpasSource|null
     */            
    public function getNotRecommendedTrafficOne()
    {
        return $this->getOne(CpasSource::class, [
          'id' => 'not_recommended_traffic',
      ]);    
    }
    
     /**
     *
     * Function  getNotRecommendedTraffic
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getNotRecommendedTraffic()
    {
        return $this->hasOne(CpasSource::class, [
          'id' => 'not_recommended_traffic',
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
     * Function  getCpasOfferItemsWithCpasOfferIdMany
     * @return  null|\yii\db\ActiveRecord[]|CpasOfferItem
     */            
    public function getCpasOfferItemsWithCpasOfferIdMany()
    {
       return $this->getMany(CpasOfferItem::class, [
            'cpas_offer_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasOfferItemsWithCpasOfferId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasOfferItemsWithCpasOfferId()
    {
       return $this->hasMany(CpasOfferItem::class, [
            'cpas_offer_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCpasStreamsWithCpasOfferIdMany
     * @return  null|\yii\db\ActiveRecord[]|CpasStream
     */            
    public function getCpasStreamsWithCpasOfferIdMany()
    {
       return $this->getMany(CpasStream::class, [
            'cpas_offer_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasStreamsWithCpasOfferId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasStreamsWithCpasOfferId()
    {
       return $this->hasMany(CpasStream::class, [
            'cpas_offer_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCpasTrackersWithCpasOfferIdMany
     * @return  null|\yii\db\ActiveRecord[]|CpasTracker
     */            
    public function getCpasTrackersWithCpasOfferIdMany()
    {
       return $this->getMany(CpasTracker::class, [
            'cpas_offer_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasTrackersWithCpasOfferId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasTrackersWithCpasOfferId()
    {
       return $this->hasMany(CpasTracker::class, [
            'cpas_offer_id' => 'id',
        ]);     
    }


    #endregion


}
