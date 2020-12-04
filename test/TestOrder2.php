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


use kartik\grid\DataColumn;
use Underscore\Types\Number;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\calls\CallsCdr;
use zetsoft\models\calls\CallsCel;
use zetsoft\models\calls\CallsOrder;
use zetsoft\models\calls\CallsRecord;
use zetsoft\models\calls\CallsUserman;
use zetsoft\models\cpas\CpasTracker;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\place\PlaceRegion;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\shop\ShopShipment;
use zetsoft\models\user\User;
use zetsoft\models\user\UserCompany;
use zetsoft\models\ware\Ware;
use zetsoft\models\ware\WareAccept;
use zetsoft\models\ware\WareReturn;
use zetsoft\service\cores\Date;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\column\ZKDataColumn;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\audios\ZAudioWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZInputMaskWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\models\shop\ShopRejectCause;
use zetsoft\models\shop\ShopDelay;
use zetsoft\models\shop\ShopDelayCause;
use zetsoft\models\shop\ShopPackaging;
use zetsoft\models\shop\ShopCoupon;
use zetsoft\models\shop\ShopChannel;
use zetsoft\models\shop\ShopElement;
use zetsoft\models\shop\ShopPayment;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZPeriodPickerWidget;
use zetsoft\widgets\navigat\ZButtonWidget;
use zetsoft\widgets\values\ZDateFormatWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    TestOrder2
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $code
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $number
 * @property int $user_id
 * @property int $parent
 * @property int $children
 * @property string $contact_name
 * @property string $status_universal
 * @property string $contact_phone
 * @property string $add_contact_phone
 * @property string $date
 * @property string $comment_user
 * @property int $responsible
 * @property int $place_adress_id
 * @property int $place_region_id
 * @property double $distance
 * @property array $user_company_ids
 * @property int $operator
 * @property string $comment_agent
 * @property string $tasks
 * @property int $source
 * @property string $source_type
 * @property string $called_time
 * @property int $shop_reject_cause_id
 * @property string $cpas_track
 * @property string $status_client
 * @property string $status_callcenter
 * @property string $status_autodial
 * @property string $status_logistics
 * @property string $status_accept
 * @property string $status_deliver
 * @property string $date_deliver
 * @property string $date_approve
 * @property string $date_return
 * @property string $delayed_deliver_date
 * @property int $shop_delay_id
 * @property int $shop_delay_cause_id
 * @property int $packaging
 * @property string $labelled
 * @property string $fragile
 * @property double $weight
 * @property double $weight_plan
 * @property int $volume
 * @property int $shop_shipment_id
 * @property int $price
 * @property int $prepayment
 * @property int $deliver_price
 * @property int $total_price
 * @property int $shop_coupon_id
 * @property int $shop_channel_id
 * @property string $payment_type
 * @property string $additional_payment_type
 * @property int $additional_deliver
 * @property int $additional_received_money
 * @property boolean $accepted
 * @property array $shop_element_ids
 * @property array $ware_ids
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class TestOrder2 extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $sort;
    public $name;
    public $code;
    public $title;
    public $tranz;
    public $accept;
    public $active;
    public $number;
    public $user_id;
    public $parent;
    public $children;
    public $contact_name;
    public $status_universal;
    public $contact_phone;
    public $add_contact_phone;
    public $date;
    public $comment_user;
    public $responsible;
    public $place_adress_id;
    public $place_region_id;
    public $distance;
    public $user_company_ids;
    public $operator;
    public $comment_agent;
    public $tasks;
    public $source;
    public $source_type;
    public $called_time;
    public $shop_reject_cause_id;
    public $cpas_track;
    public $status_client;
    public $status_callcenter;
    public $status_autodial;
    public $status_logistics;
    public $status_accept;
    public $status_deliver;
    public $date_deliver;
    public $date_approve;
    public $date_return;
    public $delayed_deliver_date;
    public $shop_delay_id;
    public $shop_delay_cause_id;
    public $packaging;
    public $labelled;
    public $fragile;
    public $weight;
    public $weight_plan;
    public $volume;
    public $shop_shipment_id;
    public $price;
    public $prepayment;
    public $deliver_price;
    public $total_price;
    public $shop_coupon_id;
    public $shop_channel_id;
    public $payment_type;
    public $additional_payment_type;
    public $additional_deliver;
    public $additional_received_money;
    public $accepted;
    public $shop_element_ids;
    public $ware_ids;
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
        'code',
        'title',
        'tranz',
        'accept',
        'active',
        'number',
        'user_id',
        'parent',
        'children',
        'contact_name',
        'status_universal',
        'contact_phone',
        'add_contact_phone',
        'date',
        'comment_user',
        'responsible',
        'place_adress_id',
        'place_region_id',
        'distance',
        'user_company_ids',
        'operator',
        'comment_agent',
        'tasks',
        'source',
        'source_type',
        'called_time',
        'shop_reject_cause_id',
        'cpas_track',
        'status_client',
        'status_callcenter',
        'status_autodial',
        'status_logistics',
        'status_accept',
        'status_deliver',
        'date_deliver',
        'date_approve',
        'date_return',
        'delayed_deliver_date',
        'shop_delay_id',
        'shop_delay_cause_id',
        'packaging',
        'labelled',
        'fragile',
        'weight',
        'weight_plan',
        'volume',
        'shop_shipment_id',
        'price',
        'prepayment',
        'deliver_price',
        'total_price',
        'shop_coupon_id',
        'shop_channel_id',
        'payment_type',
        'additional_payment_type',
        'additional_deliver',
        'additional_received_money',
        'accepted',
        'shop_element_ids',
        'ware_ids',
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

    /* @var array $_status_universal*/
    public $_status_universal;  
    public const status_universal = [
        'change' => 'change',
        'free' => 'free',
        'error' => 'error',
        'cancel' => 'cancel',
    ];

    /* @var array $_source_type*/
    public $_source_type;  
    public const source_type = [
        'basket' => 'basket',
        'offline' => 'offline',
        'onclick' => 'onclick',
        'funnel' => 'funnel',
        'mobile_version' => 'mobile_version',
        'by_call' => 'by_call',
        'concultancy' => 'concultancy',
        'social' => 'social',
        'cheaper' => 'cheaper',
        'abandoned_basket' => 'abandoned_basket',
    ];

    /* @var array $_status_client*/
    public $_status_client;  
    public const status_client = [
        'accepted' => 'accepted',
        'approved' => 'approved',
        'forming' => 'forming',
        'delivering' => 'delivering',
        'delivered' => 'delivered',
        'received' => 'received',
        'not_received' => 'not_received',
        'not_delivered' => 'not_delivered',
    ];

    /* @var array $_status_callcenter*/
    public $_status_callcenter;  
    public const status_callcenter = [
        'new' => 'new',
        'ring' => 'ring',
        'autodial' => 'autodial',
        'approved' => 'approved',
        'cancel' => 'cancel',
        'not_ordered' => 'not_ordered',
        'double' => 'double',
        'incorrect' => 'incorrect',
        'on_performance' => 'on_performance',
        'check' => 'check',
    ];

    /* @var array $_status_autodial*/
    public $_status_autodial;  
    public const status_autodial = [
        'autodial' => 'autodial',
        'answered' => 'answered',
        'busy' => 'busy',
        'not-available' => 'not-available',
        'error' => 'error',
        'success' => 'success',
        'no-answer' => 'no-answer',
        'dial-success' => 'dial-success',
        'dial-failed' => 'dial-failed',
    ];

    /* @var array $_status_logistics*/
    public $_status_logistics;  
    public const status_logistics = [
        'new' => 'new',
        'cancelled' => 'cancelled',
        'complect_wait' => 'complect_wait',
        'on_complecting' => 'on_complecting',
        'notset' => 'notset',
        'shipment_ready' => 'shipment_ready',
        'courier_appointment' => 'courier_appointment',
        'reported' => 'reported',
        'completed' => 'completed',
        'part_paid' => 'part_paid',
        'part_refunded' => 'part_refunded',
        'delivery_failure' => 'delivery_failure',
        'delivery_transfer' => 'delivery_transfer',
        'exchange' => 'exchange',
        'cancel' => 'cancel',
        'annulled' => 'annulled',
    ];

    /* @var array $_status_accept*/
    public $_status_accept;  
    public const status_accept = [
        'completed' => 'completed',
        'part_paid' => 'part_paid',
        'delivery_failure' => 'delivery_failure',
        'delivery_transfer' => 'delivery_transfer',
        'exchange' => 'exchange',
        'cancel' => 'cancel',
    ];

    /* @var array $_status_deliver*/
    public $_status_deliver;  
    public const status_deliver = [
        'delivered' => 'delivered',
        'received' => 'received',
        'completed' => 'completed',
        'part_paid' => 'part_paid',
        'part_refunded' => 'part_refunded',
        'delivery_failure' => 'delivery_failure',
        'delivery_transfer' => 'delivery_transfer',
        'annulled' => 'annulled',
    ];

    /* @var array $_payment_type*/
    public $_payment_type;  
    public const payment_type = [
        'cash' => 'cash',
        'uzcard' => 'uzcard',
        'humo' => 'humo',
        'transfer' => 'transfer',
    ];

    /* @var array $_additional_payment_type*/
    public $_additional_payment_type;  
    public const additional_payment_type = [
        'cash' => 'cash',
        'uzcard' => 'uzcard',
        'humo' => 'humo',
        'transfer' => 'transfer',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Заказы';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_status_universal = [
            'change' => Az::l('Обмен'),
            'free' => Az::l('Бесплатный курс'),
            'error' => Az::l('Заказ по ошибке'),
            'cancel' => Az::l('Отказ'),
        ];
        
        $this->_source_type = [
            'basket' => Az::l('Корзина'),
            'offline' => Az::l('Оффлайн'),
            'onclick' => Az::l('В один клик'),
            'funnel' => Az::l('Воронка продаж'),
            'mobile_version' => Az::l('Мобильная версия'),
            'by_call' => Az::l('По телефону'),
            'concultancy' => Az::l('Онлайн консультант'),
            'social' => Az::l('Социальные сети'),
            'cheaper' => Az::l('Нашли дешевле'),
            'abandoned_basket' => Az::l('Брошенные корзины'),
        ];
        
        $this->_status_client = [
            'accepted' => Az::l('Принят'),
            'approved' => Az::l('Одобрен'),
            'forming' => Az::l('Формируется'),
            'delivering' => Az::l('Доставляется'),
            'delivered' => Az::l('Доставлено'),
            'received' => Az::l('Получено'),
            'not_received' => Az::l('Не получено'),
            'not_delivered' => Az::l('Не доставлено'),
        ];
        
        $this->_status_callcenter = [
            'new' => Az::l('Новый'),
            'ring' => Az::l('На исполнения'),
            'autodial' => Az::l('Автообзвон'),
            'approved' => Az::l('Одобрен'),
            'cancel' => Az::l('Отказ'),
            'not_ordered' => Az::l('Не заказывал'),
            'double' => Az::l('Дубль'),
            'incorrect' => Az::l('Треш'),
            'on_performance' => Az::l('На исполнении'),
            'check' => Az::l('Проверка'),
        ];
        
        $this->_status_autodial = [
            'autodial' => Az::l('Идет автодозвон'),
            'answered' => Az::l('Ответил'),
            'busy' => Az::l('Занятый'),
            'not-available' => Az::l('Недоступно'),
            'error' => Az::l('Недоступно'),
            'success' => Az::l('Ответил'),
            'no-answer' => Az::l('Нет ответа'),
            'dial-success' => Az::l('Дозвон успешный'),
            'dial-failed' => Az::l('Дозвон не удался'),
        ];
        
        $this->_status_logistics = [
            'new' => Az::l('Новый'),
            'cancelled' => Az::l('Отменен колл центром'),
            'complect_wait' => Az::l('В ожидании комплектации'),
            'on_complecting' => Az::l('На комплектации'),
            'notset' => Az::l('Не комплект'),
            'shipment_ready' => Az::l('Готов к отгрузке'),
            'courier_appointment' => Az::l('К назначению курьера'),
            'reported' => Az::l('Передан в подотчёт'),
            'completed' => Az::l('Выполнена оплата'),
            'part_paid' => Az::l('Оплачен частично'),
            'part_refunded' => Az::l('Возврат частично'),
            'delivery_failure' => Az::l('Отказ во время доставки'),
            'delivery_transfer' => Az::l('Перенос даты доставки'),
            'exchange' => Az::l('Обмен'),
            'cancel' => Az::l('Отменено'),
            'annulled' => Az::l('Аннулирован'),
        ];
        
        $this->_status_accept = [
            'completed' => Az::l('Выполнена оплата'),
            'part_paid' => Az::l('Частичный выкуп'),
            'delivery_failure' => Az::l('Отказ во время доставки'),
            'delivery_transfer' => Az::l('Перенос дата доставки'),
            'exchange' => Az::l('Обмен'),
            'cancel' => Az::l('Отменено'),
        ];
        
        $this->_status_deliver = [
            'delivered' => Az::l('Доставлено'),
            'received' => Az::l('Получено'),
            'completed' => Az::l('Выполнена оплата'),
            'part_paid' => Az::l('Оплачен частично'),
            'part_refunded' => Az::l('Возврат частично'),
            'delivery_failure' => Az::l('Отказ во время доставки'),
            'delivery_transfer' => Az::l('Перенос дата доставки'),
            'annulled' => Az::l('Аннулирован'),
        ];
        
        $this->_payment_type = [
            'cash' => Az::l('Наличные'),
            'uzcard' => Az::l('Карта UzCard'),
            'humo' => Az::l('Карта Humo'),
            'transfer' => Az::l('Безналичный расчет'),
        ];
        
        $this->_additional_payment_type = [
            'cash' => Az::l('Наличные'),
            'uzcard' => Az::l('Карта UzCard'),
            'humo' => Az::l('Карта Humo'),
            'transfer' => Az::l('Безналичный расчет'),
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
			'code',
			'title',
			'tranz',
			'accept',
			'active',
			'number',
			'user_id',
			'parent',
			'children',
			'contact_name',
			'status_universal',
			'contact_phone',
			'add_contact_phone',
			'date',
			'comment_user',
			'responsible',
			'place_adress_id',
			'place_region_id',
			'distance',
			'user_company_ids',
			'operator',
			'comment_agent',
			'tasks',
			'source',
			'source_type',
			'called_time',
			'shop_reject_cause_id',
			'cpas_track',
			'status_client',
			'status_callcenter',
			'status_autodial',
			'status_logistics',
			'status_accept',
			'status_deliver',
			'date_deliver',
			'date_approve',
			'date_return',
			'delayed_deliver_date',
			'shop_delay_id',
			'shop_delay_cause_id',
			'packaging',
			'labelled',
			'fragile',
			'weight',
			'weight_plan',
			'volume',
			'shop_shipment_id',
			'price',
			'prepayment',
			'deliver_price',
			'total_price',
			'shop_coupon_id',
			'shop_channel_id',
			'payment_type',
			'additional_payment_type',
			'additional_deliver',
			'additional_received_money',
			'accepted',
			'shop_element_ids',
			'ware_ids',
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

            $config->addCode = true;
            $config->nameValue = 'Заказ клиента №{number} от {created_at}. Ф.И.О {contact_name}';

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $config->codeValue = function (TestOrder $model) {
                return Number::paddingLeft($model->number, 12);
            };

            $config->title = Az::l('Заказы');

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

            'number' => function (FormDb $column) {

                $column->title = Az::l('Номер заказа');
                $column->readonly = true;
                $column->widget = ZSelect2Widget::class;
                $column->width = '100px';
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'user_id' => function (FormDb $column) {

                $column->title = Az::l('Клиент');
                $column->dbType = dbTypeInteger;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                $column->width = '120px';

                return $column;
            },


            'parent' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Вышестоящий');
                $column->dbType = dbTypeInteger;
                $column->readonly = true;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                        'placeholder' => 'bosya',   
                    ],
                ];
                $column->fkTable = 'shop_order';

                return $column;
            },


            'children' => function (FormDb $column) {

                $column->title = Az::l('Связанные');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZSelect2Widget::class;
                $column->fkTable = 'shop_order';
                $column->fkQuery = [
                    'parent' => null
                ];
                $column->options = [
                    'config' => [
                        'ajax' => true,
                        'multiple' => true,
                    ],
                ];

                return $column;
            },


            'contact_name' => function (FormDb $column) {

                $column->title = Az::l('Контактное имя');
                $column->rules = [
                    [
                        validatorString,
                    ],

                ];

                return $column;
            },


            'status_universal' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Универсальный статус');
                $column->data = [
                    'change' => Az::l('Обмен'),
                    'free' => Az::l('Бесплатный курс'),
                    'error' => Az::l('Заказ по ошибке'),
                    'cancel' => Az::l('Отказ'),
                ];
                /* $column->rules = validatorString;*/
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                        'multiple' => true,
                    ],
                ];

                return $column;
            },


            'contact_phone' => function (FormDb $column) {

                $column->title = Az::l('Контактный номер');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorString,
                    ],
                ];

                $column->widget = ZInputMaskWidget::class;
                $column->options = [
                    'config' => [
                        'alias' => 'datetime',
                    ],
                ];

                return $column;
            },


            'add_contact_phone' => function (FormDb $column) {

                $column->title = Az::l('Дополнительный контактный номер');
                $column->rules = validatorString;
                $column->widget = ZInputMaskWidget::class;

                return $column;
            },


            'date' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Дата');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;
                $column->valueWidget = ZDateFormatWidget::class;
                return $column;
            },


            'comment_user' => function (FormDb $column) {

                $column->title = Az::l('Комментарий к заказу');
                $column->tooltip = Az::l('Комментарий Оператора');
                $column->rules = validatorString;

                return $column;
            },


            'responsible' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Ответственный');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZSelect2Widget::class;
                $column->fkTable = 'user';
                $column->fkQuery = [

                    'role' => [
                        'manager',
                        'admin',
                        'logistics',
                        'warehouse',
                    ],

                ];
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'place_adress_id' => function (FormDb $column) {

                $column->title = Az::l('Место доставки');
                $column->dbType = dbTypeInteger;
                /*$column->rules = [
                    [
                        validatorInteger,
                    ],
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ]
                ];*/
                $column->widget = ZSelect2Widget::class;
                $column->width = '220px';
                $column->options = [
                    'config' => [
                        'ajax' => true,
                        'multiple' => true,
                    ],
                ];

                return $column;
            },


            'place_region_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Регион');
                $column->auto = true;
                $column->autoValue = static function (TestOrder $order) {

                    /** @var PlaceAdress $adress */

                    if (!$order->place_adress_id)
                        return null;

                    $adress = PlaceAdress::findOne($order->place_adress_id);

                    if ($adress === null)
                        return null;

                    return $adress->place_region_id;

                };

                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [validatorInteger],
                ];
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'distance' => function (FormDb $column) {

                $column->title = Az::l('Дистанция');
                $column->tooltip = Az::l('Дистанция между покупателем и магазином');
                $column->dbType = dbTypeDouble;
                $column->rules = validatorDouble;

                return $column;
            },


            'user_company_ids' => function (FormDb $column) {

                $column->title = Az::l('Магазины');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'multiple' => true,
                        'ajax' => true,
                    ],
                ];
                $column->fkQuery = [
                    'type' => 'market',
                ];
                $column->readonly = true;

                return $column;
            },


            'operator' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Оператор');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];

                $column->fkQuery = [
                    'role' => 'agent',
                ];

                $column->fkTable = 'user';

                return $column;
            },


            'comment_agent' => function (FormDb $column) {

                $column->title = Az::l('Комментарий оператора');
                $column->rules = validatorString;

                return $column;
            },


            'tasks' => function (FormDb $column) {

                $column->title = Az::l('Поручения оператору');
                $column->rules = validatorString;

                return $column;
            },


            'source' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Источник');
                $column->auto = true;
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [validatorInteger],
                ];
                $column->widget = ZSelect2Widget::class;
                $column->fkTable = 'user_company';
                $column->fkQuery = [
                    'type' => 'source'
                ];
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];


                return $column;
            },

            'source_type' => function (FormDb $column) {

                $column->title = Az::l('Источник заказа');
                $column->data = [
                    'basket' => Az::l('Корзина'),
                    'offline' => Az::l('Оффлайн'),
                    'onclick' => Az::l('В один клик'),
                    'funnel' => Az::l('Воронка продаж'),
                    'mobile_version' => Az::l('Мобильная версия'),
                    'by_call' => Az::l('По телефону'),
                    'concultancy' => Az::l('Онлайн консультант'),
                    'social' => Az::l('Социальные сети'),
                    'cheaper' => Az::l('Нашли дешевле'),
                    'abandoned_basket' => Az::l('Брошенные корзины'),
                ];
                $column->rules = validatorString;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'called_time' => function (FormDb $column) {

                $column->title = Az::l('Время звонка');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;
                /*$column->filterWidget = ZPeriodPickerWidget::class;
                $column->period = true;*/

                return $column;
            },


            /*   'call_record' => function (FormDb $column) {

                   $column->title = Az::l('Аудиозапись звонка');
                   $column->dbType = dbTypeJsonb;
                   $column->widget = ZAudioWidget::class;
                   $column->valueWidget = ZAudioWidget::class;
                   $column->filterWidget = ZHInputWidget::class;
                   $column->valueOptions = [
                       'config' => [
                           'value' => true,
                       ],
                   ];
                   $column->width = '400px';
                   $column->readonly = true;

                   return $column;
               },*/


            'shop_reject_cause_id' => function (FormDb $column) {

                $column->title = Az::l('Причина отказа');
                $column->rules = validatorString;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },
            'cpas_track' => function (FormDb $column) {

                $column->title = Az::l('Номер заказа СПА');
                $column->rules = validatorInteger;
                $column->readonly = true;

                return $column;
            },


            'status_client' => function (FormDb $column) {

                $column->title = Az::l('Статусы клиента');
                $column->data = [
                    'accepted' => Az::l('Принят'),
                    'approved' => Az::l('Одобрен'),
                    'forming' => Az::l('Формируется'),
                    'delivering' => Az::l('Доставляется'),
                    'delivered' => Az::l('Доставлено'),
                    'received' => Az::l('Получено'),
                    'not_received' => Az::l('Не получено'),
                    'not_delivered' => Az::l('Не доставлено'),
                ];
                $column->rules = validatorString;
                $column->widget = ZSelect2Widget::class;
                $column->history = true;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'status_callcenter' => function (FormDb $column) {

                $column->title = Az::l('Статусы колл центра');
                $column->value = 'new';
                $column->data = [
                    'new' => Az::l('Новый'),
                    'ring' => Az::l('На исполнения'),
                    'autodial' => Az::l('Автообзвон'),
                    'approved' => Az::l('Одобрен'),
                    'cancel' => Az::l('Отказ'),
                    'not_ordered' => Az::l('Не заказывал'),
                    'double' => Az::l('Дубль'),
                    'incorrect' => Az::l('Треш'),
                    'on_performance' => Az::l('На исполнении'),
                    'check' => Az::l('Проверка'),
                ];
                $column->event = function (TestOrder $model) {
                    Az::$app->market->order->sendStatusToCpa($model, 'status_callcenter');
                };
                $column->rules = validatorString;
                $column->widget = ZSelect2Widget::class;
                $column->history = true;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'status_autodial' => function (FormDb $column) {

                $column->title = Az::l('Статусы автодозвона');
                $column->data = [
                    'autodial' => Az::l('Идет автодозвон'),
                    'answered' => Az::l('Ответил'),
                    'busy' => Az::l('Занятый'),
                    'not-available' => Az::l('Недоступно'),
                    'error' => Az::l('Недоступно'),
                    'success' => Az::l('Ответил'),
                    'no-answer' => Az::l('Нет ответа'),
                    'dial-success' => Az::l('Дозвон успешный'),
                    'dial-failed' => Az::l('Дозвон не удался'),
                ];
                $column->rules = validatorString;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'status_logistics' => function (FormDb $column) {

                $column->title = Az::l('Статусы логистики');
                $column->value = 'new';

                $column->data = [
                    'new' => Az::l('Новый'),
                    'cancelled' => Az::l('Отменен колл центром'),
                    'complect_wait' => Az::l('В ожидании комплектации'),
                    'on_complecting' => Az::l('На комплектации'),
                    'notset' => Az::l('Не комплект'),
                    'shipment_ready' => Az::l('Готов к отгрузке'),
                    'courier_appointment' => Az::l('К назначению курьера'),
                    'reported' => Az::l('Передан в подотчёт'),
                    'completed' => Az::l('Выполнена оплата'),
                    'part_paid' => Az::l('Оплачен частично'),
                    'part_refunded' => Az::l('Возврат частично'),
                    'delivery_failure' => Az::l('Отказ во время доставки'),
                    'delivery_transfer' => Az::l('Перенос даты доставки'),
                    'exchange' => Az::l('Обмен'),
                    'cancel' => Az::l('Отменено'),
                    'annulled' => Az::l('Аннулирован'),
                ];
                $column->rules = validatorString;
                $column->event = function (ShopOrder $model) {
                    Az::$app->market->order->sendStatusToCpa($model, 'status_logistics');
                };
                $column->widget = ZSelect2Widget::class;
                $column->history = true;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'status_accept' => function (FormDb $column) {

                $column->title = Az::l('Статусы приемки логистики');
                $column->data = [
                    'completed' => Az::l('Выполнена оплата'),
                    'part_paid' => Az::l('Частичный выкуп'),
                    'delivery_failure' => Az::l('Отказ во время доставки'),
                    'delivery_transfer' => Az::l('Перенос дата доставки'),
                    'exchange' => Az::l('Обмен'),
                    'cancel' => Az::l('Отменено'),
                ];
                $column->rules = validatorString;
                $column->widget = ZSelect2Widget::class;
                $column->history = true;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'status_deliver' => function (FormDb $column) {

                $column->title = Az::l('Статусы курьера');
                $column->data = [
                    'delivered' => Az::l('Доставлено'),
                    'received' => Az::l('Получено'),
                    'completed' => Az::l('Выполнена оплата'),
                    'part_paid' => Az::l('Оплачен частично'),
                    'part_refunded' => Az::l('Возврат частично'),
                    'delivery_failure' => Az::l('Отказ во время доставки'),
                    'delivery_transfer' => Az::l('Перенос дата доставки'),
                    'annulled' => Az::l('Аннулирован'),
                ];
                $column->rules = validatorString;
                $column->widget = ZSelect2Widget::class;
                $column->history = true;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'date_deliver' => function (FormDb $column) {

                $column->title = Az::l('Дата доставки');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;
                //$column->valueWidget = ZDateFormatWidget::class;
                $column->modalHeight = '200px';

                return $column;
            },


            'date_approve' => function (FormDb $column) {

                $column->title = Az::l('Дата одобрения');

                $column->dbType = dbTypeDateTime;

                $column->widget = ZKDatepickerWidget::class;

                return $column;
            },


            'date_return' => function (FormDb $column) {

                $column->title = Az::l('Дата возврата');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;

                return $column;
            },


            'delayed_deliver_date' => function (FormDb $column) {

                $column->title = Az::l('Перенесенная дата доставки');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;

                return $column;
            },


            'shop_delay_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Перенос доставки');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'tags' => true,
                        'ajax' => true,
                    ],
                ];

                return $column;
            },


            'shop_delay_cause_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Причина переноса доставки');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'tags' => true,
                        'ajax' => true,
                    ],
                ];

                return $column;
            },


            'packaging' => function (FormDb $column) {

                $column->title = Az::l('Тип упаковки');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZSelect2Widget::class;
                $column->fkTable = 'shop_packaging';
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'labelled' => function (FormDb $column) {

                $column->title = Az::l('Маркированный');
                $column->rules = validatorString;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },


            'fragile' => function (FormDb $column) {

                $column->title = Az::l('Хрупкий');
                $column->rules = validatorString;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },


            'weight' => function (FormDb $column) {

                $column->title = Az::l('Вес заказа в граммах');
                $column->dbType = dbTypeDouble;
                $column->rules = validatorDouble;

                return $column;
            },


            'weight_plan' => function (FormDb $column) {

                $column->title = Az::l('Вес по плану');
                $column->dbType = dbTypeDouble;
                $column->rules = validatorDouble;

                return $column;
            },


            'volume' => function (FormDb $column) {

                $column->title = Az::l('Объём');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },


            'shop_shipment_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Доставка');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'price' => function (FormDb $column) {

$column->event = function (TestOrder $model) {
                    $model->total_price = $model->price;
                    $model->user_id = $model->id;
                    $model->number = "$model->id | $model->price";
                };

                $column->title = Az::l('Сумма');
                $column->diff = true;
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZKTouchSpinWidget::class;

                return $column;
            },


            'prepayment' => function (FormDb $column) {

                $column->defaultValue = 0;
                $column->title = Az::l('Предоплата');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZKTouchSpinWidget::class;

                return $column;
            },


            'deliver_price' => function (FormDb $column) {

$column->defaultValue = 0;
                $column->title = Az::l('Сумма доставки');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [validatorInteger,],
                ];
                $column->widget = ZKTouchSpinWidget::class;

                return $column;
            },


            'total_price' => function (FormDb $column) {

                $column->title = Az::l('Общая сумма');
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZKTouchSpinWidget::class;
                $column->width = '100px';
                $column->readonly = true;
                //$column->auto = true;
                /*$column->autoValue = function (TestOrder $model) {
                    return (int)$model->price + (int)$model->deliver_price;
                };*/

                return $column;
            },


            'shop_coupon_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Купон');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZSelect2Widget::class;
                $column->fkTable = 'shop_coupon';
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'shop_channel_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Каналы продаж');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'payment_type' => function (FormDb $column) {

                $column->title = Az::l('Cпособ оплаты');
                $column->data = [
                    'cash' => Az::l('Наличные'),
                    'uzcard' => Az::l('Карта UzCard'),
                    'humo' => Az::l('Карта Humo'),
                    'transfer' => Az::l('Безналичный расчет'),
                ];
                $column->rules = [
                    [validatorString],
                ];
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'additional_payment_type' => function (FormDb $column) {

                $column->title = Az::l('Дополнительный способ оплаты');
                $column->data = [
                    'cash' => Az::l('Наличные'),
                    'uzcard' => Az::l('Карта UzCard'),
                    'humo' => Az::l('Карта Humo'),
                    'transfer' => Az::l('Безналичный расчет'),
                ];
                $column->rules = validatorString;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                return $column;
            },


            'additional_deliver' => function (FormDb $column) {

                $column->title = Az::l('Дополнительная доставка');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },


            'additional_received_money' => function (FormDb $column) {

                $column->title = Az::l('Сумма оплаченная дополнительным способом');
                $column->rules = validatorInteger;
                $column->dbType = dbTypeBigInteger;
                $column->widget = ZKTouchSpinWidget::class;
                return $column;
            },


            'accepted' => function (FormDb $column) {

                $column->title = Az::l('Принят');
                $column->dbType = dbTypeBoolean;
                $column->rules = validatorBoolean;

                return $column;
            },


            'shop_element_ids' => function (FormDb $column) {

                $column->title = Az::l('Товары');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'multiple' => true,
                        'ajax' => true,
                    ],
                ];

                $column->readonly = true;

                return $column;
            },


            'ware_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Склады откуда идет доставка');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                        'multiple' => true,
                    ],
                ];
                $column->readonly = true;

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
        'code',
        'title',
        'tranz',
        'accept',
        'active',
        'number',
        'user_id',
        'parent',
        'children',
        'contact_name',
        'status_universal',
        'contact_phone',
        'add_contact_phone',
        'date',
        'comment_user',
        'responsible',
        'place_adress_id',
        'place_region_id',
        'distance',
        'user_company_ids',
        'operator',
        'comment_agent',
        'tasks',
        'source',
        'source_type',
        'called_time',
        'shop_reject_cause_id',
        'cpas_track',
        'status_client',
        'status_callcenter',
        'status_autodial',
        'status_logistics',
        'status_accept',
        'status_deliver',
        'date_deliver',
        'date_approve',
        'date_return',
        'delayed_deliver_date',
        'shop_delay_id',
        'shop_delay_cause_id',
        'packaging',
        'labelled',
        'fragile',
        'weight',
        'weight_plan',
        'volume',
        'shop_shipment_id',
        'price',
        'prepayment',
        'deliver_price',
        'total_price',
        'shop_coupon_id',
        'shop_channel_id',
        'payment_type',
        'additional_payment_type',
        'additional_deliver',
        'additional_received_money',
        'accepted',
        'shop_element_ids',
        'ware_ids',
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
                                'code',
                            ],
                            [
                                'date',
                                'responsible',
                            ],
                            [
                                'user_id',
                                'contact_name',
                            ],
                            [
                                'contact_phone',
                                'add_contact_phone',
                                'called_time',
                            ],
                            [
                                'comment_user',
                                'place_adress_id',
                            ],
                            [
                                'distance',
                                'user_company_ids',
                            ],
                            [
                                'ware_ids',
                                'operator',
                            ],
                            [
                                'comment_agent',
                                'tasks',
                            ],
                            [
                                'source',
                                'shop_reject_cause_id',
                            ],
                            [
                                'status_client',
                                'status_callcenter',
                            ],
                            [
                                'status_accept',
                                'date_deliver',
                            ],
                            [
                                'date_approve',
                                'date_return',
                            ],
                            [
                                'delayed_deliver_date',
                                'weight_plan',
                            ],
                            [
                                'shop_delay_id',
                                'shop_delay_cause_id',
                            ],
                            [
                                'packaging',
                                'labelled',
                            ],
                            [
                                'fragile',
                                'weight',
                            ],
                            [
                                'volume',
                                'shop_shipment_id',
                            ],
                            [
                                'price',
                                'deliver_price',
                            ],
                            [
                                'total_price',
                                'shop_coupon_id',
                            ],
                            [
                                'shop_channel_id',
                                'payment_type',
                            ],
                            [
                                'additional_payment_type',
                                'additional_received_money',
                            ],
                            [
                                'additional_deliver',
                                'prepayment',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(TestOrder &$model = null)
    {
        if ($model === null) {
            $model = $this;
        }

        $TestOrderItems = TestOrderItem::find()
            ->where([
                'shop_order_id' => $model->id
            ])
            ->all();

        /*$TestOrderItem = new TestOrderItem();

        $shopCatalog = ShopCatalog::find()->where(['id' => $TestOrderItem->shop_catalog_id])->all();*/


        if (!$this->emptyOrNullable($TestOrderItems) && !$this->emptyOrNullable($model)) {
            if ($model->user_company_ids === null)
                $model->user_company_ids = [];

            if ($model->ware_ids === null)
                $model->ware_ids = [];

            $collectedItems = collect($TestOrderItems);
            if (empty($model->user_company_ids) || !is_array($model->user_company_ids))
                $model->user_company_ids = [];

            $user_company_ids = ZArrayHelper::merge($model->user_company_ids, ZArrayHelper::getColumn($TestOrderItems, 'user_company_id'));

            $model->shop_element_ids = ZArrayHelper::getColumn($TestOrderItems, 'id');

            $model->user_company_ids = array_unique($user_company_ids);
            if (empty($model->ware_ids) || !is_array($model->ware_ids))
                $model->ware_ids = [];
            $ware_ids = ZArrayHelper::merge($model->ware_ids, ZArrayHelper::getColumn($TestOrderItems, 'ware_id'));

            $model->user_company_ids = array_unique($ware_ids);

        }

        $model->configs->rules = [[validatorSafe]];

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


        /*$event->beforeDelete = function (TestOrderItem $model) {

            TestOrderItem::deleteAll([
                'shop_order_id' => $model->id
            ]);

        };*/

        /*$event->beforeSave = function (TestOrder $model) {

            // $this->value($model);

            if (ZArrayHelper::keyExists($model->status_accept, self::status_logistics))
                $model->status_logistics = $model->status_accept;

            $model->total_price = Az::$app->menu->orderNorms->setTotalPrice($model);

            if ($this->isNewRecord) {
                $model->status_client = TestOrder::status_client['accepted'];
                $model->status_logistics = TestOrder::status_logistics['new'];
                $model->status_callcenter = TestOrder::status_callcenter['new'];
            } else {
                if ($this->emptyOrNullable($model->shop_shipment_id)) {

                    $shopShipment = ShopShipment::findOne($model->shop_shipment_id);
                    if ($shopShipment !== null) {

                    }
                }
            }

        };*/

        /* if (!$this->isNewRecord) {
             if ($model->oldAttributes['operator_id'] == null and $model->operator_id != null) {
                 $model->status = $this->_status['checking'];
             }
             // For add status history on change status
             if ($model->oldAttributes['status'] != $model->status) {
                 $time = date('Y-m-d h:i:s');
                 $new_status = $model->status;
                 $old_status = $model->oldAttributes['status'];
                 $user_id = $this->userIdentity()->id;

                 $new_json = [
                     'time' => $time,
                     'new_status' => $new_status,
                     'old_status' => $old_status,
                     'user_id' => $user_id,
                 ];

                 $status = $model->oldAttributes['status_history'];
                 $status[] = $new_json;

                 $model->status_history = $status;
             }
         }*/

        /*    $event->beforeSave = function (TestOrder $model) {
                if (!$this->isNewRecord) {

                    switch ($model->status_logistics) {

                        case TestOrder::status_logistics['buyed']:
                            Az::$app->market->order->orderBuyed($model);
                            break;

                    }

                }
            };*/

        /*
        $event->beforeDelete = function (UserCompany $model) {
        return null;
        };

        $event->afterDelete = function (UserCompany $model) {
        return null;
        };

        $event->beforeSave = function (UserCompany $model) {
        return null;
        };
          */

        /*
        $event->afterSave = function (TestOrder $model) {

            $del_price = Az::$app->maps->distance->deliverPrice($model->id, $model->user_company_id);

            $model->deliver_price = $del_price;

            $model->save();

        };
        */

        /*
      $event->beforeValidate = function (UserCompany $model) {
      return null;
      };

      $event->afterValidate = function (UserCompany $model) {
      return null;
      };

      $event->afterRefresh = function (UserCompany $model) {
      return null;
      };

      $event->afterFind = function (UserCompany $model) {
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
