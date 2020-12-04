<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\calls;


use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\system\actives\ZModel;
use zetsoft\dbitem\data\FormDb;
use zetsoft\widgets\audios\ZAudioWidget;
use zetsoft\widgets\audios\ZPlyrWidget;
use zetsoft\widgets\images\ZHImgWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\shop\ShopOrder;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\values\ZDateFormatWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;
use zetsoft\models\user\User;



/**
 * Class    CallsCdr
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $shop_order_id
 * @property string $calldate
 * @property string $recordingfile
 * @property string $clid
 * @property string $number
 * @property string $dst
 * @property string $src
 * @property string $dcontext
 * @property string $channel
 * @property string $dstchannel
 * @property string $lastapp
 * @property string $lastdata
 * @property string $duration
 * @property string $billsec
 * @property string $disposition
 * @property string $amaflags
 * @property string $accountcode
 * @property string $uniqueid
 * @property string $userfield
 * @property string $did
 * @property string $cnum
 * @property string $cnam
 * @property string $outbound_cnum
 * @property string $outbound_cnam
 * @property string $dst_cnam
 * @property string $linkedid
 * @property string $peeraccount
 * @property string $sequence
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 */
class CallsCdr extends ZActiveRecord
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
    public $shop_order_id;
    public $calldate;
    public $recordingfile;
    public $clid;
    public $number;
    public $dst;
    public $src;
    public $dcontext;
    public $channel;
    public $dstchannel;
    public $lastapp;
    public $lastdata;
    public $duration;
    public $billsec;
    public $disposition;
    public $amaflags;
    public $accountcode;
    public $uniqueid;
    public $userfield;
    public $did;
    public $cnum;
    public $cnam;
    public $outbound_cnum;
    public $outbound_cnam;
    public $dst_cnam;
    public $linkedid;
    public $peeraccount;
    public $sequence;
    public $deleted_at;
    public $deleted_by;
    public $deleted_text;
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
        'shop_order_id',
        'calldate',
        'recordingfile',
        'clid',
        'number',
        'dst',
        'src',
        'dcontext',
        'channel',
        'dstchannel',
        'lastapp',
        'lastdata',
        'duration',
        'billsec',
        'disposition',
        'amaflags',
        'accountcode',
        'uniqueid',
        'userfield',
        'did',
        'cnum',
        'cnam',
        'outbound_cnum',
        'outbound_cnam',
        'dst_cnam',
        'linkedid',
        'peeraccount',
        'sequence',
        'deleted_at',
        'deleted_by',
        'deleted_text',
    ];

    #endregion

    #region Names

    #endregion

    #region Const

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Звонки колл центра';
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
			'shop_order_id',
			'calldate',
			'recordingfile',
			'clid',
			'number',
			'dst',
			'src',
			'dcontext',
			'channel',
			'dstchannel',
			'lastapp',
			'lastdata',
			'duration',
			'billsec',
			'disposition',
			'amaflags',
			'accountcode',
			'uniqueid',
			'userfield',
			'did',
			'cnum',
			'cnam',
			'outbound_cnum',
			'outbound_cnam',
			'dst_cnam',
			'linkedid',
			'peeraccount',
			'sequence',
			'deleted_at',
			'deleted_by',
			'deleted_text',

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

            $config->addBy = false;
            $config->hasOne = [
                    'ShopOrder' => [
                        'shop_order_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Звонки колл центра');

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

            'shop_order_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Идентификатор заказа');
                $column->tooltip = Az::l('Идентификатор заказа колл центра');
                $column->dbType = dbTypeString;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'calldate' => function (FormDb $column) {

                $column->defaultValue = '1000-01-01 00:00:00';
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Дата и время вызова');
                $column->tooltip = Az::l('Дата и время вызова колл центра');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;
                $column->valueWidget = ZDateFormatWidget::class;

                return $column;
            },


            'recordingfile' => function (FormDb $column) {

                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Имя файла, содержащего запись разговора');
                $column->tooltip = Az::l('Имя файла, содержащего запись разговора колл центра');

                $column->widget = ZAudioWidget::class;
                $column->valueWidget = ZAudioWidget::class;
                $column->filterWidget = ZHInputWidget::class;
                $column->valueOptions = [
                    'config' => [
                        'value' => true,
                    ],
                ];
                $column->width = '300px';
                $column->readonly = true;

                return $column;
            },


            'clid' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Caller ID вызывающего абонента в полном формате');
                $column->tooltip = Az::l('Caller ID вызывающего абонента в полном формате ');


                return $column;
            },


            'number' => function (FormDb $column) {

                $column->title = Az::l('Внутренний номер');
                $column->tooltip = Az::l('Внутренний номер колл центра');

                return $column;
            },


            'dst' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Пункт назначения вызова');
                $column->tooltip = Az::l('Пункт назначения вызова колл центра');


                return $column;
            },


            'src' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Идентификатор вызывающего абонента(Caller ID)');
                $column->tooltip = Az::l('Идентификатор вызывающего абонента(Caller ID)');
                $column->dbType = dbTypeString;


                return $column;
            },


            'dcontext' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Контекст назначения обработки вызова');
                $column->tooltip = Az::l('Контекст назначения обработки вызова');

                return $column;
            },


            'channel' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Канал инициатор вызова');
                $column->tooltip = Az::l('Канал инициатор вызова');

                return $column;
            },


            'dstchannel' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Канал назначения вызова');
                $column->tooltip = Az::l('Канал назначения вызова');


                return $column;
            },


            'lastapp' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Приложение обработки вызова выполненное последним в канале');
                $column->tooltip = Az::l('Приложение обработки вызова выполненное последним в канале');

                return $column;
            },


            'lastdata' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Данные приложения выполненного последним');
                $column->tooltip = Az::l('Данные приложения выполненного последним');


                return $column;
            },


            'duration' => function (FormDb $column) {

                $column->length = 11;
                $column->notNull = true;
                $column->title = Az::l('Общая продолжительность вызова в секундах');
                $column->tooltip = Az::l('Длительность вызова в секундах');
                $column->dbType = dbTypeString;


                return $column;
            },


            'billsec' => function (FormDb $column) {

                $column->length = 11;
                $column->notNull = true;
                $column->title = Az::l('Продолжительность соединения в секундах с момента ответа');
                $column->tooltip = Az::l('Длительность соединения в секундах с момента ответа');
                $column->dbType = dbTypeString;

                return $column;
            },


            'disposition' => function (FormDb $column) {

                $column->length = 45;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Состояние обработки вызова');
                $column->tooltip = Az::l('Состояние обработки вызова');


                return $column;
            },


            'amaflags' => function (FormDb $column) {

                $column->length = 11;
                $column->notNull = true;
                $column->title = Az::l('Automatic Message Accounting');
                $column->tooltip = Az::l('Автоматический учет сообщений');
                $column->dbType = dbTypeString;

                return $column;
            },


            'accountcode' => function (FormDb $column) {

                $column->length = 20;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Код аккаунта присвоенный абоненту, для биллинга например');
                $column->tooltip = Az::l('Код аккаунта присвоенный абоненту, для биллинга ');


                return $column;
            },


            'uniqueid' => function (FormDb $column) {

                $column->length = 32;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Уникальный идентификатор канала');
                $column->tooltip = Az::l('Уникальный идентификатор канала');
                $column->dbType = dbTypeString;

                return $column;
            },


            'userfield' => function (FormDb $column) {

                $column->notNull = true;
                $column->title = Az::l('Пользовательское поле');
                $column->tooltip = Az::l('Пользовательское поле');


                return $column;
            },


            'did' => function (FormDb $column) {

                $column->length = 50;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Номер Direct Inward Dialing, который используется для приема входящего вызова от оператора связи');
                $column->tooltip = Az::l('Номер прямой внутренний набор, который используется для приема входящего вызова от оператора связи');

                return $column;
            },


            'cnum' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Caller Number часть от CallerID');
                $column->tooltip = Az::l('Номер звонящего часть от CallerID');

                return $column;
            },


            'cnam' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Caller Name часть от CallerID');
                $column->tooltip = Az::l('Имя звонящего часть от CallerID');

                return $column;
            },


            'outbound_cnum' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Caller Number часть от CallerID при вызове вызываемого абонента');
                $column->tooltip = Az::l('Номер звонящего часть от CallerID при вызове вызываемого абонента');


                return $column;
            },


            'outbound_cnam' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Caller Name часть от CallerID при вызове вызываемого абонента');
                $column->tooltip = Az::l('Имя звонящего часть от CallerID при вызове вызываемого абонента');

                return $column;
            },


            'dst_cnam' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('dst_cnam');


                return $column;
            },


            'linkedid' => function (FormDb $column) {

                $column->length = 32;
                $column->notNull = true;
                $column->title = Az::l('Идентификатор вызова, возможно, охватывает несколько событий');
                $column->tooltip = Az::l('Идентификатор вызова, возможно, охватывает несколько событий');

                $column->dbType = dbTypeString;


                return $column;
            },


            'peeraccount' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Пользователь назначил данные (строку) на одноранговом узле');
                $column->tooltip = Az::l('Пользователь назначил данные (строку) на одноранговом узле');


                return $column;
            },


            'sequence' => function (FormDb $column) {

                $column->length = 11;
                $column->notNull = true;
                $column->title = Az::l('Числовое значение, которое в сочетании с uniqueid и linkid');
                $column->tooltip = Az::l('Числовое значение, которое в сочетании с уникальным идентификатором и ссылкой идентификатора');

                $column->dbType = dbTypeString;


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
        'shop_order_id',
        'calldate',
        'recordingfile',
        'clid',
        'number',
        'dst',
        'src',
        'dcontext',
        'channel',
        'dstchannel',
        'lastapp',
        'lastdata',
        'duration',
        'billsec',
        'disposition',
        'amaflags',
        'accountcode',
        'uniqueid',
        'userfield',
        'did',
        'cnum',
        'cnam',
        'outbound_cnum',
        'outbound_cnam',
        'dst_cnam',
        'linkedid',
        'peeraccount',
        'sequence',
        'deleted_at',
        'deleted_by',
        'deleted_text',

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
                                'shop_order_id',
                            ],
                            [
                                'calldate',
                            ],
                            [
                                'clid',
                            ],
                            [
                                'src',
                            ],
                            [
                                'dst',
                            ],
                            [
                                'dcontext',
                            ],
                            [
                                'channel',
                            ],
                            [
                                'dstchannel',
                            ],
                            [
                                'lastapp',
                            ],
                            [
                                'lastdata',
                            ],
                            [
                                'duration',
                            ],
                            [
                                'billsec',
                            ],
                            [
                                'disposition',
                            ],
                            [
                                'amaflags',
                            ],
                            [
                                'accountcode',
                            ],
                            [
                                'uniqueid',
                            ],
                            [
                                'userfield',
                            ],
                            [
                                'did',
                            ],
                            [
                                'recordingfile',
                            ],
                            [
                                'cnum',
                            ],
                            [
                                'cnam',
                            ],
                            [
                                'outbound_cnum',
                            ],
                            [
                                'outbound_cnam',
                            ],
                            [
                                'dst_cnam',
                            ],
                            [
                                'linkedid',
                            ],
                            [
                                'peeraccount',
                            ],
                            [
                                'sequence',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(CallsCdr $model = null)
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
            $event->beforeDelete = function (CallsCdr $model) {
                return null;
            };

            $event->afterDelete = function (CallsCdr $model) {
                return null;
            };

            $event->beforeSave = function (CallsCdr $model) {
                return null;
            };

            $event->afterSave = function (CallsCdr $model) {
                return null;
            };

            $event->beforeValidate = function (CallsCdr $model) {
                return null;
            };

            $event->afterValidate = function (CallsCdr $model) {
                return null;
            };

            $event->afterRefresh = function (CallsCdr $model) {
                return null;
            };

            $event->afterFind = function (CallsCdr $model) {
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
     * Function  getShopOrder
     * @return bool|\yii\db\ActiveRecord|ShopOrder|null
     */            
    public function getShopOrderOne()
    {
        return $this->getOne(ShopOrder::class, [
          'id' => 'shop_order_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopOrder
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopOrder()
    {
        return $this->hasOne(ShopOrder::class, [
          'id' => 'shop_order_id',
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
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}
