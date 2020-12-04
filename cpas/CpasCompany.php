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
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CpasCompany
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $auth_code
 * @property string $auth_type
 * @property array $postback
 * @property array $service
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CpasCompany extends ZActiveRecord
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
    public $auth_code;
    public $auth_type;
    public $postback;
    public $service;
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
        'auth_code',
        'auth_type',
        'postback',
        'service',
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
    public static ?string $title = Azl . 'Компании партнеры';
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
			'auth_code',
			'auth_type',
			'postback',
			'service',
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
            $config->hasMany = [
                    'CpasOffer' => [
                        'cpas_company_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Компании партнеры');

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



            'auth_code' => function (FormDb $column) {

                $column->title = Az::l('Код авторизации');

                $column->rules = [
                    [
                        validatorString,
                    ],
                ];


                return $column;
            },


            'auth_type' => function (FormDb $column) {

                $column->title = Az::l('Тип авторизации');

                $column->rules = [
                    [
                        validatorString,
                    ],
                ];


                return $column;
            },

            'postback' => function (FormDb $column) {

                $column->title = Az::l('Постбэк для компании');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
                    'config' => [
                        'formClass' => PostCpasPostbackForm::class,
                    ],
                ];
                $column->valueOptions = [
                    'config' => [
                        'formClass' => PostCpasPostbackForm::class,
                    ],
                ];
                $column->mergeHeader = true;


                return $column;
            },


            'service' => function (FormDb $column) {

                $column->title = Az::l('Сервис');
                $column->dbType = dbTypeJsonb;
                $column->showForm = false;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
                    'config' => [
                        'formClass' => 'zetsoft\former\core\CoreServiceForm',
                    ],
                ];
                $column->valueOptions = [
                    'config' => [
                        'formClass' => 'zetsoft\former\core\CoreServiceForm',
                    ],
                ];

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
        'auth_code',
        'auth_type',
        'postback',
        'service',
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
                                'auth_code',
                                'auth_type',
                                'postback',
                                'service',
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
        $event->beforeDelete = function (CpasCompany $model) {
            return null;
        };

        $event->afterDelete = function (CpasCompany $model) {
            return null;
        };

        $event->beforeSave = function (CpasCompany $model) {
            return null;
        };

        $event->afterSave = function (CpasCompany $model) {
            return null;
        };

        $event->beforeValidate = function (CpasCompany $model) {
            return null;
        };

        $event->afterValidate = function (CpasCompany $model) {
            return null;
        };

        $event->afterRefresh = function (CpasCompany $model) {
            return null;
        };

        $event->afterFind = function (CpasCompany $model) {
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



    #endregion
    
    #region Many


    /**
     *
     * Function  getCpasOffersWithCpasCompanyIdMany
     * @return  null|\yii\db\ActiveRecord[]|CpasOffer
     */            
    public function getCpasOffersWithCpasCompanyIdMany()
    {
       return $this->getMany(CpasOffer::class, [
            'cpas_company_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasOffersWithCpasCompanyId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasOffersWithCpasCompanyId()
    {
       return $this->hasMany(CpasOffer::class, [
            'cpas_company_id' => 'id',
        ]);     
    }


    #endregion


}
