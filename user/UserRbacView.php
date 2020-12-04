<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\user;


use zetsoft\dbdata\auth\RoleData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\models\page\PageView;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\models\page\PageViewType;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    UserRbacView
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property array $roles
 * @property array $page_view_type_ids
 * @property array $page_view_ids
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class UserRbacView extends ZActiveRecord
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
    public $roles;
    public $page_view_type_ids;
    public $page_view_ids;
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
        'roles',
        'page_view_type_ids',
        'page_view_ids',
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
    public static ?string $title = Azl . 'RBAC для View';
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
			'roles',
			'page_view_type_ids',
			'page_view_ids',
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
            $config->hasMulti = [
                    'PageViewType' => [
                        'page_view_type_ids' => 'id',
                    ],
                    'PageView' => [
                        'page_view_ids' => 'id',
                    ],
                ];
            $config->title = Az::l('RBAC для View');

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
           
            'roles' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Разрешен для:');
                $column->tooltip = Az::l('Список ролей для которых разрешен доступ');
                $column->dbType = dbTypeJsonb;
                $column->data = RoleData::class;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                $column->ajax = false;

                return $column;
            },
            
           

           
            'page_view_type_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Тип веб-модуля');
                $column->tooltip = Az::l('Тип веб-модуля');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },
            
           
            'page_view_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Веб-модуль');
                $column->tooltip = Az::l('Веб-модуль');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
						'config' =>[
							'multiple' => true,
							'ajax' => true,
						],
					];

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
        'roles',
        'page_view_type_ids',
        'page_view_ids',
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
                                'name',
                                'roles',
                                'active',
                                'page_view_folder_ids',
                                'page_view_ids',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                            public function value(UserRbac $model = null)
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
        $event->beforeDelete = function (CoreRbac $model) {
        return null;
        };

        $event->afterDelete = function (CoreRbac $model) {
        return null;
        };

        $event->beforeSave = function (CoreRbac $model) {
        return null;
        };

        $event->afterSave = function (CoreRbac $model) {
        return null;
        };

        $event->beforeValidate = function (CoreRbac $model) {
        return null;
        };

        $event->afterValidate = function (CoreRbac $model) {
        return null;
        };

        $event->afterRefresh = function (CoreRbac $model) {
        return null;
        };

        $event->afterFind = function (CoreRbac $model) {
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


    /**
     *
     * Function  getPageViewTypesFromPageViewTypeIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|PageViewType
     */            
    public function getPageViewTypesFromPageViewTypeIdsMulti()
    {
        return $this->getMulti(PageViewType::class, [
          'id' => 'page_view_type_ids',
      ]);    
    }

    /**
     *
     * Function  getPageViewsFromPageViewIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|PageView
     */            
    public function getPageViewsFromPageViewIdsMulti()
    {
        return $this->getMulti(PageView::class, [
          'id' => 'page_view_ids',
      ]);    
    }


    #endregion
    
    #region Many



    #endregion


}
