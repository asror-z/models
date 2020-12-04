<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\dyna;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    DynaDynagrid
 * @package zetsoft\models\App
 * 
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $id
 * @property int $filter_id
 * @property int $sort_id
 * @property string $data
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DynaDynagrid extends ZActiveRecord
{
    #region MVars

    /*
    
    public $sort;
    public $name;
    public $title;
    public $tranz;
    public $accept;
    public $active;
    public $id;
    public $filter_id;
    public $sort_id;
    public $data;
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

        'sort',
        'name',
        'title',
        'tranz',
        'accept',
        'active',
        'id',
        'filter_id',
        'sort_id',
        'data',
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
    public static ?string $title = Azl . 'DynaDynagrid таблицы';
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
			'sort',
			'name',
			'title',
			'tranz',
			'accept',
			'active',
			'id',
			'filter_id',
			'sort_id',
			'data',
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

            $config->addID = false;
            $config->hasOne = [
                    'Filter' => [
                        'filter_id' => 'id',
                    ],
                    'Sort' => [
                        'sort_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->makeMenu = false;
            $config->order = [];

            $config->title = Az::l('DynaDynagrid таблицы');

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
           
            'id' => function (FormDb $column) {

                $column->length = 100;
                $column->notNull = true;
                $column->index = true;
                $column->indexUnique = true;
                $column->isPKey = true;
                $column->title = Az::l('Id');

                return $column;
            },
            
           
            'filter_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Filter');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'sort_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Sort');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'data' => function (FormDb $column) {

                $column->title = Az::l('Data');
                $column->dbType = dbTypeText;

                return $column;
            },
            

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'sort',
        'name',
        'title',
        'tranz',
        'accept',
        'active',
        'id',
        'filter_id',
        'sort_id',
        'data',
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
                                'filter_id',
                            ],
                            [
                                'sort_id',
                            ],
                            [
                                'data',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(DynaDynagrid &$model = null)
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
        $event->beforeDelete = function (DynaDynagrid $model) {
            return null;
        };

        $event->afterDelete = function (DynaDynagrid $model) {
            return null;
        };

        $event->beforeSave = function (DynaDynagrid $model) {
            return null;
        };

        $event->afterSave = function (DynaDynagrid $model) {
            return null;
        };

        $event->beforeValidate = function (DynaDynagrid $model) {
            return null;
        };

        $event->afterValidate = function (DynaDynagrid $model) {
            return null;
        };

        $event->afterRefresh = function (DynaDynagrid $model) {
            return null;
        };

        $event->afterFind = function (DynaDynagrid $model) {
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
     * Function  getFilter
     * @return bool|\yii\db\ActiveRecord|Filter|null
     */            
    public function getFilterOne()
    {
        return $this->getOne(Filter::class, [
          'id' => 'filter_id',
      ]);    
    }
    
     /**
     *
     * Function  getFilter
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getFilter()
    {
        return $this->hasOne(Filter::class, [
          'id' => 'filter_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getSort
     * @return bool|\yii\db\ActiveRecord|Sort|null
     */            
    public function getSortOne()
    {
        return $this->getOne(Sort::class, [
          'id' => 'sort_id',
      ]);    
    }
    
     /**
     *
     * Function  getSort
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getSort()
    {
        return $this->hasOne(Sort::class, [
          'id' => 'sort_id',
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
