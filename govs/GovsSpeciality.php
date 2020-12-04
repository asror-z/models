<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\govs;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    GovsSpeciality
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $core_education_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class GovsSpeciality extends ZActiveRecord
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
    public $core_education_id;
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
        'core_education_id',
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
    public static ?string $title = Azl . 'Специальность';
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
			'core_education_id',
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
                    'CoreEducation' => [
                        'core_education_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'EyufCompatriot' => [
                        'govs_speciality_ids' => 'id',
                    ],
                    'EyufTable' => [
                        'govs_speciality_ids' => 'id',
                    ],
                ];
            $config->title = Az::l('Специальность');

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

            'core_education_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Область знаний');
                $column->tooltip = Az::l('Область знаний сотрудника');
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
        'core_education_id',
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
                                'core_education_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(GovsSpeciality $model = null)
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
        $event->beforeDelete = function (GovsSpeciality $model) {
        return null;
        };

        $event->afterDelete = function (GovsSpeciality $model) {
        return null;
        };

        $event->beforeSave = function (GovsSpeciality $model) {
        return null;
        };

        $event->afterSave = function (GovsSpeciality $model) {
        return null;
        };

        $event->beforeValidate = function (GovsSpeciality $model) {
        return null;
        };

        $event->afterValidate = function (GovsSpeciality $model) {
        return null;
        };

        $event->afterRefresh = function (GovsSpeciality $model) {
        return null;
        };

        $event->afterFind = function (GovsSpeciality $model) {
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
     * Function  getCoreEducation
     * @return bool|\yii\db\ActiveRecord|CoreEducation|null
     */            
    public function getCoreEducationOne()
    {
        return $this->getOne(CoreEducation::class, [
          'id' => 'core_education_id',
      ]);    
    }
    
     /**
     *
     * Function  getCoreEducation
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCoreEducation()
    {
        return $this->hasOne(CoreEducation::class, [
          'id' => 'core_education_id',
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


    /**
     *
     * Function  getEyufCompatriotsWithGovsSpecialityIdsMany
     * @return  null|\yii\db\ActiveRecord[]|EyufCompatriot
     */            
    public function getEyufCompatriotsWithGovsSpecialityIdsMany()
    {
       return $this->getMany(EyufCompatriot::class, [
            'govs_speciality_ids' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufCompatriotsWithGovsSpecialityIds
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufCompatriotsWithGovsSpecialityIds()
    {
       return $this->hasMany(EyufCompatriot::class, [
            'govs_speciality_ids' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufTablesWithGovsSpecialityIdsMany
     * @return  null|\yii\db\ActiveRecord[]|EyufTable
     */            
    public function getEyufTablesWithGovsSpecialityIdsMany()
    {
       return $this->getMany(EyufTable::class, [
            'govs_speciality_ids' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufTablesWithGovsSpecialityIds
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufTablesWithGovsSpecialityIds()
    {
       return $this->hasMany(EyufTable::class, [
            'govs_speciality_ids' => 'id',
        ]);     
    }


    #endregion


}
