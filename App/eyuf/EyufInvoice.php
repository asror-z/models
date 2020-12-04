<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\App\eyuf;


use zetsoft\dbdata\shop\CurrencyData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\pays\PaysCurrency;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\models\App\eyuf\EyufInvoiceType;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\widgets\navigat\ZDownloadWidget;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    EyufInvoice
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $convert
 * @property int $eyuf_scholar_id
 * @property int $eyuf_invoice_type_id
 * @property boolean $status
 * @property string $currency
 * @property string $price
 * @property string $dollar
 * @property array $payment_file
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class EyufInvoice extends ZActiveRecord
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
    public $convert;
    public $eyuf_scholar_id;
    public $eyuf_invoice_type_id;
    public $status;
    public $currency;
    public $price;
    public $dollar;
    public $payment_file;
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
        'convert',
        'eyuf_scholar_id',
        'eyuf_invoice_type_id',
        'status',
        'currency',
        'price',
        'dollar',
        'payment_file',
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

    /* @var array $_convert*/
    public $_convert;  
    public const convert = [
        'cbu' => 'cbu',
        'nbu' => 'nbu',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Расходы';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_convert = [
            'cbu' => Az::l('Курс ЦБУ'),
            'nbu' => Az::l('Курс НБ'),
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
			'convert',
			'eyuf_scholar_id',
			'eyuf_invoice_type_id',
			'status',
			'currency',
			'price',
			'dollar',
			'payment_file',
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

            $config->hasOne = [
                    'EyufScholar' => [
                        'eyuf_scholar_id' => 'id',
                    ],
                    'EyufInvoiceType' => [
                        'eyuf_invoice_type_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Расходы');

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
           
            'convert' => function (FormDb $column) {

                $column->title = Az::l('Конвертация');
                $column->tooltip = Az::l('Конвертация расходов');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->data = [
                    'cbu' => 'Курс ЦБУ',
                    'nbu' => 'Курс НБ',
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },



            'eyuf_scholar_id' => function (FormDb $column) {

                $column->title = Az::l('Пользователь');
                $column->tooltip = Az::l('Пользователь расходов');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'eyuf_invoice_type_id' => function (FormDb $column) {

                $column->title = Az::l('Тип расходов');
                $column->tooltip = Az::l('Тип расходов');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->width = '350px';

                return $column;
            },
            
           
            'status' => function (FormDb $column) {

                $column->title = Az::l('Принят?');
                $column->tooltip = Az::l('Приняты ли расходы?');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },


            'currency' => function (FormDb $column) {

                $column->title = Az::l('Валюта');
                $column->tooltip = Az::l('Валюта');
                $column->dbType = dbTypeString;
                $column->data = CurrencyData::class;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'id' => 'kurs_ban_cbu'
                ];
                //start|AlisherXayrillayev|2020-10-16
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-16

                return $column;
            },
            
           
            'price' => function (FormDb $column) {

                $column->title = Az::l('Цена в сумах');
                $column->tooltip = Az::l('Сумма расходов в сумах');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },

            'dollar' => function (FormDb $column) {

                $column->title = Az::l('Цена в валюте');
                $column->tooltip = Az::l('Сумма расходов в валюте');
                $column->widget = ZHInputWidget::class;
                $column->readonly = true;
                $column->auto = true;
               /* $column->autoValue = function (EyufInvoice $model){
                    $pays = PaysCurrency::find()->orderBy('created_at DESC')->limit(1)->one();
                    $return = 0;
                    if ($model->convert === 'cbu'){
                        $return = (int)$model->price / (int)$pays->cbu;
                    } else if($model->convert === 'nbu'){
                        $return = (int)$model->price / (int)$pays->bank;
                    }
                    return $return;
                };*/
                $column->options = [
                    'config' => [
                        'class' => 'end_value',
                    ],
                ];

                return $column;
            },
            
           
            'payment_file' => function (FormDb $column) {

                $column->title = Az::l('Доказательство оплаты');
                $column->tooltip = Az::l('Доказательство оплаты расходов');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->valueWidget = ZDownloadWidget::class;
                $column->options = [
                    'config' => [
                        'maxFileCount' => 2,
                        'required' => true,
                    ],
                ];
                $column->format = 'raw';
                $column->width = '250px';

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
        'convert',
        'eyuf_scholar_id',
        'eyuf_invoice_type_id',
        'status',
        'currency',
        'price',
        'dollar',
        'payment_file',
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
                                'convert',
                            ],
                            [
                                'eyuf_scholar_id',
                            ],
                            [
                                'eyuf_invoice_type_id',
                            ],
                            [
                                'status',
                            ],
                            [
                                'price',
                            ],
                            [
                                'dollar',
                            ],
                            [
                                'payment_file',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                public function value(EyufInvoice $model = null)
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
        $event->beforeDelete = function (EyufInvoice $model) {
            return null;
        };

        $event->afterDelete = function (EyufInvoice $model) {
            return null;
        };

        $event->beforeSave = function (EyufInvoice $model) {
            return null;
        };

        $event->afterSave = function (EyufInvoice $model) {
            return null;
        };

        $event->beforeValidate = function (EyufInvoice $model) {
            return null;
        };

        $event->afterValidate = function (EyufInvoice $model) {
            return null;
        };

        $event->afterRefresh = function (EyufInvoice $model) {
            return null;
        };

        $event->afterFind = function (EyufInvoice $model) {
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
     * Function  getEyufScholar
     * @return bool|\yii\db\ActiveRecord|EyufScholar|null
     */            
    public function getEyufScholarOne()
    {
        return $this->getOne(EyufScholar::class, [
          'id' => 'eyuf_scholar_id',
      ]);    
    }
    
     /**
     *
     * Function  getEyufScholar
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getEyufScholar()
    {
        return $this->hasOne(EyufScholar::class, [
          'id' => 'eyuf_scholar_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getEyufInvoiceType
     * @return bool|\yii\db\ActiveRecord|EyufInvoiceType|null
     */            
    public function getEyufInvoiceTypeOne()
    {
        return $this->getOne(EyufInvoiceType::class, [
          'id' => 'eyuf_invoice_type_id',
      ]);    
    }
    
     /**
     *
     * Function  getEyufInvoiceType
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getEyufInvoiceType()
    {
        return $this->hasOne(EyufInvoiceType::class, [
          'id' => 'eyuf_invoice_type_id',
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



    #endregion


}
