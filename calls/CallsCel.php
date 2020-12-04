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
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\shop\ShopOrder;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\values\ZDateFormatWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;
use zetsoft\models\user\User;



/**
 * Class    CallsCel
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
 * @property int $call_cdr_id
 * @property string $eventtype
 * @property string $eventtime
 * @property string $cid_name
 * @property string $cid_num
 * @property string $cid_ani
 * @property string $cid_rdnis
 * @property string $cid_dnid
 * @property string $exten
 * @property string $context
 * @property string $channame
 * @property string $appname
 * @property string $appdata
 * @property string $amaflags
 * @property string $accountcode
 * @property string $uniqueid
 * @property string $linkedid
 * @property string $peer
 * @property string $userdeftype
 * @property string $extra
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 */
class CallsCel extends ZActiveRecord
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
    public $call_cdr_id;
    public $eventtype;
    public $eventtime;
    public $cid_name;
    public $cid_num;
    public $cid_ani;
    public $cid_rdnis;
    public $cid_dnid;
    public $exten;
    public $context;
    public $channame;
    public $appname;
    public $appdata;
    public $amaflags;
    public $accountcode;
    public $uniqueid;
    public $linkedid;
    public $peer;
    public $userdeftype;
    public $extra;
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
        'call_cdr_id',
        'eventtype',
        'eventtime',
        'cid_name',
        'cid_num',
        'cid_ani',
        'cid_rdnis',
        'cid_dnid',
        'exten',
        'context',
        'channame',
        'appname',
        'appdata',
        'amaflags',
        'accountcode',
        'uniqueid',
        'linkedid',
        'peer',
        'userdeftype',
        'extra',
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
    public static ?string $title = Azl . 'Детализация звонков';
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
			'call_cdr_id',
			'eventtype',
			'eventtime',
			'cid_name',
			'cid_num',
			'cid_ani',
			'cid_rdnis',
			'cid_dnid',
			'exten',
			'context',
			'channame',
			'appname',
			'appdata',
			'amaflags',
			'accountcode',
			'uniqueid',
			'linkedid',
			'peer',
			'userdeftype',
			'extra',
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
                    'CallCdr' => [
                        'call_cdr_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Детализация звонков');

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
                $column->tooltip = Az::l('Уникальный Идентификатор заказа');
                $column->dbType = dbTypeString;

                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'call_cdr_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('CDR звонка');
                $column->tooltip = Az::l('Детализация звонков');
                $column->dbType = dbTypeString;

                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'eventtype' => function (FormDb $column) {

                $column->length = 30;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Название события');
                $column->tooltip = Az::l('Наименование события');
                return $column;
            },
            
           
            'eventtime' => function (FormDb $column) {

                $column->notNull = true;
                $column->title = Az::l('Время, когда произошло событие');
                $column->dbType = dbTypeDateTime;

                $column->widget = ZKDateTimePickerWidget::class;
                
                $column->valueWidget = ZDateFormatWidget::class;

                return $column;
            },
            
           
            'cid_name' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Поле имени CID');
                $column->tooltip = Az::l('Поле имени для идентификационного номера звонящего');


                return $column;
            },
            
           
            'cid_num' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Поле номера CID');
                $column->tooltip = Az::l('Поле номера для идентификационного номера звонящего');


                return $column;
            },
            
           
            'cid_ani' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Поле CID ANI');
                $column->tooltip = Az::l('Поле для идентификационного номера звонящего ANI');


                return $column;
            },
            
           
            'cid_rdnis' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Поле CID RDNIS');
                $column->tooltip = Az::l('Поле для идентификационного номера звонящего RDNIS');


                return $column;
            },
            
           
            'cid_dnid' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Поле CID DNID');
                $column->tooltip = Az::l('Поле для идентификационного номера звонящего DNID');


                return $column;
            },
            
           
            'exten' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Расширение в диалплане');

                return $column;
            },
            
           
            'context' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Контекст в диалплане');


                return $column;
            },
            
           
            'channame' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Название, присвоенное каналу, в котором произошло событие');


                return $column;
            },
            
           
            'appname' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Название текущего приложения');


                return $column;
            },
            
           
            'appdata' => function (FormDb $column) {

                $column->notNull = true;
                $column->title = Az::l('Аргументы, которые будут переданы этому заявлению');


                return $column;
            },
            
           
            'amaflags' => function (FormDb $column) {

                $column->length = 11;
                $column->notNull = true;
                $column->title = Az::l('Флаги AMA, связанные с событием; назначаемый пользователем');
                $column->dbType = dbTypeString;


                return $column;
            },
            
           
            'accountcode' => function (FormDb $column) {

                $column->length = 20;
                $column->notNull = true;
                $column->title = Az::l('Код аккаунта присвоенный абоненту');


                return $column;
            },
            
           
            'uniqueid' => function (FormDb $column) {

             
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Уникальный идентификатор канала');
                $column->tooltip = Az::l('ID канала');
                $column->dbType = dbTypeString;

                return $column;
            },
            
           
            'linkedid' => function (FormDb $column) {

                $column->length = 32;
                $column->notNull = true;
                $column->index = true;
                $column->title = Az::l('Идентификатор вызова, возможно, охватывает несколько событий');
                $column->dbType = dbTypeString;


                return $column;
            },
            
           
            'peer' => function (FormDb $column) {

                $column->length = 80;
                $column->notNull = true;
                $column->title = Az::l('Название канала соединено с каналом, обозначенным как channel name');


                return $column;
            },
            
           
            'userdeftype' => function (FormDb $column) {

                $column->notNull = true;
                $column->title = Az::l('Пользовательское имя события');


                return $column;
            },
            
           
            'extra' => function (FormDb $column) {

                $column->length = 512;
                $column->notNull = true;
                $column->title = Az::l('Дополнительная информация, связанная с событием');
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
        'call_cdr_id',
        'eventtype',
        'eventtime',
        'cid_name',
        'cid_num',
        'cid_ani',
        'cid_rdnis',
        'cid_dnid',
        'exten',
        'context',
        'channame',
        'appname',
        'appdata',
        'amaflags',
        'accountcode',
        'uniqueid',
        'linkedid',
        'peer',
        'userdeftype',
        'extra',
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
                                'call_cdr_id',
                            ],
                            [
                                'eventtype',
                            ],
                            [
                                'eventtime',
                            ],
                            [
                                'cid_name',
                            ],
                            [
                                'cid_num',
                            ],
                            [
                                'cid_ani',
                            ],
                            [
                                'cid_rdnis',
                            ],
                            [
                                'cid_dnid',
                            ],
                            [
                                'exten',
                            ],
                            [
                                'context',
                            ],
                            [
                                'channame',
                            ],
                            [
                                'appname',
                            ],
                            [
                                'appdata',
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
                                'linkedid',
                            ],
                            [
                                'peer',
                            ],
                            [
                                'userdeftype',
                            ],
                            [
                                'extra',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                                public function value(CallsCel $model = null)
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
        $event->beforeDelete = function (CallsCel $model) {
            return null;
        };

        $event->afterDelete = function (CallsCel $model) {
            return null;
        };

        $event->beforeSave = function (CallsCel $model) {
            return null;
        };

        $event->afterSave = function (CallsCel $model) {
            return null;
        };

        $event->beforeValidate = function (CallsCel $model) {
            return null;
        };

        $event->afterValidate = function (CallsCel $model) {
            return null;
        };

        $event->afterRefresh = function (CallsCel $model) {
            return null;
        };

        $event->afterFind = function (CallsCel $model) {
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
     * Function  getCallCdr
     * @return bool|\yii\db\ActiveRecord|CallCdr|null
     */            
    public function getCallCdrOne()
    {
        return $this->getOne(CallCdr::class, [
          'id' => 'call_cdr_id',
      ]);    
    }
    
     /**
     *
     * Function  getCallCdr
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCallCdr()
    {
        return $this->hasOne(CallCdr::class, [
          'id' => 'call_cdr_id',
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
