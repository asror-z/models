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
 * Class    DynaDynagridDtl
 * @package zetsoft\models\App
 * 
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $id
 * @property string $category
 * @property string $data
 * @property int $dynagrid_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DynaDynagridDtl extends ZActiveRecord
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
    public $category;
    public $data;
    public $dynagrid_id;
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
        'category',
        'data',
        'dynagrid_id',
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
    public static ?string $title = Azl . 'DynaDynagridDtl';
    public static ?string $icon = '';
    public static ?bool $menu = false;

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
			'category',
			'data',
			'dynagrid_id',
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
                    'Dynagrid' => [
                        'dynagrid_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->makeMenu = false;
            $config->order = [];

            $config->menu = false;
            $config->title = Az::l('DynaDynagridDtl');

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
            
           
            'category' => function (FormDb $column) {

                $column->title = Az::l('Category');

                return $column;
            },
            
           
            'data' => function (FormDb $column) {

                $column->title = Az::l('Data');
                $column->dbType = dbTypeText;

                return $column;
            },
            
           
            'dynagrid_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Dynagrid');
                $column->widget = ZKSelect2Widget::class;

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
        'category',
        'data',
        'dynagrid_id',
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
                                'id',
                            ],
                            [
                                'category',
                            ],
                            [
                                'data',
                            ],
                            [
                                'dynagrid_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(DynaDynagridDtl &$model = null)
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
        $event->beforeDelete = function (DynaDynagridDtl $model) {
            return null;
        };

        $event->afterDelete = function (DynaDynagridDtl $model) {
            return null;
        };

        $event->beforeSave = function (DynaDynagridDtl $model) {
            return null;
        };

        $event->afterSave = function (DynaDynagridDtl $model) {
            return null;
        };

        $event->beforeValidate = function (DynaDynagridDtl $model) {
            return null;
        };

        $event->afterValidate = function (DynaDynagridDtl $model) {
            return null;
        };

        $event->afterRefresh = function (DynaDynagridDtl $model) {
            return null;
        };

        $event->afterFind = function (DynaDynagridDtl $model) {
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
     * Function  getDynagrid
     * @return bool|\yii\db\ActiveRecord|Dynagrid|null
     */            
    public function getDynagridOne()
    {
        return $this->getOne(Dynagrid::class, [
          'id' => 'dynagrid_id',
      ]);    
    }
    
     /**
     *
     * Function  getDynagrid
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getDynagrid()
    {
        return $this->hasOne(Dynagrid::class, [
          'id' => 'dynagrid_id',
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
