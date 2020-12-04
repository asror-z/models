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


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\dbitem\data\Event;
use zetsoft\models\user\User;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;



/**
 * Class    TestR
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property array $form
 * @property array $file
 * @property array $cbu
 * @property array $single
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class TestR extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $name;
    public $form;
    public $file;
    public $cbu;
    public $single;
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
			'form',
			'file',
			'cbu',
			'single',
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

            $config->title = Az::l('Сектор образования');
            $config->makeMenu = false;

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
           
            'form' => function (FormDb $column) {

                $column->title = Az::l('form');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
						'formClass' => 'zetsoft\former\shop\OptionTypeForm',
					];
                $column->valueOptions = [
						'formClass' => 'zetsoft\former\shop\OptionTypeForm',
					];
                $column->filterOptions = [
						'formClass' => 'zetsoft\former\shop\OptionTypeForm',
					];

                return $column;
            },
            
           
            'file' => function (FormDb $column) {

                $column->title = Az::l('Переводы');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;
                $column->options = [
						'formClass' => 'zetsoft\former\deps\DepsDropForm',
					];
                $column->valueOptions = [
						'formClass' => 'zetsoft\former\deps\DepsDropForm',
					];
                $column->filterOptions = [
						'formClass' => 'zetsoft\former\deps\DepsDropForm',
					];

                return $column;
            },
            
           
            'cbu' => function (FormDb $column) {

                $column->title = Az::l('Курсы ЦБУ');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->filterWidget = ZFormWidget::class;
                $column->options = [
						'formClass' => 'zetsoft\former\deps\DepsDropForm',
					];
                $column->filterOptions = [
						'formClass' => 'zetsoft\former\deps\DepsDropForm',
					];

                return $column;
            },
            
           
            'single' => function (FormDb $column) {

                $column->title = Az::l('Переводы');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'form',
        'file',
        'cbu',
        'single',
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
                                'form',
                            ],
                            [
                                'file',
                            ],
                            [
                                'cbu',
                            ],
                            [
                                'single',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(TestR &$model = null)
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
        $event->beforeDelete = function (TestR $model) {
            return null;
        };

        $event->afterDelete = function (TestR $model) {
            return null;
        };

        $event->beforeSave = function (TestR $model) {
            return null;
        };

        $event->afterSave = function (TestR $model) {
            return null;
        };

        $event->beforeValidate = function (TestR $model) {
            return null;
        };

        $event->afterValidate = function (TestR $model) {
            return null;
        };

        $event->afterRefresh = function (TestR $model) {
            return null;
        };

        $event->afterFind = function (TestR $model) {
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
