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
use zetsoft\former\place\PlaceRegionForm;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZIconPickerWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\user\UserCompany;
use zetsoft\models\shop\ShopElement;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;



/**
 * Class    TestAsror
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property string $number
 * @property string $email
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class TestAsror extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $name;
    public $number;
    public $email;
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
			'number',
			'email',
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

            $config->title = Az::l('Каталог');

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

        $forms = ZArrayHelper::merge(parent::column(), [

            'number' => function (FormDb $column) {

                $column->title = Az::l('Номер заказа');
                $column->width = '100px';
             //   $column->changeSubmit = 'this';
                $column->changeReload = '#asrorz';

                $column->options = [
                    'active' => [
                        'change' => false,
                    ],
                    'event' => [
                        'change' => "
                             
                          $.pjax.reload({
                    container: '#asrorz', 
                    async:true,
               });
               
                        "
                    ]
                ];
                return $column;
            },


            'email' => function (FormDb $column) {

                $column->title = Az::l('email клиента');
                $column->width = '100px';
                $column->auto = true;
                
                $column->autoValue = function ($model) {
                    return $model->number;
                };
                $column->widget = function ($model) {

       /*             if (Az::$app->utility->cache->paramGet(paramMigration))
                        return ZHInputWidget::class;*/

                    switch ($model->number) {
                        case 1234:
                            return ZKSelect2Widget::class;
                            break;

                        default:
                            return ZHInputWidget::class;

                    }

                };


                return $column;
            },


        ], $this->configs->replace);

/*
        $forms['region'] = function (FormDb $column) {

            $object = new PlaceRegion();
            

            $column->title = Az::l('region');
            $column->dbType = dbTypeJsonb;
            $column->widget = ZFormWidget::class;
            $column->valueWidget = ZFormViewWidget::class;
            $column->options = [
                'config' => [
                    'formObject' => $object,
                ],
            ];
            $column->valueOptions = [
                'config' => [
                    'formObject' => $object,
                ],
            ];
            $column->mergeHeader = true;

            return $column;
        };*/

        return  $forms;


    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'number',
        'email',
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
                                'number',
                                'email',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(TestAsror &$model = null)
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
            $event->beforeDelete = function (TestAsror1 $model) {
                return null;
            };

            $event->afterDelete = function (TestAsror1 $model) {
                return null;
            };

            $event->beforeSave = function (TestAsror1 $model) {
                return null;
            };

            $event->afterSave = function (TestAsror1 $model) {
                return null;
            };

            $event->beforeValidate = function (TestAsror1 $model) {
                return null;
            };

            $event->afterValidate = function (TestAsror1 $model) {
                return null;
            };

            $event->afterRefresh = function (TestAsror1 $model) {
                return null;
            };

            $event->afterFind = function (TestAsror1 $model) {
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
