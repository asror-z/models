<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\page;


use kartik\grid\DataColumn;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\column\ZKDataColumn;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZIconPickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\navigat\ZButtonWidget;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    PageAction
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $data
 * @property string $input
 * @property boolean $check
 * @property int $clone
 * @property string $icon
 * @property string $type
 * @property boolean $debug
 * @property boolean $cache
 * @property boolean $cacheHttp
 * @property boolean $csrf
 * @property int $page_control_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class PageAction extends ZActiveRecord
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
    public $data;
    public $input;
    public $check;
    public $clone;
    public $icon;
    public $type;
    public $debug;
    public $cache;
    public $cacheHttp;
    public $csrf;
    public $page_control_id;
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
        'data',
        'input',
        'check',
        'clone',
        'icon',
        'type',
        'debug',
        'cache',
        'cacheHttp',
        'csrf',
        'page_control_id',
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
        'html' => 'html',
        'ajax' => 'ajax',
        'part' => 'part',
        'rest' => 'rest',
        'grap' => 'grap',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Веб-действия';
    public static ?string $icon = 'fal fa-file';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_type = [
            'html' => Az::l('html'),
            'ajax' => Az::l('ajax'),
            'part' => Az::l('part'),
            'rest' => Az::l('rest'),
            'grap' => Az::l('grap'),
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
			'data',
			'input',
			'check',
			'clone',
			'icon',
			'type',
			'debug',
			'cache',
			'cacheHttp',
			'csrf',
			'page_control_id',
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
        return static function (ConfigDB $config) {

            $config->addBy = true;
            $config->icon = 'fal fa-file';
            $config->nameAuto = false;
            $config->hasOne = [
                'CoreControl' => [
                    'page_control_id' => 'id',
                ],
                'User' => [
                    'created_by' => 'id',
                    'modified_by' => 'id',
                ],
            ];
            $config->title = Az::l('Веб-действия');
            $config->extraConfig = true;
            $config->after = [
                'icon' => [
                    [
                        'class' => ZKDataColumn::class,
                        'label' => Az::l('Редактировать'),
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, DataColumn $dataColumn) {


                            return ZButtonWidget::widget([
                                'id' => $key,
                                'config' => [
                                    'title' => Az::l('Редактировать'),
                                    'icon' => 'fas fa-edit',
                                    'pjax' => 0,
                                    'url' => '/core/widget/sampleWidgetNorm.aspx?key=' . $key,
                                    'btnRounded' => false,
                                    'btn' => false,
                                    'hasIcon' => true,
                                ],
                                'event' => [
                                    'click' => 'function(event){event.preventDefault(); window.open(this.href, "_blank")}',
                                ],
                            ]);
                        }
                    ],
                    [
                        'class' => ZKDataColumn::class,
                        'label' => Az::l('Редактировать 2'),
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, DataColumn $dataColumn) {
                            return ZButtonWidget::widget([
                                'id' => $key,
                                'config' => [
                                    'title' => Az::l('Редактировать'),
                                    'icon' => 'fas fa-save',
                                    'pjax' => 0,
                                    'url' => '/core/widget/sampleWidgetNorm.aspx?key=' . $key,
                                    'btnRounded' => false,
                                    'btn' => false,
                                    'hasIcon' => true,
                                ],
                                'event' => [
                                    'click' => 'function(event){event.preventDefault(); window.open(this.href, "_blank")}',
                                ],
                            ]);
                        }
                    ],
                ]
            ];

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



            'data' => function (FormDb $column) {

                $column->title = Az::l('Данные');
                $column->showForm = false;

                return $column;
            },


            'input' => function (FormDb $column) {

                $column->title = Az::l('Введенное название');
                $column->showDyna = false;

                return $column;
            },


            'check' => function (FormDb $column) {

                $column->title = Az::l('Верификация');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->showForm = false;
                $column->width = '100px';
                $column->mergeHeader = true;

                return $column;
            },


            'clone' => function (FormDb $column) {

                $column->title = Az::l('Клонировать');
                $column->tooltip = 'Клонировать данные с:';
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'page_action';

                return $column;
            },




            'icon' => function (FormDb $column) {

                $column->title = Az::l('Иконка');
                $column->widget = ZIconPickerWidget::class;

                return $column;
            },


            'type' => function (FormDb $column) {

                $column->defaultValue = 'html';
                $column->index = true;
                $column->title = Az::l('Тип');
                $column->data = [
                    'html' => Az::l('html'),
                    'ajax' => Az::l('ajax'),
                    'part' => Az::l('part'),
                    'rest' => Az::l('rest'),
                    'grap' => Az::l('grap'),
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->ajax = false;
                $column->width = '400px';

                return $column;
            },


            'debug' => function (FormDb $column) {

                $column->title = Az::l('Debug Panel?');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },


            'cache' => function (FormDb $column) {

                $column->defaultValue = false;
                $column->title = Az::l('Кешировать страницу?');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },


            'cacheHttp' => function (FormDb $column) {

                $column->defaultValue = false;
                $column->title = Az::l('Кешировать HTTP?');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },


            'csrf' => function (FormDb $column) {

                $column->title = Az::l('csrf?');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },


            'page_control_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Контроллер');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

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
        'data',
        'input',
        'check',
        'clone',
        'icon',
        'type',
        'debug',
        'cache',
        'cacheHttp',
        'csrf',
        'page_control_id',
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
                                'data',
                            ],
                            [
                                'input',
                            ],
                            [
                                'check',
                            ],
                            [
                                'clone',
                            ],
                            [
                                'title',
                            ],
                            [
                                'icon',
                            ],
                            [
                                'type',
                            ],
                            [
                                'debug',
                            ],
                            [
                                'cache',
                            ],
                            [
                                'cacheHttp',
                            ],
                            [
                                'csrf',
                            ],
                            [
                                'page_control_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
        public function value(PageAction $model = null)
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
        $event->beforeSave = function (PageAction $model) {
            if (ZArrayHelper::getValue(Az::$app->params, paramNoEvent))
                return null;
            else
                Az::$app->cores->appPage->action($model, $this->isNewRecord);
        };

        $event->beforeDelete = function (PageAction $model) {
            if (ZArrayHelper::getValue(Az::$app->params, paramNoEvent))
                return null;
            else
                Az::$app->cores->appPage->move_action($model);
        };
        /*
        $event->beforeDelete = function (PageAction $model) {
        return null;
        };

        $event->afterDelete = function (PageAction $model) {
        return null;
        };

        $event->beforeSave = function (PageAction $model) {
        return null;
        };

        $event->afterSave = function (PageAction $model) {
        return null;
        };

        $event->beforeValidate = function (PageAction $model) {
        return null;
        };

        $event->afterValidate = function (PageAction $model) {
        return null;
        };

        $event->afterRefresh = function (PageAction $model) {
        return null;
        };

        $event->afterFind = function (PageAction $model) {
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
     * Function  getClone
     * @return bool|\yii\db\ActiveRecord|PageAction|null
     */            
    public function getCloneOne()
    {
        return $this->getOne(PageAction::class, [
          'id' => 'clone',
      ]);    
    }
    
     /**
     *
     * Function  getClone
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getClone()
    {
        return $this->hasOne(PageAction::class, [
          'id' => 'clone',
      ]);    
    }
    
    

    /**
     *
     * Function  getPageControl
     * @return bool|\yii\db\ActiveRecord|PageControl|null
     */            
    public function getPageControlOne()
    {
        return $this->getOne(PageControl::class, [
          'id' => 'page_control_id',
      ]);    
    }
    
     /**
     *
     * Function  getPageControl
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPageControl()
    {
        return $this->hasOne(PageControl::class, [
          'id' => 'page_control_id',
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
     * Function  getPageActionsWithCloneMany
     * @return  null|\yii\db\ActiveRecord[]|PageAction
     */            
    public function getPageActionsWithCloneMany()
    {
       return $this->getMany(PageAction::class, [
            'clone' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageActionsWithClone
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageActionsWithClone()
    {
       return $this->hasMany(PageAction::class, [
            'clone' => 'id',
        ]);     
    }


    #endregion


}
