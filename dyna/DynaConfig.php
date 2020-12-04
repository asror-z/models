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
use zetsoft\dbitem\data\FormDb;
use zetsoft\service\forms\Modelz;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\system\module\Models;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZCKEditorWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\dyna\DynaMulti;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    DynaConfig
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property array $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $dynaId
 * @property array $column
 * @property array $config
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DynaConfig extends ZActiveRecord
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
    public $column;
    public $config;
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
        'column',
        'config',
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
    public static ?string $title = Azl . 'Настройки вариантов отчёта';
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
			'column',
			'config',
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
                    'DynaMulti' => [
                        'dyna_config_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Настройки вариантов отчёта');

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

                return $column;
            },
            
           

           
            'column' => function (FormDb $column) {

                $column->title = Az::l('Настройки колонок');
                $column->dbType = dbTypeJsonb;
                $column->showDyna = false;

                return $column;
            },
            
           
            'config' => function (FormDb $column) {

                $column->title = Az::l('Настройки таблицы');
                $column->dbType = dbTypeJsonb;
                $column->showDyna = false;

                return $column;
            },
            
           
            'sort' => function (FormDb $column) {

                $column->title = Az::l('Сортировка колонок');
                $column->dbType = dbTypeJsonb;
                $column->showDyna = false;

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
        'column',
        'config',
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
                                'dynaId',
                            ],
                            [
                                'column',
                            ],
                            [
                                'config',
                            ],
                            [
                                'sort',
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
        $event->beforeSave = static function (DynaConfig $model) {

            if ($model->active) {

                /** @var Models $class */
                $class = $model->clazz;

                $configs = $class::find()
                    ->where([
                        'active' => true,
                        'dynaId' => $model->dynaId,
                    ])
                    ->all();

                /** @var DynaConfig $config */
                foreach ($configs as $config) {

                    if ($config->id === $model->id)
                        continue;

                    $config->active = false;
                    $config->configs->rules = [
                        [
                            validatorSafe
                        ]
                    ];
                    $config->save();
                }

            }

        };

        /*
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
     * Function  getDynaMultisWithDynaConfigIdMany
     * @return  null|\yii\db\ActiveRecord[]|DynaMulti
     */            
    public function getDynaMultisWithDynaConfigIdMany()
    {
       return $this->getMany(DynaMulti::class, [
            'dyna_config_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaMultisWithDynaConfigId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaMultisWithDynaConfigId()
    {
       return $this->hasMany(DynaMulti::class, [
            'dyna_config_id' => 'id',
        ]);     
    }


    #endregion


}
