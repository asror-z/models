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
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\place\PlaceRegion;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\helpers\ZVarDumper;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    TestAsror3
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
 * @property string $phone_number
 * @property string $user_name
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
class TestAsror3 extends ZActiveRecord
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
    public $phone_number;
    public $user_name;
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
        'phone_number',
        'user_name',
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
			'phone_number',
			'user_name',
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
                $column->changeSave = true;
                /*  $column->auto = true;
                  $column->autoValue = function ($model) {

                      $values = $model->email;

                  };*/
                //$column->changeReload = '#asrorz';
                return $column;
            },


            'phone_number' => function (FormDb $column) {

                $column->title = Az::l('Nomer Telephone');

                $column->changeSave = true;

                $column->widget = ZHInputWidget::class;

                //$column->changeReload = '#asrorz';

                return $column;
            },


            'user_name' => function (FormDb $column) {

                $column->title = Az::l('Nomer Telephone');

                $column->changeSave = true;

                $column->widget = ZHInputWidget::class;
                $column->filterWidget = ZHInputWidget::class;

                //$column->changeReload = '#asrorz';

                return $column;
            },


            'email' => function (FormDb $column) {

                $column->title = Az::l('email клиента');
                $column->width = '100px';
                $column->auto = true;

                /*$column->autoValue = function ($model) {
                    return $model->number;
                };*/
                $column->data = function ($model) {
                    return [
                        'sadfsadfsadfsadf',
                        'sadfsadfsadfsadf',
                        'sadfsadfsadfsadf',
                    ];
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


            'region' => function (FormDb $column) {

                $column->title = Az::l('Регионы');
                $column->dbType = dbTypeJsonb;
                $column->changeSave = false;
                $column->widget = ZFormWidget::class;
                //$column->valueWidget = ZFormViewWidget::class;

                if (!$this->callableCan())
                    return $column;

                $app = new ALLApp();

                $configs = new Config();
                $configs->changeSave = true;

                $app->parentAttr = 'region';
                $app->parentClass = self::class;
                $app->parentId = $this->id;
                $app->configs = $configs;

                //start|DavlatovRavshan|2020.10.11

                $formEx = new Form();
                $formEx->title = Az::l('Основной регион');
                $formEx->fkTable = 'place_region';
                $formEx->changeSave = true;
                $formEx->fkQuery = [
                    'parent_id' => null,
                ];
                $formEx->widget = ZKSelect2Widget::class;
                /*  $formEx->options = [
                      'config' => [
                          'multiple' => true
                      ]
                  ];*/

                $app->columns['region_0'] = $formEx;

                $values = $this->region;

                $i = 1;
                $bool = false;
                if (!empty($values)) {
                    foreach ($values as $value) {

                        $parentValue = ZArrayHelper::getValue($values, 'region_0');
                        if (empty($parentValue)) {
                            $bool = true;
                            continue;
                        }

                        $region = null;
                        if (!empty($value))
                            $region = PlaceRegion::findAll([
                                'parent_id' => $value
                            ]);

                        if (!empty($region)) {

                            $form = clone $formEx;
                            $form->title = Az::l('Регион уровня #' . $i);
                            $form->fkQuery = [
                                'parent_id' => $value
                            ];
                            $app->columns['region_' . $i] = $form;

                        }
                        $i++;
                    }
                }

                if ($bool) {
                    $this->region = null;
                }

                $object = Az::$app->forms->former->model($app, null, $values);

                //end|DavlatovRavshan|2020.10.11

                $column->options = [
                    'config' => [
                        'formObject' => $object,
                    ],
                ];

                return $column;
            },

        ], $this->configs->replace);

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
        'phone_number',
        'user_name',
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
