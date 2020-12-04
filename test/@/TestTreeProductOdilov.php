<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\test;


use kartik\tree\models\Tree;
use Yii;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\models\user\User;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\dbcore\chat\ChatMailCore;




/**
 * Class    TestTreeProduct
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property int $root
 * @property int $lft
 * @property int $rgt
 * @property int $lvl
 * @property string $icon
 * @property boolean $icon_type
 * @property boolean $active
 * @property boolean $activeOrig
 * @property boolean $selected
 * @property boolean $disabled
 * @property boolean $readonly
 * @property boolean $visible
 * @property boolean $collapsed
 * @property boolean $movable_u
 * @property boolean $movable_d
 * @property boolean $movable_l
 * @property boolean $movable_r
 * @property boolean $removable
 * @property boolean $removable_all
 * @property boolean $child_allowed
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class TestTreeProductOdilov extends Tree
{




    public static function tableName()
    {
        return "{{%test_tree_product}}";
    }

    #region MVars

    /*
    
    public $id;
    public $name;
    public $root;
    public $lft;
    public $rgt;
    public $lvl;
    public $icon;
    public $icon_type;
    public $active;
    public $activeOrig;
    public $selected;
    public $disabled;
    public $readonly;
    public $visible;
    public $collapsed;
    public $movable_u;
    public $movable_d;
    public $movable_l;
    public $movable_r;
    public $removable;
    public $removable_all;
    public $child_allowed;
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
                    'User' => [
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->name = 'Потребности';

            $config->title = Az::l('TreeProduct');

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
           
            'root' => function (FormDb $column) {

                $column->title = Az::l('root');
                $column->dbType = dbTypeInteger;

                return $column;
            },
            
           
            'lft' => function (FormDb $column) {

                $column->title = Az::l('lft');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },
            
           
            'rgt' => function (FormDb $column) {

                $column->title = Az::l('rgt');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },
            
           
            'lvl' => function (FormDb $column) {

                $column->title = Az::l('lvl');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },
            
           
            'icon' => function (FormDb $column) {

                $column->title = Az::l('icon');

                return $column;
            },
            
           
            'icon_type' => function (FormDb $column) {

                $column->defaultValue = '1';
                $column->title = Az::l('icon_type');
                $column->dbType = dbTypeBoolean;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },
            

           
            'activeOrig' => function (FormDb $column) {

                $column->title = Az::l('activeOrig');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'selected' => function (FormDb $column) {

                $column->title = Az::l('selected');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'disabled' => function (FormDb $column) {

                $column->title = Az::l('disabled');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'readonly' => function (FormDb $column) {

                $column->title = Az::l('readonly');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'visible' => function (FormDb $column) {

                $column->title = Az::l('visible');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'collapsed' => function (FormDb $column) {

                $column->title = Az::l('collapsed');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'movable_u' => function (FormDb $column) {

                $column->title = Az::l('movable_u');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'movable_d' => function (FormDb $column) {

                $column->title = Az::l('movable_d');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'movable_l' => function (FormDb $column) {

                $column->title = Az::l('movable_l');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'movable_r' => function (FormDb $column) {

                $column->title = Az::l('movable_r');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'removable' => function (FormDb $column) {

                $column->title = Az::l('removable');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'removable_all' => function (FormDb $column) {

                $column->title = Az::l('removable_all');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            
           
            'child_allowed' => function (FormDb $column) {

                $column->title = Az::l('child_allowed');
                $column->dbType = dbTypeBoolean;

                return $column;
            },
            

        ], $this->configs->replace);
    }



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
                'items' => [
                    [
                        'title' => Az::l('Форма'),
                        'items' => [
                            [
                                'name',
                                'root',
                                'lft',
                                'rgt',
                                'lvl',
                                'icon',
                                'icon_type',
                                'active',
                                'activeOrig',
                                'selected',
                                'disabled',
                                'readonly',
                                'visible',
                                'collapsed',
                                'movable_u',
                                'movable_d',
                                'movable_l',
                                'movable_r',
                                'removable',
                                'removable_all',
                                'child_allowed',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
    

    #region Events

    /**
     * Function column
     * @return ZEvent
     */
    public function event()
    {

        $event = new Event();
    /*
        $event->beforeDelete = function (TreeProduct $model) {
            return null;
        };

        $event->afterDelete = function (TreeProduct $model) {
            return null;
        };

        $event->beforeSave = function (TreeProduct $model) {
            return null;
        };

        $event->afterSave = function (TreeProduct $model) {
            return null;
        };

        $event->beforeValidate = function (TreeProduct $model) {
            return null;
        };

        $event->afterValidate = function (TreeProduct $model) {
            return null;
        };

        $event->afterRefresh = function (TreeProduct $model) {
            return null;
        };

        $event->afterFind = function (TreeProduct $model) {
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

    /*
        $event = new Event();
        $event->beforeDelete = function (TestTreeProduct $model) {
            return null;
        };

        $event->afterDelete = function (TestTreeProduct $model) {
            return null;
        };

        $event->beforeSave = function (TestTreeProduct $model) {
            return null;
        };

        $event->afterSave = function (TestTreeProduct $model) {
            return null;
        };

        $event->beforeValidate = function (TestTreeProduct $model) {
            return null;
        };

        $event->afterValidate = function (TestTreeProduct $model) {
            return null;
        };

        $event->afterRefresh = function (TestTreeProduct $model) {
            return null;
        };

        $event->afterFind = function (TestTreeProduct $model) {
            return null;
        };
*/

    }


    #endregion

    #region One


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
