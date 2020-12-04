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


use zetsoft\dbdata\grap\DynamicData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\deps\DepsFilterForm;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;
use zetsoft\widgets\inputes\ZCKEditorWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\user\User;
use zetsoft\dbcore\chat\ChatMailCore;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;


/**
 * Class    DynaMulti
 * @package zetsoft\models\App
 *
 * @property int $id
 * @property string $name
 * @property array $filter
 * @property string $dynaId
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DynaMultiItem extends ZActiveRecord
{

    #region MVars

    /*
    
    public $id;
    public $name;
    public $filter;
    public $dynaId;
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

    public function init()
    {
        parent::init();


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

            $config->icon='fal fa-filter';
            $config->hasOne = [
                'User' => [
                    'created_by' => 'id',
                    'modified_by' => 'id',
                ],
            ];
            $config->title = Az::l('Конфигурации универсального фильтра');

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

            'dynaId' => function (FormDb $column) {

                $column->title = Az::l('ID фильтра');
                $column->rules = [
                    [
                        validatorUnique,
                    ],
                ];
                $column->showForm = false;
                $column->index = true;
                $column->indexUnique = true;
                $column->widget = function (DynaMulti $model) {
                    //vd($model);
                    return ZKSelect2Widget::class;
                };

                return $column;
            },




            'group' => function (FormDb $column) {

                $column->title = Az::l('Группировка');
                $column->dbType = dbTypeString;
                $column->index = true;
                $column->data = [
                    'null' => Az::l('Без группировки'),
                    'and' => Az::l('AND'),
                    'or' => Az::l('OR'),
                    'not' => Az::l('NOT'),
                ];
                $column->value = 'none';
                $column->widget = ZKSelect2Widget::class;
                return $column;
            },

            'attribute' => function (Form $column) {

                $column->title = Az::l('Аттрибут');
                $column->widget = ZKSelect2Widget::class;
                $column->data = DynamicData::class;
                $column->rules = [
                    ['zetsoft\\system\\validate\\ZRequiredValidator']
                ];
                $column->value = Az::$app->cores->session->get('filterAttributes');

                return $column;
            },

            'operator' => function (Form $column) {

                $column->title = Az::l('Операторы');
                $column->data = [
                    '=' => 'равно',
                    '>' => 'больше',
                    '>=' => 'больше и равно',
                    '<' => 'меньше',
                    '<=' => 'меньше и равно',
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->rules = [
                    ['zetsoft\\system\\validate\\ZRequiredValidator']
                ];
                return $column;
            },


            'value' => function (Form $column) {

                $column->title = Az::l('Значение');
                $column->rules = [
                    ['zetsoft\\system\\validate\\ZRequiredValidator']
                ];
                $column->widget = function (DepsFilterForm $model) {
                    //   vd($model);
                    return ZKSelect2Widget::class;
                };


                return $column;
            },

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'filter',
        'dynaId',
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
                                'dynaId',
                                'filter',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value

    public function value(DynaConfig $model = null)
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
        $event->beforeDelete = function (CoreDyna $model) {
        return null;
        };

        $event->afterDelete = function (CoreDyna $model) {
        return null;
        };

        $event->beforeSave = function (CoreDyna $model) {
        return null;
        };

        $event->afterSave = function (CoreDyna $model) {
        return null;
        };

        $event->beforeValidate = function (CoreDyna $model) {
        return null;
        };

        $event->afterValidate = function (CoreDyna $model) {
        return null;
        };

        $event->afterRefresh = function (CoreDyna $model) {
        return null;
        };

        $event->afterFind = function (CoreDyna $model) {
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
     * @return \yii\db\ActiveQuery
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
     * @return \yii\db\ActiveQuery
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
