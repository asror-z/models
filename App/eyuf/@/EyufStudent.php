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
use zetsoft\widgets\inputes\ZHTextareaWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\App\eyuf\EyufUniversity;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;



/**
 * Class    EyufStudent
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property string $fio
 * @property string $adress
 * @property array $photo
 * @property int $eyuf_university_id
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class EyufStudent extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $name;
    public $fio;
    public $adress;
    public $photo;
    public $eyuf_university_id;
    public $created_at;
    public $modified_at;
    public $created_by;
    public $modified_by;
    */

    #endregion

    #region Names

    #endregion

    #region Const

    #endregion

    ##region Init

    public static ?string $dbase = 'db';

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
			'name',
			'fio',
			'adress',
			'photo',
			'eyuf_university_id',
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
        return static function (ConfigDB $config) {

            $config->hasOne = [
                    'EyufUniversity' => [
                        'eyuf_university_id' => 'id',
                    ],
                    'User' => [
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'EyufDocument' => [
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
            $config->title = Az::l('Student');
            $config->tooltip = Az::l('Студент');

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
           
            'fio' => function (FormDb $column) {

                $column->title = Az::l('FIO');
                $column->tooltip = Az::l('Фамилия Имя Отчество Студента');

                return $column;
            },
            
           
            'adress' => function (FormDb $column) {

                $column->title = Az::l('adress');
                $column->tooltip = Az::l('Адрес Студента');
                $column->widget = ZHTextareaWidget::class;

                return $column;
            },
            
           
            'photo' => function (FormDb $column) {

                $column->title = Az::l('photo');
                $column->tooltip = Az::l('Фото Студента');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;

                return $column;
            },
            
           
            'eyuf_university_id' => function (FormDb $column) {

                $column->title = Az::l('university');
                $column->tooltip = Az::l('Университет Студента');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'fio',
        'adress',
        'photo',
        'eyuf_university_id',
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
                                'fio',
                            ],
                            [
                                'adress',
                            ],
                            [
                                'photo',
                            ],
                            [
                                'eyuf_university_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                public function value(EyufStudent $model = null)
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
        $event->beforeDelete = function (EyufStudent $model) {
            return null;
        };

        $event->afterDelete = function (EyufStudent $model) {
            return null;
        };

        $event->beforeSave = function (EyufStudent $model) {
            return null;
        };

        $event->afterSave = function (EyufStudent $model) {
            return null;
        };

        $event->beforeValidate = function (EyufStudent $model) {
            return null;
        };

        $event->afterValidate = function (EyufStudent $model) {
            return null;
        };

        $event->afterRefresh = function (EyufStudent $model) {
            return null;
        };

        $event->afterFind = function (EyufStudent $model) {
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
    public function faker()
    {
        return null;
    }


    #endregion

    #region One


    /**
     *
     * Function  getEyufUniversity
     * @return bool|\yii\db\ActiveRecord|EyufUniversity|null
     */            
    public function getEyufUniversityOne()
    {
        return $this->getOne(EyufUniversity::class, [
          'id' => 'eyuf_university_id',
      ]);    
    }
    
     /**
     *
     * Function  getEyufUniversity
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getEyufUniversity()
    {
        return $this->hasOne(EyufUniversity::class, [
          'id' => 'eyuf_university_id',
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
     * Function  getEyufDocumentsWithEyufStudentIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufDocument
     */            
    public function getEyufDocumentsWithEyufStudentIdMany()
    {
       return $this->getMany(EyufDocument::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufDocumentsWithEyufStudentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufDocumentsWithEyufStudentId()
    {
       return $this->hasMany(EyufDocument::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufInvoicesWithEyufStudentIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufInvoice
     */            
    public function getEyufInvoicesWithEyufStudentIdMany()
    {
       return $this->getMany(EyufInvoice::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufInvoicesWithEyufStudentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufInvoicesWithEyufStudentId()
    {
       return $this->hasMany(EyufInvoice::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufReportsWithEyufStudentIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufReport
     */            
    public function getEyufReportsWithEyufStudentIdMany()
    {
       return $this->getMany(EyufReport::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufReportsWithEyufStudentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufReportsWithEyufStudentId()
    {
       return $this->hasMany(EyufReport::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufTicketsWithEyufStudentIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufTicket
     */            
    public function getEyufTicketsWithEyufStudentIdMany()
    {
       return $this->getMany(EyufTicket::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufTicketsWithEyufStudentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufTicketsWithEyufStudentId()
    {
       return $this->hasMany(EyufTicket::class, [
            'eyuf_scholar_id' => 'id',
        ]);     
    }


    #endregion


}
