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
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\validate\ZRequiredValidator;
use zetsoft\widgets\inputes\ZInputMaskWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\dbitem\data\Event;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\user\User;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\place\PlaceCountry;
use zetsoft\models\user\UserCompany;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    EyufScholar
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $program
 * @property string $currency
 * @property string $email
 * @property string $passport
 * @property string $passport_give
 * @property string $birthdate
 * @property int $user_id
 * @property int $place_country_id
 * @property string $status
 * @property int $age
 * @property string $edu_start
 * @property string $edu_end
 * @property int $user_company_id
 * @property string $company_type
 * @property string $edu_area
 * @property string $edu_sector
 * @property string $edu_type
 * @property string $speciality
 * @property int $edu_place
 * @property int $finance
 * @property string $address
 * @property string $phone
 * @property string $home_phone
 * @property string $position
 * @property string $experience
 * @property boolean $completed
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class EyufScholar extends ZActiveRecord
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
    public $program;
    public $currency;
    public $email;
    public $passport;
    public $passport_give;
    public $birthdate;
    public $user_id;
    public $place_country_id;
    public $status;
    public $age;
    public $edu_start;
    public $edu_end;
    public $user_company_id;
    public $company_type;
    public $edu_area;
    public $edu_sector;
    public $edu_type;
    public $speciality;
    public $edu_place;
    public $finance;
    public $address;
    public $phone;
    public $home_phone;
    public $position;
    public $experience;
    public $completed;
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
        'program',
        'currency',
        'email',
        'passport',
        'passport_give',
        'birthdate',
        'user_id',
        'place_country_id',
        'status',
        'age',
        'edu_start',
        'edu_end',
        'user_company_id',
        'company_type',
        'edu_area',
        'edu_sector',
        'edu_type',
        'speciality',
        'edu_place',
        'finance',
        'address',
        'phone',
        'home_phone',
        'position',
        'experience',
        'completed',
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

    /* @var array $_program*/
    public $_program;  
    public const program = [
        'intern' => 'intern',
        'doctors' => 'doctors',
        'masters' => 'masters',
        'qualify' => 'qualify',
    ];

    /* @var array $_status*/
    public $_status;  
    public const status = [
        'register' => 'register',
        'docReady' => 'docReady',
        'stipend' => 'stipend',
        'accounter' => 'accounter',
        'education' => 'education',
        'process' => 'process',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Стипендиат';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_program = [
            'intern' => Az::l('Стажировка'),
            'doctors' => Az::l('Докторантура'),
            'masters' => Az::l('Магистратура'),
            'qualify' => Az::l('Повышение квалификации'),
        ];
        
        $this->_status = [
            'register' => Az::l('Стипендиант зарегистрирован'),
            'docReady' => Az::l('Все документы загружены'),
            'stipend' => Az::l('Утвержден отделом стипендий'),
            'accounter' => Az::l('Утвержден отделом бухгалтерии'),
            'education' => Az::l('Учеба завершена'),
            'process' => Az::l('Учеба завершена'),
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
			'program',
			'currency',
			'email',
			'passport',
			'passport_give',
			'birthdate',
			'user_id',
			'place_country_id',
			'status',
			'age',
			'edu_start',
			'edu_end',
			'user_company_id',
			'company_type',
			'edu_area',
			'edu_sector',
			'edu_type',
			'speciality',
			'edu_place',
			'finance',
			'address',
			'phone',
			'home_phone',
			'position',
			'experience',
			'completed',
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

            $config->titleTitle = 'ФИО';

            $config->hasOne = [
                    'User' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PlaceCountry' => [
                        'place_country_id' => 'id',
                    ],
                    'UserCompany' => [
                        'user_company_id' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'EyufDocument' => [
                        'eyuf_scholar_id' => 'id',
                    ],
                    'EyufFile' => [
                        'eyuf_scholar_id' => 'id',
                    ],
                    'EyufInvoice' => [
                        'eyuf_scholar_id' => 'id',
                    ],
                    'EyufReport' => [
                        'eyuf_scholar_id' => 'id',
                    ],
                    'EyufTicket' => [
                        'eyuf_scholar_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Стипендиат');

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

            'program' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Программа Обучения');
                $column->tooltip = Az::l('Программа Обучения Стипендианта');
                $column->dbType = dbTypeString;
                $column->data = [
                    'intern' => Az::l('Стажировка'),
                    'doctors' => Az::l('Докторантура'),
                    'masters' => Az::l('Магистратура'),
                    'qualify' => Az::l('Повышение квалификации'),
                ];
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-16
                //$column->ajax = false;
                //end|AlisherXayrillayev|2020-10-16

                return $column;
            },

            'currency' => function (FormDb $column) {

                $column->title = Az::l('Валюта');
                $column->tooltip = Az::l('Валюта');
                $column->dbType = dbTypeString;
                $column->data = CurrencyData::class;
                $column->widget = ZKSelect2Widget::class;
                $column->rules = ZRequiredValidator::class;
                //start|AlisherXayrillayev|2020-10-16
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-16

                return $column;
            },


            'email' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('E-mail');
                $column->tooltip = Az::l('Электронный адрес стипендианта (E-mail)');
                $column->dbType = dbTypeString;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorEmail,
                    ],
                    [
                        validatorUnique,
                    ],
                ];
                $column->hiddenFromExport = true;
                $column->changeSave = true;
                return $column;
            },

            'passport' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Серия и номер паспорта');
                $column->tooltip = Az::l('Серия и номер паспорта стипендианта');
                $column->dbType = dbTypeString;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorUnique,
                    ],
                ];
                $column->widget = ZInputMaskWidget::class;
                $column->options = [
                    'config' => [
                        'type' => 'ready',
                        'ready' => 'AA-9999999',
                    ],
                ];
                
                return $column;
            },


            'passport_give' => function (FormDb $column) {

                $column->title = Az::l('Когда и кем выдан');
                $column->tooltip = Az::l('Когда и кем выдан пасспорт');
                $column->dbType = dbTypeString;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },


            'birthdate' => function (FormDb $column) {

                $column->title = Az::l('Дата рождение');
                $column->tooltip = Az::l('Дата рождение стипендианта');
                $column->dbType = dbTypeDate;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->auto = true;
                $column->value = function (EyufScholar $model) {
                    return Az::$app->cores->date->fbDate();
                };
                $column->widget = ZKDatepickerWidget::class;

                return $column;
            },


            'user_id' => function (FormDb $column) {

                $column->title = Az::l('Пользователь');
                $column->tooltip = Az::l('Пользователь');
                $column->dbType = dbTypeInteger;
                $column->showForm = false;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'place_country_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Страна обучение');
                $column->tooltip = Az::l('Страна обучения пользователя');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'status' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Статус');
                $column->tooltip = Az::l('Статус стипендианта');
                $column->dbType = dbTypeString;
                $column->data = [
                    'register' => Az::l('Стипендиант зарегистрирован'),
                    'docReady' => Az::l('Все документы загружены'),
                    'stipend' => Az::l('Утвержден отделом стипендий'),
                    'accounter' => Az::l('Утвержден отделом бухгалтерии'),
                    'education' => Az::l('Учеба завершена'),
                    'process' => Az::l('Учеба завершена'),
                ];

                //start|JakhongirKudratov|2020-10-27

                $column->event = function (EyufScholar $model) {
                    Az::$app->App->eyuf->scholar->sendNotify($model);

                };

                //end|JakhongirKudratov|2020-10-27

                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-16
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-16

                $column->showForm = false;
                $column->width = '200px';
                $column->hiddenFromExport = true;
                /*$column->roleShow = [
                    'scholar',
                    'user',
                    'guest',
                    'admin',
                    'accounter'
                ];*/

                return $column;
            },

            'age' => function (FormDb $column) {

                $column->title = Az::l('Возраст');
                $column->tooltip = Az::l('Возраст стипендианта');
                $column->dbType = dbTypeInteger;
                $column->autoValue = function (EyufScholar $model) {
                    return Az::$app->App->eyuf->user->getAge($model->birthdate);
                };

                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];


                $column->showForm = false;

                return $column;
            },


            'edu_start' => function (FormDb $column) {

                $column->title = Az::l('Начала обучения');
                $column->tooltip = Az::l('Начала обучения стипендианта');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;
                $column->options = [
                    'config' => [
                        'type' => 2,
                        'pickerButton' => [
                            'icon' => '',
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-M-yyyy',
                        ],
                        'hasIcon' => true,
                    ],
                ];

                return $column;
            },


            'edu_end' => function (FormDb $column) {

                $column->title = Az::l('Завершение обучения');
                $column->tooltip = Az::l('Завершение обучения стипендианта');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;
                $column->options = [
                    'config' => [
                        'type' => 2,
                        'pickerButton' => [
                            'icon' => '',
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-M-yyyy',
                        ],
                        'hasIcon' => true,
                    ],
                ];

                return $column;
            },


            'user_company_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Вышестоящая организация');
                $column->tooltip = Az::l('Вышестоящая организация');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'company_type' => function (FormDb $column) {

                $column->title = Az::l('Тип рабочего места');
                $column->tooltip = Az::l('Тип рабочего места стипендианта');
                $column->dbType = dbTypeString;

                return $column;
            },


            'edu_area' => function (FormDb $column) {

                $column->title = Az::l('Область знаний');
                $column->tooltip = Az::l('Область знаний стипендианта');
                $column->dbType = dbTypeString;

                return $column;
            },


            'edu_sector' => function (FormDb $column) {

                $column->title = Az::l('Сектор образования');
                $column->tooltip = Az::l('Сектор образования стипендианта');
                $column->dbType = dbTypeString;

                return $column;
            },


            'edu_type' => function (FormDb $column) {

                $column->title = Az::l('Направление образования');
                $column->tooltip = Az::l('Направление образования стипендианта');
                $column->dbType = dbTypeString;

                return $column;
            },


            'speciality' => function (FormDb $column) {

                $column->title = Az::l('Специальность');
                $column->tooltip = Az::l('Специальность стипендианта');
                $column->dbType = dbTypeString;

                return $column;
            },


            'edu_place' => function (FormDb $column) {

                $column->title = Az::l('Место  обучения(ВУЗ)');
                $column->tooltip = Az::l('Место  обучения(ВУЗ) стипендианта');
                $column->dbType = dbTypeInteger;

                return $column;
            },


            'finance' => function (FormDb $column) {

                $column->title = Az::l('Источник финансирования');
                $column->tooltip = Az::l('Источник финансирования стипендианта');
                $column->dbType = dbTypeInteger;
                //start|AsrorZakirov|2020-10-25

                $column->showForm = false;

//end|AsrorZakirov|2020-10-25

                return $column;
            },


            'address' => function (FormDb $column) {

                $column->title = Az::l('Постоянный адрес проживания');
                $column->tooltip = Az::l('Постоянный адрес проживания стипендианта');
                $column->dbType = dbTypeString;
                $column->hiddenFromExport = true;

                return $column;
            },


            'phone' => function (FormDb $column) {

                $column->title = Az::l('Сотовый телефон');
                $column->tooltip = Az::l('Сотовый телефон стипендианта');
                $column->dbType = dbTypeString;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorUnique,
                    ],
                ];
                $column->widget = ZInputMaskWidget::class;
                $column->options = [
                    'config' => [
                        'ready' => '99-999-99-99',
                    ],
                ];
                $column->hiddenFromExport = true;

                return $column;
            },


            'home_phone' => function (FormDb $column) {

                $column->title = Az::l('Домашний Телефон');
                $column->tooltip = Az::l('Домашний Телефон Стипендианта');
                $column->dbType = dbTypeString;
                $column->widget = ZInputMaskWidget::class;
                $column->options = [
                    'config' => [
                        'ready' => '99-999-99-99',
                    ],
                ];
                $column->hiddenFromExport = true;

                return $column;
            },


            'position' => function (FormDb $column) {

                $column->title = Az::l('Должность');
                $column->tooltip = Az::l('Должность стипендианта');
                $column->dbType = dbTypeString;

                return $column;
            },


            'experience' => function (FormDb $column) {

                $column->title = Az::l('Стаж работы (месяц)');
                $column->tooltip = Az::l('Стаж работы стипендианта (месяц)');
                $column->dbType = dbTypeString;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKTouchSpinWidget::class;

                return $column;
            },


            'completed' => function (FormDb $column) {

                $column->title = Az::l('Обучение завершено?');
                $column->tooltip = Az::l('Завершено ли обучение стипендианта?');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;

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
        'program',
        'currency',
        'email',
        'passport',
        'passport_give',
        'birthdate',
        'user_id',
        'place_country_id',
        'status',
        'age',
        'edu_start',
        'edu_end',
        'user_company_id',
        'company_type',
        'edu_area',
        'edu_sector',
        'edu_type',
        'speciality',
        'edu_place',
        'finance',
        'address',
        'phone',
        'home_phone',
        'position',
        'experience',
        'completed',
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
                                'program',
                                'passport',
                                'passport_give',
                                'birthdate',
                                'core_user_id',
                                'core_country_id',
                                'status',
                                'edu_start',
                                'age',
                                'edu_end',
                                'currency',
                                'core_company_id',
                                'company_type',
                                'edu_area',
                                'edu_sector',
                                'edu_type',
                                'speciality',
                                'edu_place',
                                'finance',
                                'address',
                                'phone',
                                'home_phone',
                                'email',
                                'position',
                                'experience',
                                'completed',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(EyufScholar &$model = null)
    {
        if ($model === null)
            $model = $this;

        // Todo: MyCode

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
        $event->afterDelete = function (EyufScholar $model) {
            //User::deleteAll(['id' => $model->user_id]);
        };


        $event->beforeSave = function (EyufScholar $model) {
         ///   Az::$app->App->eyuf->scholar->sendNotifyToAdmin($model);
        };
        /*
            $event->beforeDelete = function (EyufScholar $model) {
                return null;
            };

            $event->afterDelete = function (EyufScholar $model) {
                return null;
            };

            $event->beforeSave = function (EyufScholar $model) {
                return null;
            };

            $event->afterSave = function (EyufScholar $model) {
                return null;
            };

            $event->beforeValidate = function (EyufScholar $model) {
                return null;
            };

            $event->afterValidate = function (EyufScholar $model) {
                return null;
            };

            $event->afterRefresh = function (EyufScholar $model) {
                return null;
            };

            $event->afterFind = function (EyufScholar $model) {
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
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many


    /**
     *
     * Function  getEyufDocumentsWithEyufScholarIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufDocument
     */            
    public function getEyufDocumentsWithEyufScholarIdMany()
    {
       return $this->getMany(EyufDocument::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufDocumentsWithEyufScholarId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufDocumentsWithEyufScholarId()
    {
       return $this->hasMany(EyufDocument::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufFilesWithEyufScholarIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufFile
     */            
    public function getEyufFilesWithEyufScholarIdMany()
    {
       return $this->getMany(EyufFile::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufFilesWithEyufScholarId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufFilesWithEyufScholarId()
    {
       return $this->hasMany(EyufFile::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufInvoicesWithEyufScholarIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufInvoice
     */            
    public function getEyufInvoicesWithEyufScholarIdMany()
    {
       return $this->getMany(EyufInvoice::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufInvoicesWithEyufScholarId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufInvoicesWithEyufScholarId()
    {
       return $this->hasMany(EyufInvoice::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufReportsWithEyufScholarIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufReport
     */            
    public function getEyufReportsWithEyufScholarIdMany()
    {
       return $this->getMany(EyufReport::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufReportsWithEyufScholarId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufReportsWithEyufScholarId()
    {
       return $this->hasMany(EyufReport::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufTicketsWithEyufScholarIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufTicket
     */            
    public function getEyufTicketsWithEyufScholarIdMany()
    {
       return $this->getMany(EyufTicket::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufTicketsWithEyufScholarId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufTicketsWithEyufScholarId()
    {
       return $this->hasMany(EyufTicket::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }


    #endregion


}
