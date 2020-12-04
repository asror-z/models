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


use kartik\grid\DataColumn;
use zetsoft\dbdata\cpas\CpasTeaserData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\cpas\CpasCounterForm;
use zetsoft\former\cpas\CpasTeaserForm;
use zetsoft\former\cpas\CpasWidgetForm;
use zetsoft\former\post\PostCpasPostbackForm;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\column\ZKDataColumn;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\kernels\ZView;
use zetsoft\system\validate\TransLinkValidator;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\widgets\navigat\ZButtonWidget;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\models\cpas\CpasOffer;
use zetsoft\models\cpas\CpasLand;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\cpas\CpasStream;
use zetsoft\models\cpas\CpasTeaser;
use zetsoft\models\cpas\CpasTracker;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CpasStreamItem
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property int $accept
 * @property boolean $active
 * @property int $cpas_land_id
 * @property int $cpas_trans
 * @property int $cpas_trans_form
 * @property int $cpas_stream_id
 * @property int $user_id
 * @property string $link
 * @property string $trans_link
 * @property string $track
 * @property array $teaser
 * @property int $click
 * @property int $uniclick
 * @property int $lead
 * @property int $cancel
 * @property int $trash
 * @property string $EPC
 * @property string $CPC
 * @property string $CR
 * @property string $revenue
 * @property string $expense
 * @property string $profit
 * @property string $ROI
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CpasStreamItem extends ZActiveRecord
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
    public $cpas_land_id;
    public $cpas_trans;
    public $cpas_trans_form;
    public $cpas_stream_id;
    public $user_id;
    public $link;
    public $trans_link;
    public $track;
    public $teaser;
    public $click;
    public $uniclick;
    public $lead;
    public $cancel;
    public $trash;
    public $EPC;
    public $CPC;
    public $CR;
    public $revenue;
    public $expense;
    public $profit;
    public $ROI;
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
        'cpas_land_id',
        'cpas_trans',
        'cpas_trans_form',
        'cpas_stream_id',
        'user_id',
        'link',
        'trans_link',
        'track',
        'teaser',
        'click',
        'uniclick',
        'lead',
        'cancel',
        'trash',
        'EPC',
        'CPC',
        'CR',
        'revenue',
        'expense',
        'profit',
        'ROI',
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
    public static ?string $title = Azl . 'Элементы потока';
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
			'cpas_land_id',
			'cpas_trans',
			'cpas_trans_form',
			'cpas_stream_id',
			'user_id',
			'link',
			'trans_link',
			'track',
			'teaser',
			'click',
			'uniclick',
			'lead',
			'cancel',
			'trash',
			'EPC',
			'CPC',
			'CR',
			'revenue',
			'expense',
			'profit',
			'ROI',
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
                    'CpasLand' => [
                        'cpas_land_id' => 'id',
                        'cpas_trans' => 'id',
                        'cpas_trans_form' => 'id',
                    ],
                    'CpasStream' => [
                        'cpas_stream_id' => 'id',
                    ],
                    'User' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'CpasTracker' => [
                        'cpas_stream_item_id' => 'id',
                    ],
                ];
            $config->name = 'title';

            $config->after = [
                    'link' => [
                        [
                            'class' => 'zetsoft\\system\\column\\ZKDataColumn',
                            'label' => 'Трекинг ссылка',
                            'format' => 'raw',
                            'mergeHeader' => false,
                            'filter' => true,
                            'filterType' => 'zetsoft\\widgets\\inputes\\ZHInputWidget',
                            'value' => function ($model, $key, $index, DataColumn $dataColumn) {
                            return ZButtonWidget::widget([
                                    'id' => ZArrayHelper::getValue($model, 'id'),
                                    'config' => [
                                        'title' => Az::l('Трекинг ссылка'),
                                        'icon' => 'fas fa-edit',
                                        'pjax' => 0,
                                        'url' => '/cpas/track/main.aspx?cpas_stream_item_id=' . ZArrayHelper::getValue($model, 'id'),
                                        'btnRounded' => false,
                                        'btn' => false,
                                        'hasIcon' => true,
                                    ],
                                    'event' => [
                                        'click' => 'event.preventDefault(); window.open(this.href, "_blank")',
                                    ],
                                ]) .
                                ZButtonWidget::widget([
                                    'id' => ZArrayHelper::getValue($model, 'id'),
                                    'config' => [
                                        'title' => Az::l('Трекинг ссылка'),
                                        'icon' => 'fas fa-edit',
                                        'pjax' => 0,
                                        'url' => '/cpas/track/teaser.aspx?network=mgid&cpas_stream_item_id=' . ZArrayHelper::getValue($model, 'id'),
                                        'btnRounded' => false,
                                        'btn' => false,
                                        'hasIcon' => true,
                                    ],
                                    'event' => [
                                        'click' => 'event.preventDefault(); window.open(this.href, "_blank")',
                                    ],
                                ]);
                                        },
                        ],
                    ],
                ];
            $config->title = Az::l('Элементы потока');

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


            /**
             *
             * Landings
             */

            'cpas_land_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Лендинг');
               /* $column->widget = ZKSelect2Widget::class;
                $column->fkQuery = [
                    'type' => 'land'
                ];*/
                $column->widget = ZDepdropWidget::class;
                $column->options = [
                    'config' => [
                        'depend' => 'cpas_stream_id',
                        'method' => 'getCpasLand',
                        'args' => 'land'

                    ],
                ];

                $column->fkAttr = 'title';
                return $column;
            },


            'cpas_trans' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Прелендинг');
                $column->dbType = dbTypeInteger;
                /*$column->widget = ZKSelect2Widget::class;
                $column->fkQuery = [
                    'type' => 'trans'
                ];*/
                $column->fkTable = 'cpas_land';
                $column->fkAttr = 'title';

                $column->widget = ZDepdropWidget::class;
                $column->options = [
                    'config' => [
                        'depend' => 'cpas_stream_id',
                        'method' => 'getCpasLand',
                        'args' => 'trans'

                    ],
                ];
                $column->dbType = dbTypeInteger;
                return $column;
            },

            'cpas_trans_form' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Прелендинг с формой');
                $column->dbType = dbTypeInteger;
                /*$column->widget = ZKSelect2Widget::class;
                $column->fkQuery = [
                    'type' => 'trans_form'
                ];*/
                $column->fkTable = 'cpas_land';
                $column->fkAttr = 'title';

                $column->widget = ZDepdropWidget::class;
                $column->options = [
                    'config' => [
                        'depend' => 'cpas_stream_id',
                        'method' => 'getCpasLand',
                        'args' => 'trans_form'

                    ],
                ];
                $column->dbType = dbTypeInteger;
                return $column;
            },


            /**
             *
             * Auto Fill
             */

            'cpas_stream_id' => function (FormDb $column) {

                $column->index = true;
                $column->readonly = true;
                $column->title = Az::l('Поток');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'user_id' => function (FormDb $column) {

                $column->index = true;
                $column->readonly = true;
                $column->title = Az::l('User');
                $column->widget = ZKSelect2Widget::class;

                /*$column->auto = true;
                $column->autoValue = function () {
                    return null;
                };*/
               /* $column->auto = false;
                $column->autoValue = function () {
                    return $this->getCpasStreamOne()->user_id;
                };*/

                return $column;
            },


            /**
             *
             * Main Data
             */




            'link' => function (FormDb $column) {

                $column->title = Az::l('Ссылка лендинга');
                $column->widget = ZHInputWidget::class;
                return $column;
            },
            
            'trans_link' => function (FormDb $column) {

                $column->title = Az::l('Ссылка для прелендинга');
                $column->widget = ZHInputWidget::class;
                $column->rules = [
                    [
                        TransLinkValidator::class
                    ]
                ];
                return $column;
            },


            'track' => function (FormDb $column) {

                $column->title = Az::l('Трекинг ссылка');
                $column->widget = ZHInputWidget::class;

                return $column;
            },

            'teaser' => function (FormDb $column) {

                $column->title = Az::l('Ссылка для тизерных сетей');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
                    'config' => [
                        'formClass' => CpasTeaserForm::class,
                    ],
                ];
                $column->valueOptions = [
                    'config' => [
                        'formClass' => CpasTeaserForm::class,
                    ],
                ];

                $column->auto = true;
                $column->autoValue = function (CpasStreamItem $model) {
                    $view = new ZView();
                    $form = new CpasTeaserForm();
                    $data = (new CpasTeaserData())->lang();
                    foreach ($data as $key => $item) {
                        $form->$key = $view->urlGetBase() . "/track/teaser.aspx?cpas_stream_item_id={$model->id}&" . $item;
                        $keys[] = $key;
                    }
                    $array = $form->attributes;
                    foreach ($array as $key => $item) {
                        if (!ZArrayHelper::isIn($key, $keys)) {
                            unset($array[$key]);
                        }
                    }
                    return $array;
                };
                $column->mergeHeader = true;
                $column->showForm = false;

                return $column;
            },


            /**
             *
             * Stats Data
             */

            'click' => function (FormDb $column) {

                $column->title = Az::l('Клики');
                $column->readonly = true;
                $column->dbType = dbTypeInteger;
                $column->value = 0;

                return $column;
            },

            'uniclick' => function (FormDb $column) {

                $column->title = Az::l('Уникальные клики');
                $column->readonly = true;
                $column->dbType = dbTypeInteger;

                return $column;
            },

            'lead' => function (FormDb $column) {

                $column->title = Az::l('Лиды');
                $column->readonly = true;
                $column->dbType = dbTypeInteger;

                return $column;
            },


            /**
             *
             * Statuses
             */

            'accept' => function (FormDb $column) {

                $column->title = Az::l('Одобрен');
                $column->readonly = true;
                $column->dbType = dbTypeInteger;

                return $column;
            },

            'cancel' => function (FormDb $column) {

                $column->title = Az::l('Отменен');
                $column->readonly = true;
                $column->dbType = dbTypeInteger;

                return $column;
            },

            'trash' => function (FormDb $column) {

                $column->title = Az::l('Треш');
                $column->readonly = true;
                $column->dbType = dbTypeInteger;

                return $column;
            },


            /**
             *
             * Conversion
             */

            'EPC' => function (FormDb $column) {

                $column->title = Az::l('EPC');
                $column->widget = ZHInputWidget::class;

                return $column;
            },

            'CPC' => function (FormDb $column) {

                $column->title = Az::l('CPC');
                $column->widget = ZHInputWidget::class;

                return $column;
            },


            'CR' => function (FormDb $column) {

                $column->title = Az::l('CR');
                $column->widget = ZHInputWidget::class;

                return $column;
            },


            /**
             *
             * Money
             */

            'revenue' => function (FormDb $column) {

                $column->title = Az::l('Доход');
                $column->readonly = true;
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZHInputWidget::class;

                return $column;
            },


            'expense' => function (FormDb $column) {

                $column->title = Az::l('Расходы');
                $column->readonly = true;
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZHInputWidget::class;

                return $column;
            },

            'profit' => function (FormDb $column) {

                $column->title = Az::l('Прибыль');
                $column->readonly = true;
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZHInputWidget::class;

                return $column;
            },


            'ROI' => function (FormDb $column) {

                $column->title = Az::l('Возврат инвестиций');
                $column->readonly = true;
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZHInputWidget::class;

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
        'cpas_land_id',
        'cpas_trans',
        'cpas_trans_form',
        'cpas_stream_id',
        'user_id',
        'link',
        'trans_link',
        'track',
        'teaser',
        'click',
        'uniclick',
        'lead',
        'cancel',
        'trash',
        'EPC',
        'CPC',
        'CR',
        'revenue',
        'expense',
        'profit',
        'ROI',
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
                                'cpas_land_id',
                                'cpas_trans',
                                'cpas_trans_form',
                                'cpas_stream_id',
                                'user_id',
                                'title',
                                'link',
                                'trans_link',
                                'track',
                                'teaser',
                                'click',
                                'uniclick',
                                'lead',
                                'accept',
                                'cancel',
                                'trash',
                                'EPC',
                                'CPC',
                                'CR',
                                'revenue',
                                'expense',
                                'profit',
                                'ROI',
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
    public function value(CpasStream $model = null)
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
        $event->afterSave = function (CpasStreamItem $model) {

               
                   Az::$app->cpas->cpa->createCpasSite($model);
                   $model->track = $this->urlGetBase() . '/cpas/track/track.aspx?cpas_stream_item_id=' . $model->id;

        };
        /*
        $event->beforeDelete = function (ShopBrand $model) {
        return null;
        };

        $event->afterDelete = function (ShopBrand $model) {
        return null;
        };

        $event->beforeSave = function (ShopBrand $model) {
        return null;
        };

        $event->afterSave = function (ShopBrand $model) {
        return null;
        };

        $event->beforeValidate = function (ShopBrand $model) {
        return null;
        };

        $event->afterValidate = function (ShopBrand $model) {
        return null;
        };

        $event->afterRefresh = function (ShopBrand $model) {
        return null;
        };

        $event->afterFind = function (ShopBrand $model) {
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
     * Function  getCpasLand
     * @return bool|\yii\db\ActiveRecord|CpasLand|null
     */            
    public function getCpasLandOne()
    {
        return $this->getOne(CpasLand::class, [
          'id' => 'cpas_land_id',
      ]);    
    }
    
     /**
     *
     * Function  getCpasLand
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCpasLand()
    {
        return $this->hasOne(CpasLand::class, [
          'id' => 'cpas_land_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getCpasTrans
     * @return bool|\yii\db\ActiveRecord|CpasLand|null
     */            
    public function getCpasTransOne()
    {
        return $this->getOne(CpasLand::class, [
          'id' => 'cpas_trans',
      ]);    
    }
    
     /**
     *
     * Function  getCpasTrans
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCpasTrans()
    {
        return $this->hasOne(CpasLand::class, [
          'id' => 'cpas_trans',
      ]);    
    }
    
    

    /**
     *
     * Function  getCpasTransForm
     * @return bool|\yii\db\ActiveRecord|CpasLand|null
     */            
    public function getCpasTransFormOne()
    {
        return $this->getOne(CpasLand::class, [
          'id' => 'cpas_trans_form',
      ]);    
    }
    
     /**
     *
     * Function  getCpasTransForm
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCpasTransForm()
    {
        return $this->hasOne(CpasLand::class, [
          'id' => 'cpas_trans_form',
      ]);    
    }
    
    

    /**
     *
     * Function  getCpasStream
     * @return bool|\yii\db\ActiveRecord|CpasStream|null
     */            
    public function getCpasStreamOne()
    {
        return $this->getOne(CpasStream::class, [
          'id' => 'cpas_stream_id',
      ]);    
    }
    
     /**
     *
     * Function  getCpasStream
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCpasStream()
    {
        return $this->hasOne(CpasStream::class, [
          'id' => 'cpas_stream_id',
      ]);    
    }
    
    

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
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many


    /**
     *
     * Function  getCpasTrackersWithCpasStreamItemIdMany
     * @return  null|\yii\db\ActiveRecord[]|CpasTracker
     */            
    public function getCpasTrackersWithCpasStreamItemIdMany()
    {
       return $this->getMany(CpasTracker::class, [
            'cpas_stream_item_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasTrackersWithCpasStreamItemId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasTrackersWithCpasStreamItemId()
    {
       return $this->hasMany(CpasTracker::class, [
            'cpas_stream_item_id' => 'id',
        ]);     
    }


    #endregion


}
