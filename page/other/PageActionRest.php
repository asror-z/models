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
use zetsoft\models\page\PageControl;
use zetsoft\models\page\PageModule;
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
use zetsoft\models\page\PageAction;
use zetsoft\dbcore\chat\ChatMailCore;




/**
 * Class    PageActionRest
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property string $data
 * @property string $input
 * @property boolean $check
 * @property int $clone
 * @property string $title
 * @property string $icon
 * @property boolean $cache
 * @property boolean $cacheHttp
 * @property int $page_control_id
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class PageActionRest extends ZActiveRecord
{

    #region MVars

    /*
    
    public $id;
    public $name;
    public $data;
    public $input;
    public $check;
    public $clone;
    public $title;
    public $icon;
    public $cache;
    public $cacheHttp;
    public $page_control_id;
    public $created_at;
    public $modified_at;
    public $created_by;
    public $modified_by;
    */

    #endregion

    #region Names

    #endregion

    #region Const

    #endregion

    ##region Init

    public function init()
    {
        parent::init();


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
            $config->icon = 'fal fa-edit';
            $config->hasOne = [
                'CoreControl' => [
                    'page_control_id' => 'id',
                ],
                'User' => [
                    'created_by' => 'id',
                    'modified_by' => 'id',
                ],
            ];
            $config->title = Az::l('Веб-API');
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
        'name',
        'data',
        'input',
        'check',
        'clone',
        'title',
        'icon',
        'cache',
        'cacheHttp',
        'page_control_id',
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
                                'cache',
                            ],
                            [
                                'cacheHttp',
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

        public function value(PageActionRest $model = null)
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
//        $event->beforeSave = function (PageAction $model) {
//            if (ZArrayHelper::getValue(Az::$app->params, paramNoEvent))
//                return null;
//            else
//                Az::$app->cores->appPage->action($model, $this->isNewRecord);
//        };
//
//        $event->beforeDelete = function (PageAction $model) {
//            if (ZArrayHelper::getValue(Az::$app->params, paramNoEvent))
//                return null;
//            else
//                Az::$app->cores->appPage->move_action($model);
//        };
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
    public function faker()
    {
        return null;
    }


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
     * @return \yii\db\ActiveQuery
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
     * @return \yii\db\ActiveQuery
     */            
    public function getPageControl()
    {
        return $this->hasOne(PageControl::class, [
          'id' => 'page_control_id',
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
     * @return \yii\db\ActiveQuery
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
     * @return \yii\db\ActiveQuery
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
