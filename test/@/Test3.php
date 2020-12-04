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


use yii\db\ActiveQuery;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveData;
use zetsoft\system\helpers\ZVarDumper;
use zetsoft\system\schema\PgSqlSchema;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;



/**
 * Class    Test3
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property string $sender
 * @property array $receiver
 * @property string $time
 * @property boolean $read
 * @property int $user_group_id
 * @property array $user_group_ids
 * @property array $group
 * @property array $user_company_id
 * @property array $depdrop
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class Test3 extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $name;
    public $sender;
    public $receiver;
    public $time;
    public $read;
    public $user_group_id;
    public $user_group_ids;
    public $group;
    public $user_company_id;
    public $depdrop;
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

    public static ?string $dbase = 'db';

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
			'name',
			'sender',
			'receiver',
			'time',
			'read',
			'user_group_id',
			'user_group_ids',
			'group',
			'user_company_id',
			'depdrop',
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
        return static function (ConfigDB $config) {

            $config->faker = true;
            $config->name = 'Сообщения';

            $config->title = Az::l('Test3');
            $config->fakerCount = 100;


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
           
            'sender' => function (FormDb $column) {

                $column->title = Az::l('Отправитель');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
						'config' =>[
							'tags' => true,
						],
					];
                $column->filterOptions = [
						'config' =>[
							'tags' => true,
						],
					];
                $column->indexSearch = true;
                $column->fkTable = 'user';

                return $column;
            },
            
           
            'receiver' => function (FormDb $column) {

                $column->title = Az::l('Получатель');
                $column->dbType = dbTypeJsonb;
                $column->options = [
						'config' =>[
							'formClass' => 'zetsoft\former\eyuf\PTest',
						],
					];
                $column->valueOptions = [
						'config' =>[
							'formClass' => 'zetsoft\former\eyuf\PTest',
						],
					];
                $column->filterOptions = [
						'config' =>[
							'formClass' => 'zetsoft\former\eyuf\PTest',
						],
					];
                $column->indexSearch = true;

                return $column;
            },
            
           
            'time' => function (FormDb $column) {

                $column->title = Az::l('Time');
                $column->dbType = dbTypeDateTime;

                return $column;
            },
            
           
            'read' => function (FormDb $column) {

                $column->title = Az::l('Прочитано?');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->faker = 'name';
                $column->fakerFunc = [
                    'male',
                ];
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'user_group_id' => function (FormDb $column) {

                $column->title = Az::l('Групповой чат');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
						'config' =>[
							'tags' => true,
						],
					];
                $column->filterOptions = [
						'config' =>[
							'tags' => true,
						],
					];
                $column->faker = 'randomElement';
                $column->fakerFunc = [
                    [
                        153,
                        154,
                        155,
                        156,
                        157,
                    ],
                ];

                return $column;
            },
            
           
            'user_group_ids' => function (FormDb $column) {

                $column->title = Az::l('Групповой чат');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMRadioGroupWidget::class;
                $column->filterWidget = ZMRadioGroupWidget::class;
                $column->options = [
						'config' =>[
							'tags' => true,
							'multiple' => true,
						],
					];
                $column->filterOptions = [
						'config' =>[
							'tags' => true,
							'multiple' => true,
						],
					];

                return $column;
            },
            
           
            'group' => function (FormDb $column) {

                $column->title = Az::l('Групповой чат');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMRadioGroupWidget::class;
                $column->filterWidget = ZMRadioGroupWidget::class;
                $column->options = [
						'config' =>[
						],
					];
                $column->filterOptions = [
						'config' =>[
						],
					];
                $column->fkTable = 'core_group';
                $column->fkMulti = true;

                return $column;
            },
            
           
            'user_company_id' => function (FormDb $column) {

                $column->title = Az::l('Групповой чат');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user';
                $column->fkMulti = true;

                return $column;
            },
            
           
            'depdrop' => function (FormDb $column) {

                $column->title = Az::l('Групповой чат');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKDepDropWidget::class;
                $column->filterWidget = ZKDepDropWidget::class;
                $column->options = [
						'config' =>[
							'depend' => 'user_company_id',
							'args' => 'zetsoft\models\ALL\UserCompany|user_company_id',
						],
					];
                $column->filterOptions = [
						'config' =>[
							'depend' => 'user_company_id',
							'args' => 'zetsoft\models\ALL\UserCompany|user_company_id',
						],
					];
                $column->fkMulti = true;

                return $column;
            },
            

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'sender',
        'receiver',
        'time',
        'read',
        'user_group_id',
        'user_group_ids',
        'group',
        'user_company_id',
        'depdrop',
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
                                'sender',
                            ],
                            [
                                'receiver',
                            ],
                            [
                                'time',
                            ],
                            [
                                'read',
                            ],
                            [
                                'user_group_id',
                            ],
                            [
                                'user_group_ids',
                            ],
                            [
                                'group',
                            ],
                            [
                                'user_company_id',
                            ],
                            [
                                'depdrop',
                            ],
                            [
                                'deleted_at',
                            ],
                            [
                                'deleted_by',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(Test3 &$model = null)
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
        $event->beforeDelete = function (Test3 $model) {
            return null;
        };

        $event->afterDelete = function (Test3 $model) {
            return null;
        };

        $event->beforeSave = function (Test3 $model) {
            return null;
        };

        $event->afterSave = function (Test3 $model) {
            return null;
        };

        $event->beforeValidate = function (Test3 $model) {
            return null;
        };

        $event->afterValidate = function (Test3 $model) {
            return null;
        };

        $event->afterRefresh = function (Test3 $model) {
            return null;
        };

        $event->afterFind = function (Test3 $model) {
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



    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}
