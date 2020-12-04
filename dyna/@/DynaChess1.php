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


use kartik\grid\DataColumn;
use zetsoft\dbdata\App\eyuf\RoleData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\navigat\ZButtonWidget;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;



/**
 * Class    DynaChess1
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property boolean $active
 * @property string $models
 * @property array $query
 * @property array $rols
 * @property boolean $allow
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DynaChess1 extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $sort;
    public $name;
    public $active;
    public $models;
    public $query;
    public $rols;
    public $allow;
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

    public static ?string $dbase = 'db';

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
			'active',
			'models',
			'query',
			'rols',
			'allow',
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

            $config->addSort = true;
            $config->nameAuto = false;
            $config->hasOne = [
                    'User' => [
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Универсальный отчет');
            $config->icon = 'fal fa-table';

            $config->after = [
                    'active' => [
                        [
                            'class' => 'zetsoft\\system\\column\\ZKDataColumn',
                            'label' => 'Посмотреть',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, DataColumn $dataColumn) {
                            return ZButtonWidget::widget([
                                'id' => $key,
                                'config' => [
                                    'title' => Az::l('Посмотреть'),
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
                                        },
                        ],
                    ],
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



            'models' => function (FormDb $column) {

                $column->title = Az::l('Основная модель');
                $column->data = function () {
                    return Az::$app->smart->migra->scanTitle();
                };

                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->event = function ($model){
                     $this->paramSet('chess_model', $model->models);
                };

                return $column;
            },

           'query' => function (FormDb $column) {

                $column->title = Az::l('Запрос');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->options = [
                    'config' =>[
                        'formClass' => 'zetsoft\former\deps\DepsChessQuery',
                    ],
                ];


                return $column;
            },

            'rols' => function (FormDb $column) {

                $column->title = Az::l('Роли');
                $column->data = RoleData::class;
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'multiple' => true,
                    ]

                ];
                return $column;
            },

            'allow' => function (FormDb $column) {

                $column->title = Az::l('Разрешить режим');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;

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
        'active',
        'models',
        'query',
        'rols',
        'allow',
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
                                'sort',
                                'name',
                                'active',
                                'models',
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
    public function value(DynaConfig $model = null)
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
        $event->beforeDelete = function (CoreDyna $model) {
        return null;
        };

        $event->afterDelete = function (CoreDyna $model) {
        return null;
        };

        $event->beforeSave = function (CoreDyna $model) {
        return null;
        };

        $event->afterSave = function (CoreDyna $model) {
        return null;
        };

        $event->beforeValidate = function (CoreDyna $model) {
        return null;
        };

        $event->afterValidate = function (CoreDyna $model) {
        return null;
        };

        $event->afterRefresh = function (CoreDyna $model) {
        return null;
        };

        $event->afterFind = function (CoreDyna $model) {
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
