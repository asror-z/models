<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\drag;


use kartik\grid\DataColumn;
use zetsoft\dbdata\core\RuleData;
use zetsoft\dbdata\wdg\WidgetData;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\card\CardModelForm;
use zetsoft\system\column\ZKDataColumn;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZFileHelper;
use zetsoft\system\helpers\ZInflector;
use zetsoft\system\validate\VisualsValidator;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\drag\DragForm;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\drag\DragConfig;
use zetsoft\models\drag\DragFormDb;
use zetsoft\dbitem\data\Event;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    DragConfigDb
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $class_name
 * @property array $card
 * @property string $dbase
 * @property string $lang
 * @property boolean $addID
 * @property boolean $addBy
 * @property string $icon
 * @property boolean $relationBtn
 * @property boolean $extraConfig
 * @property boolean $extraColumn
 * @property boolean $makeMenu
 * @property boolean $genName
 * @property boolean $makeInsert
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DragConfigDb extends ZActiveRecord
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
    public $class_name;
    public $card;
    public $dbase;
    public $lang;
    public $addID;
    public $addBy;
    public $icon;
    public $relationBtn;
    public $extraConfig;
    public $extraColumn;
    public $makeMenu;
    public $genName;
    public $makeInsert;
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
        'class_name',
        'card',
        'dbase',
        'lang',
        'addID',
        'addBy',
        'icon',
        'relationBtn',
        'extraConfig',
        'extraColumn',
        'makeMenu',
        'genName',
        'makeInsert',
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
    public static ?string $title = Azl . 'Системные Модели';
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
			'class_name',
			'card',
			'dbase',
			'lang',
			'addID',
			'addBy',
			'icon',
			'relationBtn',
			'extraConfig',
			'extraColumn',
			'makeMenu',
			'genName',
			'makeInsert',
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
                    'DragFormDb' => [
                        'drag_config_db_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Системные Модели');

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
           
            'class_name' => function (FormDb $column) {

                $column->title = Az::l('Название класса');
                $column->rules = [
                    [
                        validatorUnique,
                    ],
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'card' => function (FormDb $column) {

                $column->title = Az::l('Generate cards');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->options = [
						'config' =>[
							'formClass' => 'zetsoft\former\card\CardModelForm',
						],
					];
                $column->showDyna = false;

                return $column;
            },
            
           
            'dbase' => function (FormDb $column) {

                $column->title = Az::l('Data base');
                $column->value = 'db';
                $column->rules = validatorString;

                return $column;
            },
            
           
            'lang' => function (FormDb $column) {

                $column->title = Az::l('Язык');
                $column->value = 'ru';
                $column->rules = validatorString;

                return $column;
            },
            
           
            'addID' => function (FormDb $column) {

                $column->title = Az::l('Add ID');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'addBy' => function (FormDb $column) {

                $column->title = Az::l('Add By');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           

            
           
            'icon' => function (FormDb $column) {

                $column->title = Az::l('Иконка');
                $column->value = 'fal fa-graduation-cap';
                $column->rules = validatorString;

                return $column;
            },
            
           
            'relationBtn' => function (FormDb $column) {

                $column->title = Az::l('Показать кнопку отношений формы');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'extraConfig' => function (FormDb $column) {

                $column->title = Az::l('extraConfig');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'extraColumn' => function (FormDb $column) {

                $column->title = Az::l('extraColumn');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'makeMenu' => function (FormDb $column) {

                $column->title = Az::l('Generate CRUD');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'genName' => function (FormDb $column) {

                $column->title = Az::l('Generate name');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'makeInsert' => function (FormDb $column) {

                $column->title = Az::l('Generate insert');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
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
        'class_name',
        'card',
        'dbase',
        'lang',
        'addID',
        'addBy',
        'icon',
        'relationBtn',
        'extraConfig',
        'extraColumn',
        'makeMenu',
        'genName',
        'makeInsert',
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
                                'class_name',
                            ],
                            [
                                'card',
                            ],
                            [
                                'dbase',
                            ],
                            [
                                'lang',
                            ],
                            [
                                'addID',
                            ],
                            [
                                'addBy',
                            ],
                            [
                                'title',
                            ],
                            [
                                'icon',
                            ],
                            [
                                'relationBtn',
                            ],
                            [
                                'extraConfig',
                            ],
                            [
                                'extraColumn',
                            ],
                            [
                                'makeMenu',
                            ],
                            [
                                'genName',
                            ],
                            [
                                'makeInsert',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(DragConfigDb &$model = null)
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
        $event->beforeDelete = function (DragConfigDb $model) {
            return null;
        };

        $event->afterDelete = function (DragConfigDb $model) {
            return null;
        };

        $event->beforeSave = function (DragConfigDb $model) {
            return null;
        };

        $event->afterSave = function (DragConfigDb $model) {
            return null;
        };

        $event->beforeValidate = function (DragConfigDb $model) {
            return null;
        };

        $event->afterValidate = function (DragConfigDb $model) {
            return null;
        };

        $event->afterRefresh = function (DragConfigDb $model) {
            return null;
        };

        $event->afterFind = function (DragConfigDb $model) {
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
     * Function  getDragFormDbsWithDragConfigDbIdMany
     * @return  null|\yii\db\ActiveRecord[]|DragFormDb
     */            
    public function getDragFormDbsWithDragConfigDbIdMany()
    {
       return $this->getMany(DragFormDb::class, [
            'drag_config_db_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragFormDbsWithDragConfigDbId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragFormDbsWithDragConfigDbId()
    {
       return $this->hasMany(DragFormDb::class, [
            'drag_config_db_id' => 'id',
        ]);     
    }


    #endregion


}
