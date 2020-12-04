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
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZHTextareaWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\models\govs\GovsDegree;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\lang\LangNationality;
use zetsoft\models\govs\GovsSpeciality;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\place\PlaceCountry;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    EyufTable
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $birthdate
 * @property array $photo
 * @property int $lang_nationality_id
 * @property int $citizenship
 * @property int $place_country_id
 * @property string $address
 * @property array $phone
 * @property array $email
 * @property array $govs_speciality_ids
 * @property array $govs_degree_ids
 * @property array $higher_education
 * @property array $additional_education
 * @property array $higher_publication
 * @property array $experience
 * @property array $awards
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class EyufTable extends ZActiveRecord
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
    public $birthdate;
    public $photo;
    public $lang_nationality_id;
    public $citizenship;
    public $place_country_id;
    public $address;
    public $phone;
    public $email;
    public $govs_speciality_ids;
    public $govs_degree_ids;
    public $higher_education;
    public $additional_education;
    public $higher_publication;
    public $experience;
    public $awards;
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
        'birthdate',
        'photo',
        'lang_nationality_id',
        'citizenship',
        'place_country_id',
        'address',
        'phone',
        'email',
        'govs_speciality_ids',
        'govs_degree_ids',
        'higher_education',
        'additional_education',
        'higher_publication',
        'experience',
        'awards',
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
    public static ?string $title = Azl . 'Соотечественники';
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
			'birthdate',
			'photo',
			'lang_nationality_id',
			'citizenship',
			'place_country_id',
			'address',
			'phone',
			'email',
			'govs_speciality_ids',
			'govs_degree_ids',
			'higher_education',
			'additional_education',
			'higher_publication',
			'experience',
			'awards',
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
                    'LangNationality' => [
                        'lang_nationality_id' => 'id',
                    ],
                    'PlaceCountry' => [
                        'citizenship' => 'id',
                        'place_country_id' => 'id',
                    ],
                    'GovsSpeciality' => [
                        'govs_speciality_ids' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'GovsDegree' => [
                        'govs_degree_ids' => 'id',
                    ],
                ];
            $config->denyDB = 'Table';

            $config->title = Az::l('Соотечественники');

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
           

            
           
            'birthdate' => function (FormDb $column) {

                $column->title = Az::l('Дата рождение');
                $column->tooltip = Az::l('Дата рождение Соотечественника');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;

                return $column;
            },
            
           
            'photo' => function (FormDb $column) {

                $column->title = Az::l('Фото');
                $column->tooltip = Az::l('Фото Соотечественника');
                $column->dbType = dbTypeJsonb;

                return $column;
            },
            
           
            'lang_nationality_id' => function (FormDb $column) {

                $column->title = Az::l('Национальность');
                $column->tooltip = Az::l('Национальность Соотечественника');
                $column->widget = ZHTextareaWidget::class;

                return $column;
            },
            
           
            'citizenship' => function (FormDb $column) {

                $column->title = Az::l('Гражданство');
                $column->tooltip = Az::l('Гражданство Соотечественника');
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'place_country';

                return $column;
            },
            
           
            'place_country_id' => function (FormDb $column) {

                $column->title = Az::l('Страна проживания');
                $column->tooltip = Az::l('Страна проживания Соотечественника');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'address' => function (FormDb $column) {

                $column->title = Az::l('Постоянный адрес проживания');
                $column->tooltip = Az::l('Постоянный адрес проживания Соотечественника');
                $column->widget = ZHTextareaWidget::class;

                return $column;
            },
            
           
            'phone' => function (FormDb $column) {

                $column->title = Az::l('Телефон');
                $column->tooltip = Az::l('Телефон Соотечественника');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;
                $column->options = [
                    'formClass' => 'zetsoft\\former\\auth\\AuthPhoneForm',
                ];
                $column->valueOptions = [
                    'formClass' => 'zetsoft\\former\\auth\\AuthPhoneForm',
                ];

                return $column;
            },
            
           
            'email' => function (FormDb $column) {

                $column->title = Az::l('E-mail');
                $column->tooltip = Az::l('Элетронный адрес Соотечественника(E-mail)');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;
                $column->options = [
                    'formClass' => 'zetsoft\\former\\auth\\AuthEmailForm',
                ];
                $column->valueOptions = [
                    'formClass' => 'zetsoft\\former\\auth\\AuthEmailForm',
                ];

                return $column;
            },
            
           
            'govs_speciality_ids' => function (FormDb $column) {

                $column->title = Az::l('Специальности');
                $column->tooltip = Az::l('Специальности Соотечественника');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;
                $column->fkTable = 'govs_speciality';

                return $column;
            },
            
           
            'govs_degree_ids' => function (FormDb $column) {

                $column->title = Az::l('Научные степени');
                $column->tooltip = Az::l('Научные степени Соотечественника');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },
            
           
            'higher_education' => function (FormDb $column) {

                $column->title = Az::l('Высшие образования');
                $column->tooltip = Az::l('Высшие образования Соотечественника');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;
                $column->options = [
                    'formClass' => 'zetsoft\\former\\eyuf\\EyufHigherEducationForm',
                ];
                $column->valueOptions = [
                    'formClass' => 'zetsoft\\former\\eyuf\\EyufHigherEducationForm',
                ];

                return $column;
            },
            
           
            'additional_education' => function (FormDb $column) {

                $column->title = Az::l('Дополнительное образование');
                $column->tooltip = Az::l('Дополнительное образование Соотечественника');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;
                $column->options = [
                    'formClass' => 'zetsoft\\former\\eyuf\\EyufAdditionalEducationForm',
                ];
                $column->valueOptions = [
                    'formClass' => 'zetsoft\\former\\eyuf\\EyufAdditionalEducationForm',
                ];

                return $column;
            },
            
           
            'higher_publication' => function (FormDb $column) {

                $column->title = Az::l('Публикации');
                $column->tooltip = Az::l('Публикации Соотечественника');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;
                $column->options = [
                    'formClass' => 'zetsoft\\former\\eyuf\\EyufHigherPublicationForm',
                ];
                $column->valueOptions = [
                    'formClass' => 'zetsoft\\former\\eyuf\\EyufHigherPublicationForm',
                ];

                return $column;
            },
            
           
            'experience' => function (FormDb $column) {

                $column->title = Az::l('Опыт работы');
                $column->tooltip = Az::l('Опыт работы Соотечественника');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;
                $column->options = [
                    'formClass' => 'zetsoft\\former\\eyuf\\EyufExperienceForm',
                ];
                $column->valueOptions = [
                    'formClass' => 'zetsoft\\former\\eyuf\\EyufExperienceForm',
                ];

                return $column;
            },
            
           
            'awards' => function (FormDb $column) {

                $column->title = Az::l('Достижения');
                $column->tooltip = Az::l('Достижения Соотечественника');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;
                $column->options = [
                    'formClass' => 'zetsoft\\former\\eyuf\\EyufHonoursForm',
                ];
                $column->valueOptions = [
                    'formClass' => 'zetsoft\\former\\eyuf\\EyufHonoursForm',
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
        'birthdate',
        'photo',
        'lang_nationality_id',
        'citizenship',
        'place_country_id',
        'address',
        'phone',
        'email',
        'govs_speciality_ids',
        'govs_degree_ids',
        'higher_education',
        'additional_education',
        'higher_publication',
        'experience',
        'awards',
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
                                'title',
                            ],
                            [
                                'birthdate',
                            ],
                            [
                                'photo',
                            ],
                            [
                                'lang_nationality_id',
                            ],
                            [
                                'citizenship',
                            ],
                            [
                                'place_country_id',
                            ],
                            [
                                'address',
                            ],
                            [
                                'phone',
                            ],
                            [
                                'email',
                            ],
                            [
                                'govs_speciality_ids',
                            ],
                            [
                                'govs_degree_ids',
                            ],
                            [
                                'higher_education',
                            ],
                            [
                                'additional_education',
                            ],
                            [
                                'higher_publication',
                            ],
                            [
                                'experience',
                            ],
                            [
                                'awards',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                public function value(EyufTable $model = null)
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
        $event->beforeDelete = function (EyufTable $model) {
            return null;
        };

        $event->afterDelete = function (EyufTable $model) {
            return null;
        };

        $event->beforeSave = function (EyufTable $model) {
            return null;
        };

        $event->afterSave = function (EyufTable $model) {
            return null;
        };

        $event->beforeValidate = function (EyufTable $model) {
            return null;
        };

        $event->afterValidate = function (EyufTable $model) {
            return null;
        };

        $event->afterRefresh = function (EyufTable $model) {
            return null;
        };

        $event->afterFind = function (EyufTable $model) {
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
     * Function  getLangNationality
     * @return bool|\yii\db\ActiveRecord|LangNationality|null
     */            
    public function getLangNationalityOne()
    {
        return $this->getOne(LangNationality::class, [
          'id' => 'lang_nationality_id',
      ]);    
    }
    
     /**
     *
     * Function  getLangNationality
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getLangNationality()
    {
        return $this->hasOne(LangNationality::class, [
          'id' => 'lang_nationality_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getCitizenship
     * @return bool|\yii\db\ActiveRecord|PlaceCountry|null
     */            
    public function getCitizenshipOne()
    {
        return $this->getOne(PlaceCountry::class, [
          'id' => 'citizenship',
      ]);    
    }
    
     /**
     *
     * Function  getCitizenship
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCitizenship()
    {
        return $this->hasOne(PlaceCountry::class, [
          'id' => 'citizenship',
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
     * Function  getGovsSpecialityIds
     * @return bool|\yii\db\ActiveRecord|GovsSpeciality|null
     */            
    public function getGovsSpecialityIdsOne()
    {
        return $this->getOne(GovsSpeciality::class, [
          'id' => 'govs_speciality_ids',
      ]);    
    }
    
     /**
     *
     * Function  getGovsSpecialityIds
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getGovsSpecialityIds()
    {
        return $this->hasOne(GovsSpeciality::class, [
          'id' => 'govs_speciality_ids',
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
     * Function  getGovsDegreesFromGovsDegreeIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|GovsDegree
     */            
    public function getGovsDegreesFromGovsDegreeIdsMulti()
    {
        return $this->getMulti(GovsDegree::class, [
          'id' => 'govs_degree_ids',
      ]);    
    }


    #endregion
    
    #region Many



    #endregion


}
