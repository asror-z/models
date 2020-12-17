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


use Closure;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\shop\ShopCourier;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\shop\ShopShipment;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\helpers\ZVarDumper;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZHTextareaWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\UserCompany;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    WareAccept
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property array $dc_returns_group
 * @property string $date
 * @property string $status
 * @property int $shop_courier_id
 * @property int $shop_shipment_id
 * @property int $responsible
 * @property string $comment
 * @property int $completed
 * @property int $completed_all
 * @property int $total
 * @property int $exchange
 * @property int $refusal
 * @property int $cancel
 * @property int $date_transfer
 * @property int $terminal
 * @property int $add_delivery
 * @property int $refund
 * @property int $bonus
 * @property int $cashless
 * @property int $sales_amount
 * @property int $courier_reward
 * @property int $exchange_reward
 * @property int $refund_reward
 * @property int $salary_courier
 * @property int $remain
 * @property int $in_dollar
 * @property int $currency
 * @property int $converted
 * @property boolean $closed
 * @property string $closed_time
 * @property int $source
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class WareAccept extends ZActiveRecord
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
    public $dc_returns_group;
    public $date;
    public $status;
    public $shop_courier_id;
    public $shop_shipment_id;
    public $responsible;
    public $comment;
    public $completed;
    public $completed_all;
    public $total;
    public $exchange;
    public $refusal;
    public $cancel;
    public $date_transfer;
    public $terminal;
    public $add_delivery;
    public $refund;
    public $bonus;
    public $cashless;
    public $sales_amount;
    public $courier_reward;
    public $exchange_reward;
    public $refund_reward;
    public $salary_courier;
    public $remain;
    public $in_dollar;
    public $currency;
    public $converted;
    public $closed;
    public $closed_time;
    public $source;
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
        'dc_returns_group',
        'date',
        'status',
        'shop_courier_id',
        'shop_shipment_id',
        'responsible',
        'comment',
        'completed',
        'completed_all',
        'total',
        'exchange',
        'refusal',
        'cancel',
        'date_transfer',
        'terminal',
        'add_delivery',
        'refund',
        'bonus',
        'cashless',
        'sales_amount',
        'courier_reward',
        'exchange_reward',
        'refund_reward',
        'salary_courier',
        'remain',
        'in_dollar',
        'currency',
        'converted',
        'closed',
        'closed_time',
        'source',
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

    /* @var array $_status*/
    public $_status;  
    public const status = [
        'checked' => 'checked',
        'delivered' => 'delivered',
        'accept' => 'accept',
        'generate_doc' => 'generate_doc',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Приёмка от курьера';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_status = [
            'checked' => Az::l('Проверил факт ДС'),
            'delivered' => Az::l('Заказы сданы'),
            'accept' => Az::l('Принял ДС'),
            'generate_doc' => Az::l('Сформировать пакет документов'),
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
			'dc_returns_group',
			'date',
			'status',
			'shop_courier_id',
			'shop_shipment_id',
			'responsible',
			'comment',
			'completed',
			'completed_all',
			'total',
			'exchange',
			'refusal',
			'cancel',
			'date_transfer',
			'terminal',
			'add_delivery',
			'refund',
			'bonus',
			'cashless',
			'sales_amount',
			'courier_reward',
			'exchange_reward',
			'refund_reward',
			'salary_courier',
			'remain',
			'in_dollar',
			'currency',
			'converted',
			'closed',
			'closed_time',
			'source',
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

            $config->addDel = 1;

            $config->titleId = 'Номер';

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $config->nameValue = function ($model) {

                Az::$app->forms->wiData->clean();
                Az::$app->forms->wiData->model = $model;
                Az::$app->forms->wiData->attribute = 'shop_courier_id';
                $shop_courier_id = Az::$app->forms->wiData->value();

                /** @var WareAccept $model */
                return "Приёмка №{$model->id} от {$shop_courier_id}";

            };

            $config->hasOne = [
                    'ShopCourier' => [
                        'shop_courier_id' => 'id',
                    ],
                    'ShopShipment' => [
                        'shop_shipment_id' => 'id',
                    ],
                    'User' => [
                        'responsible' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'UserCompany' => [
                        'source' => 'id',
                    ],
                ];
            $config->title = Az::l('Приёмка от курьера');

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

            'dc_returns_group' => function (FormDb $column) {

                $column->title = Az::l('Группа возвраты ДС');
                $column->tooltip = Az::l('Возвраты товаров для приёмки');
                $column->dbType = dbTypeJsonb;
                $column->showForm = false;
                $column->showDyna = false;

                return $column;
            },


            'date' => function (FormDb $column) {

                $column->title = Az::l('Дата');
                $column->tooltip = Az::l('Дата создания приёмки');
                $column->dbType = dbTypeDate;
                $column->showDyna = false;
                $column->readonlyWidget = true;
                $column->widget = ZKDatepickerWidget::class;
                return $column;
            },


            'status' => function (FormDb $column) {

                $column->title = Az::l('Статус');
                $column->changeSave = true;
                $column->tooltip = Az::l('Статус приёмки');
                $column->data = [
                    'checked' => Az::l('Проверил факт ДС'),
                    'delivered' => Az::l('Заказы сданы'),
                    'accept' => Az::l('Принял ДС'),
                    'generate_doc' => Az::l('Сформировать пакет документов'),
                ];
                $column->event = function (WareAccept $model) {
                    if ($model->status === 'generate_doc') {
                        $model->save();
                    }
                };

                $column->widget = ZHRadioButtonGroupWidget::class;
                $column->dynaWidget = ZKSelect2Widget::class;

                return $column;
            },


            'shop_courier_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Курьер');
                $column->tooltip = Az::l('Курьер для которого открывается приёмка');

                $column->dbType = dbTypeInteger;

                $column->rules = [
                    [validatorInteger],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'shop_shipment_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Маршрутный лист');
                $column->tooltip = Az::l('Маршрутный лист указанного курьера');
                $column->dbType = dbTypeInteger;
                $column->widget = ZDepdropWidget::class;
                $column->filterWidget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'method' => 'getShipmentByCourierId',
                        'depend' => 'shop_courier_id',
                        'reverse' => true,
                    ],
                ];

                return $column;
            },


            'responsible' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Ответственный');
                $column->tooltip = Az::l('Ответственное лицо создавшее приёмку');
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
                $column->tooltip = Az::l('Комментарий к приёмке');
                $column->widget = ZHTextareaWidget::class;
                $column->filterWidget = ZInputWidget::class;

                return $column;
            },


            'completed' => function (FormDb $column) {

                $column->title = Az::l('Выполнен');
                $column->tooltip = Az::l('Общее количество выполненных заказов');
                $column->dbType = dbTypeInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },

            'completed_all' => function (FormDb $column) {

                $column->title = Az::l('Выполнен по общему');
                $column->tooltip = Az::l('Общее количество выполненных заказов считая двойных заказов');
                $column->dbType = dbTypeInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'total' => function (FormDb $column) {

                $column->title = Az::l('Всего');
                $column->tooltip = Az::l('Количество всех заказов маршрутного листа');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'exchange' => function (FormDb $column) {

                $column->title = Az::l('Обмен');
                $column->tooltip = Az::l('Количество заказов со статусом "Обмен"');
                $column->dbType = dbTypeInteger;

                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'refusal' => function (FormDb $column) {

                $column->title = Az::l('Отказ');
                $column->tooltip = Az::l('Количество заказов со статусом "Отказ"');
                $column->dbType = dbTypeInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },

            'cancel' => function (FormDb $column) {

                $column->title = Az::l('Отменено');
                $column->tooltip = Az::l('Количество заказов со статусом "Отменено"');
                $column->dbType = dbTypeInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'date_transfer' => function (FormDb $column) {

                $column->title = Az::l('Перенос даты');
                $column->tooltip = Az::l('Количество заказов со статусом "Перенос даты доставки"');
                $column->dbType = dbTypeInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'terminal' => function (FormDb $column) {

                $column->title = Az::l('Терминал');
                $column->tooltip = Az::l('Сумма оплаченная дополнительным способом "Картой"');
                $column->dbType = dbTypeBigInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'add_delivery' => function (FormDb $column) {

                $column->title = Az::l('Дополнительные доставки');
                $column->tooltip = Az::l('Сумма оплаченная за дополнительную доставку');
                $column->widget = ZHInputWidget::class;
                $column->dbType = dbTypeBigInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },


            'refund' => function (FormDb $column) {

                $column->title = Az::l('Возврат денежных средств');
                $column->tooltip = Az::l('Общая сумма возвращенных товаров');
                $column->dbType = dbTypeBigInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'bonus' => function (FormDb $column) {

                $column->title = Az::l('Бонус');
                $column->tooltip = Az::l('Бонус курьеру');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZHInputWidget::class;

                return $column;
            },


            'cashless' => function (FormDb $column) {

                $column->title = Az::l('Безналичные');
                $column->tooltip = Az::l('Сумма оплаченная безналичным способом');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'sales_amount' => function (FormDb $column) {

                $column->title = Az::l('Сумма реализации');
                $column->tooltip = Az::l('Сумма реализованных заказов');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'courier_reward' => function (FormDb $column) {

                $column->title = Az::l('Вознаграждение курьеру');
                $column->tooltip = Az::l('Вознаграждение курьеру за реализованные заказы');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'exchange_reward' => function (FormDb $column) {

                $column->title = Az::l('Вознаграждение за обмен');
                $column->tooltip = Az::l('Вознаграждение курьеру за заказы со статусом "Обмен"');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'refund_reward' => function (FormDb $column) {

                $column->title = Az::l('Вознаграждение за ВДС');
                $column->tooltip = Az::l('Вознаграждение курьеру за возврат денежных средств от клиента');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'salary_courier' => function (FormDb $column) {

                $column->title = Az::l('ЗП курьеру');
                $column->tooltip = Az::l('Общая зарплата курьеру');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'remain' => function (FormDb $column) {

                $column->title = Az::l('Общий остаток');
                $column->tooltip = Az::l('Общий остаток денег (сумма реализации )');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'in_dollar' => function (FormDb $column) {

                $column->title = Az::l('Принятые деньги в иностранной валюте');
                $column->tooltip = Az::l('Сумма принятых денег в иностранной валюте');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'currency' => function (FormDb $column) {

                $column->title = Az::l('Иностранная валюта');
                $column->tooltip = Az::l('Актуальный курс иностранной валюты');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'converted' => function (FormDb $column) {

                $column->title = Az::l('Значение в сумах');
                $column->tooltip = Az::l('Значение в сумах принятых денег в иностранной валюте');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZHInputWidget::class;
                $column->options = [
                    'config' => [
                        'hasLabel' => true,
                        'hasPlace' => false,
                    ],
                ];

                return $column;
            },


            'closed' => function (FormDb $column) {

                $column->title = Az::l('Приёмка закрыта?');
                $column->tooltip = Az::l('Приёмка закрыта?');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->event = static function (WareAccept $model) {
                    $closed = ZVarDumper::grapesValue($model->closed);
                    if ($closed === true) {
                        Az::$app->market->wares->aceptOrders($model);
                        $model->closed_time = Az::$app->cores->date->date();
                    }
                };
                return $column;
            },

            'closed_time' => function (FormDb $column) {

                $column->title = Az::l('Время закрытия приёмки');
                $column->tooltip = Az::l('Время, когда было закрыта приемка');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;

                return $column;
            },

            'source' => function (FormDb $column) {

                $column->title = Az::l('Проект');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user_company';
                $column->fkQuery = [
                    'type' => 'source'
                ];
                $column->auto = true;
                $column->showForm = false;
                $column->showDyna = false;
                $column->autoValue = function (WareAccept $model) {
                    $orders = ShopOrder::find()
                        ->where([
                            'shop_shipment_id' => $model->shop_shipment_id
                        ])
                        ->asArray()
                        ->all();

                    return ZArrayHelper::map($orders, '', 'source');
                };

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
        'dc_returns_group',
        'date',
        'status',
        'shop_courier_id',
        'shop_shipment_id',
        'responsible',
        'comment',
        'completed',
        'completed_all',
        'total',
        'exchange',
        'refusal',
        'cancel',
        'date_transfer',
        'terminal',
        'add_delivery',
        'refund',
        'bonus',
        'cashless',
        'sales_amount',
        'courier_reward',
        'exchange_reward',
        'refund_reward',
        'salary_courier',
        'remain',
        'in_dollar',
        'currency',
        'converted',
        'closed',
        'closed_time',
        'source',
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
                                'dc_returns_group',
                                'date',
                                'status',
                                'shop_courier_id',
                                'shop_shipment_id',
                                'responsible',
                                'comment',
                                'completed',
                                'total',
                                'exchange',
                                'refusal',
                                'cancel',
                                'date_transfer',
                                'terminal',
                                'add_delivery',
                                'refund',
                                'bonus',
                                'cashless',
                                'sales_amount',
                                'courier_reward',
                                'exchange_reward',
                                'refund_reward',
                                'salary_courier',
                                'remain',
                                'in_dollar',
                                'currency',
                                'converted',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(WareAccept $model = null)
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

        $event->beforeSave = function (WareAccept $model) {

            /*  $closed = ZVarDumper::grapesValue($model->closed);
              $b1 = $closed === true;

              if ($b1) {
                  Az::$app->market->wares->aceptOrders($model);
                  $model->closed_time = Az::$app->cores->date->date();
              }*/

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
     * Function  getShopCourier
     * @return bool|\yii\db\ActiveRecord|ShopCourier|null
     */            
    public function getShopCourierOne()
    {
        return $this->getOne(ShopCourier::class, [
          'id' => 'shop_courier_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopCourier
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopCourier()
    {
        return $this->hasOne(ShopCourier::class, [
          'id' => 'shop_courier_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getShopShipment
     * @return bool|\yii\db\ActiveRecord|ShopShipment|null
     */            
    public function getShopShipmentOne()
    {
        return $this->getOne(ShopShipment::class, [
          'id' => 'shop_shipment_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopShipment
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopShipment()
    {
        return $this->hasOne(ShopShipment::class, [
          'id' => 'shop_shipment_id',
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
    
    

    /**
     *
     * Function  getSource
     * @return bool|\yii\db\ActiveRecord|UserCompany|null
     */            
    public function getSourceOne()
    {
        return $this->getOne(UserCompany::class, [
          'id' => 'source',
      ]);    
    }
    
     /**
     *
     * Function  getSource
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getSource()
    {
        return $this->hasOne(UserCompany::class, [
          'id' => 'source',
      ]);    
    }
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}
