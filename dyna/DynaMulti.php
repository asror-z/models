<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\dyna;


use zetsoft\dbitem\core\SessionItem;
use zetsoft\dbitem\data\ALLApp;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\kernels\ZView;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\system\actives\ZModel;
use zetsoft\models\dyna\DynaConfig;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    DynaMulti
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $dyna_config_id
 * @property string $dynaId
 * @property string $group
 * @property string $models
 * @property string $operator
 * @property array $val
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DynaMulti extends ZActiveRecord
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
    public $dyna_config_id;
    public $dynaId;
    public $group;
    public $models;
    public $operator;
    public $val;
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
        'dyna_config_id',
        'dynaId',
        'group',
        'models',
        'operator',
        'val',
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

    /* @var array $_group*/
    public $_group;  
    public const group = [
        'and' => 'and',
        'or' => 'or',
        'not' => 'not',
    ];

    /* @var array $_operator*/
    public $_operator;  
    public const operator = [
        '=' => '=',
        '!=' => '!=',
        '>' => '>',
        '>=' => '>=',
        '<' => '<',
        '<=' => '<=',
        'between' => 'between',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Конфигурации универсального фильтра';
    public static ?string $icon = 'fal fa-list-alt';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_group = [
            'and' => Az::l('AND'),
            'or' => Az::l('OR'),
            'not' => Az::l('NOT'),
        ];
        
        $this->_operator = [
            '=' => Az::l('Равно'),
            '!=' => Az::l('Не равно'),
            '>' => Az::l('Больше'),
            '>=' => Az::l('Больше или равно'),
            '<' => Az::l('Меньше'),
            '<=' => Az::l('Меньше или равно'),
            'between' => Az::l('Mежду'),
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
			'dyna_config_id',
			'dynaId',
			'group',
			'models',
			'operator',
			'val',
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
                    'DynaConfig' => [
                        'dyna_config_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->icon = 'fal fa-list-alt';

            $config->title = Az::l('Конфигурации универсального фильтра');

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

            'dyna_config_id' => function (FormDb $column) {

                $column->index = true;
                $column->widget = ZKSelect2Widget::class;
                $column->title = Az::l('DynaConfig');

                return $column;
            },


            'dynaId' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('ID фильтра');
                $column->showForm = false;
                $column->showDyna = false;

                return $column;
            },


            'sort' => function (FormDb $column) {

                $column->title = Az::l('Sort');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->showForm = false;
                $column->showDyna = false;

                return $column;
            },




            'group' => function (FormDb $column) {

                $column->title = Az::l('Группировка');
                $column->value = 'and';
                $column->ajax = false;
                $column->data = [
                    'and' => Az::l('AND'),
                    'or' => Az::l('OR'),
                    'not' => Az::l('NOT'),
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },

/*
            'attr' => function (FormDb $column) {

                $column->title = Az::l('Аттрибут');
                $column->data = function ($modelThis) {

                    $modelName = $modelThis->models;
                    $modelClass = Az::$app->utility->execs->bootFull($modelName);

                    $arr = [];

                    $attributes = Az::$app->smart->migra->getAttrsOfModel();
                    if (ZArrayHelper::keyExists($modelClass, $attributes)) {
                        $arr = $attributes[Az::$app->utility->execs->bootFull($modelName)];
                    }

                    return $arr;
                };

                $column->widget = ZKSelect2Widget::class;

                return $column;
            },*/


            'models' => function (FormDb $column) {

                $column->title = Az::l('Model');
                $column->showDyna = false;

                return $column;
            },


            'operator' => function (FormDb $column) {

                $column->title = Az::l('Операторы');
                $column->value = '=';
                $column->data = [
                    '=' => Az::l('Равно'),
                    '!=' => Az::l('Не равно'),
                    '>' => Az::l('Больше'),
                    '>=' => Az::l('Больше или равно'),
                    '<' => Az::l('Меньше'),
                    '<=' => Az::l('Меньше или равно'),
                    'between' => Az::l('Mежду'),
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'val' => function (Form $column) {

                $column->title = Az::l('Значение');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];
                $column->modalWidth = '700px';
                $column->modalHeight = '500px';
                $column->dbType = dbTypeJsonb;
            //    $column->widget = ZFormWidget::class;
      /*          $column->options = static function ($filterForm) {

                    $array = [
                        'config' => [
                            'formClass' => SizeForm::class
                        ]
                    ];

                    $view = new ZView();
                    if (!empty($filterForm->id)) {
                        if (!$view->paramGet(paramMigration)) {
                            $app = new ALLApp();

                            $timeColumns = Az::$app->smart->widget->getTimeColumns($filterForm);

                            $config = new Config();
                            $app->configs = $config;

                            switch (true) {

                                case $filterForm->operator === 'between' || ZArrayHelper::isIn($filterForm->attr, $timeColumns):

                                    $column = new Form();
                                    $column->title = Az::l('Значение 1');
                                    $column->widget = ZKDatepickerWidget::class;
                                    $column->options = [
                                        'config' => [
                                            'startDate' => ''
                                        ]
                                    ];
                                    $column->rules = [
                                        [
                                            validatorRequired,
                                        ],
                                    ];

                                    $columns['value1'] = $column;

                                    $column = new Form();
                                    $column->title = Az::l('Значение 2');
                                    $column->widget = ZKDatepickerWidget::class;
                                    $column->options = [
                                        'config' => [
                                            'startDate' => ''
                                        ]
                                    ];
                                    $column->rules = [
                                        [
                                            validatorRequired,
                                        ],
                                    ];

                                    $columns['value2'] = $column;

                                    break;


                                default:

                                    $model = null;
                                    if ($filterForm->models) {
                                        $modelClass = Az::$app->forms->dynas->bootFull($filterForm->models);
                                        $model = new $modelClass();
                                    }

                                    $data = [];
                                    $widget = ZHInputWidget::class;
                                    if ($model) {

                                        if (!empty($filterForm->attr)) {

                                            $col = $model->columns[$filterForm->attr];
                                            $widget = $col->widget;

                                            Az::$app->forms->wiData->model = $model;
                                            Az::$app->forms->wiData->columns = $model->columns;
                                            Az::$app->forms->wiData->attribute = $filterForm->attr;
                                            Az::$app->forms->wiData->data();

                                            $data = Az::$app->forms->wiData->data;

                                        }

                                        if (empty($filterForm->models)) {
                                            $widget = ZHInputWidget::class;
                                        }

                                    }
                                    $column = new Form();
                                    $column->title = Az::l('Значение');
                                    $column->widget = $widget;
                                    $column->options = [
                                        'data' => $data,
                                        'config' => [
                                            'startDate' => ''
                                        ]
                                    ];
                                    $column->rules = [
                                        [
                                            validatorRequired,
                                        ],
                                    ];

                                    $columns['value'] = $column;

                                    break;
                            }

                            $app->columns = $columns;

                            $item = new SessionItem();
                            $item->class = ALLApp::class;
                            $item->data = $app;

                            $view = new ZView();
                            if (!$view->isCLI()) {
                                Az::$app->cores->session->sessionSet('formRavshan', $item);
                            }

                            $array = [
                                'config' => [
                                    'formSession' => 'formRavshan',
                                    'isCnt' => true,
                                    'count' => 2,
                                    'type' => ZFormWidget::type['allbl']
                                ],
                            ];
                        }
                    }

                    return $array;

                };
                $column->widget = static function ($filterForm) {

                    if (empty($filterForm->models))
                        return ZHInputWidget::class;

                    if ($filterForm->operator === 'between')
                        return ZPeriodPickerWidget::class;

                    $modelClass = Az::$app->forms->dynas->bootFull($filterForm->models);
                    $model = new $modelClass();

                    $widget = ZHInputWidget::class;
                    if (!empty($filterForm->attr)) {
                        $column = $model->columns[$filterForm->attr];
                        $widget = $column->widget;
                    }

                    return $widget;

                };*/

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
        'dyna_config_id',
        'dynaId',
        'group',
        'models',
        'operator',
        'val',
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
                                'dynaId',
                                'attr',
                                'operator',
                                'value',
                                'active',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    function value(DynaMulti &$model = null)
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
    function event()
    {

        $event = new Event();
        /*
            $event->beforeDelete = function (DynaMulti $model) {
                return null;
            };

            $event->afterDelete = function (DynaMulti $model) {
                return null;
            };

            $event->beforeSave = function (DynaMulti $model) {
                return null;
            };

            $event->afterSave = function (DynaMulti $model) {
                return null;
            };

            $event->beforeValidate = function (DynaMulti $model) {
                return null;
            };

            $event->afterValidate = function (DynaMulti $model) {
                return null;
            };

            $event->afterRefresh = function (DynaMulti $model) {
                return null;
            };

            $event->afterFind = function (DynaMulti $model) {
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
     * Function  getDynaConfig
     * @return bool|\yii\db\ActiveRecord|DynaConfig|null
     */            
    public function getDynaConfigOne()
    {
        return $this->getOne(DynaConfig::class, [
          'id' => 'dyna_config_id',
      ]);    
    }
    
     /**
     *
     * Function  getDynaConfig
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getDynaConfig()
    {
        return $this->hasOne(DynaConfig::class, [
          'id' => 'dyna_config_id',
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
