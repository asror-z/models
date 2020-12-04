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
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\widgets\values\ZAdressViewWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;



/**
 * Class    Test4
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property int $page_module_id
 * @property int $page_control_id
 * @property array $place_region_form
 * @property int $page_action_id
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class Test4 extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $name;
    public $page_module_id;
    public $page_control_id;
    public $place_region_form;
    public $page_action_id;
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
			'place_region_form',
			'page_action_id',
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

            $config->name = 'Сообщения';

            $config->title = Az::l('Test4');

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

                $column->title = Az::l('Modules');
                $column->tooltip = Az::l('Modules ');
                $column->dbType = dbTypeInteger;
                $column->widget = ZDepdropWidget::class;

                return $column;
            },
            
           
            'page_control_id' => function (FormDb $column) {

                $column->title = Az::l('brand ?');
                $column->tooltip = Az::l('brand');
                $column->dbType = dbTypeInteger;
                $column->widget = ZDepdropWidget::class;
                $column->options = [
						'config' =>[
							'depend' => 'page_module_id',
							'args' => 'zetsoft\models\ALL\CoreControl|page_module_id',
						],
					];
                $column->filterOptions = [
						'config' =>[
							'depend' => 'page_module_id',
							'args' => 'zetsoft\models\ALL\CoreControl|page_module_id',
						],
					];

                return $column;
            },
            
           
            'place_region_form' => function (FormDb $column) {

                $column->title = Az::l('Место (Регион)');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZAdressViewWidget::class;
                $column->options = [
						'config' =>[
							'formClass' => 'zetsoft\former\map\MapRegionForm',
						],
					];
                $column->valueOptions = [
						'config' =>[
							'formClass' => 'zetsoft\former\map\MapRegionForm',
						],
					];
                $column->filterOptions = [
						'config' =>[
							'formClass' => 'zetsoft\former\map\MapRegionForm',
						],
					];
                $column->mergeHeader = true;

                return $column;
            },
            
           
            'page_action_id' => function (FormDb $column) {

                $column->title = Az::l('brand ?');
                $column->tooltip = Az::l('brand ');
                $column->dbType = dbTypeInteger;
                $column->widget = ZDepdropWidget::class;
                $column->options = [
						'config' =>[
							'depend' => 'page_control_id',
							'args' => 'zetsoft\models\ALL\PageAction|page_control_id',
						],
					];
                $column->filterOptions = [
						'config' =>[
							'depend' => 'page_control_id',
							'args' => 'zetsoft\models\ALL\PageAction|page_control_id',
						],
					];

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
        'place_region_form',
        'page_action_id',
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
                                'place_region_form',
                            ],
                            [
                                'page_action_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(Test4 &$model = null)
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
        $event->beforeDelete = function (Test4 $model) {
            return null;
        };

        $event->afterDelete = function (Test4 $model) {
            return null;
        };

        $event->beforeSave = function (Test4 $model) {
            return null;
        };

        $event->afterSave = function (Test4 $model) {
            return null;
        };

        $event->beforeValidate = function (Test4 $model) {
            return null;
        };

        $event->afterValidate = function (Test4 $model) {
            return null;
        };

        $event->afterRefresh = function (Test4 $model) {
            return null;
        };

        $event->afterFind = function (Test4 $model) {
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
