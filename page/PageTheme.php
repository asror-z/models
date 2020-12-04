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
use yii\validators\RequiredValidator;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\column\ZKDataColumn;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZIconPickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\navigat\ZButtonWidget;
use zetsoft\models\user\User;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Form;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\system\actives\ZModel;
use zetsoft\dbitem\data\Config;
use zetsoft\models\page\PageThemeType;
use zetsoft\models\page\PageApp;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    PageTheme
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $desc
 * @property boolean $check
 * @property string $icon
 * @property string $path
 * @property array $tags
 * @property array $data
 * @property array $image
 * @property int $author
 * @property int $page_theme_type_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class PageTheme extends ZActiveRecord
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
    public $desc;
    public $check;
    public $icon;
    public $path;
    public $tags;
    public $data;
    public $image;
    public $author;
    public $page_theme_type_id;
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
        'desc',
        'check',
        'icon',
        'path',
        'tags',
        'data',
        'image',
        'author',
        'page_theme_type_id',
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
    public static ?string $title = Azl . 'Шаблоны';
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
			'desc',
			'check',
			'icon',
			'path',
			'tags',
			'data',
			'image',
			'author',
			'page_theme_type_id',
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
                        'author' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageThemeType' => [
                        'page_theme_type_id' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'PageApp' => [
                        'page_theme_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Шаблоны');

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
           

            
           
            'desc' => function (FormDb $column) {

                $column->title = Az::l('Подробное описание');
                $column->dbType = dbTypeText;

                return $column;
            },
            
           
            'check' => function (FormDb $column) {

                $column->title = Az::l('Верефецировано');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },
            
           
            'icon' => function (FormDb $column) {

                $column->title = Az::l('Подробное описание');

                return $column;
            },
            
           
            'path' => function (FormDb $column) {

                $column->title = Az::l('Путь');

                return $column;
            },
            
           
            'tags' => function (FormDb $column) {

                $column->title = Az::l('Тэги');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
						'config' =>[
							'multiple' => true,
							'tags' => true,
						],
					];

                return $column;
            },
            
           
            'data' => function (FormDb $column) {

                $column->title = Az::l('Тэги');
                $column->dbType = dbTypeJsonb;
                $column->data = DbCategoryData::class;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },
            
           
            'image' => function (FormDb $column) {

                $column->title = Az::l('Изображение');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;

                return $column;
            },
            
           
            'author' => function (FormDb $column) {

                $column->title = Az::l('Автор');
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user';

                return $column;
            },
            
           
            'page_theme_type_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Категория');
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
        'desc',
        'check',
        'icon',
        'path',
        'tags',
        'data',
        'image',
        'author',
        'page_theme_type_id',
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
                                'input',
                            ],
                            [
                                'title',
                            ],
                            [
                                'icon',
                            ],
                            [
                                'all',
                            ],
                            [
                                'page_blocks_type_id',
                            ],
                            [
                                'sample',
                            ],
                            [
                                'check',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(PageTheme &$model = null)
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
        $event->beforeDelete = function (PageTheme $model) {
            return null;
        };

        $event->afterDelete = function (PageTheme $model) {
            return null;
        };

        $event->beforeSave = function (PageTheme $model) {
            return null;
        };

        $event->afterSave = function (PageTheme $model) {
            return null;
        };

        $event->beforeValidate = function (PageTheme $model) {
            return null;
        };

        $event->afterValidate = function (PageTheme $model) {
            return null;
        };

        $event->afterRefresh = function (PageTheme $model) {
            return null;
        };

        $event->afterFind = function (PageTheme $model) {
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
     * Function  getAuthor
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getAuthorOne()
    {
        return $this->getOne(User::class, [
          'id' => 'author',
      ]);    
    }
    
     /**
     *
     * Function  getAuthor
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getAuthor()
    {
        return $this->hasOne(User::class, [
          'id' => 'author',
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
    
    

    /**
     *
     * Function  getPageThemeType
     * @return bool|\yii\db\ActiveRecord|PageThemeType|null
     */            
    public function getPageThemeTypeOne()
    {
        return $this->getOne(PageThemeType::class, [
          'id' => 'page_theme_type_id',
      ]);    
    }
    
     /**
     *
     * Function  getPageThemeType
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPageThemeType()
    {
        return $this->hasOne(PageThemeType::class, [
          'id' => 'page_theme_type_id',
      ]);    
    }
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many


    /**
     *
     * Function  getPageAppsWithPageThemeIdMany
     * @return  null|\yii\db\ActiveRecord[]|PageApp
     */            
    public function getPageAppsWithPageThemeIdMany()
    {
       return $this->getMany(PageApp::class, [
            'page_theme_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageAppsWithPageThemeId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageAppsWithPageThemeId()
    {
       return $this->hasMany(PageApp::class, [
            'page_theme_id' => 'id',
        ]);     
    }


    #endregion


}
