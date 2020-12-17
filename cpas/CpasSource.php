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
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\models\user\User;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\cpas\CpasOffer;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\dbitem\data\FormDb;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CpasSource
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
class CpasSource extends ZActiveRecord
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
    public static ?string $title = Azl . 'Источники траффика';
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

            $config->nameAuto = false;
            $config->hasOne = [
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'CpasOffer' => [
                        'recommended_trafic' => 'id',
                        'not_recommended_traffic' => 'id',
                    ],
                ];
            $config->title = Az::l('Источники траффика');

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


            /*
             *
             * Веб-трафик
             * Мобильный трафикEmail-рассылка (по согласованию с личным менеджером)Дорвей-трафикКонтекстная рекламаКонтекстная реклама на брендmyTargetFacebook (Европа)Instagram (Европа)Таргет ВК (Европа) CashbackPopUp-рекламаClickUnder-рекламаСоц. сети (паблики ВК, ОК и Мой мир)РетаргетингМотивированный трафикFacebook (СНГ/РФ)Instagram (СНГ/РФ)Таргет ВК (СНГ/РФ)Push-уведомленияYouTube
             *
             * */

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
                            [
                                'title',
                            ],
                            [
                                'description',
                            ],
                            [
                                'text',
                            ],
                            [
                                'type_substance',
                            ],
                            [
                                'company',
                            ],
                            [
                                'composition',
                            ],
                            [
                                'deliver',
                            ],
                            [
                                'photos',
                            ],
                            [
                                'promo',
                            ],
                            [
                                'call_center',
                            ],
                            [
                                'recommended_trafic',
                            ],
                            [
                                'not_recommended_traffic',
                            ],
                            [
                                'work_time',
                            ],
                            [
                                'api',
                            ],
                            [
                                'audience',
                            ],
                            [
                                'limit',
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


        /*
        $event->beforeDelete = function (ShopBrand $model) {
        return null;
        };

        $event->afterDelete = function (ShopBrand $model) {
        return null;
        };

        $event->beforeSave = function (ShopBrand $model) {
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
     * Function  getCpasOffersWithRecommendedTraficMany
     * @return  null|\yii\db\ActiveRecord[]|CpasOffer
     */            
    public function getCpasOffersWithRecommendedTraficMany()
    {
       return $this->getMany(CpasOffer::class, [
            'recommended_trafic' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasOffersWithRecommendedTrafic
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasOffersWithRecommendedTrafic()
    {
       return $this->hasMany(CpasOffer::class, [
            'recommended_trafic' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCpasOffersWithNotRecommendedTrafficMany
     * @return  null|\yii\db\ActiveRecord[]|CpasOffer
     */            
    public function getCpasOffersWithNotRecommendedTrafficMany()
    {
       return $this->getMany(CpasOffer::class, [
            'not_recommended_traffic' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasOffersWithNotRecommendedTraffic
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasOffersWithNotRecommendedTraffic()
    {
       return $this->hasMany(CpasOffer::class, [
            'not_recommended_traffic' => 'id',
        ]);     
    }


    #endregion


}
