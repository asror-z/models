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


use zetsoft\dbitem\data\ALLApp;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\dbitem\form\DependItem;
use zetsoft\former\place\PlaceRegionForm;
use zetsoft\models\place\PlaceRegion;
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
use zetsoft\widgets\values\ZJsonWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\dbitem\data\Form;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    TestAsror6
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $number
 * @property string $email
 * @property array $region
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class TestAsror6 extends ZActiveRecord
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
    public $number;
    public $email;
    public $region;
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
        'number',
        'email',
        'region',
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
    public static ?string $title = Azl . 'Каталог';
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
			'number',
			'email',
			'region',
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
                $column->changeSave = false;
                //$column->changeReload = '#asrorz';
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

                    switch ($model->number) {
                        case 1234:
                            return ZKSelect2Widget::class;
                            break;

                        default:
                            return ZHInputWidget::class;
                            break;
                    }

                };


                return $column;
            },


        ], $this->configs->replace);


        $forms['region'] = function (FormDb $column) {

            $column->title = Az::l('Регионы');
            $column->dbType = dbTypeJsonb;
            $column->changeSave = false;
            $column->widget = ZFormWidget::class;

            if (!$this->callableCan())
                return $column;

            $app = new ALLApp();

            $configs = new Config();
            $configs->changeSave = true;

            $app->parentAttr = 'region';
            $app->parentClass = self::class;
            $app->parentId = $this->id;
            $app->configs = $configs;

            $form = new Form();
            $form->title = Az::l('Main');
            $form->fkTable = 'place_region';
            $form->changeSave = true;
            $form->fkQuery = [
                'parent_id' => null
            ];
            $form->widget = ZKSelect2Widget::class;

            $app->columns['region_0'] = $form;

            $formEx = new Form();
            $formEx->title = Az::l('Main');
            $formEx->changeSave = true;
            $formEx->fkTable = 'place_region';
            $formEx->widget = ZKSelect2Widget::class;

            $data = [];

            $item = new DependItem();
            $item->native = 'one';
            $item->title = 'Регион уровня #1';
            $item->parent = 'place_region_id';
            $data[] = $item;

            $item = new DependItem();
            $item->native = 'two';
            $item->title = 'Регион уровня #2';
            $item->parent = 'one';
            $data[] = $item;

            //start|DavlatovRavshan|2020.10.10

            $values = $this->region;

            $i = 1;

            foreach ($data as $item) {

                $value = ZArrayHelper::getValue($values, $item->parent);
                $region = null;
                if (!empty($value))
                    $region = PlaceRegion::findAll([
                        'parent_id' => $value
                    ]);

                if (!empty($region)) {

                    $form = clone $formEx;

                    $form->title = $item->title;
                    $form->fkQuery = [
                        'parent_id' => $value
                    ];

                    $app->columns['region_' . $i] = $form;

                }

                $i++;
                
            }
            //end | DavlatovRavshan | 10.10.2020
            $object = Az::$app->forms->former->model($app, null, $values);
            //end|DavlatovRavshan|2020-10-10

            $column->options = [
                'config' => [
                    'formObject' => $object,
                ],
            ];


            return $column;
        };

        return $forms;


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
        'number',
        'email',
        'region',
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
                                'number',
                            ],
                            [
                                'email',
                            ],
                            [
                                'region',
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


    #endregion

    #region One



    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}
