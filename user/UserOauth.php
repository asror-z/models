<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\user;


use zetsoft\dbdata\auth\RoleData;
use zetsoft\dbdata\core\LangData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\auto\Auto;
use zetsoft\models\auto\AutoModel;
use zetsoft\models\auto\AutoType;
use zetsoft\models\chat\ChatMail;
use zetsoft\models\chat\ChatMessage;
use zetsoft\models\chat\ChatMessagePublic;
use zetsoft\models\chat\ChatNotify;
use zetsoft\models\chat\ChatPrivate;
use zetsoft\models\chat\ChatSubscribe;
use zetsoft\models\core\CoreQueue;
use zetsoft\models\core\CoreSession;
use zetsoft\models\core\CoreSetting;
use zetsoft\models\drag\DragApp;
use zetsoft\models\drag\DragConfig;
use zetsoft\models\drag\DragConfigDb;
use zetsoft\models\drag\DragForm;
use zetsoft\models\drag\DragFormDb;
use zetsoft\models\dyna\DynaConfig;
use zetsoft\models\dyna\DynaFilter;
use zetsoft\models\faqs\Faqs;
use zetsoft\models\faqs\FaqsManual;
use zetsoft\models\faqs\FaqsType;
use zetsoft\models\govs\GovsDegree;
use zetsoft\models\govs\GovsEducation;
use zetsoft\models\govs\GovsPosition;
use zetsoft\models\govs\GovsSpeciality;
use zetsoft\models\lang\LangNationality;
use zetsoft\models\news\News;
use zetsoft\models\news\NewsType;
use zetsoft\models\page\PageBlocks;
use zetsoft\models\page\PageBlocksType;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\place\PlaceRegion;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\shop\ShopCategory;
use zetsoft\models\shop\ShopCoupon;
use zetsoft\models\shop\ShopCourier;
use zetsoft\models\pays\PaysCurrency;
use zetsoft\models\shop\ShopDiscount;
use zetsoft\models\shop\ShopOffer;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\shop\ShopOverview;
use zetsoft\models\shop\ShopPayment;
use zetsoft\models\shop\ShopQuestion;
use zetsoft\models\shop\ShopRejectCause;
use zetsoft\models\shop\ShopReview;
use zetsoft\models\shop\ShopShipment;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHPasswordInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputMaskWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\user\UserCompany;
use zetsoft\models\user\UserBlocked;
use zetsoft\models\user\UserContact;
use zetsoft\models\user\UserFriend;
use zetsoft\models\shop\ShopChannel;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\chat\ChatGroup;
use zetsoft\models\calls\CallsOrder;
use zetsoft\models\calls\CallsQueue;
use zetsoft\widgets\market\ZSwitchBoxWidget;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    UserOauth
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $type
 * @property int $client_id
 * @property string $client_secret
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class UserOauth extends ZActiveRecord
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
    public $type;
    public $client_id;
    public $client_secret;
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
        'type',
        'client_id',
        'client_secret',
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

    /* @var array $_type*/
    public $_type;  
    public const type = [
        'google' => 'google',
        'github' => 'github',
        'yandex' => 'yandex',
        'microsoft' => 'microsoft',
        'instagram' => 'instagram',
        'facebook' => 'facebook',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Аккаунты OAuth';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_type = [
            'google' => Az::l('Google'),
            'github' => Az::l('Github'),
            'yandex' => Az::l('Yandex'),
            'microsoft' => Az::l('Microsoft'),
            'instagram' => Az::l('Instagram'),
            'facebook' => Az::l('Facebook'),
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
			'type',
			'client_id',
			'client_secret',
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
                    'Client' => [
                        'client_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Аккаунты OAuth');

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
           

           
            'type' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Тип авторизации');
                $column->tooltip = Az::l('Тип авторизации');
                $column->data = [
                    'google' => Az::l('Google'),
                    'github' => Az::l('Github'),
                    'yandex' => Az::l('Yandex'),
                    'microsoft' => Az::l('Microsoft'),
                    'instagram' => Az::l('Instagram'),
                    'facebook' => Az::l('Facebook'),
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'client_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Client ID');
                $column->tooltip = Az::l('Идентификационный номер клиента');

                return $column;
            },
            
           
            'client_secret' => function (FormDb $column) {

                $column->title = Az::l('Client secret');
                $column->tooltip = Az::l('Секрет клиента');

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
        'type',
        'client_id',
        'client_secret',
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
                                'active',
                                'type',
                                'client_id',
                                'client_secret',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                                public function value(UserOauth $model = null)
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
//        $event->beforeSave = function (User $model) {
//            global $boot;
//            if ($boot->env('passHashed'))
//                if (!Az::$app->cores->auth->isHash($model->password))
//                    $model->password = Az::$app->cores->auth->hashGet($model->password);
//        };
        /*
        $event->beforeDelete = function (User $model) {
        return null;
        };

        $event->afterDelete = function (User $model) {
        return null;
        };

        $event->beforeSave = function (User $model) {
        return null;
        };

        $event->afterSave = function (User $model) {
        return null;
        };

        $event->beforeValidate = function (User $model) {
        return null;
        };

        $event->afterValidate = function (User $model) {
        return null;
        };

        $event->afterRefresh = function (User $model) {
        return null;
        };

        $event->afterFind = function (User $model) {
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
     * Function  getClient
     * @return bool|\yii\db\ActiveRecord|Client|null
     */            
    public function getClientOne()
    {
        return $this->getOne(Client::class, [
          'id' => 'client_id',
      ]);    
    }
    
     /**
     *
     * Function  getClient
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getClient()
    {
        return $this->hasOne(Client::class, [
          'id' => 'client_id',
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
