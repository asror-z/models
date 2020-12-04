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


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\lang\LanguageForm;
use zetsoft\former\eyuf\EyufNeedForm;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZIconPickerWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\models\menu\Menu;
use zetsoft\models\user\User;
use zetsoft\dbitem\data\Form;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    MenuImage
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property array $image
 * @property string $target
 * @property string $location
 * @property string $url
 * @property array $role
 * @property int $menu_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class MenuImage extends ZActiveRecord
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
    public $image;
    public $target;
    public $location;
    public $url;
    public $role;
    public $menu_id;
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
        'image',
        'target',
        'location',
        'url',
        'role',
        'menu_id',
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
        'self' => 'self',
        'blank' => 'blank',
    ];

    /* @var array $_location*/
    public $_location;  
    public const location = [
        'right' => 'right',
        'bottom' => 'bottom',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Рисунок меню';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_target = [
            'self' => Az::l('в текущей вкладке'),
            'blank' => Az::l('в новой вкладке'),
        ];
        
        $this->_location = [
            'right' => Az::l('Справа'),
            'bottom' => Az::l('Снизу'),
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
			'image',
			'target',
			'location',
			'url',
			'role',
			'menu_id',
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
                    'Menu' => [
                        'menu_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->name = 'title';

            $config->title = Az::l('Рисунок меню');

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
           
            'image' => function (FormDb $column) {

                $column->title = Az::l('Картина');
                $column->tooltip = Az::l('Загрузка картины');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            
           

           
            'target' => function (FormDb $column) {

                $column->title = Az::l('Открытие картины');
                $column->tooltip = Az::l('В какой вкладке открыть картину');
                $column->data = [
                    'self' => Az::l('в текущей вкладке'),
                    'blank' => Az::l('в новой вкладке'),
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'location' => function (FormDb $column) {

                $column->title = Az::l('Расположение');
                $column->tooltip = Az::l('Расположение картины');
                $column->data = [
                    'right' => Az::l('Справа'),
                    'bottom' => Az::l('Снизу'),
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'url' => function (FormDb $column) {

                $column->title = Az::l('Линк');
                $column->tooltip = Az::l('Линк для картины');
                $column->widget = ZHInputWidget::class;

                return $column;
            },
            
           
            'role' => function (FormDb $column) {

                $column->title = Az::l('Показать для:');
                $column->tooltip = Az::l('Роли для тех кому будут доступны');
                $column->dbType = dbTypeJsonb;
                $column->data = RoleData::class;
                $column->widget = ZSelect2Widget::class;

                return $column;
            },
            
           
            'menu_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Меню');
                $column->tooltip = Az::l('Для какого меню будет отображаться картина');
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
        'image',
        'target',
        'location',
        'url',
        'role',
        'menu_id',
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
                                'image',
                            ],
                            [
                                'title',
                            ],
                            [
                                'target',
                            ],
                            [
                                'location',
                            ],
                            [
                                'url',
                            ],
                            [
                                'role',
                            ],
                            [
                                'menu_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(MenuImage &$model = null)
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
        $event->beforeDelete = function (MenuImage $model) {
            return null;
        };

        $event->afterDelete = function (MenuImage $model) {
            return null;
        };

        $event->beforeSave = function (MenuImage $model) {
            return null;
        };

        $event->afterSave = function (MenuImage $model) {
            return null;
        };

        $event->beforeValidate = function (MenuImage $model) {
            return null;
        };

        $event->afterValidate = function (MenuImage $model) {
            return null;
        };

        $event->afterRefresh = function (MenuImage $model) {
            return null;
        };

        $event->afterFind = function (MenuImage $model) {
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
     * Function  getMenu
     * @return bool|\yii\db\ActiveRecord|Menu|null
     */            
    public function getMenuOne()
    {
        return $this->getOne(Menu::class, [
          'id' => 'menu_id',
      ]);    
    }
    
     /**
     *
     * Function  getMenu
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getMenu()
    {
        return $this->hasOne(Menu::class, [
          'id' => 'menu_id',
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
