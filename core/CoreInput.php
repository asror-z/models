<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\core;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\system\validate\ZCoreControlValidator;
use zetsoft\system\validate\ZMultiUniqueValidator;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inptest\ZFilepondWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\dbitem\data\Form;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CoreInput
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property array $jsonb_1
 * @property array $jsonb_2
 * @property array $jsonb_3
 * @property array $jsonb_4
 * @property array $jsonb_5
 * @property array $jsonb_6
 * @property array $jsonb_7
 * @property array $jsonb_8
 * @property array $jsonb_9
 * @property array $jsonb_10
 * @property int $int_1
 * @property int $int_2
 * @property int $int_3
 * @property int $int_4
 * @property int $int_5
 * @property int $int_6
 * @property int $int_7
 * @property int $int_8
 * @property int $int_9
 * @property int $int_10
 * @property string $string_1
 * @property string $string_2
 * @property string $string_3
 * @property string $string_4
 * @property string $string_5
 * @property string $string_6
 * @property string $string_7
 * @property string $string_8
 * @property string $string_9
 * @property string $string_10
 * @property boolean $bool_1
 * @property boolean $bool_2
 * @property boolean $bool_3
 * @property boolean $bool_4
 * @property boolean $bool_5
 * @property string $text_1
 * @property string $text_2
 * @property string $text_3
 * @property string $text_4
 * @property string $text_5
 * @property string $date_1
 * @property string $date_2
 * @property string $date_3
 * @property string $date_4
 * @property string $date_5
 * @property string $time_1
 * @property string $time_2
 * @property string $time_3
 * @property string $time_4
 * @property string $time_5
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CoreInput extends ZActiveRecord
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
    public $jsonb_1;
    public $jsonb_2;
    public $jsonb_3;
    public $jsonb_4;
    public $jsonb_5;
    public $jsonb_6;
    public $jsonb_7;
    public $jsonb_8;
    public $jsonb_9;
    public $jsonb_10;
    public $int_1;
    public $int_2;
    public $int_3;
    public $int_4;
    public $int_5;
    public $int_6;
    public $int_7;
    public $int_8;
    public $int_9;
    public $int_10;
    public $string_1;
    public $string_2;
    public $string_3;
    public $string_4;
    public $string_5;
    public $string_6;
    public $string_7;
    public $string_8;
    public $string_9;
    public $string_10;
    public $bool_1;
    public $bool_2;
    public $bool_3;
    public $bool_4;
    public $bool_5;
    public $text_1;
    public $text_2;
    public $text_3;
    public $text_4;
    public $text_5;
    public $date_1;
    public $date_2;
    public $date_3;
    public $date_4;
    public $date_5;
    public $time_1;
    public $time_2;
    public $time_3;
    public $time_4;
    public $time_5;
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
        'jsonb_1',
        'jsonb_2',
        'jsonb_3',
        'jsonb_4',
        'jsonb_5',
        'jsonb_6',
        'jsonb_7',
        'jsonb_8',
        'jsonb_9',
        'jsonb_10',
        'int_1',
        'int_2',
        'int_3',
        'int_4',
        'int_5',
        'int_6',
        'int_7',
        'int_8',
        'int_9',
        'int_10',
        'string_1',
        'string_2',
        'string_3',
        'string_4',
        'string_5',
        'string_6',
        'string_7',
        'string_8',
        'string_9',
        'string_10',
        'bool_1',
        'bool_2',
        'bool_3',
        'bool_4',
        'bool_5',
        'text_1',
        'text_2',
        'text_3',
        'text_4',
        'text_5',
        'date_1',
        'date_2',
        'date_3',
        'date_4',
        'date_5',
        'time_1',
        'time_2',
        'time_3',
        'time_4',
        'time_5',
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
    public static ?string $title = Azl . 'Тестовые компоненты';
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
			'jsonb_1',
			'jsonb_2',
			'jsonb_3',
			'jsonb_4',
			'jsonb_5',
			'jsonb_6',
			'jsonb_7',
			'jsonb_8',
			'jsonb_9',
			'jsonb_10',
			'int_1',
			'int_2',
			'int_3',
			'int_4',
			'int_5',
			'int_6',
			'int_7',
			'int_8',
			'int_9',
			'int_10',
			'string_1',
			'string_2',
			'string_3',
			'string_4',
			'string_5',
			'string_6',
			'string_7',
			'string_8',
			'string_9',
			'string_10',
			'bool_1',
			'bool_2',
			'bool_3',
			'bool_4',
			'bool_5',
			'text_1',
			'text_2',
			'text_3',
			'text_4',
			'text_5',
			'date_1',
			'date_2',
			'date_3',
			'date_4',
			'date_5',
			'time_1',
			'time_2',
			'time_3',
			'time_4',
			'time_5',
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
            $config->title = Az::l('Тестовые компоненты');

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
           
            'jsonb_1' => function (FormDb $column) {

                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;
                $column->options = [
						'config' =>[
							'formClass' => 'zetsoft\former\shop\PriceHistoryForm',
						],
					];
                $column->valueOptions = [
						'config' =>[
							'formClass' => 'zetsoft\former\shop\PriceHistoryForm',
						],
					];

                return $column;
            },
            
           
            'jsonb_2' => function (FormDb $column) {

                $column->dbType = dbTypeJsonb;
                $column->widget = ZFilepondWidget::class;

                return $column;
            },
            
           
            'jsonb_3' => function (FormDb $column) {

                $column->dbType = dbTypeJsonb;
                $column->widget = ZFilepondWidget::class;

                return $column;
            },
            
           
            'jsonb_4' => function (FormDb $column) {

                $column->dbType = dbTypeJsonb;
                $column->widget = ZFilepondWidget::class;

                return $column;
            },
            
           
            'jsonb_5' => function (FormDb $column) {

                $column->dbType = dbTypeJsonb;
                $column->widget = ZFilepondWidget::class;

                return $column;
            },
            
           
            'jsonb_6' => function (FormDb $column) {

                $column->dbType = dbTypeJsonb;
                $column->widget = ZFilepondWidget::class;

                return $column;
            },
            
           
            'jsonb_7' => function (FormDb $column) {

                $column->dbType = dbTypeJsonb;
                $column->widget = ZFilepondWidget::class;

                return $column;
            },
            
           
            'jsonb_8' => function (FormDb $column) {

                $column->dbType = dbTypeJsonb;
                $column->widget = ZFilepondWidget::class;

                return $column;
            },
            
           
            'jsonb_9' => function (FormDb $column) {

                $column->dbType = dbTypeJsonb;
                $column->widget = ZFilepondWidget::class;

                return $column;
            },
            
           
            'jsonb_10' => function (FormDb $column) {

                $column->dbType = dbTypeJsonb;
                $column->widget = ZFilepondWidget::class;

                return $column;
            },
            
           
            'int_1' => function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'int_2' => function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'int_3' => function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'int_4' => function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'int_5' => function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'int_6' => function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'int_7' => function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'int_8' => function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'int_9' => function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'int_10' => function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },
            
           
            'string_1' => function (FormDb $column) {

                $column->rules = validatorString;
                $column->tooltip ='sadfasdfasdfasfasfasdf';

                return $column;
            },
            
           
            'string_2' => function (FormDb $column) {

                $column->title = Az::l('Стринг 2');
                return $column;
            },
            
           
            'string_3' => function (FormDb $column) {

                $column->rules = validatorString;

                return $column;
            },
            
           
            'string_4' => function (FormDb $column) {

                $column->rules = validatorString;

                return $column;
            },
            
           
            'string_5' => function (FormDb $column) {

                $column->rules = validatorString;

                return $column;
            },
            
           
            'string_6' => function (FormDb $column) {

                $column->rules = validatorString;

                return $column;
            },
            
           
            'string_7' => function (FormDb $column) {

                $column->rules = validatorString;

                return $column;
            },
            
           
            'string_8' => function (FormDb $column) {

                $column->rules = validatorString;

                return $column;
            },
            
           
            'string_9' => function (FormDb $column) {

                $column->rules = validatorString;

                return $column;
            },
            
           
            'string_10' => function (FormDb $column) {

                $column->rules = validatorString;

                return $column;
            },
            
           
            'bool_1' => function (FormDb $column) {

                $column->dbType = dbTypeBoolean;
                $column->rules = validatorBoolean;

                return $column;
            },
            
           
            'bool_2' => function (FormDb $column) {

                $column->dbType = dbTypeBoolean;
                $column->rules = validatorBoolean;

                return $column;
            },
            
           
            'bool_3' => function (FormDb $column) {

                $column->dbType = dbTypeBoolean;
                $column->rules = validatorBoolean;

                return $column;
            },
            
           
            'bool_4' => function (FormDb $column) {

                $column->dbType = dbTypeBoolean;
                $column->rules = validatorBoolean;

                return $column;
            },
            
           
            'bool_5' => function (FormDb $column) {

                $column->dbType = dbTypeBoolean;
                $column->rules = validatorBoolean;

                return $column;
            },
            
           
            'text_1' => function (FormDb $column) {

                $column->dbType = dbTypeText;

                return $column;
            },
            
           
            'text_2' => function (FormDb $column) {

                $column->dbType = dbTypeText;

                return $column;
            },
            
           
            'text_3' => function (FormDb $column) {

                $column->dbType = dbTypeText;

                return $column;
            },
            
           
            'text_4' => function (FormDb $column) {

                $column->dbType = dbTypeText;

                return $column;
            },
            
           
            'text_5' => function (FormDb $column) {

                $column->dbType = dbTypeText;

                return $column;
            },
            
           
            'date_1' => function (FormDb $column) {

                $column->dbType = dbTypeDate;

                return $column;
            },
            
           
            'date_2' => function (FormDb $column) {

                $column->dbType = dbTypeDate;

                return $column;
            },
            
           
            'date_3' => function (FormDb $column) {

                $column->dbType = dbTypeDate;

                return $column;
            },
            
           
            'date_4' => function (FormDb $column) {

                $column->dbType = dbTypeDate;

                return $column;
            },
            
           
            'date_5' => function (FormDb $column) {

                $column->dbType = dbTypeDate;

                return $column;
            },
            
           
            'time_1' => function (FormDb $column) {

                $column->dbType = dbTypeTime;
                

                return $column;
            },
            
           
            'time_2' => function (FormDb $column) {

                $column->dbType = dbTypeTime;
                

                return $column;
            },
            
           
            'time_3' => function (FormDb $column) {

                $column->dbType = dbTypeTime;
                

                return $column;
            },
            
           
            'time_4' => function (FormDb $column) {

                $column->dbType = dbTypeTime;
                

                return $column;
            },
            
           
            'time_5' => function (FormDb $column) {

                $column->dbType = dbTypeTime;
                

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
        'jsonb_1',
        'jsonb_2',
        'jsonb_3',
        'jsonb_4',
        'jsonb_5',
        'jsonb_6',
        'jsonb_7',
        'jsonb_8',
        'jsonb_9',
        'jsonb_10',
        'int_1',
        'int_2',
        'int_3',
        'int_4',
        'int_5',
        'int_6',
        'int_7',
        'int_8',
        'int_9',
        'int_10',
        'string_1',
        'string_2',
        'string_3',
        'string_4',
        'string_5',
        'string_6',
        'string_7',
        'string_8',
        'string_9',
        'string_10',
        'bool_1',
        'bool_2',
        'bool_3',
        'bool_4',
        'bool_5',
        'text_1',
        'text_2',
        'text_3',
        'text_4',
        'text_5',
        'date_1',
        'date_2',
        'date_3',
        'date_4',
        'date_5',
        'time_1',
        'time_2',
        'time_3',
        'time_4',
        'time_5',
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
                                'jsonb_1',
                            ],
                            [
                                'jsonb_2',
                            ],
                            [
                                'jsonb_3',
                            ],
                            [
                                'jsonb_4',
                            ],
                            [
                                'jsonb_5',
                            ],
                            [
                                'jsonb_6',
                            ],
                            [
                                'jsonb_7',
                            ],
                            [
                                'jsonb_8',
                            ],
                            [
                                'jsonb_9',
                            ],
                            [
                                'jsonb_10',
                            ],
                            [
                                'int_1',
                            ],
                            [
                                'int_2',
                            ],
                            [
                                'int_3',
                            ],
                            [
                                'int_4',
                            ],
                            [
                                'int_5',
                            ],
                            [
                                'int_6',
                            ],
                            [
                                'int_7',
                            ],
                            [
                                'int_8',
                            ],
                            [
                                'int_9',
                            ],
                            [
                                'int_10',
                            ],
                            [
                                'string_1',
                            ],
                            [
                                'string_2',
                            ],
                            [
                                'string_3',
                            ],
                            [
                                'string_4',
                            ],
                            [
                                'string_5',
                            ],
                            [
                                'string_6',
                            ],
                            [
                                'string_7',
                            ],
                            [
                                'string_8',
                            ],
                            [
                                'string_9',
                            ],
                            [
                                'string_10',
                            ],
                            [
                                'bool_1',
                            ],
                            [
                                'bool_2',
                            ],
                            [
                                'bool_3',
                            ],
                            [
                                'bool_4',
                            ],
                            [
                                'bool_5',
                            ],
                            [
                                'text_1',
                            ],
                            [
                                'text_2',
                            ],
                            [
                                'text_3',
                            ],
                            [
                                'text_4',
                            ],
                            [
                                'text_5',
                            ],
                            [
                                'date_1',
                            ],
                            [
                                'date_2',
                            ],
                            [
                                'date_3',
                            ],
                            [
                                'date_4',
                            ],
                            [
                                'date_5',
                            ],
                            [
                                'time_1',
                            ],
                            [
                                'time_2',
                            ],
                            [
                                'time_3',
                            ],
                            [
                                'time_4',
                            ],
                            [
                                'time_5',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(CoreInput &$model = null)
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
        $event->beforeDelete = function (CoreInput $model) {
            return null;
        };

        $event->afterDelete = function (CoreInput $model) {
            return null;
        };

        $event->beforeSave = function (CoreInput $model) {
            return null;
        };

        $event->afterSave = function (CoreInput $model) {
            return null;
        };

        $event->beforeValidate = function (CoreInput $model) {
            return null;
        };

        $event->afterValidate = function (CoreInput $model) {
            return null;
        };

        $event->afterRefresh = function (CoreInput $model) {
            return null;
        };

        $event->afterFind = function (CoreInput $model) {
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



    #endregion


}
