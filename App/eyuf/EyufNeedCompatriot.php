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


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\UserCompany;
use zetsoft\models\user\User;
use zetsoft\dbitem\data\Event;
use zetsoft\models\govs\GovsSpeciality;
use zetsoft\models\App\eyuf\EyufNeed;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\place\PlaceCountry;
use zetsoft\dbdata\eyuf\ProgramData;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\navigat\ZDownloadWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\widgets\inputes\ZInputMaskWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    EyufNeedCompatriot
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $user_company_id
 * @property int $eyuf_request_id
 * @property string $position
 * @property array $govs_speciality_ids
 * @property string $education_field
 * @property string $code_specialty
 * @property string $program
 * @property string $recommendation
 * @property array $certificate_olimp
 * @property int $experiance
 * @property string $phone
 * @property string $email
 * @property int $place_country_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class EyufNeedCompatriot extends ZActiveRecord
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
    public $user_company_id;
    public $eyuf_request_id;
    public $position;
    public $govs_speciality_ids;
    public $education_field;
    public $code_specialty;
    public $program;
    public $recommendation;
    public $certificate_olimp;
    public $experiance;
    public $phone;
    public $email;
    public $place_country_id;
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
        'user_company_id',
        'eyuf_request_id',
        'position',
        'govs_speciality_ids',
        'education_field',
        'code_specialty',
        'program',
        'recommendation',
        'certificate_olimp',
        'experiance',
        'phone',
        'email',
        'place_country_id',
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
    public static ?string $title = Azl . 'Потребности Соотечественника';
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
			'user_company_id',
			'eyuf_request_id',
			'position',
			'govs_speciality_ids',
			'education_field',
			'code_specialty',
			'program',
			'recommendation',
			'certificate_olimp',
			'experiance',
			'phone',
			'email',
			'place_country_id',
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
                    'UserCompany' => [
                        'user_company_id' => 'id',
                    ],
                    'EyufRequest' => [
                        'eyuf_request_id' => 'id',
                    ],
                    'PlaceCountry' => [
                        'place_country_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'GovsSpeciality' => [
                        'govs_speciality_ids' => 'id',
                    ],
                ];
            $config->title = Az::l('Потребности Соотечественника');

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

            'user_company_id' => function (FormDb $column) {

                $column->title = Az::l('Название министерства или компании');
                $column->tooltip = Az::l('Название министерства или компании');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'eyuf_request_id' => function (FormDb $column) {

                $column->title = Az::l('Запрос потребностей');
                $column->tooltip = Az::l('Запрос потребностей соотечественника');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },




            'position' => function (FormDb $column) {

                $column->title = Az::l('Должность кандидата');
                $column->tooltip = Az::l('Должность кандидата соотечетсвенника');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },


            'govs_speciality_ids' => function (FormDb $column) {

                $column->title = Az::l('Название специальности обучения за рубежом');
                $column->tooltip = Az::l('Название специальности обучения за рубежом соотечетсвенника');
                $column->dbType = dbTypeJsonb;
                
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                $column->widget = ZKSelect2Widget::class;
                
                $column->multiple = true;

                return $column;
            },


            'education_field' => function (FormDb $column) {

                $column->title = Az::l('Oбразование за рубежом');
                $column->tooltip = Az::l('Oбразование за рубежом соотечетсвенника');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },


            'code_specialty' => function (FormDb $column) {

                $column->title = Az::l('Kод специальности');
                $column->tooltip = Az::l('Kод специальности соотечетсвенника');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },


            'program' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Программы');
                $column->tooltip = Az::l('Программы соотечетсвенника');
                $column->data = ProgramData::class;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-16
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-16

                $column->options = [
                    'config' => [
                        'ajax' => false,
                    ],
                ];

                return $column;
            },


            'recommendation' => function (FormDb $column) {

                $column->title = Az::l('Рекомендация');
                $column->tooltip = Az::l('Рекомендация соотечетсвенника');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },


            'certificate_olimp' => function (FormDb $column) {

                $column->title = Az::l('Сертификат выпускника олимпиады международного и республиканского этапа');
                $column->tooltip = Az::l('Сертификат выпускника олимпиады международного и республиканского этапа');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->valueWidget = ZDownloadWidget::class;
                $column->options = [
                    'config' => [
                        'maxFileCount' => 2,
                    ],
                ];
                $column->format = 'raw';

                return $column;
            },


            'experiance' => function (FormDb $column) {

                $column->title = Az::l('Стаж работы (Месяцы)');
                $column->tooltip = Az::l('Стаж работы соотечетсвенника (Месяцы)');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKTouchSpinWidget::class;
                $column->width = '100px';

                return $column;
            },


            'phone' => function (FormDb $column) {

                $column->title = Az::l('Номер телефона кандидата');
                $column->tooltip = Az::l('Номер телефона кандидата соотечетсвенника');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZInputMaskWidget::class;
                $column->options = [
                    'config' => [
                        'ready' => '99-999-99-99',
                    ],
                ];

                return $column;
            },


            'email' => function (FormDb $column) {

                $column->title = Az::l('Aдрес электронной почты кандидата');
                $column->tooltip = Az::l('Aдрес электронной почты кандидата соотечетсвенника');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorEmail,
                    ],
                ];

                return $column;
            },


            'place_country_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Государство');
                $column->tooltip = Az::l('Государство соотечетсвенника');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
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
        'user_company_id',
        'eyuf_request_id',
        'position',
        'govs_speciality_ids',
        'education_field',
        'code_specialty',
        'program',
        'recommendation',
        'certificate_olimp',
        'experiance',
        'phone',
        'email',
        'place_country_id',
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
                                'user_company_id',
                            ],
                            [
                                'eyuf_request_id',
                            ],
                            [
                                'title',
                            ],
                            [
                                'position',
                            ],
                            [
                                'govs_speciality_ids',
                            ],
                            [
                                'education_field',
                            ],
                            [
                                'code_specialty',
                            ],
                            [
                                'program',
                            ],
                            [
                                'recommendation',
                            ],
                            [
                                'certificate_olimp',
                            ],
                            [
                                'experiance',
                            ],
                            [
                                'phone',
                            ],
                            [
                                'email',
                            ],
                            [
                                'place_country_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(EyufNeedCompatriot $model = null)
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
            $event->beforeDelete = function (EyufNeedCompatriot $model) {
                return null;
            };

            $event->afterDelete = function (EyufNeedCompatriot $model) {
                return null;
            };

            $event->beforeSave = function (EyufNeedCompatriot $model) {
                return null;
            };

            $event->afterSave = function (EyufNeedCompatriot $model) {
                return null;
            };

            $event->beforeValidate = function (EyufNeedCompatriot $model) {
                return null;
            };

            $event->afterValidate = function (EyufNeedCompatriot $model) {
                return null;
            };

            $event->afterRefresh = function (EyufNeedCompatriot $model) {
                return null;
            };

            $event->afterFind = function (EyufNeedCompatriot $model) {
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
     * Function  getEyufRequest
     * @return bool|\yii\db\ActiveRecord|EyufRequest|null
     */            
    public function getEyufRequestOne()
    {
        return $this->getOne(EyufRequest::class, [
          'id' => 'eyuf_request_id',
      ]);    
    }
    
     /**
     *
     * Function  getEyufRequest
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getEyufRequest()
    {
        return $this->hasOne(EyufRequest::class, [
          'id' => 'eyuf_request_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getPlaceCountry
     * @return bool|\yii\db\ActiveRecord|PlaceCountry|null
     */            
    public function getPlaceCountryOne()
    {
        return $this->getOne(PlaceCountry::class, [
          'id' => 'place_country_id',
      ]);    
    }
    
     /**
     *
     * Function  getPlaceCountry
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPlaceCountry()
    {
        return $this->hasOne(PlaceCountry::class, [
          'id' => 'place_country_id',
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


    /**
     *
     * Function  getGovsSpecialitiesFromGovsSpecialityIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|GovsSpeciality
     */            
    public function getGovsSpecialitiesFromGovsSpecialityIdsMulti()
    {
        return $this->getMulti(GovsSpeciality::class, [
          'id' => 'govs_speciality_ids',
      ]);    
    }


    #endregion
    
    #region Many



    #endregion


}
