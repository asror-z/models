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


use yii\db\ActiveRecord;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZFileHelper;
use zetsoft\system\helpers\ZVarDumper;
use zetsoft\system\module\Models;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\page\PageControl;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\page\PageAction;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\page\PageControlRest;
use zetsoft\models\user\User;
use zetsoft\models\test\Test4;
use zetsoft\models\test\TestDep;
use zetsoft\dbcore\chat\ChatMailCore;




/**
 * Class    PageModule
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property string $data
 * @property string $input
 * @property boolean $check
 * @property int $clone
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class PageModule extends ZActiveRecord
{

    #region MVars

    /*
    
    public $id;
    public $name;
    public $data;
    public $input;
    public $check;
    public $clone;
    public $created_at;
    public $modified_at;
    public $created_by;
    public $modified_by;
    */

    #endregion

    #region Names

    #endregion

    #region Const

    #endregion

    ##region Init

    public function init()
    {
        parent::init();


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
            $config->icon='fal fa-paperclip';
            $config->hasOne = [
                'CoreModule' => [
                    'clone' => 'id',
                ],
            ];
            $config->hasMany = [
                'CoreControl' => [
                    'page_module_id' => 'id',
                ],
                'CoreControlRest' => [
                    'page_module_id' => 'id',
                ],
                'CoreModule' => [
                    'clone' => 'id',
                ],
                'Test4' => [
                    'page_module_id' => 'id',
                ],
            ];
            $config->title = Az::l('Веб-модули');
            $config->extraColumn = true;
            $config->extraConfig = true;
            $config->readonly = [
                'name' => true,
                'data' => true,
                'clone' => true,
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


            'data' => function (FormDb $column) {

                $column->title = Az::l('Данные');
                $column->dbType = dbTypeString;
                $column->showForm = false;

                return $column;
            },


            'input' => function (FormDb $column) {

                $column->title = Az::l('Введенное название');
                $column->dbType = dbTypeString;
                $column->showDyna = false;

                return $column;
            },


            'check' => function (FormDb $column) {

                $column->title = Az::l('Верификация');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->showForm = false;

                return $column;
            },


            'clone' => function (FormDb $column) {

                $column->title = Az::l('Клонировать');
                $column->tooltip = 'Клонировать данные с:';
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'page_module';

                return $column;
            },


        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'data',
        'input',
        'check',
        'clone',
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
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value

                    public function value(PageModule $model = null)
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
        $event->beforeSave = function (PageModule $model) {

            if (ZArrayHelper::getValue(Az::$app->params, paramNoEvent))
                return null;
            else {
                Az::$app->cores->appPage->module($model, $this->isNewRecord);
            }
        };

        $event->afterSave = function (PageModule $model) {

            if (ZArrayHelper::getValue(Az::$app->params, paramNoEvent))
                return null;
            else {
                //module edit qilingandan keyin ichidagi fayl va papkalarni databasega o'tkazish
                if ($this->isNewRecord)
                    Az::$app->cores->appPage->createFilesInModel($model);
                else
                    Az::$app->cores->appPage->editFilesInModel($model);
            }
        };

        $event->beforeDelete = function (PageModule $model) {
            if (ZArrayHelper::getValue(Az::$app->params, paramNoEvent))
                return null;
            else
                Az::$app->cores->appPage->move_module($model->name);
        };

        /*
        $event->beforeDelete = function (CoreModule $model) {
        return null;
        };

        $event->afterDelete = function (CoreModule $model) {
        return null;
        };

        $event->beforeSave = function (CoreModule $model) {
        return null;
        };



        $event->beforeValidate = function (CoreModule $model) {
        return null;
        };

        $event->afterValidate = function (CoreModule $model) {
        return null;
        };

        $event->afterRefresh = function (CoreModule $model) {
        return null;
        };
        $event->afterFind = function (CoreModule $model) {
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
    public function faker()
    {
        return null;
    }


    #endregion

    #region One


    /**
     *
     * Function  getClone
     * @return bool|\yii\db\ActiveRecord|PageModule|null
     */            
    public function getCloneOne()
    {
        return $this->getOne(PageModule::class, [
          'id' => 'clone',
      ]);    
    }
    
     /**
     *
     * Function  getClone
     * @return \yii\db\ActiveQuery
     */            
    public function getClone()
    {
        return $this->hasOne(PageModule::class, [
          'id' => 'clone',
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
     * @return \yii\db\ActiveQuery
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
     * @return \yii\db\ActiveQuery
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
     * Function  getPageControlsWithPageModuleIdWith
     * @return  null|\yii\db\ActiveRecord[]|PageControl
     */            
    public function getPageControlsWithPageModuleIdMany()
    {
       return $this->getMany(PageControl::class, [
            'page_module_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageControlsWithPageModuleIdWith
     * @return  null|\yii\db\ActiveRecord[]|PageControl
     */            
    public function getPageControlsWithPageModuleId()
    {
       return $this->hasMany(PageControl::class, [
            'page_module_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageModulesWithCloneWith
     * @return  null|\yii\db\ActiveRecord[]|PageModule
     */            
    public function getPageModulesWithCloneMany()
    {
       return $this->getMany(PageModule::class, [
            'clone' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageModulesWithCloneWith
     * @return  null|\yii\db\ActiveRecord[]|PageModule
     */            
    public function getPageModulesWithClone()
    {
       return $this->hasMany(PageModule::class, [
            'clone' => 'id',
        ]);     
    }


    #endregion


}
