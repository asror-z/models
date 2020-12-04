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


use zetsoft\dbdata\data\DbTypeData;
use zetsoft\dbdata\core\RuleData;
use zetsoft\dbdata\wdg\WidgetData;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\drag\DragConfig;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\models\drag\DragConfigDb;
use zetsoft\dbitem\data\Event;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    DragForm
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $drag_config_id
 * @property string $dbType
 * @property string $value
 * @property array $data
 * @property array $rules
 * @property string $widget
 * @property string $valueWidget
 * @property string $filterWidget
 * @property array $options
 * @property array $valueOptions
 * @property array $filterOptions
 * @property boolean $showForm
 * @property boolean $showDyna
 * @property boolean $showDetail
 * @property boolean $showView
 * @property string $fkTable
 * @property boolean $fkMulti
 * @property string $fkColumn
 * @property string $format
 * @property boolean $override
 * @property int $width
 * @property boolean $mergeHeader
 * @property array $contentOptions
 * @property boolean $hiddenFromExport
 * @property string $popoverSize
 * @property int $popoverWidth
 * @property int $popoverHeight
 * @property boolean $edit
 * @property boolean $filter
 * @property array $roleShow
 * @property array $roleDenyEdit
 * @property array $roleDenyFilter
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DragForm extends ZActiveRecord
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
    public $drag_config_id;
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
    public $popoverSize;
    public $popoverWidth;
    public $popoverHeight;
    public $edit;
    public $filter;
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
        'drag_config_id',
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
        'popoverSize',
        'popoverWidth',
        'popoverHeight',
        'edit',
        'filter',
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

    /* @var array $_format*/
    public $_format;  
    public const format = [
        'text' => 'text',
        'raw' => 'raw',
        'html' => 'html',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Колонки форм';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_format = [
            'text' => Az::l('text'),
            'raw' => Az::l('raw'),
            'html' => Az::l('html'),
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
			'drag_config_id',
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
			'popoverSize',
			'popoverWidth',
			'popoverHeight',
			'edit',
			'filter',
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
                    'DragConfig' => [
                        'drag_config_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Колонки форм');

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
           
            'drag_config_id' => function (FormDb $column) {

                $column->title = Az::l('Модель');
                $column->rules = validatorString;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'drag_config';
                $column->override = true;

                return $column;
            },
            

            
           
            'dbType' => function (FormDb $column) {

                $column->title = Az::l('Тип в базе данных');
                $column->data = DbTypeData::class;
                $column->rules = validatorString;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'value' => function (FormDb $column) {

                $column->title = Az::l('Значение');
                $column->rules = validatorString;

                return $column;
            },
            
           
            'data' => function (FormDb $column) {

                $column->title = Az::l('Данные для массива');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },
            
           
            'rules' => function (FormDb $column) {

                $column->title = Az::l('Валидации');
                $column->dbType = dbTypeJsonb;
                $column->data = RuleData::class;
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                $column->multiple = true;

                return $column;
            },
            
           
            'widget' => function (FormDb $column) {

                $column->title = Az::l('Виджет');
                $column->value = '';
                $column->data = WidgetData::class;
                $column->rules = validatorString;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'valueWidget' => function (FormDb $column) {

                $column->title = Az::l('Виджет значения');
                $column->rules = validatorString;

                return $column;
            },
            
           
            'filterWidget' => function (FormDb $column) {

                $column->title = Az::l('Виджет для фильтра');
                $column->value = '';
                $column->data = WidgetData::class;
                $column->rules = validatorString;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'options' => function (FormDb $column) {

                $column->title = Az::l('Опции виджета');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;
                $column->showForm = false;
                $column->showDyna = false;

                return $column;
            },
            
           
            'valueOptions' => function (FormDb $column) {

                $column->title = Az::l('valueOptions');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },
            
           
            'filterOptions' => function (FormDb $column) {

                $column->title = Az::l('Опции фильтра');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },
            
           
            'showForm' => function (FormDb $column) {

                $column->title = Az::l('Показать в ZFormWidget?');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'showDyna' => function (FormDb $column) {

                $column->title = Az::l('Показать в ZDynaWidget?');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'showDetail' => function (FormDb $column) {

                $column->title = Az::l('Показать в ZDetailWidget?');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'showView' => function (FormDb $column) {

                $column->title = Az::l('Показать в ZViewWidget?');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'fkTable' => function (FormDb $column) {

                $column->title = Az::l('fkTable');
                $column->rules = validatorString;

                return $column;
            },
            
           
            'fkMulti' => function (FormDb $column) {

                $column->title = Az::l('fkMulti');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'fkColumn' => function (FormDb $column) {

                $column->title = Az::l('fkColumn');
                $column->rules = validatorString;

                return $column;
            },
            
           
            'format' => function (FormDb $column) {

                $column->title = Az::l('Формат колонки');
                $column->data = [
                    'text' => Az::l('text'),
                    'raw' => Az::l('raw'),
                    'html' => Az::l('html'),
                ];
                $column->rules = validatorString;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'override' => function (FormDb $column) {

                $column->title = Az::l('override');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'width' => function (FormDb $column) {

                $column->title = Az::l('Ширина колонки');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'mergeHeader' => function (FormDb $column) {

                $column->title = Az::l('mergeHeader');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'contentOptions' => function (FormDb $column) {

                $column->title = Az::l('contentOptions');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },
            
           
            'hiddenFromExport' => function (FormDb $column) {

                $column->title = Az::l('hiddenFromExport');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'popoverSize' => function (FormDb $column) {

                $column->title = Az::l('Размер Popover');
                $column->rules = validatorString;

                return $column;
            },
            
           
            'popoverWidth' => function (FormDb $column) {

                $column->title = Az::l('Ширина Popover');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'popoverHeight' => function (FormDb $column) {

                $column->title = Az::l('Высота Popover');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'edit' => function (FormDb $column) {

                $column->title = Az::l('Редактировать Колонку?');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'filter' => function (FormDb $column) {

                $column->title = Az::l('Включить Фильтр?');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'roleShow' => function (FormDb $column) {

                $column->title = Az::l('Запрет для ролей');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },
            
           
            'roleDenyEdit' => function (FormDb $column) {

                $column->title = Az::l('Запрет для редактитрования');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },
            
           
            'roleDenyFilter' => function (FormDb $column) {

                $column->title = Az::l('Запрет для фильтра');
                $column->dbType = dbTypeJsonb;
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
        'drag_config_id',
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
        'popoverSize',
        'popoverWidth',
        'popoverHeight',
        'edit',
        'filter',
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
                                'drag_config_id',
                            ],
                            [
                                'title',
                            ],
                            [
                                'dbType',
                            ],
                            [
                                'value',
                            ],
                            [
                                'data',
                            ],
                            [
                                'rules',
                            ],
                            [
                                'widget',
                            ],
                            [
                                'valueWidget',
                            ],
                            [
                                'filterWidget',
                            ],
                            [
                                'options',
                            ],
                            [
                                'valueOptions',
                            ],
                            [
                                'filterOptions',
                            ],
                            [
                                'showForm',
                            ],
                            [
                                'showDyna',
                            ],
                            [
                                'showDetail',
                            ],
                            [
                                'showView',
                            ],
                            [
                                'fkTable',
                            ],
                            [
                                'fkMulti',
                            ],
                            [
                                'fkColumn',
                            ],
                            [
                                'format',
                            ],
                            [
                                'override',
                            ],
                            [
                                'width',
                            ],
                            [
                                'mergeHeader',
                            ],
                            [
                                'contentOptions',
                            ],
                            [
                                'hiddenFromExport',
                            ],
                            [
                                'popoverSize',
                            ],
                            [
                                'popoverWidth',
                            ],
                            [
                                'popoverHeight',
                            ],
                            [
                                'edit',
                            ],
                            [
                                'filter',
                            ],
                            [
                                'roleShow',
                            ],
                            [
                                'roleDenyEdit',
                            ],
                            [
                                'roleDenyFilter',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(DragForm &$model = null)
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
        $event->beforeDelete = function (DragForm $model) {
            return null;
        };

        $event->afterDelete = function (DragForm $model) {
            return null;
        };

        $event->beforeSave = function (DragForm $model) {
            return null;
        };

        $event->afterSave = function (DragForm $model) {
            return null;
        };

        $event->beforeValidate = function (DragForm $model) {
            return null;
        };

        $event->afterValidate = function (DragForm $model) {
            return null;
        };

        $event->afterRefresh = function (DragForm $model) {
            return null;
        };

        $event->afterFind = function (DragForm $model) {
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
     * Function  getDragConfig
     * @return bool|\yii\db\ActiveRecord|DragConfig|null
     */            
    public function getDragConfigOne()
    {
        return $this->getOne(DragConfig::class, [
          'id' => 'drag_config_id',
      ]);    
    }
    
     /**
     *
     * Function  getDragConfig
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getDragConfig()
    {
        return $this->hasOne(DragConfig::class, [
          'id' => 'drag_config_id',
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
