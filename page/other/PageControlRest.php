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


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\page\PageModule;
use zetsoft\models\page\PageAction;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\page\PageControl;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\dbcore\chat\ChatMailCore;
use zetsoft\models\user\User;




/**
 * Class    PageControlRest
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
class PageControlRest extends ZActiveRecord
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

            $config->hasOne = [
                    'CoreControl' => [
                        'clone' => 'id',
                    ],
                    'User' => [
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Веб-контроллеры API');
            $config->icon = 'fal fa-file-code-o';


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
                $column->showForm = false;

                return $column;
            },
            
           
            'input' => function (FormDb $column) {

                $column->title = Az::l('Введенное название');
                $column->showDyna = false;

                return $column;
            },
            
           
            'check' => function (FormDb $column) {

                $column->title = Az::l('Верификация');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->showForm = false;
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'clone' => function (FormDb $column) {

                $column->title = Az::l('Клонировать');
                $column->tooltip = 'Клонировать данные с:';
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'core_control';

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

                    public function value(PageControlRest $model = null)
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
 
// $event->beforeDelete = function (CoreControl $model) {
// return null;
// };
//
// $event->afterDelete = function (CoreControl $model) {
// return null;
// };
//
// $event->beforeSave = function (CoreControl $model) {
// return null;
// };
//
//
// $event->beforeValidate = function (CoreControl $model) {
// return null;
// };
//
// $event->afterValidate = function (CoreControl $model) {
// return null;
// };
//
// $event->afterRefresh = function (CoreControl $model) {
// return null;
// };
//
// $event->afterFind = function (CoreControl $model) {
// return null;
// };
//
//
//
// $event->afterSave = function (CoreControl $model) {
//
//
//
//
//
//
// return null;
// };

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
     * @return bool|\yii\db\ActiveRecord|CoreControl|null
     */            
    public function getCloneOne()
    {
        return $this->getOne(CoreControl::class, [
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
        return $this->hasOne(CoreControl::class, [
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



    #endregion


}
