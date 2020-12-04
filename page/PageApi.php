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
use zetsoft\models\page\PageViewType;
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
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\models\page\PageApiType;
use zetsoft\dbitem\data\Form;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    PageApi
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $icon
 * @property string $type
 * @property boolean $check
 * @property int $page_api_type_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class PageApi extends ZActiveRecord
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
    public $icon;
    public $type;
    public $check;
    public $page_api_type_id;
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
        'icon',
        'type',
        'check',
        'page_api_type_id',
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
        'ajaxFile' => 'ajaxFile',
        'partFile' => 'partFile',
        'ajaxFilePreg' => 'ajaxFilePreg',
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
            'ajaxFile' => Az::l('ajaxFile'),
            'partFile' => Az::l('partFile'),
            'ajaxFilePreg' => Az::l('ajaxFilePreg'),
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
			'icon',
			'type',
			'check',
			'page_api_type_id',
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

            $config->title = Az::l('Веб-действия');
            $config->tooltip = Az::l('API модули');
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
           

            
           
            'icon' => function (FormDb $column) {

                $column->title = Az::l('Иконка');
                $column->widget = ZIconPickerWidget::class;

                return $column;
            },
            
           
            'type' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Тип');
                $column->data = [
                    'html' => Az::l('html'),
                    'ajax' => Az::l('ajax'),
                    'part' => Az::l('part'),
                    'ajaxFile' => Az::l('ajaxFile'),
                    'partFile' => Az::l('partFile'),
                    'ajaxFilePreg' => Az::l('ajaxFilePreg'),
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->width = '400px';

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
            
           
            'page_api_type_id' => function (FormDb $column) {

                $column->title = Az::l('Вышестоящий');
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
        'icon',
        'type',
        'check',
        'page_api_type_id',
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
    public function value(PageApi &$model = null)
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
        $event->beforeDelete = function (PageApi $model) {
            return null;
        };

        $event->afterDelete = function (PageApi $model) {
            return null;
        };

        $event->beforeSave = function (PageApi $model) {
            return null;
        };

        $event->afterSave = function (PageApi $model) {
            return null;
        };

        $event->beforeValidate = function (PageApi $model) {
            return null;
        };

        $event->afterValidate = function (PageApi $model) {
            return null;
        };

        $event->afterRefresh = function (PageApi $model) {
            return null;
        };

        $event->afterFind = function (PageApi $model) {
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
     * Function  getPageApiType
     * @return bool|\yii\db\ActiveRecord|PageApiType|null
     */            
    public function getPageApiTypeOne()
    {
        return $this->getOne(PageApiType::class, [
          'id' => 'page_api_type_id',
      ]);    
    }
    
     /**
     *
     * Function  getPageApiType
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPageApiType()
    {
        return $this->hasOne(PageApiType::class, [
          'id' => 'page_api_type_id',
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
