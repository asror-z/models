<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\ware;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZHTextareaWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\user\UserCompany;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\ware\WareEnter;
use zetsoft\models\ware\WareExit;
use zetsoft\models\ware\Ware;
use zetsoft\models\ware\WareTransItem;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\system\validate\IdenticalValidator;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    WareTrans
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $date
 * @property int $user_company_id
 * @property int $ware_enter_id
 * @property int $ware_exit_id
 * @property int $warehouse_from
 * @property int $warehouse_to
 * @property int $responsible
 * @property string $comment
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class WareTrans extends ZActiveRecord
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
    public $date;
    public $user_company_id;
    public $ware_enter_id;
    public $ware_exit_id;
    public $warehouse_from;
    public $warehouse_to;
    public $responsible;
    public $comment;
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
        'date',
        'user_company_id',
        'ware_enter_id',
        'ware_exit_id',
        'warehouse_from',
        'warehouse_to',
        'responsible',
        'comment',
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
    public static ?string $title = Azl . 'Перемещение между складами';
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
			'date',
			'user_company_id',
			'ware_enter_id',
			'ware_exit_id',
			'warehouse_from',
			'warehouse_to',
			'responsible',
			'comment',
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

            $config->titleId = 'Номер';

                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $config->nameValue = static function ($model) {

                Az::$app->forms->wiData->clean();
                Az::$app->forms->wiData->model = $model;
                Az::$app->forms->wiData->attribute = 'warehouse_from';
                $first = Az::$app->forms->wiData->value();

                Az::$app->forms->wiData->clean();
                Az::$app->forms->wiData->model = $model;
                Az::$app->forms->wiData->attribute = 'warehouse_to';
                $second = Az::$app->forms->wiData->value();

                return "Перемещение с $first в $second №{$model->id}";

            };

            $config->hasOne = [
                    'UserCompany' => [
                        'user_company_id' => 'id',
                    ],
                    'WareEnter' => [
                        'ware_enter_id' => 'id',
                    ],
                    'WareExit' => [
                        'ware_exit_id' => 'id',
                    ],
                    'Ware' => [
                        'warehouse_from' => 'id',
                        'warehouse_to' => 'id',
                    ],
                    'User' => [
                        'responsible' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'WareTransItem' => [
                        'ware_trans_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Перемещение между складами');

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

            'date' => function (FormDb $column) {

                $column->title = Az::l('Дата');
                $column->tooltip = Az::l('Дата создания перемещения между складами');
                $column->dbType = dbTypeDate;
                $column->showDyna = false;
                $column->readonly = true;
                $column->readonlyWidget = true;
                $column->widget = ZKDatepickerWidget::class;
                return $column;
            },


            'user_company_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Магазин');
                $column->tooltip = Az::l('Магазин откуда производится перемещение');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkQuery = [
                    'type' => 'market',
                ];

                return $column;
            },


            'ware_enter_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('ИД поступления в склад');

                return $column;
            },


            'ware_exit_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('ИД списания со склада');

                return $column;
            },


            'warehouse_from' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Склад-отправитель');
                $column->tooltip = Az::l('Склад откуда списывается товар для перемещения');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZDepdropWidget::class;
                $column->filterWidget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'multiple' => false,
                        'depend' => 'user_company_id',
                        'service' => 'wares',
                        'namespace' => 'market',
                        'method' => 'depWare',
                    ],
                ];
                $column->fkTable = 'ware';

                return $column;
            },


            'warehouse_to' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Склад-получатель');
                $column->tooltip = Az::l('Склад куда поступает товар');
                $column->rules = [
                    [
                        IdenticalValidator::class,
                        'first' => 'warehouse_from',
                        'second' => 'warehouse_to',
                        'message' => 'Склады не могут быть одинаковыми',
                    ],
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'ware';

                return $column;
            },


            'responsible' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Ответственный');
                $column->tooltip = Az::l('Ответственное лицо, создавшее акт пермещения между складами');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user';
                $column->fkQuery = [
                    'role' => [
                        'manager',
                        'admin',
                        'logistics',
                        'warehouse',
                    ],
                ];

                return $column;
            },


            'comment' => function (FormDb $column) {

                $column->title = Az::l('Комментарий');
                $column->tooltip = Az::l('Комментарий к перемещению между складами');
                $column->widget = ZHTextareaWidget::class;
                $column->filterWidget = ZInputWidget::class;

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
        'date',
        'user_company_id',
        'ware_enter_id',
        'ware_exit_id',
        'warehouse_from',
        'warehouse_to',
        'responsible',
        'comment',
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
                                'date',
                                'user_company_id',
                                'warehouse_from',
                                'warehouse_to',
                                'responsible',
                                'comment',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(WareTrans $model = null)
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
        $event->beforeSave = function (WareTrans $model) {

            if ($this->isNewRecord) {

                $ware_exit = new WareExit();
                $ware_exit->user_company_id = $model->user_company_id;
                $ware_exit->ware_id = $model->warehouse_from;
                $ware_exit->source = WareExit::source['trans'];

                $ware_exit->save();
                $model->ware_exit_id = $ware_exit->id;

                $ware_enter = new WareEnter();
                $ware_enter->user_company_id = $model->user_company_id;
                $ware_enter->ware_id = $model->warehouse_to;
                $ware_enter->source = WareEnter::source['trans'];

                $ware_enter->save();
                $model->ware_enter_id = $ware_enter->id;

            }

        };
        /*
        $event->beforeDelete = function (ShopCatalog $model) {
        return null;
        };

        $event->afterDelete = function (ShopCatalog $model) {
        return null;
        };

        $event->beforeSave = function (ShopCatalog $model) {
        return null;
        };

        $event->afterSave = function (ShopCatalog $model) {
        return null;
        };

        $event->beforeValidate = function (ShopCatalog $model) {
        return null;
        };

        $event->afterValidate = function (ShopCatalog $model) {
        return null;
        };

        $event->afterRefresh = function (ShopCatalog $model) {
        return null;
        };

        $event->afterFind = function (ShopCatalog $model) {
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
     * Function  getUserCompany
     * @return bool|\yii\db\ActiveRecord|UserCompany|null
     */            
    public function getUserCompanyOne()
    {
        return $this->getOne(UserCompany::class, [
          'id' => 'user_company_id',
      ]);    
    }
    
     /**
     *
     * Function  getUserCompany
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getUserCompany()
    {
        return $this->hasOne(UserCompany::class, [
          'id' => 'user_company_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getWareEnter
     * @return bool|\yii\db\ActiveRecord|WareEnter|null
     */            
    public function getWareEnterOne()
    {
        return $this->getOne(WareEnter::class, [
          'id' => 'ware_enter_id',
      ]);    
    }
    
     /**
     *
     * Function  getWareEnter
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWareEnter()
    {
        return $this->hasOne(WareEnter::class, [
          'id' => 'ware_enter_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getWareExit
     * @return bool|\yii\db\ActiveRecord|WareExit|null
     */            
    public function getWareExitOne()
    {
        return $this->getOne(WareExit::class, [
          'id' => 'ware_exit_id',
      ]);    
    }
    
     /**
     *
     * Function  getWareExit
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWareExit()
    {
        return $this->hasOne(WareExit::class, [
          'id' => 'ware_exit_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getWarehouseFrom
     * @return bool|\yii\db\ActiveRecord|Ware|null
     */            
    public function getWarehouseFromOne()
    {
        return $this->getOne(Ware::class, [
          'id' => 'warehouse_from',
      ]);    
    }
    
     /**
     *
     * Function  getWarehouseFrom
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWarehouseFrom()
    {
        return $this->hasOne(Ware::class, [
          'id' => 'warehouse_from',
      ]);    
    }
    
    

    /**
     *
     * Function  getWarehouseTo
     * @return bool|\yii\db\ActiveRecord|Ware|null
     */            
    public function getWarehouseToOne()
    {
        return $this->getOne(Ware::class, [
          'id' => 'warehouse_to',
      ]);    
    }
    
     /**
     *
     * Function  getWarehouseTo
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWarehouseTo()
    {
        return $this->hasOne(Ware::class, [
          'id' => 'warehouse_to',
      ]);    
    }
    
    

    /**
     *
     * Function  getResponsible
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getResponsibleOne()
    {
        return $this->getOne(User::class, [
          'id' => 'responsible',
      ]);    
    }
    
     /**
     *
     * Function  getResponsible
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getResponsible()
    {
        return $this->hasOne(User::class, [
          'id' => 'responsible',
      ]);    
    }
    
    

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


    /**
     *
     * Function  getWareTransItemsWithWareTransIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareTransItem
     */            
    public function getWareTransItemsWithWareTransIdMany()
    {
       return $this->getMany(WareTransItem::class, [
            'ware_trans_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareTransItemsWithWareTransId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareTransItemsWithWareTransId()
    {
       return $this->hasMany(WareTransItem::class, [
            'ware_trans_id' => 'id',
        ]);     
    }


    #endregion


}
