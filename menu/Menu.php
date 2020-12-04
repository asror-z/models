<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\menu;


use kartik\grid\DataColumn;
use zetsoft\dbdata\auth\RoleData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\column\ZKDataColumn;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZIconPickerWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\dbitem\data\Event;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\navigat\ZButtonWidget;
use zetsoft\models\menu\MenuImage;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    Menu
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property boolean $inline
 * @property string $target
 * @property string $icon
 * @property array $role
 * @property array $json
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class Menu extends ZActiveRecord
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
    public $inline;
    public $target;
    public $icon;
    public $role;
    public $json;
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
        'inline',
        'target',
        'icon',
        'role',
        'json',
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

    /* @var array $_target*/
    public $_target;  
    public const target = [
        '_blank' => '_blank',
        '_self' => '_self',
        '_parent' => '_parent',
        '_top' => '_top',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Меню';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_target = [
            '_blank' => Az::l('_blank'),
            '_self' => Az::l('_self'),
            '_parent' => Az::l('_parent'),
            '_top' => Az::l('_top'),
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
			'inline',
			'target',
			'icon',
			'role',
			'json',
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
                    'MenuImage' => [
                        'menu_id' => 'id',
                    ],
                ];
            $config->after = [
                    'title' => [
                        [
                            'class' => 'zetsoft\\system\\column\\ZKDataColumn',
                            'label' => 'Редактировать',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, DataColumn $dataColumn) {
                            return ZButtonWidget::widget([
                                'id' => 'edit-menu-' . $key,
                                'config' => [
                                    'title' => Az::l('Редактировать'),
                                    'icon' => 'fas fa-edit',
                                    'pjax' => 0,
                                    'url' => '/core/menu/editor.aspx?id=' . $key,
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
            $config->title = Az::l('Меню');

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



            'inline' => function (FormDb $column) {

                $column->title = Az::l('Список ?');
                $column->tooltip = Az::l('Вложенность меню - возможность добавления дочерного меню');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },

            'target' => function (FormDb $column) {

                $column->title = Az::l('Открыть в новом окне ?');
                $column->dbType = dbTypeString;
                $column->widget = ZKSelect2Widget::class;
                $column->data = [
                    '_blank' => '_blank',
                    '_self' => '_self',
                    '_parent' => '_parent',
                    '_top' => '_top',
                ];

                return $column;
            },


            'icon' => function (FormDb $column) {

                $column->title = Az::l('Иконка');
                $column->tooltip = Az::l('Иконка отображаемое в меню');
                $column->widget = ZIconPickerWidget::class;

                return $column;
            },


            'role' => function (FormDb $column) {

                $column->title = Az::l('Показать для:');
                $column->tooltip = Az::l('Роли для тех кому будут доступны');
                $column->dbType = dbTypeJsonb;
                $column->data = RoleData::class;
                $column->ajax = false;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },


            'json' => function (FormDb $column) {

                $column->title = Az::l('Json');
                $column->tooltip = Az::l('Дочерние меню в формате Json');
                $column->dbType = dbTypeJsonb;
                $column->showForm = false;
                $column->showDyna = false;
                return $column;
            },


            'sort' => function (FormDb $column) {

                $column->title = Az::l('Сортировка');
                $column->tooltip = Az::l('Сортировка меню');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->showForm = false;
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
        'inline',
        'target',
        'icon',
        'role',
        'json',
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
                                'active',
                            ],
                            [
                                'inline',
                            ],
                            [
                                'title',
                            ],
                            [
                                'icon',
                            ],
                            [
                                'role',
                            ],
                            [
                                'json',
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
    public function value(Menu &$model = null)
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
            $event->beforeDelete = function (Menu $model) {
                return null;
            };

            $event->afterDelete = function (Menu $model) {
                return null;
            };

            $event->beforeSave = function (Menu $model) {
                return null;
            };

            $event->afterSave = function (Menu $model) {
                return null;
            };

            $event->beforeValidate = function (Menu $model) {
                return null;
            };

            $event->afterValidate = function (Menu $model) {
                return null;
            };

            $event->afterRefresh = function (Menu $model) {
                return null;
            };

            $event->afterFind = function (Menu $model) {
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
     * Function  getMenuImagesWithMenuIdMany
     * @return  null|\yii\db\ActiveRecord[]|MenuImage
     */            
    public function getMenuImagesWithMenuIdMany()
    {
       return $this->getMany(MenuImage::class, [
            'menu_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getMenuImagesWithMenuId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getMenuImagesWithMenuId()
    {
       return $this->hasMany(MenuImage::class, [
            'menu_id' => 'id',
        ]);     
    }


    #endregion


}
