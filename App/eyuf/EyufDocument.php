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


use zetsoft\dbdata\App\eyuf\RoleData;
use zetsoft\dbdata\eyuf\DocTypeData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\models\App\eyuf\EyufFile;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;



/**
 * Class    EyufDocument
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property array $file
 * @property int $eyuf_scholar_id
 * @property boolean $status
 * @property boolean $need_verify
 * @property boolean $verified
 * @property array $file_comment
 * @property string $comment
 * @property int $eyuf_document_type_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class EyufDocument extends EyufFile
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
    public $file;
    public $eyuf_scholar_id;
    public $status;
    public $need_verify;
    public $verified;
    public $file_comment;
    public $comment;
    public $eyuf_document_type_id;
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
        'file',
        'eyuf_scholar_id',
        'status',
        'need_verify',
        'verified',
        'file_comment',
        'comment',
        'eyuf_document_type_id',
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
    public static ?string $title = Azl . 'Документ';
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
			'file',
			'eyuf_scholar_id',
			'status',
			'need_verify',
			'verified',
			'file_comment',
			'comment',
			'eyuf_document_type_id',
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

                        $config->query = function ($model) {
                if ($this->hasRole(RoleData::scholar))

                    return static::find()
                        ->where([
                            'eyuf_scholar_id' => Az::$app->App->eyuf->scholar->getId()
                        ]);


                return null;

            };

            $config->hasOne = [
                    'EyufScholar' => [
                        'eyuf_scholar_id' => 'id',
                    ],
                    'EyufDocumentType' => [
                        'eyuf_document_type_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Документ');
                        $config->readonly = static function ($model, $widget = null) {
                $data = false;
                $b1 = ZArrayHelper::getValue($model, 'status');

                return $b1;

            };


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

            'eyuf_document_type_id' => function (FormDb $column) {

                $column->title = Az::l('Тип документа');
                $column->tooltip = Az::l('Тип документа');
                $column->dbType = dbTypeInteger;
                $column->width = '200px';
                $column->ajax = false;
                $column->data = DocTypeData::class;
                $column->rules = 'zetsoft\\system\\validate\\ZRequiredValidator';
                $column->widget = ZKSelect2Widget::class;

                //$column->hiddenFromExport = true;

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
        'file',
        'eyuf_scholar_id',
        'status',
        'need_verify',
        'verified',
        'file_comment',
        'comment',
        'eyuf_document_type_id',
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
                                'sort',
                                'name',
                                'title',
                                'tranz',
                                'accept',
                                'active',
                                'file',
                                'eyuf_scholar_id',
                                'status',
                                'need_verify',
                                'verified',
                                'file_comment',
                                'comment',
                                'eyuf_document_type_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value($model = null)
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

        $event->beforeSave = function (EyufDocument $model) {
            return null;

        };

        //start|JakhongirKudratov|2020-10-27

        $event->afterSave = function (EyufDocument $model) {
            Az::$app->App->eyuf->docs->changeDocReady($model);
            Az::$app->App->eyuf->docs->sendToAccounter($model);
        };

        //end|JakhongirKudratov|2020-10-27

        /*
            $event->beforeDelete = function (EyufDocument $model) {
                return null;
            };

            $event->afterDelete = function (EyufDocument $model) {
                return null;
            };



            $event->afterSave = function (EyufDocument $model) {
                return null;
            };

            $event->beforeValidate = function (EyufDocument $model) {
                return null;
            };

            $event->afterValidate = function (EyufDocument $model) {
                return null;
            };

            $event->afterRefresh = function (EyufDocument $model) {
                return null;
            };

            $event->afterFind = function (EyufDocument $model) {
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
     * Function  getEyufDocumentType
     * @return bool|\yii\db\ActiveRecord|EyufDocumentType|null
     */            
    public function getEyufDocumentTypeOne()
    {
        return $this->getOne(EyufDocumentType::class, [
          'id' => 'eyuf_document_type_id',
      ]);    
    }
    
     /**
     *
     * Function  getEyufDocumentType
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getEyufDocumentType()
    {
        return $this->hasOne(EyufDocumentType::class, [
          'id' => 'eyuf_document_type_id',
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
