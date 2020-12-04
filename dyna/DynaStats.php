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


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\actives\ZModel;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\kernels\ZView;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\dyna\DynaConfig;
use zetsoft\dbitem\data\Config;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    DynaStats
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $dynaId
 * @property string $models
 * @property string $cols
 * @property string $rows
 * @property string $time_col
 * @property string $start_time
 * @property string $end_time
 * @property array $depend_cols
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DynaStats extends ZActiveRecord
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
    public $dynaId;
    public $models;
    public $cols;
    public $rows;
    public $time_col;
    public $start_time;
    public $end_time;
    public $depend_cols;
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
        'dynaId',
        'models',
        'cols',
        'rows',
        'time_col',
        'start_time',
        'end_time',
        'depend_cols',
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
    public static ?string $title = Azl . 'Конфигурации универсального фильтра';
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
			'dynaId',
			'models',
			'cols',
			'rows',
			'time_col',
			'start_time',
			'end_time',
			'depend_cols',
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
            $config->title = Az::l('Конфигурации универсального фильтра');
            $config->showStats = false;

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
           
            'dynaId' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('ID фильтра');
                $column->showForm = false;
                $column->showDyna = false;

                return $column;
            },
            
           

            
           
            'models' => function (FormDb $column) {

                $column->title = Az::l('Модель');
                $column->readonly = true;

                return $column;
            },
            
           
            'cols' => function (FormDb $column) {

                $column->title = Az::l('Первый атрибут');
                $column->data = static function ($modelThis) {
             
                    $th = new ZView();
                    $modelClassName = $modelThis->models;
                    if (empty($modelClassName))
                        return [];
                        
                    $modelClass = $th->bootFull($modelClassName);
                   
                    /** @var ZModel $model */
                    if (!class_exists($modelClass))
                        return [];

                    $model = new $modelClass();
                    
                    $model->configs->nameShowEx = [];

                    $model->columns();
                    $return = [];
                     
                    foreach ($model->columns as $attr => $column) {
                        if (!empty($column->data) /*|| $column->data === []*/)
                            $return[$attr] = $column->title;
                    }
                      
                    return $return;
                };

                $column->widget = ZKSelect2Widget::class;
                $column->ajax = false;
                $column->modalWidth = '1000px';
                $column->modalHeight = '1000px';

                return $column;
            },
            
           
            'rows' => function (FormDb $column) {

                $column->title = Az::l('Второй атрибут');
                $column->data = static function ($modelThis) {
                    $th = new ZView();
                    $modelClassName = $modelThis->models;
                    if (empty($modelClassName))
                        return [];

                    $modelClass = $th->bootFull($modelClassName);

                    if (!class_exists($modelClass))
                        return [];

                    /** @var ZModel $model */
                    $model = new $modelClass();
                    $model->configs->nameShowEx = [];
                    $model->columns();
                    $data = [];

                    foreach ($model->columns as $attr => $column) {
                        if ($column->dbType !== dbTypeDate && $column->dbType !== dbTypeDateTime && $column->dbType !== dbTypeTime && $column->dbType !== dbTypeTimestamp)
                            $data[$attr] = $column->title;
                    }

                    return $data;
                };

                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'time_col' => function (FormDb $column) {

                $column->title = Az::l('Столбец времени');
                $column->data = static function ($modelThis) {
                    $th = new ZView();
                    $modelClassName = $modelThis->models;
                    if (empty($modelClassName))
                        return [];

                    $modelClass = $th->bootFull($modelClassName);
                    if (!class_exists($modelClass))
                        return [];
                        
                    /** @var ZModel $model */
                    $model = new $modelClass();
                    $data = [];
                    $model->configs->nameShowEx = [];
                    $model->columns();


                   
                    foreach ($model->columns as $attr => $column) {
                        if ($column->dbType === dbTypeDate || $column->dbType === dbTypeDateTime || $column->dbType === dbTypeTime || $column->dbType === dbTypeTimestamp)
                            $data[$attr] = $column->title;
                    }

                    return $data;
                };

                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'start_time' => function (FormDb $column) {

                $column->title = Az::l('Начальное время');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;

                return $column;
            },
            
           
            'end_time' => function (FormDb $column) {

                $column->title = Az::l('Время окончания');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;

                return $column;
            },
            
           
            'depend_cols' => function (FormDb $column) {

                $column->title = Az::l('Зависит от столбцов');
                $column->dbType = dbTypeJsonb;
                $column->data = static function ($modelThis) {
                    $th = new ZView();
                    $modelClassName = $modelThis->models;
                    if (empty($modelClassName))
                        return [];
                    $modelClass = $th->bootFull($modelClassName);
                    if (!class_exists($modelClass))
                        return [];
                    /** @var ZModel $model */
                    $model = new $modelClass();
                    $data = [];

                    foreach ($model->columns as $attr => $column) {
                        if ($column->dbType !== dbTypeDate && $column->dbType !== dbTypeDateTime && $column->dbType !== dbTypeTime && $column->dbType !== dbTypeTimestamp && $column->dbType !== dbTypeJsonb)
                            $data[$attr] = $column->title;


                    }

                    return $data;
                };

                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

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
        'dynaId',
        'models',
        'cols',
        'rows',
        'time_col',
        'start_time',
        'end_time',
        'depend_cols',
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
    public function value(DynaStats &$model = null)
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
        $event->beforeDelete = function (DynaStatistics $model) {
            return null;
        };

        $event->afterDelete = function (DynaStatistics $model) {
            return null;
        };

        $event->beforeSave = function (DynaStatistics $model) {
            return null;
        };

        $event->afterSave = function (DynaStatistics $model) {
            return null;
        };

        $event->beforeValidate = function (DynaStatistics $model) {
            return null;
        };

        $event->afterValidate = function (DynaStatistics $model) {
            return null;
        };

        $event->afterRefresh = function (DynaStatistics $model) {
            return null;
        };

        $event->afterFind = function (DynaStatistics $model) {
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



    #endregion


}
