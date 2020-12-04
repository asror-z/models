<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\shop;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\shop\ShopOptionTypeForm;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;


/**
 * Class    ShopCategoryTest
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property boolean $tranz
 * @property string $icon
 * @property array $shop_brand_ids
 * @property array $shop_option_type
 * @property array $image
 * @property boolean $active
 */
class ShopCategoryTest extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $sort;
    public $name;
    public $tranz;
    public $icon;
    public $shop_brand_ids;
    public $shop_option_type;
    public $image;
    public $active;
    */

    #endregion

    #region Attrs

    public const attrs = [

        'id',
        'sort',
        'name',
        'tranz',
        'icon',
        'shop_brand_ids',
        'shop_option_type',
        'image',
        'active',
    ];

    #endregion

    #region Names

    #endregion

    #region Const

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Категории';
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
			'tranz',
			'icon',
			'shop_brand_ids',
			'shop_option_type',
			'image',
			'active',

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

            $config->addSort = true;
            $config->nameLang = true;
            $config->hasMulti = [
                    'ShopBrand' => [
                        'shop_brand_ids' => 'id',
                    ],
                ];
            $config->title = Az::l('Категории');

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

            'icon' => function (FormDb $column) {

                $column->title = Az::l('Иконка');
                $column->tooltip = Az::l('Иконка для Магазина');
                //$column->widget = ZIconPickerWidget::class;

                return $column;
            },


            'shop_brand_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Бренды');
                $column->tooltip = Az::l('Доступные бренды магазина');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },


          /*  'shop_review_option_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Опции для отзывов');
                $column->tooltip = Az::l('Опции для отзывов магазина');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },*/


            'shop_option_type' => function (FormDb $column) {

                $column->title = Az::l('Параметры опций');
                $column->tooltip = Az::l('Доступные параметры опций магазинов');
                $column->dbType = dbTypeJsonb;

                $column->widget = ZMultiWidget::class;

                $column->options = [
                    'config' => [
                        'model' => $this,
                        'attribute' => 'home',
                        'formClass' => ShopOptionTypeForm::class,
                    ],
                ];

                return $column;
            },

/*
            'parent_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Вышестоящий');
                $column->tooltip = Az::l('Связанный вышестоящая категория');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'shop_category';

                return $column;
            },*/


            'image' => function (FormDb $column) {

                $column->title = Az::l('Картина');
                $column->tooltip = Az::l('Картина магазина');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->options = [
                    'config' => [
                        'maxFileCount' => '1',
                    ],
                ];
                $column->filterOptions = [
                    'config' => [
                        'maxFileCount' => '1',
                    ],
                ];
                $column->mergeHeader = true;

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
        'tranz',
        'icon',
        'shop_brand_ids',
        'shop_option_type',
        'image',
        'active',

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
                                'sort',
                            ],
                            [
                                'name',
                            ],
                            [
                                'icon',
                            ],
                            [
                                'shop_brand_ids',
                            ],
                            [
                                'shop_review_option_ids',
                            ],
                            [
                                'shop_option_type',
                            ],
                            [
                                'parent_id',
                            ],
                            [
                                'image',
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
    public function value(ShopCategory $model = null)
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

        /*   $event->afterSave = function (ShopCategory $model) {
               if (!$this->isCLI())
                   if (!ZArrayHelper::getValue(Az::$app->params, 'sortCategory'))
                       if (!$this->isNewRecord) {


                           //Az::$app->market->product->afterEditCorecategory($model->id);
                           //$url = $this->urlGetBase() . "/admin/core-category/queue.aspx?namespace=cores&service=product&method=afterEditCorecategory&args=$model->id";
                           // $url = '/shop/admin/core-category/queue.aspx?namespace=reacts&service=childprocess&method=runcommand&args=ping mail.ru -t';

                          $url = $this->urlGetBase() . '/core/product/afterEditCoreCategory.aspx?category_id=' . $model->id;
                           //vdd($url);
                           Az::$app->https->amphp->getRequest($url);
                       }
           };*/


        /*
        *
        * $event->afterSave = function (CoreCategory $model) {
        return null;
        };
        $event->beforeDelete = function (CoreCategory $model) {
        return null;
        };

        $event->afterDelete = function (CoreCategory $model) {
        return null;
        };

        $event->beforeSave = function (CoreCategory $model) {
        return null;
        };

        $event->afterSave = function (CoreCategory $model) {
        return null;
        };

        $event->beforeValidate = function (CoreCategory $model) {
        return null;
        };

        $event->afterValidate = function (CoreCategory $model) {
        return null;
        };

        $event->afterRefresh = function (CoreCategory $model) {
        return null;
        };

        $event->afterFind = function (CoreCategory $model) {
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



    #endregion

    #region Multi


    /**
     *
     * Function  getShopBrandsFromShopBrandIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|ShopBrand
     */            
    public function getShopBrandsFromShopBrandIdsMulti()
    {
        return $this->getMulti(ShopBrand::class, [
          'id' => 'shop_brand_ids',
      ]);    
    }


    #endregion
    
    #region Many



    #endregion


}
