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
use zetsoft\former\shop\ShopOfferForm;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\system\validate\IdenticalValidator;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZHTextareaWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
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
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\shop\ShopOffer;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\ware\WareExitItem;
use zetsoft\models\ware\Ware;
use zetsoft\models\shop\ShopCourier;
use zetsoft\models\ware\WareEnterItem;
use zetsoft\models\ware\WareTrans;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    WareEnter
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
 * @property string $source
 * @property int $user_company_id
 * @property int $ware_id
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
class WareEnter extends ZActiveRecord
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
    public $source;
    public $user_company_id;
    public $ware_id;
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
        'source',
        'user_company_id',
        'ware_id',
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

    /* @var array $_source*/
    public $_source;  
    public const source = [
        'enter' => 'enter',
        'trans' => 'trans',
        'accept' => 'accept',
        'return' => 'return',
        'exchange' => 'exchange',
        'cancel' => 'cancel',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Поступление товаров в склад';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_source = [
            'enter' => Az::l('Прямой приход товара'),
            'trans' => Az::l('Перемещение между складами'),
            'accept' => Az::l('Отказ во время доставки'),
            'return' => Az::l('Возврат денежных средств'),
            'exchange' => Az::l('Обмен товара'),
            'cancel' => Az::l('Отменено'),
        ];
        

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
			'source',
			'user_company_id',
			'ware_id',
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

            $config->nameValue = 'Поступление в склад №{id} от {created_at}';

            $config->hasOne = [
                    'UserCompany' => [
                        'user_company_id' => 'id',
                    ],
                    'Ware' => [
                        'ware_id' => 'id',
                    ],
                    'User' => [
                        'responsible' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'WareEnterItem' => [
                        'ware_enter_id' => 'id',
                    ],
                    'WareTrans' => [
                        'ware_enter_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Поступление товаров в склад');

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

                $column->index = true;
                $column->title = Az::l('Дата');
                $column->tooltip = Az::l('Дата создания поступление в склад');
                $column->dbType = dbTypeDate;
                $column->showDyna = false;
                $column->readonlyWidget = true;
                $column->widget = ZKDatepickerWidget::class;
                return $column;
            },
            
           
            'source' => function (FormDb $column) {

                $column->title = Az::l('Причина прихода');
                $column->tooltip = Az::l('Причина прихода');
                $column->value = 'enter';
                $column->data = [
                    'enter' => Az::l('Прямой приход товара'),
                    'trans' => Az::l('Перемещение между складами'),
                    'accept' => Az::l('Отказ во время доставки'),
                    'return' => Az::l('Возврат денежных средств'),
                    'exchange' => Az::l('Обмен товара'),
                    'cancel' => Az::l('Отменено'),
                ];
                $column->auto = true;
                $column->value = 'enter';
                $column->defaultValue = 'enter';
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'user_company_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Магазин');
                $column->tooltip = Az::l('Магазин откуда идет поступление');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkQuery = [
                    'type' => 'market',
                ];

                return $column;
            },
            
           
            'ware_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Склад');
                $column->tooltip = Az::l('В какой склад идет поступление');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;


                return $column;
            },
            
           
            'responsible' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Ответственный');
                $column->tooltip = Az::l('Ответственное лицо создавшее поступление');
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
                $column->tooltip = Az::l('Комментарий к поступлению');
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
        'source',
        'user_company_id',
        'ware_id',
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
                                'id',
                                'name',
                            ],
                            [
                                'date',
                                'source',
                            ],
                            [
                                'user_company_id',
                                'ware_id',
                            ],
                            [
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
                            public function value(WareEnter $model = null)
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
        $event->beforeSave = function (WareEnter $model) {

            if ($this->emptyVar($model->user_company_id) || $model->user_company_id === null) {
                $model->user_company_id = $this->userIdentity()->user_company_id;
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
     * Function  getWare
     * @return bool|\yii\db\ActiveRecord|Ware|null
     */            
    public function getWareOne()
    {
        return $this->getOne(Ware::class, [
          'id' => 'ware_id',
      ]);    
    }
    
     /**
     *
     * Function  getWare
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWare()
    {
        return $this->hasOne(Ware::class, [
          'id' => 'ware_id',
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
     * Function  getWareEnterItemsWithWareEnterIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareEnterItem
     */            
    public function getWareEnterItemsWithWareEnterIdMany()
    {
       return $this->getMany(WareEnterItem::class, [
            'ware_enter_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareEnterItemsWithWareEnterId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareEnterItemsWithWareEnterId()
    {
       return $this->hasMany(WareEnterItem::class, [
            'ware_enter_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareTransWithWareEnterIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareTrans
     */            
    public function getWareTransWithWareEnterIdMany()
    {
       return $this->getMany(WareTrans::class, [
            'ware_enter_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareTransWithWareEnterId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareTransWithWareEnterId()
    {
       return $this->hasMany(WareTrans::class, [
            'ware_enter_id' => 'id',
        ]);     
    }


    #endregion


}
