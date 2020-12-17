<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\cpas;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\post\PostCpasPostbackForm;
use zetsoft\models\place\PlaceCountry;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTimePickerWidget;
use zetsoft\widgets\inputes\ZTextAreaWidget;
use zetsoft\models\cpas\CpasSource;
use zetsoft\models\cpas\CpasOfferItem;
use zetsoft\models\cpas\CpasStream;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\models\cpas\CpasOffer;
use zetsoft\models\pays\PaysPayment;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CpasPaysHistory
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $user_id
 * @property int $balance
 * @property int $userBy
 * @property int $pays_payment_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CpasPaysHistory extends ZActiveRecord
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
    public $user_id;
    public $balance;
    public $userBy;
    public $pays_payment_id;
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
        'user_id',
        'balance',
        'userBy',
        'pays_payment_id',
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
    public static ?string $title = Azl . 'История выплат';
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
			'user_id',
			'balance',
			'userBy',
			'pays_payment_id',
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

            $config->nameAuto = false;
            $config->hasOne = [
                    'User' => [
                        'user_id' => 'id',
                        'userBy' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PaysPayment' => [
                        'pays_payment_id' => 'id',
                    ],
                ];
            $config->title = Az::l('История выплат');

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



            'user_id' => static function (FormDb $column) {
                $column->index = true;
                $column->dbType = dbTypeInteger;
                $column->title = Az::l('Пользователь');
                $column->widget = ZKSelect2Widget::class;
                $column->fkAttr = 'email';
                return $column;
            },
            

            'balance' => static function (FormDb $column) {

                $column->dbType = dbTypeInteger;
                $column->title = Az::l('Сумма');


                return $column;
            },


            'userBy' => static function (FormDb $column) {
                $column->index = true;
                $column->dbType = dbTypeInteger;
                $column->title = Az::l('Кому разрешено');
                $column->fkTable = 'user';
                $column->fkAttr = 'email';
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            'pays_payment_id' => static function (FormDb $column) {

                $column->index = true;
                $column->dbType = dbTypeInteger;
                $column->title = Az::l('Платежная система');
                

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
        'user_id',
        'balance',
        'userBy',
        'pays_payment_id',
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
                                'user_id',
                                'balance',
                                'userBy',
                                'pays_payment_id',
                                'created_at',
                                'modified_at',
                                'created_by',
                                'modified_by',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(CpasOffer $model = null)
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
        $event->beforeDelete = function (CpasPaysHistory $model) {
            return null;
        };

        $event->afterDelete = function (CpasPaysHistory $model) {
            return null;
        };

        $event->beforeSave = function (CpasPaysHistory $model) {
            return null;
        };

        $event->afterSave = function (CpasPaysHistory $model) {
            return null;
        };

        $event->beforeValidate = function (CpasPaysHistory $model) {
            return null;
        };

        $event->afterValidate = function (CpasPaysHistory $model) {
            return null;
        };

        $event->afterRefresh = function (CpasPaysHistory $model) {
            return null;
        };

        $event->afterFind = function (CpasPaysHistory $model) {
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
     * Function  getUser
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getUserOne()
    {
        return $this->getOne(User::class, [
          'id' => 'user_id',
      ]);    
    }
    
     /**
     *
     * Function  getUser
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getUser()
    {
        return $this->hasOne(User::class, [
          'id' => 'user_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getUserBy
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getUserByOne()
    {
        return $this->getOne(User::class, [
          'id' => 'userBy',
      ]);    
    }
    
     /**
     *
     * Function  getUserBy
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getUserBy()
    {
        return $this->hasOne(User::class, [
          'id' => 'userBy',
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
     * Function  getPaysPayment
     * @return bool|\yii\db\ActiveRecord|PaysPayment|null
     */            
    public function getPaysPaymentOne()
    {
        return $this->getOne(PaysPayment::class, [
          'id' => 'pays_payment_id',
      ]);    
    }
    
     /**
     *
     * Function  getPaysPayment
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPaysPayment()
    {
        return $this->hasOne(PaysPayment::class, [
          'id' => 'pays_payment_id',
      ]);    
    }
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}
