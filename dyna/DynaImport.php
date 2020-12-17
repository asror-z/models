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


use zetsoft\dbitem\core\SessionItem;
use zetsoft\dbitem\data\ALLApp;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\kernels\ZView;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\system\actives\ZModel;
use zetsoft\models\dyna\DynaConfig;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\incores\ZMCheckboxWidget;


/**
 * Class    DynaImport
 * @package zetsoft\models\App
 *
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $modelClass
 * @property array $excel
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class DynaImport extends ZActiveRecord
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
    public $modelClass;
    public $excel;
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
        'modelClass',
        'excel',
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
    public static ?string $title = Azl . 'Конфигурации универсального фильтра';
    public static ?string $icon = 'fal fa-list-alt';
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
            'modelClass',
            'excel',
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
            $config->nameShowForm = false;
            $config->hasOne = [
                'User' => [
                    'deleted_by' => 'id',
                    'created_by' => 'id',
                    'modified_by' => 'id',
                ],
            ];
            $config->icon = 'fal fa-list-alt';

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

            'modelClass' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('DynaConfig');

                return $column;
            },

            'excel' => function (FormDb $column) {

                $column->title = Az::l('Excel');
                $column->tooltip = Az::l('Excel');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
//                $column->valueWidget = ZDownloadWidget::class;
                $column->format = 'raw';
                $column->width = '250px';
                $column->mergeHeader = true;
                $column->edit = false;

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
        'modelClass',
        'excel',
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
                                'dynaId',
                                'attr',
                                'operator',
                                'value',
                                'active',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    function value(DynaMulti &$model = null)
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
    function event()
    {

        $event = new Event();

        $event->afterSave = function (DynaImport $model) {
//            if (!$this->emptyOrNullable($model->excel))
//                Az::$app->forms->import->import($model);
        };
        /*
            $event->beforeDelete = function (DynaMulti $model) {
                return null;
            };

            $event->afterDelete = function (DynaMulti $model) {
                return null;
            };

            $event->beforeSave = function (DynaMulti $model) {
                return null;
            };



            $event->beforeValidate = function (DynaMulti $model) {
                return null;
            };

            $event->afterValidate = function (DynaMulti $model) {
                return null;
            };

            $event->afterRefresh = function (DynaMulti $model) {
                return null;
            };

            $event->afterFind = function (DynaMulti $model) {
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
