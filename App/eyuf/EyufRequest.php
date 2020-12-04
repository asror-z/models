<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\App\eyuf;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    EyufRequest
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $form
 * @property array $value
 * @property string $deadline
 * @property string $lang
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class EyufRequest extends ZActiveRecord
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
    public $form;
    public $value;
    public $deadline;
    public $lang;
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
        'form',
        'value',
        'deadline',
        'lang',
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

    /* @var array $_form*/
    public $_form;  
    public const form = [
        'zetsoft\\former\\eyuf\\EyufNeedForm' => 'zetsoft\\former\\eyuf\\EyufNeedForm',
        'zetsoft\\former\\eyuf\\EyufNeedCompatriotForm' => 'zetsoft\\former\\eyuf\\EyufNeedCompatriotForm',
        'zetsoft\\former\\eyuf\\EyufNeedCountForm' => 'zetsoft\\former\\eyuf\\EyufNeedCountForm',
    ];

    /* @var array $_lang*/
    public $_lang;  
    public const lang = [
        'krill' => 'krill',
        'lotin' => 'lotin',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Запрос потребностей';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_form = [
            'zetsoft\former\eyuf\EyufNeedForm' => Az::l('Потребности к стипендиантам'),
            'zetsoft\former\eyuf\EyufNeedCompatriotForm' => Az::l('Потребности к соотечественникам'),
            'zetsoft\former\eyuf\EyufNeedCountForm' => Az::l('Потребности по количеству'),
        ];
        
        $this->_lang = [
            'krill' => Az::l('Кириллица'),
            'lotin' => Az::l('Латиница'),
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
			'form',
			'value',
			'deadline',
			'lang',
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
                    'EyufNeed' => [
                        'eyuf_request_id' => 'id',
                    ],
                    'EyufNeedCompatriot' => [
                        'eyuf_request_id' => 'id',
                    ],
                    'EyufNeedCount' => [
                        'eyuf_request_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Запрос потребностей');

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


            'form' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Форма');
                $column->tooltip = Az::l('Форма запроса потребностей');
                $column->data = [
                    'zetsoft\former\eyuf\EyufNeedForm' => Az::l('Потребности к стипендиантам'),
                    'zetsoft\former\eyuf\EyufNeedCompatriotForm' => Az::l('Потребности к соотечественникам'),
                    'zetsoft\former\eyuf\EyufNeedCountForm' => Az::l('Потребности по количеству'),
                ];

                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-16
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-16

                return $column;
            },


            'value' => function (FormDb $column) {

                $column->title = Az::l('Форма');
                $column->tooltip = Az::l('Форма значения запроса потребностей');
                $column->dbType = dbTypeJsonb;
                $column->showForm = true;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->showDyna = true;
                $column->options = [
                    'config' => [
                        'formAttr' => 'form',
                    ]
                ];
                return $column;
            },


            'deadline' => function (FormDb $column) {

                $column->title = Az::l('Завершение рассмотрения потребностей');
                $column->tooltip = Az::l('Завершение рассмотрения запроса потребностей');
                $column->widget = ZKDatepickerWidget::class;
                $column->options = [
                    'config' => [
                        'type' => 2,
                        'pickerButton' => [
                            'icon' => '',
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                        ],
                        'hasIcon' => true,
                    ],
                ];

                return $column;
            },


            'lang' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Допустимый язык');
                $column->tooltip = Az::l('Допустимый язык запроса потребностей');
                $column->data = [
                    'krill' => Az::l('Кириллица'),
                    'lotin' => Az::l('Латиница'),
                ];
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-16
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-16

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
        'form',
        'value',
        'deadline',
        'lang',
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
                                'form',
                            ],
                            [
                                'deadline',
                                'lang',
                            ],
                            [
                                'value',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(EyufRequest $model = null)
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
            $event->beforeDelete = function (EyufRequest $model) {
                return null;
            };

            $event->afterDelete = function (EyufRequest $model) {
                return null;
            };

            $event->beforeSave = function (EyufRequest $model) {
                return null;
            };

            $event->afterSave = function (EyufRequest $model) {
                return null;
            };

            $event->beforeValidate = function (EyufRequest $model) {
                return null;
            };

            $event->afterValidate = function (EyufRequest $model) {
                return null;
            };

            $event->afterRefresh = function (EyufRequest $model) {
                return null;
            };

            $event->afterFind = function (EyufRequest $model) {
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
     * Function  getEyufNeedsWithEyufRequestIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeed
     */            
    public function getEyufNeedsWithEyufRequestIdMany()
    {
       return $this->getMany(EyufNeed::class, [
            'eyuf_request_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedsWithEyufRequestId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedsWithEyufRequestId()
    {
       return $this->hasMany(EyufNeed::class, [
            'eyuf_request_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedCompatriotsWithEyufRequestIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeedCompatriot
     */            
    public function getEyufNeedCompatriotsWithEyufRequestIdMany()
    {
       return $this->getMany(EyufNeedCompatriot::class, [
            'eyuf_request_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedCompatriotsWithEyufRequestId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedCompatriotsWithEyufRequestId()
    {
       return $this->hasMany(EyufNeedCompatriot::class, [
            'eyuf_request_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedCountsWithEyufRequestIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeedCount
     */            
    public function getEyufNeedCountsWithEyufRequestIdMany()
    {
       return $this->getMany(EyufNeedCount::class, [
            'eyuf_request_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedCountsWithEyufRequestId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedCountsWithEyufRequestId()
    {
       return $this->hasMany(EyufNeedCount::class, [
            'eyuf_request_id' => 'id',
        ]);     
    }


    #endregion


}
