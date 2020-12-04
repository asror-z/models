<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\test;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\column\ZKEditableColumn;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\widgets\inputes\ZTelInputWidget;
use zetsoft\models\place\PlaceRegion;
use zetsoft\models\shop\ShopOrder;
use zetsoft\widgets\navigat\ZButtonWidget;
use zetsoft\widgets\places\ZGoogleReadyWidget;
use zetsoft\widgets\values\ZAdressViewWidget;
use zetsoft\widgets\values\ZFormViewShahzodWidget;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\widgets\values\ZLocationViewWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\user\UserCompany;
use zetsoft\models\place\PlaceCountry;
use zetsoft\models\ware\Ware;
use zetsoft\widgets\inputes\ZKDatepickerWidget;



/**
 * Class    TestZPlaceAdressZoir2
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property int $place_country_id
 * @property int $place_region_id
 * @property string $street
 * @property string $home
 * @property string $orientation
 * @property int $postal_code
 * @property string $place
 * @property array $location
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class TestZPlaceAdressZoir2 extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $name;
    public $place_country_id;
    public $place_region_id;
    public $street;
    public $home;
    public $orientation;
    public $postal_code;
    public $place;
    public $location;
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
			'place_country_id',
			'place_region_id',
			'street',
			'home',
			'orientation',
			'postal_code',
			'place',
			'location',
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

            $config->title = Az::l('Адреса');

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
           
            'place_country_id' => function (FormDb $column) {

                $column->title = Az::l('Страна');
                $column->dbType = dbTypeInteger;
                $column->widget = ZDepdropWidget::class;
                $column->fkTable = 'place_country';

                return $column;
            },
            
           
            'place_region_id' => function (FormDb $column) {

                $column->title = Az::l('Область');
                $column->dbType = dbTypeInteger;
                $column->widget = ZDepdropWidget::class;
                $column->options = [
						'config' =>[
							'depend' => 'place_country_id',
							'url' => '/core/region/getRegion.aspx',
						],
					];

                return $column;
            },
            
           
            'street' => function (FormDb $column) {

                $column->title = Az::l('Улица/Переулок');

                return $column;
            },
            
           
            'home' => function (FormDb $column) {

                $column->title = Az::l('Дом, Этаж, № квартиры');

                return $column;
            },
            
           
            'orientation' => function (FormDb $column) {

                $column->title = Az::l('Ориентир');

                return $column;
            },
            
           
            'postal_code' => function (FormDb $column) {

                $column->title = Az::l('Почтовый индекс');
                $column->dbType = dbTypeInteger;

                return $column;
            },
            
           
            'place' => function (FormDb $column) {

                $column->title = Az::l('Место');

                return $column;
            },
            
           
            'location' => function (FormDb $column) {

                $column->title = Az::l('Локация');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZGoogleReadyWidget2::class;
                $column->options = [
						'config' =>[
							'height' => '500',
							'width' => '900',
							'searchAutoComplete' => true,
							'searchPlaceImageShow' => false,
							'zoom' => '12',
							'markerCount' => '1',
							'limitWayPoints' => '0',
							'optimizeWaypoints' => false,
							'draggable' => true,
							'mapUseType' => 'write',
							'dependPlace' => true,
							'depend_id' => 'place',
						],
					];
                $column->width = '2000px';

                return $column;
            },
            

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'place_country_id',
        'place_region_id',
        'street',
        'home',
        'orientation',
        'postal_code',
        'place',
        'location',
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
                                'place_country_id',
                            ],
                            [
                                'place_region_id',
                            ],
                            [
                                'street',
                            ],
                            [
                                'home',
                            ],
                            [
                                'orientation',
                            ],
                            [
                                'postal_code',
                            ],
                            [
                                'place',
                            ],
                            [
                                'location',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(TestZPlaceAdressZoir2 &$model = null)
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
    /*
        $event->beforeDelete = function (TestZPlaceAdressZoir2 $model) {
            return null;
        };

        $event->afterDelete = function (TestZPlaceAdressZoir2 $model) {
            return null;
        };

        $event->beforeSave = function (TestZPlaceAdressZoir2 $model) {
            return null;
        };

        $event->afterSave = function (TestZPlaceAdressZoir2 $model) {
            return null;
        };

        $event->beforeValidate = function (TestZPlaceAdressZoir2 $model) {
            return null;
        };

        $event->afterValidate = function (TestZPlaceAdressZoir2 $model) {
            return null;
        };

        $event->afterRefresh = function (TestZPlaceAdressZoir2 $model) {
            return null;
        };

        $event->afterFind = function (TestZPlaceAdressZoir2 $model) {
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



    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}
