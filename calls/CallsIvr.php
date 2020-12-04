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


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHPasswordInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputMaskWidget;
use zetsoft\widgets\inputes\ZKColorInputWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKStarRatingWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\user\UserCompany;
use zetsoft\models\drag\DragApp;
use zetsoft\models\user\UserBlocked;
use zetsoft\models\page\PageBlocks;
use zetsoft\models\page\PageBlocksType;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\shop\ShopCategory;
use zetsoft\models\pays\PaysCurrency;
use zetsoft\models\govs\GovsDegree;
use zetsoft\models\dyna\DynaConfig;
use zetsoft\models\govs\GovsEducation;
use zetsoft\models\faqs\Faqs;
use zetsoft\models\faqs\FaqsType;
use zetsoft\models\user\UserFriend;
use zetsoft\models\faqs\FaqsManual;
use zetsoft\models\news\News;
use zetsoft\models\news\NewsType;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\govs\GovsPosition;
use zetsoft\models\core\CoreQueue;
use zetsoft\models\core\CoreSession;
use zetsoft\models\core\CoreSetting;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\shop\ShopReview;
use zetsoft\models\shop\ShopQuestion;
use zetsoft\models\shop\ShopPayment;
use zetsoft\models\shop\ShopShipment;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\auto\AutoType;
use zetsoft\models\auto\AutoModel;
use zetsoft\models\shop\ShopCourier;
use zetsoft\models\calls\CallsOrder;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\calls\CallsQueue;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CallsIvr
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $number
 * @property array $user_ids
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CallsIvr extends ZActiveRecord
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
    public $number;
    public $user_ids;
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
        'number',
        'user_ids',
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
    public static ?string $title = Azl . 'Интерактивное голосовое меню';
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
			'number',
			'user_ids',
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
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'User' => [
                        'user_ids' => 'id',
                    ],
                ];
            $config->title = Az::l('Интерактивное голосовое меню');

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

                $column->title = Az::l('Внутренный номер');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },
            
           
            'user_ids' => function (FormDb $column) {

                $column->title = Az::l('Операторы');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;

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
        'number',
        'user_ids',
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
                                'number',
                            ],
                            [
                                'user_ids',
                            ],
                            [
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
                                public function value(CallsQueue $model = null)
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


    /**
     *
     * Function  getUsersFromUserIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|User
     */            
    public function getUsersFromUserIdsMulti()
    {
        return $this->getMulti(User::class, [
          'id' => 'user_ids',
      ]);    
    }


    #endregion
    
    #region Many



    #endregion


}
