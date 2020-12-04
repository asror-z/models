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
use zetsoft\dbdata\App\mplace\RoleData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\navigat\ZButtonWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\dyna\DynaChessItem;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\models\dyna\DynaChessQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    DynaChess
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $models
 * @property array $model_query
 * @property array $rols
 * @property boolean $allow
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DynaChess extends ZActiveRecord
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
    public $models;
    public $model_query;
    public $rols;
    public $allow;
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
        'models',
        'model_query',
        'rols',
        'allow',
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
    public static ?string $title = Azl . 'Универсальный отчет';
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
			'models',
			'model_query',
			'rols',
			'allow',
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
                    'DynaChessItem' => [
                        'dyna_chess_id' => 'id',
                    ],
                    'DynaChessQuery' => [
                        'dyna_chess_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Универсальный отчет');

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
                $column->event = function ($model) {
                    Az::$app->utility->mains->paramSet('chess_model', $model->models);
                };

                return $column;
            },

            'model_query' => function (FormDb $column) {

                $column->title = Az::l('Запрос');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->options = [
                    'config' => [
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
        'title',
        'tranz',
        'accept',
        'active',
        'models',
        'model_query',
        'rols',
        'allow',
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
     * Function  getDynaChessItemsWithDynaChessIdMany
     * @return  null|\yii\db\ActiveRecord[]|DynaChessItem
     */            
    public function getDynaChessItemsWithDynaChessIdMany()
    {
       return $this->getMany(DynaChessItem::class, [
            'dyna_chess_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaChessItemsWithDynaChessId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaChessItemsWithDynaChessId()
    {
       return $this->hasMany(DynaChessItem::class, [
            'dyna_chess_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaChessQueriesWithDynaChessIdMany
     * @return  null|\yii\db\ActiveRecord[]|DynaChessQuery
     */            
    public function getDynaChessQueriesWithDynaChessIdMany()
    {
       return $this->getMany(DynaChessQuery::class, [
            'dyna_chess_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaChessQueriesWithDynaChessId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaChessQueriesWithDynaChessId()
    {
       return $this->hasMany(DynaChessQuery::class, [
            'dyna_chess_id' => 'id',
        ]);     
    }


    #endregion


}
