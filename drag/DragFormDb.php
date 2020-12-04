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
use zetsoft\former\deps\DepsDataForm;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\drag\DragConfig;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\former\auth\AuthPhoneForm;
use zetsoft\models\drag\DragConfigDb;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\dbitem\data\Event;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\system\actives\ZActiveQuery;



/**
 * Class    DragFormDb
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $drag_config_db_id
 * @property int $length
 * @property string $check
 * @property string $defaultValue
 * @property string $defaultExpression
 * @property string $append
 * @property boolean $notNull
 * @property boolean $unsigned
 * @property boolean $index
 * @property boolean $indexUnique
 * @property boolean $isPKey
 * @property boolean $fkCreate
 * @property string $tooltip
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
 * @property string $width
 * @property string $mergeHeader
 * @property string $contentOptions
 * @property boolean $hiddenFromExport
 * @property int $popoverWidth
 * @property int $popoverHeight
 * @property int $popoverSize
 * @property boolean $edit
 * @property boolean $filter
 * @property boolean $summary
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
class DragFormDb extends ZActiveRecord
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
    public $drag_config_db_id;
    public $length;
    public $check;
    public $defaultValue;
    public $defaultExpression;
    public $append;
    public $notNull;
    public $unsigned;
    public $index;
    public $indexUnique;
    public $isPKey;
    public $fkCreate;
    public $tooltip;
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
        'drag_config_db_id',
        'length',
        'check',
        'defaultValue',
        'defaultExpression',
        'append',
        'notNull',
        'unsigned',
        'index',
        'indexUnique',
        'isPKey',
        'fkCreate',
        'tooltip',
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
    public static ?string $title = Azl . 'Колонки моделей';
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
			'drag_config_db_id',
			'length',
			'check',
			'defaultValue',
			'defaultExpression',
			'append',
			'notNull',
			'unsigned',
			'index',
			'indexUnique',
			'isPKey',
			'fkCreate',
			'tooltip',
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
                    'DragConfigDb' => [
                        'drag_config_db_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Колонки моделей');

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
           
            'drag_config_db_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Модель');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'drag_config_db';

                return $column;
            },
            
           
            'length' => function (FormDb $column) {

                $column->title = Az::l('Длина значения');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKTouchSpinWidget::class;

                return $column;
            },
            
           
            'check' => function (FormDb $column) {

                $column->title = Az::l('check');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'defaultValue' => function (FormDb $column) {

                $column->title = Az::l('Значение по умолчанию');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'defaultExpression' => function (FormDb $column) {

                $column->title = Az::l('defaultExpression');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'append' => function (FormDb $column) {

                $column->title = Az::l('append');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'notNull' => function (FormDb $column) {

                $column->title = Az::l('notNull');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->widget = ZMCheckboxWidget::class;
                $column->filterWidget = ZMCheckboxWidget::class;

                return $column;
            },
            
           
            'unsigned' => function (FormDb $column) {

                $column->title = Az::l('unsigned');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'index' => function (FormDb $column) {

                $column->title = Az::l('index');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'indexUnique' => function (FormDb $column) {

                $column->title = Az::l('indexUnique');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'isPKey' => function (FormDb $column) {

                $column->title = Az::l('isPKey');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'fkCreate' => function (FormDb $column) {

                $column->title = Az::l('fkCreate');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           

           
            'tooltip' => function (FormDb $column) {

                $column->title = Az::l('tooltip');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'dbType' => function (FormDb $column) {

                $column->title = Az::l('Тип в базе данных');
                $column->data = DbTypeData::class;
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'value' => function (FormDb $column) {

                $column->title = Az::l('Значение');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'data' => function (FormDb $column) {

                $column->title = Az::l('Данные для массива');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->options = [
						'config' =>[
							'formClass' => 'zetsoft\former\deps\DepsDataForm',
						],
					];
                $column->filterOptions = [
						'config' =>[
							'formClass' => 'zetsoft\former\deps\DepsDataForm',
						],
					];
                $column->showDyna = false;
                $column->showDetail = false;
                $column->showView = false;

                return $column;
            },
            
           
            'rules' => function (FormDb $column) {

                $column->title = Az::l('Валидации');
                $column->dbType = dbTypeJsonb;
                $column->data = RuleData::class;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;
                $column->showDyna = false;

                return $column;
            },
            
           
            'widget' => function (FormDb $column) {

                $column->title = Az::l('Виджет');
                $column->data = WidgetData::class;
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'valueWidget' => function (FormDb $column) {

                $column->title = Az::l('Виджет значения');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'filterWidget' => function (FormDb $column) {

                $column->title = Az::l('Виджет для фильтра');
                $column->value = '';
                $column->data = WidgetData::class;
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
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
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'showDyna' => function (FormDb $column) {

                $column->title = Az::l('Показать в ZDynaWidget?');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'showDetail' => function (FormDb $column) {

                $column->title = Az::l('Показать в ZDetailWidget?');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'showView' => function (FormDb $column) {

                $column->title = Az::l('Показать в ZViewWidget?');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'fkTable' => function (FormDb $column) {

                $column->title = Az::l('fkTable');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'fkMulti' => function (FormDb $column) {

                $column->title = Az::l('fkMulti');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->rules = [
                    [
                        validatorBoolean,
                    ],
                ];
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'fkColumn' => function (FormDb $column) {

                $column->title = Az::l('fkColumn');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'format' => function (FormDb $column) {

                $column->title = Az::l('Формат колонки');
                $column->data = [
                    'text' => Az::l('text'),
                    'raw' => Az::l('raw'),
                    'html' => Az::l('html'),
                ];
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'override' => function (FormDb $column) {

                $column->title = Az::l('override');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->rules = [
                    [
                        validatorBoolean,
                    ],
                ];
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'width' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Ширина колонки');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'mergeHeader' => function (FormDb $column) {

                $column->title = Az::l('mergeHeader');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'contentOptions' => function (FormDb $column) {

                $column->title = Az::l('contentOptions');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'hiddenFromExport' => function (FormDb $column) {

                $column->title = Az::l('hiddenFromExport');
                $column->dbType = dbTypeBoolean;
                $column->value = false;
                $column->rules = [
                    [
                        validatorBoolean,
                    ],
                ];
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'popoverWidth' => function (FormDb $column) {

                $column->title = Az::l('Ширина Popover');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },
            
           
            'popoverHeight' => function (FormDb $column) {

                $column->title = Az::l('Высота Popover');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },
            
           
            'popoverSize' => function (FormDb $column) {

                $column->title = Az::l('Размер Popover');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },
            
           
            'edit' => function (FormDb $column) {

                $column->title = Az::l('Редактировать Колонку?');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = [
                    [
                        validatorBoolean,
                    ],
                ];
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'filter' => function (FormDb $column) {

                $column->title = Az::l('Включить Фильтр?');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = [
                    [
                        validatorBoolean,
                    ],
                ];
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'summary' => function (FormDb $column) {

                $column->title = Az::l('Показать Сумму');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = [
                    [
                        validatorBoolean,
                    ],
                ];
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

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
        'drag_config_db_id',
        'length',
        'check',
        'defaultValue',
        'defaultExpression',
        'append',
        'notNull',
        'unsigned',
        'index',
        'indexUnique',
        'isPKey',
        'fkCreate',
        'tooltip',
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
                                'drag_config_db_id',
                            ],
                            [
                                'length',
                            ],
                            [
                                'check',
                            ],
                            [
                                'defaultValue',
                            ],
                            [
                                'defaultExpression',
                            ],
                            [
                                'append',
                            ],
                            [
                                'notNull',
                            ],
                            [
                                'unsigned',
                            ],
                            [
                                'index',
                            ],
                            [
                                'indexUnique',
                            ],
                            [
                                'isPKey',
                            ],
                            [
                                'fkCreate',
                            ],
                            [
                                'title',
                            ],
                            [
                                'tooltip',
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
                                'popoverWidth',
                            ],
                            [
                                'popoverHeight',
                            ],
                            [
                                'popoverSize',
                            ],
                            [
                                'edit',
                            ],
                            [
                                'filter',
                            ],
                            [
                                'summary',
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
    public function value(DragFormDb &$model = null)
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
        $event->beforeDelete = function (DragFormDb $model) {
            return null;
        };

        $event->afterDelete = function (DragFormDb $model) {
            return null;
        };

        $event->beforeSave = function (DragFormDb $model) {
            return null;
        };

        $event->afterSave = function (DragFormDb $model) {
            return null;
        };

        $event->beforeValidate = function (DragFormDb $model) {
            return null;
        };

        $event->afterValidate = function (DragFormDb $model) {
            return null;
        };

        $event->afterRefresh = function (DragFormDb $model) {
            return null;
        };

        $event->afterFind = function (DragFormDb $model) {
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
     * Function  getDragConfigDb
     * @return bool|\yii\db\ActiveRecord|DragConfigDb|null
     */            
    public function getDragConfigDbOne()
    {
        return $this->getOne(DragConfigDb::class, [
          'id' => 'drag_config_db_id',
      ]);    
    }
    
     /**
     *
     * Function  getDragConfigDb
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getDragConfigDb()
    {
        return $this->hasOne(DragConfigDb::class, [
          'id' => 'drag_config_db_id',
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
