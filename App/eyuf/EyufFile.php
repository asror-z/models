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
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\dbdata\eyuf\DocTypeData;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\navigat\ZDownloadWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZHTextareaWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    EyufFile
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
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class EyufFile extends ZActiveRecord
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
    public static ?string $title = Azl . '';
    public static ?string $icon = '';
    public static ?bool $menu = false;

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
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->makeDB = false;
            $config->menu = false;

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

            'file' => function (FormDb $column) {

                $column->title = Az::l('Файл');
                $column->tooltip = Az::l('Файл документа');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->width = '300px';
                $column->roleEdit = [
                    RoleData::admin,
                    RoleData::dev,
                    RoleData::scholar,
                ];
                $column->valueWidget = ZDownloadWidget::class;
                $column->options = [
                    'config' => [
                        'maxFileCount' => 5,
                    ],
                ];

                return $column;
            },


            'eyuf_scholar_id' => function (FormDb $column) {

                $column->title = Az::l('Автор');
                $column->tooltip = Az::l('Автор документа');
                $column->dbType = dbTypeInteger;
                $column->width = '100px';
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                $column->value = function () {
                    return Az::$app->App->eyuf->scholar->getId();

                };

                $column->widget = ZKSelect2Widget::class;
                $column->roleEdit = [
                    'admin',
                    'dev',
                ];

                return $column;
            },


            'status' => function (FormDb $column) {

                $column->title = Az::l('Принят?');
                $column->tooltip = Az::l('Принят ли документ');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;


                //start|JakhongirKudratov|2020-10-27

                $column->event = function ($model) {
                    
                };

                //end|JakhongirKudratov|2020-10-27

                $column->roleEditEx = [
                    RoleData::user,
                    RoleData::scholar,
                ];


                return $column;
            },


            'need_verify' => function (FormDb $column) {

                $column->title = Az::l('На подтверждение Модератору');
                $column->tooltip = Az::l('Документ на подтверждение Модератору');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                $column->roleEditEx = [
                    RoleData::user,
                    RoleData::scholar,
                ];
                //start|JakhongirKudratov|2020-10-27

                $column->event = function ($model) {
                    Az::$app->App->eyuf->docs->sendNotifyToModerator($model);
                };

                //end|JakhongirKudratov|2020-10-27

                $column->roleEditEx = [
                    RoleData::user,
                    RoleData::scholar,
                    RoleData::moderator,
                ];

                $column->roleShowEx = [
                    RoleData::user,
                    RoleData::scholar,
                ];

                return $column;
            },


            'verified' => function (FormDb $column) {

                $column->title = Az::l('Подтвержден Модератором');
                $column->tooltip = Az::l('Модераторское подтверждение документа');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->roleEditEx = [
                    RoleData::user,
                    RoleData::scholar,
                ];

                $column->roleShowEx = [
                    RoleData::user,
                    RoleData::scholar,
                ];

                $column->readonly = true;
                //start|JakhongirKudratov|2020-10-27

                $column->event = function ($model) {
                    Az::$app->App->eyuf->docs->sendNotifyToMonitor($model);
                };

                //end|JakhongirKudratov|2020-10-27

                return $column;
            },


            'file_comment' => function (FormDb $column) {

                $column->title = Az::l('Файл Коммент');
                $column->tooltip = Az::l('Файл Коммент документа');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->valueWidget = ZDownloadWidget::class;
                $column->options = [
                    'config' => [
                        'maxFileCount' => 5,
                    ],
                ];
                $column->format = 'raw';
                $column->width = '250px';
                $column->roleEditEx = [
                    RoleData::user,
                    RoleData::scholar,
                ];

                $column->roleShowEx = [
                    RoleData::user,
                    RoleData::scholar,
                ];

                return $column;
            },


            'comment' => function (FormDb $column) {

                $column->title = Az::l('Коммент');
                $column->tooltip = Az::l('Коммент документа');
                $column->widget = ZHTextareaWidget::class;
                $column->roleEditEx = [
                    RoleData::user,
                    RoleData::scholar,
                ];

                $column->roleShowEx = [
                    RoleData::user,
                    RoleData::scholar,
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
        'file',
        'eyuf_scholar_id',
        'status',
        'need_verify',
        'verified',
        'file_comment',
        'comment',
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

        $event->beforeSave = function ($model) {
            return null;

        };

        //start|JakhongirKudratov|2020-10-27

        $event->afterSave = function ($model) {
            Az::$app->App->eyuf->docs->changeDocReady($model);
        };

        //end|JakhongirKudratov|2020-10-27

        /*
            $event->beforeDelete = function ($model) {
                return null;
            };

            $event->afterDelete = function ($model) {
                return null;
            };



            $event->afterSave = function ($model) {
                return null;
            };

            $event->beforeValidate = function ($model) {
                return null;
            };

            $event->afterValidate = function ($model) {
                return null;
            };

            $event->afterRefresh = function ($model) {
                return null;
            };

            $event->afterFind = function ($model) {
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
