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


use zetsoft\dbdata\cpas\CpasTeaserData;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\system\module\Models;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\drag\DragForm;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\dbitem\data\Event;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    DragConfig
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property array $dbType
 * @property string $value
 * @property array $data
 * @property array $rules
 * @property array $widget
 * @property array $valueWidget
 * @property string $filterWidget
 * @property array $options
 * @property array $valueOptions
 * @property array $filterOptions
 * @property boolean $showForm
 * @property boolean $showDyna
 * @property boolean $showDetail
 * @property boolean $showView
 * @property array $fkTable
 * @property array $fkMulti
 * @property array $fkColumn
 * @property array $format
 * @property boolean $override
 * @property string $width
 * @property array $mergeHeader
 * @property array $contentOptions
 * @property boolean $hiddenFromExport
 * @property string $popoverWidth
 * @property string $popoverHeight
 * @property string $popoverSize
 * @property boolean $edit
 * @property boolean $filter
 * @property boolean $summary
 * @property boolean $roleShow
 * @property boolean $roleDenyEdit
 * @property boolean $roleDenyFilter
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DragConfig extends ZActiveRecord
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
    public $dbType;
    public $value;
    public $data;
    public $rules;
    public $widget;
    public $valueWidget;
    public $filterWidget;
    public $options;
    public $valueOptions;
    public $filterOptions;
    public $showForm;
    public $showDyna;
    public $showDetail;
    public $showView;
    public $fkTable;
    public $fkMulti;
    public $fkColumn;
    public $format;
    public $override;
    public $width;
    public $mergeHeader;
    public $contentOptions;
    public $hiddenFromExport;
    public $popoverWidth;
    public $popoverHeight;
    public $popoverSize;
    public $edit;
    public $filter;
    public $summary;
    public $roleShow;
    public $roleDenyEdit;
    public $roleDenyFilter;
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
        'dbType',
        'value',
        'data',
        'rules',
        'widget',
        'valueWidget',
        'filterWidget',
        'options',
        'valueOptions',
        'filterOptions',
        'showForm',
        'showDyna',
        'showDetail',
        'showView',
        'fkTable',
        'fkMulti',
        'fkColumn',
        'format',
        'override',
        'width',
        'mergeHeader',
        'contentOptions',
        'hiddenFromExport',
        'popoverWidth',
        'popoverHeight',
        'popoverSize',
        'edit',
        'filter',
        'summary',
        'roleShow',
        'roleDenyEdit',
        'roleDenyFilter',
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
    public static ?string $title = Azl . 'Системные формы';
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
			'dbType',
			'value',
			'data',
			'rules',
			'widget',
			'valueWidget',
			'filterWidget',
			'options',
			'valueOptions',
			'filterOptions',
			'showForm',
			'showDyna',
			'showDetail',
			'showView',
			'fkTable',
			'fkMulti',
			'fkColumn',
			'format',
			'override',
			'width',
			'mergeHeader',
			'contentOptions',
			'hiddenFromExport',
			'popoverWidth',
			'popoverHeight',
			'popoverSize',
			'edit',
			'filter',
			'summary',
			'roleShow',
			'roleDenyEdit',
			'roleDenyFilter',
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
                    'DragForm' => [
                        'drag_config_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Системные формы');

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


        $return = [];
        
        $raws = Form::column();
        $columns = [];
        foreach ($raws as $key => $item) {
            $columns[$key] = $item(new FormDb());
        }
        foreach ($columns as $key => $item) {

            $return[$key] = function (FormDb $column) use ($key, $item) {

                /** @var FormDb $item */
                $column->title = $item->title;
                $column->widget = $item->widget;
                $column->value = $item->value;
                //start: MurodovMirbosit 05.10.2020
                $column->data = $item->data;
                $column->dbType = $item->dbType;
                $column->readonly = $item->readonly;
                $column->readonlyWidget = $item->readonlyWidget;
                $column->valueWidget = $item->valueWidget;
                $column->filterWidget = $item->filterWidget;
                $column->dynaWidget = $item->dynaWidget;
                $column->options = $item->options;
                $column->valueOptions = $item->valueOptions;
                $column->filterOptions = $item->filterOptions;
                $column->dynaOptions = $item->dynaOptions;
                $column->fkTable = $item->fkTable;
                $column->fkQuery = $item->fkQuery;
                $column->fkOrQuery = $item->fkOrQuery;
                $column->fkAttr = $item->fkAttr;
                $column->fkAndQuery = $item->fkAndQuery;
                $column->fkMulti = $item->fkMulti;
                $column->autoValue = $item->autoValue;
                $column->auto = $item->auto;
                //end 19lines
                return $column;
            };
        }


        return $return;


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
        'dbType',
        'value',
        'data',
        'rules',
        'widget',
        'valueWidget',
        'filterWidget',
        'options',
        'valueOptions',
        'filterOptions',
        'showForm',
        'showDyna',
        'showDetail',
        'showView',
        'fkTable',
        'fkMulti',
        'fkColumn',
        'format',
        'override',
        'width',
        'mergeHeader',
        'contentOptions',
        'hiddenFromExport',
        'popoverWidth',
        'popoverHeight',
        'popoverSize',
        'edit',
        'filter',
        'summary',
        'roleShow',
        'roleDenyEdit',
        'roleDenyFilter',
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
                                'makeMenu',
                            ],
                            [
                                'genName',
                            ],
                            [
                                'makeInsert',
                            ],
                            [
                                'filter',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(DragConfig &$model = null)
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
            $event->beforeDelete = function (DragConfig $model) {
                return null;
            };

            $event->afterDelete = function (DragConfig $model) {
                return null;
            };

            $event->beforeSave = function (DragConfig $model) {
                return null;
            };

            $event->afterSave = function (DragConfig $model) {
                return null;
            };

            $event->beforeValidate = function (DragConfig $model) {
                return null;
            };

            $event->afterValidate = function (DragConfig $model) {
                return null;
            };

            $event->afterRefresh = function (DragConfig $model) {
                return null;
            };

            $event->afterFind = function (DragConfig $model) {
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
     * Function  getDragFormsWithDragConfigIdMany
     * @return  null|\yii\db\ActiveRecord[]|DragForm
     */            
    public function getDragFormsWithDragConfigIdMany()
    {
       return $this->getMany(DragForm::class, [
            'drag_config_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragFormsWithDragConfigId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragFormsWithDragConfigId()
    {
       return $this->hasMany(DragForm::class, [
            'drag_config_id' => 'id',
        ]);     
    }


    #endregion


}
