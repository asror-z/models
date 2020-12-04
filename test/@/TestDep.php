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


use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\deps\DepsDropForm;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\models\user\User;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;



/**
 * Class    TestDep
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property string $page_module_id
 * @property string $page_control_id
 * @property string $page_action_id
 * @property array $form
 * @property array $multi
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class TestDep extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $name;
    public $page_module_id;
    public $page_control_id;
    public $page_action_id;
    public $form;
    public $multi;
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
			'page_module_id',
			'page_control_id',
			'page_action_id',
			'form',
			'multi',
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
            $config->name = 'Сектор образования';

            $config->title = Az::l('TestFile2');
            $config->fakerCount = 10;


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
           
            'page_module_id' => function (FormDb $column) {

                $column->title = Az::l('Inner File 1');
                $column->widget = ZDepdropWidget::class;

                return $column;
            },
            
           
            'page_control_id' => function (FormDb $column) {

                $column->title = Az::l('Inner File 2');
                $column->widget = ZDepdropWidget::class;
                $column->options = [
						'config' =>[
							'depend' => 'page_module_id',
							'args' => 'zetsoft\models\page\PageControl|page_module_id',
						],
					];

                return $column;
            },
            
           
            'page_action_id' => function (FormDb $column) {

                $column->title = Az::l('Inner File 3');
                $column->widget = ZDepdropWidget::class;
                $column->options = [
						'config' =>[
							'depend' => 'page_control_id',
							'args' => 'zetsoft\models\page\PageAction|page_control_id',
						],
					];

                return $column;
            },
            
           
            'form' => function (FormDb $column) {

                $column->title = Az::l('Form');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
						'config' =>[
							'formClass' => 'zetsoft\former\deps\DepsDropForm',
						],
					];
                $column->valueOptions = [
						'config' =>[
							'formClass' => 'zetsoft\former\deps\DepsDropForm',
						],
					];
                $column->modalWidth = '700px';

                return $column;
            },
            
           
            'multi' => function (FormDb $column) {

                $column->title = Az::l('Multi');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;
                $column->options = [
						'config' =>[
							'formClass' => 'zetsoft\former\deps\DepsDropForm',
						],
					];
                $column->valueOptions = [
						'config' =>[
							'formClass' => 'zetsoft\former\deps\DepsDropForm',
						],
					];
                $column->modalWidth = '1200px';

                return $column;
            },
            

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'page_module_id',
        'page_control_id',
        'page_action_id',
        'form',
        'multi',
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
                                'page_module_id',
                            ],
                            [
                                'page_control_id',
                            ],
                            [
                                'page_action_id',
                            ],
                            [
                                'form',
                            ],
                            [
                                'multi',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(TestDep &$model = null)
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
        $event->beforeDelete = function (TestDep $model) {
            return null;
        };

        $event->afterDelete = function (TestDep $model) {
            return null;
        };

        $event->beforeSave = function (TestDep $model) {
            return null;
        };

        $event->afterSave = function (TestDep $model) {
            return null;
        };

        $event->beforeValidate = function (TestDep $model) {
            return null;
        };

        $event->afterValidate = function (TestDep $model) {
            return null;
        };

        $event->afterRefresh = function (TestDep $model) {
            return null;
        };

        $event->afterFind = function (TestDep $model) {
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
