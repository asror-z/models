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
use zetsoft\former\cpas\CpasCounterForm;
use zetsoft\former\cpas\CpasWidgetForm;
use zetsoft\former\post\PostCpasPostbackForm;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\models\cpas\CpasOffer;
use zetsoft\models\cpas\CpasLand;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\cpas\CpasTeaser;
use zetsoft\models\cpas\CpasStreamItem;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CpasStream
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $cpas_offer_id
 * @property int $user_id
 * @property array $counter
 * @property array $widget
 * @property array $postback
 * @property boolean $trafficback
 * @property string $sub1
 * @property string $sub2
 * @property string $sub3
 * @property string $sub4
 * @property string $sub5
 * @property string $utm_source
 * @property string $utm_company
 * @property string $utm_content
 * @property string $utm_term
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CpasStream extends ZActiveRecord
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
    public $cpas_offer_id;
    public $user_id;
    public $counter;
    public $widget;
    public $postback;
    public $trafficback;
    public $sub1;
    public $sub2;
    public $sub3;
    public $sub4;
    public $sub5;
    public $utm_source;
    public $utm_company;
    public $utm_content;
    public $utm_term;
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
        'cpas_offer_id',
        'user_id',
        'counter',
        'widget',
        'postback',
        'trafficback',
        'sub1',
        'sub2',
        'sub3',
        'sub4',
        'sub5',
        'utm_source',
        'utm_company',
        'utm_content',
        'utm_term',
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
    public static ?string $title = Azl . 'Потоки';
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
			'cpas_offer_id',
			'user_id',
			'counter',
			'widget',
			'postback',
			'trafficback',
			'sub1',
			'sub2',
			'sub3',
			'sub4',
			'sub5',
			'utm_source',
			'utm_company',
			'utm_content',
			'utm_term',
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

                        $config->nameValue = function (CpasStream $model) {
                $offer = CpasOffer::findOne($model->cpas_offer_id);
                if ($offer === null)
                    return $model->title;
                return $offer->title . '_' . $model->title . '_' . $model->created_at;
            };

            $config->hasOne = [
                    'CpasOffer' => [
                        'cpas_offer_id' => 'id',
                    ],
                    'User' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'CpasStreamItem' => [
                        'cpas_stream_id' => 'id',
                    ],
                ];
            $config->relationMany = [
                    'zetsoft\\models\\cpas\\CpasStreamItem',
                ];
            $config->title = Az::l('Потоки');

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
             * Relations
             */

            'cpas_offer_id' => static function (FormDb $column) {

                $column->index = true;
                $column->dbType = dbTypeInteger;
                $column->title = Az::l('Оффер');
                $column->widget = ZKSelect2Widget::class;
                $column->fkAttr = 'title';

                return $column;
            },


            'user_id' => static function (FormDb $column) {

                $column->index = true;
                $column->dbType = dbTypeInteger;
                $column->title = Az::l('User');
                $column->widget = ZKSelect2Widget::class;
                $column->fkAttr = 'email';

                return $column;
            },


            /**
             *
             * Main Data
             */

            'title' => static function (FormDb $column) {

                $column->title = Az::l('Название');
                $column->widget = ZInputWidget::class;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];

                return $column;
            },


            'counter' => static function (FormDb $column) {

                $column->title = Az::l('Идентификаторы счетчиков');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
                    'config' => [
                        'formClass' => CpasCounterForm::class,
                    ],
                ];
                $column->valueOptions = [
                    'config' => [
                        'formClass' => CpasCounterForm::class,
                    ],
                ];
                $column->event = function (CpasStream $model) {
//                    if (!Az::$app->paramGet($this->paramIsUpdate))
//                        Az::$app->cpas->cpa->editStream($model);
                };


                return $column;
            },

            'widget' => static function (FormDb $column) {

                $column->title = Az::l('Counter for CallCenter');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
                    'config' => [
                        'formClass' => CpasWidgetForm::class,
                    ],
                ];
                $column->valueOptions = [
                    'config' => [
                        'formClass' => CpasWidgetForm::class,
                    ],
                ];
                $column->mergeHeader = true;


                return $column;
            },


            /**
             *
             *
             * Postbacks
             */

            'postback' => static function (FormDb $column) {

                $column->title = Az::l('Постбек для пользователей');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
                    'config' => [
                        'formClass' => PostCpasPostbackForm::class,
                    ],
                ];
                $column->valueOptions = [
                    'config' => [
                        'formClass' => PostCpasPostbackForm::class,
                    ],
                ];
                $column->mergeHeader = true;


                return $column;
            },


            'trafficback' => static function (FormDb $column) {

                $column->title = Az::l('Traficback');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },


            /**
             *
             * Sub Accounts
             */

            'sub1' => static function (FormDb $column) {

                $column->title = Az::l('Sub1');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'sub2' => static function (FormDb $column) {

                $column->title = Az::l('Sub2');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'sub3' => static function (FormDb $column) {

                $column->title = Az::l('Sub3');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'sub4' => static function (FormDb $column) {

                $column->title = Az::l('Sub4');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'sub5' => static function (FormDb $column) {

                $column->title = Az::l('Sub5');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            /**
             *
             * Teasers
             */

            'utm_source' => static function (FormDb $column) {

                $column->title = Az::l('UTM source');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'utm_company' => static function (FormDb $column) {

                $column->title = Az::l('UTM company');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'utm_content' => static function (FormDb $column) {

                $column->title = Az::l('UTM content');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'utm_term' => static function (FormDb $column) {

                $column->title = Az::l('UTM term');
                $column->widget = ZInputWidget::class;

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
        'cpas_offer_id',
        'user_id',
        'counter',
        'widget',
        'postback',
        'trafficback',
        'sub1',
        'sub2',
        'sub3',
        'sub4',
        'sub5',
        'utm_source',
        'utm_company',
        'utm_content',
        'utm_term',
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
                                'cpas_offer_id',
                                'user_id',
                                'title',
                                'counter',
                                'widget',
                                'postback',
                                'trafficback',
                                'sub1',
                                'sub2',
                                'sub3',
                                'sub4',
                                'sub5',
                                'utm_source',
                                'utm_company',
                                'utm_content',
                                'utm_term',
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
    public function value(CpasStream $model = null)
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
     * Function  getCpasOffer
     * @return bool|\yii\db\ActiveRecord|CpasOffer|null
     */            
    public function getCpasOfferOne()
    {
        return $this->getOne(CpasOffer::class, [
          'id' => 'cpas_offer_id',
      ]);    
    }
    
     /**
     *
     * Function  getCpasOffer
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCpasOffer()
    {
        return $this->hasOne(CpasOffer::class, [
          'id' => 'cpas_offer_id',
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
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many


    /**
     *
     * Function  getCpasStreamItemsWithCpasStreamIdMany
     * @return  null|\yii\db\ActiveRecord[]|CpasStreamItem
     */            
    public function getCpasStreamItemsWithCpasStreamIdMany()
    {
       return $this->getMany(CpasStreamItem::class, [
            'cpas_stream_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasStreamItemsWithCpasStreamId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasStreamItemsWithCpasStreamId()
    {
       return $this->hasMany(CpasStreamItem::class, [
            'cpas_stream_id' => 'id',
        ]);     
    }


    #endregion


}
