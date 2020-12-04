<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\user;


use zetsoft\dbdata\auth\RoleData;
use zetsoft\dbdata\core\LangData;
use zetsoft\dbdata\shop\CurrencyData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\auto\Auto;
use zetsoft\models\auto\AutoModel;
use zetsoft\models\auto\AutoType;
use zetsoft\models\calls\CallsAdmin;
use zetsoft\models\calls\CallsExtens;
use zetsoft\models\calls\CallsIvr;
use zetsoft\models\calls\CallsOrder;
use zetsoft\models\calls\CallsQueue;
use zetsoft\models\calls\CallsRecord;
use zetsoft\models\calls\CallsStatus;
use zetsoft\models\calls\CallsStatusTime;
use zetsoft\models\chat\ChatGroup;
use zetsoft\models\chat\ChatMail;
use zetsoft\models\chat\ChatMessage;
use zetsoft\models\chat\ChatMessagePublic;
use zetsoft\models\chat\ChatNotify;
use zetsoft\models\chat\ChatPrivate;
use zetsoft\models\chat\ChatSubscribe;
use zetsoft\models\core\CoreAnalytics;
use zetsoft\models\core\CoreHistory;
use zetsoft\models\core\CoreInput;
use zetsoft\models\core\CoreMigra;
use zetsoft\models\core\CoreQueue;
use zetsoft\models\core\CoreSession;
use zetsoft\models\core\CoreSetting;
use zetsoft\models\core\CoreTransact;
use zetsoft\models\cpas\CpasCompany;
use zetsoft\models\cpas\CpasLand;
use zetsoft\models\cpas\CpasOffer;
use zetsoft\models\cpas\CpasOfferItem;
use zetsoft\models\cpas\CpasSource;
use zetsoft\models\cpas\CpasStream;
use zetsoft\models\cpas\CpasStreamItem;
use zetsoft\models\cpas\CpasTeaser;
use zetsoft\models\cpas\CpasTracker;
use zetsoft\models\disc\DiscAmount;
use zetsoft\models\doft\DoftDrivers;
use zetsoft\models\doft\DoftShippers;
use zetsoft\models\doft\DoftSignup;
use zetsoft\models\drag\DragApp;
use zetsoft\models\drag\DragConfig;
use zetsoft\models\drag\DragConfigDb;
use zetsoft\models\drag\DragForm;
use zetsoft\models\drag\DragFormDb;
use zetsoft\models\dyna\DynaChess;
use zetsoft\models\dyna\DynaChessItem;
use zetsoft\models\dyna\DynaChessQuery;
use zetsoft\models\dyna\DynaConfig;
use zetsoft\models\dyna\DynaFilter;
use zetsoft\models\dyna\DynaMulti;
use zetsoft\models\dyna\DynaStats;
use zetsoft\models\faqs\Faqs;
use zetsoft\models\faqs\FaqsManual;
use zetsoft\models\faqs\FaqsType;
use zetsoft\models\govs\GovsDegree;
use zetsoft\models\govs\GovsEducation;
use zetsoft\models\govs\GovsPosition;
use zetsoft\models\govs\GovsSpeciality;
use zetsoft\models\lang\Lang;
use zetsoft\models\lang\LangNationality;
use zetsoft\models\maps\MapsNavigate;
use zetsoft\models\menu\Menu;
use zetsoft\models\menu\MenuImage;
use zetsoft\models\news\News;
use zetsoft\models\news\NewsType;
use zetsoft\models\page\PageApi;
use zetsoft\models\page\PageApiType;
use zetsoft\models\page\PageApp;
use zetsoft\models\page\PageBlocks;
use zetsoft\models\page\PageBlocksType;
use zetsoft\models\page\PageTheme;
use zetsoft\models\page\PageThemeType;
use zetsoft\models\page\PageView;
use zetsoft\models\page\PageViewType;
use zetsoft\models\page\PageWidget;
use zetsoft\models\page\PageWidgetType;
use zetsoft\models\pays\PaysCurrency;
use zetsoft\models\pays\PaysIncome;
use zetsoft\models\pays\PaysPayment;
use zetsoft\models\pays\PaysSysClick;
use zetsoft\models\pays\PaysSysOson;
use zetsoft\models\pays\PaysSysPayme;
use zetsoft\models\pays\PaysSysPaysys;
use zetsoft\models\pays\PaysSysUzcard;
use zetsoft\models\pays\PaysWithdraw;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\place\PlaceCountry;
use zetsoft\models\place\PlaceLocation;
use zetsoft\models\place\PlaceRegion;
use zetsoft\models\shop\ShopBanner;
use zetsoft\models\shop\ShopBrand;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\shop\ShopCatalogWare;
use zetsoft\models\shop\ShopCategory;
use zetsoft\models\shop\ShopChannel;
use zetsoft\models\shop\ShopCoupon;
use zetsoft\models\shop\ShopCourier;
use zetsoft\models\shop\ShopDelay;
use zetsoft\models\shop\ShopDelayCause;
use zetsoft\models\shop\ShopDiscount;
use zetsoft\models\shop\ShopElement;
use zetsoft\models\shop\ShopOffer;
use zetsoft\models\shop\ShopOption;
use zetsoft\models\shop\ShopOptionBranch;
use zetsoft\models\shop\ShopOptionType;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\shop\ShopOverview;
use zetsoft\models\shop\ShopPackaging;
use zetsoft\models\shop\ShopPayment;
use zetsoft\models\shop\ShopQuestion;
use zetsoft\models\shop\ShopRejectCause;
use zetsoft\models\shop\ShopReview;
use zetsoft\models\shop\ShopReviewOption;
use zetsoft\models\shop\ShopShipment;
use zetsoft\models\tree\TreeProduct;
use zetsoft\models\ware\Ware;
use zetsoft\models\ware\WareAccept;
use zetsoft\models\ware\WareEnter;
use zetsoft\models\ware\WareEnterItem;
use zetsoft\models\ware\WareExit;
use zetsoft\models\ware\WareExitItem;
use zetsoft\models\ware\WareReturn;
use zetsoft\models\ware\WareSeries;
use zetsoft\models\ware\WareTrans;
use zetsoft\models\ware\WareTransItem;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHPasswordInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputMaskWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\navigat\ZDownloadWidget;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\models\user\UserCompany;
use zetsoft\models\user\UserBlocked;
use zetsoft\models\user\UserContact;
use zetsoft\models\user\UserFriend;
use zetsoft\models\user\UserOauth;
use zetsoft\models\user\UserRbacApi;
use zetsoft\models\user\UserRbacRest;
use zetsoft\models\user\UserRbacView;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\dyna\DynaDynagrid;
use zetsoft\models\dyna\DynaDynagridDtl;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\cpas\CpasPaysHistory;
use zetsoft\models\auto\AutoMotor;
use zetsoft\models\page\PageAction;
use zetsoft\widgets\incores\ZMCheckboxWidget;
use zetsoft\models\user\UserRbacCrud;
use zetsoft\models\shop\ShopProduct;
use zetsoft\models\calls\CallsCdr;
use zetsoft\models\calls\CallsCel;
use zetsoft\models\calls\CallsUserman;



/**
 * Class    User
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $password
 * @property string $role
 * @property string $gender
 * @property string $lang
 * @property string $phone
 * @property int $number
 * @property int $extpass
 * @property string $email
 * @property string $website
 * @property array $photo
 * @property string $status
 * @property string $lastseen
 * @property boolean $blocked
 * @property boolean $apiclient
 * @property int $place_region_id
 * @property int $balance
 * @property boolean $autodial
 * @property int $purchase_count
 * @property string $verify_code
 * @property boolean $verified_email
 * @property boolean $verified_phone
 * @property string $auth_key
 * @property array $oauth
 * @property string $oauth_type
 * @property int $user_company_id
 * @property array $place_adress_ids
 * @property string $currency
 * @property string $referal_link
 * @property array $social
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class User extends ZActiveRecord
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
    public $password;
    public $role;
    public $gender;
    public $lang;
    public $phone;
    public $number;
    public $extpass;
    public $email;
    public $website;
    public $photo;
    public $status;
    public $lastseen;
    public $blocked;
    public $apiclient;
    public $place_region_id;
    public $balance;
    public $autodial;
    public $purchase_count;
    public $verify_code;
    public $verified_email;
    public $verified_phone;
    public $auth_key;
    public $oauth;
    public $oauth_type;
    public $user_company_id;
    public $place_adress_ids;
    public $currency;
    public $referal_link;
    public $social;
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
        'password',
        'role',
        'gender',
        'lang',
        'phone',
        'number',
        'extpass',
        'email',
        'website',
        'photo',
        'status',
        'lastseen',
        'blocked',
        'apiclient',
        'place_region_id',
        'balance',
        'autodial',
        'purchase_count',
        'verify_code',
        'verified_email',
        'verified_phone',
        'auth_key',
        'oauth',
        'oauth_type',
        'user_company_id',
        'place_adress_ids',
        'currency',
        'referal_link',
        'social',
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

    /* @var array $_gender*/
    public $_gender;  
    public const gender = [
        'male' => 'male',
        'female' => 'female',
    ];

    /* @var array $_status*/
    public $_status;  
    public const status = [
        'online' => 'online',
        'process' => 'process',
        'offline' => 'offline',
        'away' => 'away',
        'dnd' => 'dnd',
        'lunch' => 'lunch',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Пользователи';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_gender = [
            'male' => Az::l('Мужчина'),
            'female' => Az::l('Женский'),
        ];
        
        $this->_status = [
            'online' => Az::l('Активен'),
            'process' => Az::l('Обработка'),
            'offline' => Az::l('Отключен'),
            'away' => Az::l('Отошел'),
            'dnd' => Az::l('Не беспокоить'),
            'lunch' => Az::l('Перерыв на обед'),
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
			'password',
			'role',
			'gender',
			'lang',
			'phone',
			'number',
			'extpass',
			'email',
			'website',
			'photo',
			'status',
			'lastseen',
			'blocked',
			'apiclient',
			'place_region_id',
			'balance',
			'autodial',
			'purchase_count',
			'verify_code',
			'verified_email',
			'verified_phone',
			'auth_key',
			'oauth',
			'oauth_type',
			'user_company_id',
			'place_adress_ids',
			'currency',
			'referal_link',
			'social',
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

                        $config->nameValue = function (User $model) {
                if ($model->role === 'agent') {
                    $count = User::find()
                        ->where(['role' => 'agent'])
                        ->count();
                    $name = 'operator' . ((int)$count + 1);
                } else {
                    $gender = null;
                    if (!empty($model->gender)) {
                        Az::$app->forms->wiData->clean();
                        Az::$app->forms->wiData->model = $model;
                        Az::$app->forms->wiData->attribute = 'gender';
                        $gender = Az::$app->forms->wiData->value();
                    }

                    $names = [
                        $model->title,
                        $gender,
                    ];

                    if (!empty($model->email))
                        $names[] = $model->email;

                    if (!empty($model->phone))
                        $names[] = $model->phone;

                    $name = implode(' | ', $names);

                }

                return $name;

            };

                        $config->guidValue = function ($model) {
                return Az::$app->cores->guid->create();
            };

            $config->hasOne = [
                    'PlaceRegion' => [
                        'place_region_id' => 'id',
                    ],
                    'UserCompany' => [
                        'user_company_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'PlaceAdress' => [
                        'place_adress_ids' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'PaysCurrency' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PaysIncome' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PaysPayment' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PaysSysClick' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PaysSysOson' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PaysSysPayme' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PaysSysPaysys' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PaysSysUzcard' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PaysWithdraw' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'UserBlocked' => [
                        'person' => 'id',
                        'blocked' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'UserCompany' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'UserContact' => [
                        'person' => 'id',
                        'friend' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'UserFriend' => [
                        'person' => 'id',
                        'friend' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'UserOauth' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'UserRbacApi' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'UserRbacCrud' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'UserRbacRest' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'UserRbacView' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PlaceAdress' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PlaceCountry' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PlaceLocation' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PlaceRegion' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'Menu' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'MenuImage' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'Lang' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'LangNationality' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DynaChess' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DynaChessItem' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DynaChessQuery' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DynaConfig' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DynaDynagrid' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DynaDynagridDtl' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DynaFilter' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DynaMulti' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DynaStats' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'Faqs' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'FaqsManual' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'FaqsType' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'News' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'NewsType' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'CoreAnalytics' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'CoreHistory' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'CoreInput' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'CoreMigra' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'CoreQueue' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'CoreSession' => [
                        'user_id' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'CoreSetting' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'CoreTransact' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageAction' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageApi' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageApiType' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageApp' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageBlocks' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageBlocksType' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageTheme' => [
                        'author' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageThemeType' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageView' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageViewType' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageWidget' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'PageWidgetType' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'MapsNavigate' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'ChatGroup' => [
                        'owner' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'ChatMail' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'ChatMessage' => [
                        'sender' => 'id',
                        'receiver' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'ChatMessagePublic' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'ChatNotify' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'ChatPrivate' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'ChatSubscribe' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DragApp' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DragConfig' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DragConfigDb' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DragForm' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'DragFormDb' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'GovsDegree' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'GovsEducation' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'GovsPosition' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'GovsSpeciality' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufCompatriot' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufDocument' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufDocumentType' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufFile' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufInvoice' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufInvoiceType' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufManual' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufNeed' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufNeedCompatriot' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufNeedCount' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufReport' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufRequest' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufReview' => [
                        'employer' => 'id',
                        'scholar' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufScholar' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufTable' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'EyufTicket' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->name = 'title';

            $config->title = Az::l('Пользователи');

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


            'password' => function (FormDb $column) {

                $column->title = Az::l('Пароль');
                $column->tooltip = Az::l('Пароль установленный пользователем для входа');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorString,
                        'min' => 6,
                    ],
                ];
                $column->widget = ZHPasswordInputWidget::class;
                $column->showDyna = false;
                $column->showDetail = false;
                $column->showView = false;

                return $column;
            },


            'role' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Роль');
                $column->tooltip = Az::l('Роль пользователя');
                $column->data = RoleData::class;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },


            'gender' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Пол');
                $column->tooltip = Az::l('Пол пользователя');
                $column->data = [
                    'male' => Az::l('Мужчина'),
                    'female' => Az::l('Женский'),
                ];
                $column->widget = ZHRadioButtonGroupWidget::class;
                $column->filterWidget = ZKSelect2Widget::class;

                return $column;
            },


            'lang' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Язык интерфейса');
                $column->tooltip = Az::l('Язык интерфейса отображаемый для пользователя');
                $column->data = LangData::class;
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },


            'phone' => function (FormDb $column) {

                $column->title = Az::l('Телефон');
                $column->tooltip = Az::l('Мобильный номер пользователя');
                $column->rules = [
                    [
                        validatorUnique,
                    ],
                ];
                $column->widget = ZInputMaskWidget::class;
                $column->filterWidget = ZInputMaskWidget::class;

                return $column;
            },


            'number' => function (FormDb $column) {

                $column->title = Az::l('Внутренний номер');
                $column->tooltip = Az::l('Внутренний номер пользователя в системе');
                $column->dbType = dbTypeInteger;
                $column->rules = [

                    [
                        validatorInteger,
                    ],

                    [
                        validatorUnique
                    ],

                ];
                return $column;
            },

            'extpass' => function (FormDb $column) {

                $column->title = Az::l('Пароль для внутренного номера');
                $column->tooltip = Az::l('Пароль для внутренного номера в системе');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                return $column;
            },


            'email' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('E-mail');
                $column->tooltip = Az::l('Электронная почта пользователя');
                $column->rules = [
                    [
                        validatorEmail,
                    ],
                    [
                        validatorUnique,
                    ],
                ];

                return $column;
            },


            'website' => function (FormDb $column) {

                $column->title = Az::l('Адрес сайта');
                $column->tooltip = Az::l('Адрес сайта');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },


            'photo' => function (FormDb $column) {

                $column->title = Az::l('Фото');
                $column->tooltip = Az::l('Фото пользователя');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->valueWidget = ZDownloadWidget::class;
                $column->format = 'raw';
                $column->width = '250px';
                $column->mergeHeader = true;
                $column->edit = false;

                return $column;
            },


            'status' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Статус');
                $column->tooltip = Az::l('Актуальный статус пользователя');
                $column->data = [
                    'online' => Az::l('Активен'),
                    'process' => Az::l('Обработка'),
                    'offline' => Az::l('Отключен'),
                    'away' => Az::l('Отошел'),
                    'dnd' => Az::l('Не беспокоить'),
                    'lunch' => Az::l('Перерыв на обед'),
                ];
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },


            'lastseen' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Последняя активность');
                $column->tooltip = Az::l('Последняя активность пользователя в системе');
                $column->dbType = dbTypeDateTime;
                $column->widget = ZKDateTimePickerWidget::class;

                return $column;
            },


            'blocked' => function (FormDb $column) {

                $column->title = Az::l('Блокирован');
                $column->tooltip = Az::l('Блокирован ли пользователь в системе');
                $column->dbType = dbTypeBoolean;

                $column->changeSave = true;
                $column->changeReload = true;

                $column->widget = ZKSwitchInputWidget::class;
                $column->showForm = true;
                $column->mergeHeader = true;

                return $column;
            },


            'apiclient' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Клиент от API');
                $column->tooltip = Az::l('Клиент от API');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },


            'place_region_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Область');
                $column->tooltip = Az::l('Область пользователя');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'balance' => function (FormDb $column) {

                $column->title = Az::l('Баланс');
                $column->tooltip = Az::l('Баланс пользователя в данный момент');
                $column->dbType = dbTypeInteger;
                $column->history = true;
                $column->readonly = true;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZHInputWidget::class;

                return $column;
            },


            'autodial' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Оператор автодозвона');
                $column->tooltip = Az::l('Оператор автодозвона, если пользователь является оператором');
                $column->autoValue = function (User $model) {
                    if ($model->role === 'agent')
                        return true;
                };

                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },


            'purchase_count' => function (FormDb $column) {

                $column->title = Az::l('Количество покупок');
                $column->tooltip = Az::l('Количество покупок пользователя');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },


            'verify_code' => function (FormDb $column) {

                $column->title = Az::l('Код верификации');
                $column->tooltip = Az::l('Код верификации');
                $column->showForm = false;
                $column->showDyna = false;

                return $column;
            },


            'verified_email' => function (FormDb $column) {

                $column->defaultValue = false;
                $column->title = Az::l('Верифицированный email');
                $column->tooltip = Az::l('Верифицированная электронная почта');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },
            'verified_phone' => function (FormDb $column) {

                $column->defaultValue = false;
                $column->title = Az::l('Верифицированный телефон');
                $column->tooltip = Az::l('Верифицированный телефон номер');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->showForm = false;
                $column->mergeHeader = true;

                return $column;
            },


            'auth_key' => function (FormDb $column) {

                $column->title = Az::l('Ключ авторизации');
                $column->tooltip = Az::l('Ключ авторизации');
                $column->rules = [
                    [
                        validatorUnique,
                    ],
                ];
                $column->showForm = false;
                $column->showDyna = false;

                return $column;
            },


            'oauth' => function (FormDb $column) {

                $column->title = Az::l('OAuth2');
                $column->tooltip = Az::l('OAuth2');
                $column->dbType = dbTypeJsonb;
                $column->showForm = false;
                $column->showDyna = false;
                $column->readonly = true;

                return $column;
            },


            'oauth_type' => function (FormDb $column) {

                $column->title = Az::l('OAuth2 type');
                $column->tooltip = Az::l('OAuth2 type');
                $column->showForm = false;
                $column->showDyna = false;
                $column->readonly = true;

                return $column;
            },


            'user_company_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Организация');
                $column->tooltip = Az::l('Организация в котором работает пользователь');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'place_adress_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Адрес');
                $column->tooltip = Az::l('Адрес пользователя');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },


            'currency' => function (FormDb $column) {

                $column->title = Az::l('Валюта');
                $column->tooltip = Az::l('Валюта в котором отображаются цены для пользователя');
                $column->data = CurrencyData::class;
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },


            'referal_link' => function (FormDb $column) {

                $column->title = Az::l('Реферальная ссылка');
                $column->tooltip = Az::l('Реферальная ссылка');

                return $column;
            },


            'social' => function (FormDb $column) {

                $column->title = Az::l('Социальная форма');
                $column->tooltip = Az::l('Социальная форма пользователя');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
                    'config' => [
                        'formClass' => 'zetsoft\former\cpas\CpasSocialForm',
                    ],
                ];
                $column->valueOptions = [
                    'config' => [
                        'formClass' => 'zetsoft\former\cpas\CpasSocialForm',
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
        'title',
        'tranz',
        'accept',
        'active',
        'password',
        'role',
        'gender',
        'lang',
        'phone',
        'number',
        'extpass',
        'email',
        'website',
        'photo',
        'status',
        'lastseen',
        'blocked',
        'apiclient',
        'place_region_id',
        'balance',
        'autodial',
        'purchase_count',
        'verify_code',
        'verified_email',
        'verified_phone',
        'auth_key',
        'oauth',
        'oauth_type',
        'user_company_id',
        'place_adress_ids',
        'currency',
        'referal_link',
        'social',
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
                                'password',
                            ],
                            [
                                'role',
                            ],
                            [
                                'gender',
                            ],
                            [
                                'lang',
                            ],
                            [
                                'phone',
                            ],
                            [
                                'number',
                            ],
                            [
                                'email',
                            ],
                            [
                                'website',
                            ],
                            [
                                'photo',
                            ],
                            [
                                'status',
                            ],
                            [
                                'lastseen',
                            ],
                            [
                                'blocked',
                            ],
                            [
                                'apiclient',
                            ],
                            [
                                'autodial',
                            ],
                            [
                                'purchase_count',
                            ],
                            [
                                'verify_code',
                            ],
                            [
                                'verified_email',
                            ],
                            [
                                'auth_key',
                            ],
                            [
                                'oauth',
                            ],
                            [
                                'oauth_type',
                            ],
                            [
                                'user_company_id',
                            ],
                            [
                                'place_adress_ids',
                            ],
                            [
                                'currency',
                            ],
                            [
                                'referal_link',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(User $model = null)
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
        $event->beforeSave = function (User $model) {

            global $boot;

            if ($boot->env('passHashed'))
                if (!Az::$app->cores->auth->isHash($model->password))
                    $model->password = Az::$app->cores->auth->hashGet($model->password);
            /*
                if (!$model->isNewRecord && $model->role === 'agent')
                    Az::$app->market->operator->callsStatusTime($model);*/

        };

        $event->afterSave = function (User $model) {

            if (!$this->paramGet($this->paramIsUpdate))
            {
                $title = 'Информация';
                $data = 'Зарегистрирован или аутентифицирован новый юзер: ' . $model->name;

                $this->notifyInfo($title, $data, RoleData::admin);
            }



            return null;
        };
        /*
        $event->beforeDelete = function (User $model) {
        return null;
        };

        $event->afterDelete = function (User $model) {
        return null;
        };

        $event->beforeSave = function (User $model) {
        return null;
        };



        $event->beforeValidate = function (User $model) {
        return null;
        };

        $event->afterValidate = function (User $model) {
        return null;
        };

        $event->afterRefresh = function (User $model) {
        return null;
        };

        $event->afterFind = function (User $model) {
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
     * Function  getPlaceRegion
     * @return bool|\yii\db\ActiveRecord|PlaceRegion|null
     */            
    public function getPlaceRegionOne()
    {
        return $this->getOne(PlaceRegion::class, [
          'id' => 'place_region_id',
      ]);    
    }
    
     /**
     *
     * Function  getPlaceRegion
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPlaceRegion()
    {
        return $this->hasOne(PlaceRegion::class, [
          'id' => 'place_region_id',
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
     * Function  getPlaceAdressesFromPlaceAdressIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|PlaceAdress
     */            
    public function getPlaceAdressesFromPlaceAdressIdsMulti()
    {
        return $this->getMulti(PlaceAdress::class, [
          'id' => 'place_adress_ids',
      ]);    
    }


    #endregion
    
    #region Many


    /**
     *
     * Function  getPaysCurrenciesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysCurrency
     */            
    public function getPaysCurrenciesWithDeletedByMany()
    {
       return $this->getMany(PaysCurrency::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysCurrenciesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysCurrenciesWithDeletedBy()
    {
       return $this->hasMany(PaysCurrency::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysCurrenciesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysCurrency
     */            
    public function getPaysCurrenciesWithCreatedByMany()
    {
       return $this->getMany(PaysCurrency::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysCurrenciesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysCurrenciesWithCreatedBy()
    {
       return $this->hasMany(PaysCurrency::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysCurrenciesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysCurrency
     */            
    public function getPaysCurrenciesWithModifiedByMany()
    {
       return $this->getMany(PaysCurrency::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysCurrenciesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysCurrenciesWithModifiedBy()
    {
       return $this->hasMany(PaysCurrency::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysIncomesWithUserIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysIncome
     */            
    public function getPaysIncomesWithUserIdMany()
    {
       return $this->getMany(PaysIncome::class, [
            'user_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysIncomesWithUserId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysIncomesWithUserId()
    {
       return $this->hasMany(PaysIncome::class, [
            'user_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysIncomesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysIncome
     */            
    public function getPaysIncomesWithDeletedByMany()
    {
       return $this->getMany(PaysIncome::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysIncomesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysIncomesWithDeletedBy()
    {
       return $this->hasMany(PaysIncome::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysIncomesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysIncome
     */            
    public function getPaysIncomesWithCreatedByMany()
    {
       return $this->getMany(PaysIncome::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysIncomesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysIncomesWithCreatedBy()
    {
       return $this->hasMany(PaysIncome::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysIncomesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysIncome
     */            
    public function getPaysIncomesWithModifiedByMany()
    {
       return $this->getMany(PaysIncome::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysIncomesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysIncomesWithModifiedBy()
    {
       return $this->hasMany(PaysIncome::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysPaymentsWithUserIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysPayment
     */            
    public function getPaysPaymentsWithUserIdMany()
    {
       return $this->getMany(PaysPayment::class, [
            'user_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysPaymentsWithUserId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysPaymentsWithUserId()
    {
       return $this->hasMany(PaysPayment::class, [
            'user_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysPaymentsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysPayment
     */            
    public function getPaysPaymentsWithDeletedByMany()
    {
       return $this->getMany(PaysPayment::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysPaymentsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysPaymentsWithDeletedBy()
    {
       return $this->hasMany(PaysPayment::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysPaymentsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysPayment
     */            
    public function getPaysPaymentsWithCreatedByMany()
    {
       return $this->getMany(PaysPayment::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysPaymentsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysPaymentsWithCreatedBy()
    {
       return $this->hasMany(PaysPayment::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysPaymentsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysPayment
     */            
    public function getPaysPaymentsWithModifiedByMany()
    {
       return $this->getMany(PaysPayment::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysPaymentsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysPaymentsWithModifiedBy()
    {
       return $this->hasMany(PaysPayment::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysClicksWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysClick
     */            
    public function getPaysSysClicksWithDeletedByMany()
    {
       return $this->getMany(PaysSysClick::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysClicksWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysClicksWithDeletedBy()
    {
       return $this->hasMany(PaysSysClick::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysClicksWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysClick
     */            
    public function getPaysSysClicksWithCreatedByMany()
    {
       return $this->getMany(PaysSysClick::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysClicksWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysClicksWithCreatedBy()
    {
       return $this->hasMany(PaysSysClick::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysClicksWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysClick
     */            
    public function getPaysSysClicksWithModifiedByMany()
    {
       return $this->getMany(PaysSysClick::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysClicksWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysClicksWithModifiedBy()
    {
       return $this->hasMany(PaysSysClick::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysOsonsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysOson
     */            
    public function getPaysSysOsonsWithDeletedByMany()
    {
       return $this->getMany(PaysSysOson::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysOsonsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysOsonsWithDeletedBy()
    {
       return $this->hasMany(PaysSysOson::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysOsonsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysOson
     */            
    public function getPaysSysOsonsWithCreatedByMany()
    {
       return $this->getMany(PaysSysOson::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysOsonsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysOsonsWithCreatedBy()
    {
       return $this->hasMany(PaysSysOson::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysOsonsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysOson
     */            
    public function getPaysSysOsonsWithModifiedByMany()
    {
       return $this->getMany(PaysSysOson::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysOsonsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysOsonsWithModifiedBy()
    {
       return $this->hasMany(PaysSysOson::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaymesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPayme
     */            
    public function getPaysSysPaymesWithDeletedByMany()
    {
       return $this->getMany(PaysSysPayme::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaymesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaymesWithDeletedBy()
    {
       return $this->hasMany(PaysSysPayme::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaymesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPayme
     */            
    public function getPaysSysPaymesWithCreatedByMany()
    {
       return $this->getMany(PaysSysPayme::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaymesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaymesWithCreatedBy()
    {
       return $this->hasMany(PaysSysPayme::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaymesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPayme
     */            
    public function getPaysSysPaymesWithModifiedByMany()
    {
       return $this->getMany(PaysSysPayme::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaymesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaymesWithModifiedBy()
    {
       return $this->hasMany(PaysSysPayme::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaysysWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPaysys
     */            
    public function getPaysSysPaysysWithDeletedByMany()
    {
       return $this->getMany(PaysSysPaysys::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaysysWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaysysWithDeletedBy()
    {
       return $this->hasMany(PaysSysPaysys::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaysysWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPaysys
     */            
    public function getPaysSysPaysysWithCreatedByMany()
    {
       return $this->getMany(PaysSysPaysys::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaysysWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaysysWithCreatedBy()
    {
       return $this->hasMany(PaysSysPaysys::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaysysWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPaysys
     */            
    public function getPaysSysPaysysWithModifiedByMany()
    {
       return $this->getMany(PaysSysPaysys::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaysysWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaysysWithModifiedBy()
    {
       return $this->hasMany(PaysSysPaysys::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysUzcardsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysUzcard
     */            
    public function getPaysSysUzcardsWithDeletedByMany()
    {
       return $this->getMany(PaysSysUzcard::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysUzcardsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysUzcardsWithDeletedBy()
    {
       return $this->hasMany(PaysSysUzcard::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysUzcardsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysUzcard
     */            
    public function getPaysSysUzcardsWithCreatedByMany()
    {
       return $this->getMany(PaysSysUzcard::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysUzcardsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysUzcardsWithCreatedBy()
    {
       return $this->hasMany(PaysSysUzcard::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysUzcardsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysUzcard
     */            
    public function getPaysSysUzcardsWithModifiedByMany()
    {
       return $this->getMany(PaysSysUzcard::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysUzcardsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysUzcardsWithModifiedBy()
    {
       return $this->hasMany(PaysSysUzcard::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysWithdrawsWithUserIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysWithdraw
     */            
    public function getPaysWithdrawsWithUserIdMany()
    {
       return $this->getMany(PaysWithdraw::class, [
            'user_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysWithdrawsWithUserId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysWithdrawsWithUserId()
    {
       return $this->hasMany(PaysWithdraw::class, [
            'user_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysWithdrawsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysWithdraw
     */            
    public function getPaysWithdrawsWithDeletedByMany()
    {
       return $this->getMany(PaysWithdraw::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysWithdrawsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysWithdrawsWithDeletedBy()
    {
       return $this->hasMany(PaysWithdraw::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysWithdrawsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysWithdraw
     */            
    public function getPaysWithdrawsWithCreatedByMany()
    {
       return $this->getMany(PaysWithdraw::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysWithdrawsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysWithdrawsWithCreatedBy()
    {
       return $this->hasMany(PaysWithdraw::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysWithdrawsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PaysWithdraw
     */            
    public function getPaysWithdrawsWithModifiedByMany()
    {
       return $this->getMany(PaysWithdraw::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysWithdrawsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysWithdrawsWithModifiedBy()
    {
       return $this->hasMany(PaysWithdraw::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUsersWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|User
     */            
    public function getUsersWithDeletedByMany()
    {
       return $this->getMany(User::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUsersWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUsersWithDeletedBy()
    {
       return $this->hasMany(User::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUsersWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|User
     */            
    public function getUsersWithCreatedByMany()
    {
       return $this->getMany(User::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUsersWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUsersWithCreatedBy()
    {
       return $this->hasMany(User::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUsersWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|User
     */            
    public function getUsersWithModifiedByMany()
    {
       return $this->getMany(User::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUsersWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUsersWithModifiedBy()
    {
       return $this->hasMany(User::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserBlockedsWithPersonMany
     * @return  null|\yii\db\ActiveRecord[]|UserBlocked
     */            
    public function getUserBlockedsWithPersonMany()
    {
       return $this->getMany(UserBlocked::class, [
            'person' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserBlockedsWithPerson
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserBlockedsWithPerson()
    {
       return $this->hasMany(UserBlocked::class, [
            'person' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserBlockedsWithBlockedMany
     * @return  null|\yii\db\ActiveRecord[]|UserBlocked
     */            
    public function getUserBlockedsWithBlockedMany()
    {
       return $this->getMany(UserBlocked::class, [
            'blocked' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserBlockedsWithBlocked
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserBlockedsWithBlocked()
    {
       return $this->hasMany(UserBlocked::class, [
            'blocked' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserBlockedsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserBlocked
     */            
    public function getUserBlockedsWithDeletedByMany()
    {
       return $this->getMany(UserBlocked::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserBlockedsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserBlockedsWithDeletedBy()
    {
       return $this->hasMany(UserBlocked::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserBlockedsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserBlocked
     */            
    public function getUserBlockedsWithCreatedByMany()
    {
       return $this->getMany(UserBlocked::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserBlockedsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserBlockedsWithCreatedBy()
    {
       return $this->hasMany(UserBlocked::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserBlockedsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserBlocked
     */            
    public function getUserBlockedsWithModifiedByMany()
    {
       return $this->getMany(UserBlocked::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserBlockedsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserBlockedsWithModifiedBy()
    {
       return $this->hasMany(UserBlocked::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserCompaniesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserCompany
     */            
    public function getUserCompaniesWithDeletedByMany()
    {
       return $this->getMany(UserCompany::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserCompaniesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserCompaniesWithDeletedBy()
    {
       return $this->hasMany(UserCompany::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserCompaniesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserCompany
     */            
    public function getUserCompaniesWithCreatedByMany()
    {
       return $this->getMany(UserCompany::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserCompaniesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserCompaniesWithCreatedBy()
    {
       return $this->hasMany(UserCompany::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserCompaniesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserCompany
     */            
    public function getUserCompaniesWithModifiedByMany()
    {
       return $this->getMany(UserCompany::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserCompaniesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserCompaniesWithModifiedBy()
    {
       return $this->hasMany(UserCompany::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserContactsWithPersonMany
     * @return  null|\yii\db\ActiveRecord[]|UserContact
     */            
    public function getUserContactsWithPersonMany()
    {
       return $this->getMany(UserContact::class, [
            'person' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserContactsWithPerson
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserContactsWithPerson()
    {
       return $this->hasMany(UserContact::class, [
            'person' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserContactsWithFriendMany
     * @return  null|\yii\db\ActiveRecord[]|UserContact
     */            
    public function getUserContactsWithFriendMany()
    {
       return $this->getMany(UserContact::class, [
            'friend' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserContactsWithFriend
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserContactsWithFriend()
    {
       return $this->hasMany(UserContact::class, [
            'friend' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserContactsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserContact
     */            
    public function getUserContactsWithDeletedByMany()
    {
       return $this->getMany(UserContact::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserContactsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserContactsWithDeletedBy()
    {
       return $this->hasMany(UserContact::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserContactsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserContact
     */            
    public function getUserContactsWithCreatedByMany()
    {
       return $this->getMany(UserContact::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserContactsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserContactsWithCreatedBy()
    {
       return $this->hasMany(UserContact::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserContactsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserContact
     */            
    public function getUserContactsWithModifiedByMany()
    {
       return $this->getMany(UserContact::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserContactsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserContactsWithModifiedBy()
    {
       return $this->hasMany(UserContact::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserFriendsWithPersonMany
     * @return  null|\yii\db\ActiveRecord[]|UserFriend
     */            
    public function getUserFriendsWithPersonMany()
    {
       return $this->getMany(UserFriend::class, [
            'person' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserFriendsWithPerson
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserFriendsWithPerson()
    {
       return $this->hasMany(UserFriend::class, [
            'person' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserFriendsWithFriendMany
     * @return  null|\yii\db\ActiveRecord[]|UserFriend
     */            
    public function getUserFriendsWithFriendMany()
    {
       return $this->getMany(UserFriend::class, [
            'friend' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserFriendsWithFriend
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserFriendsWithFriend()
    {
       return $this->hasMany(UserFriend::class, [
            'friend' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserFriendsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserFriend
     */            
    public function getUserFriendsWithDeletedByMany()
    {
       return $this->getMany(UserFriend::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserFriendsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserFriendsWithDeletedBy()
    {
       return $this->hasMany(UserFriend::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserFriendsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserFriend
     */            
    public function getUserFriendsWithCreatedByMany()
    {
       return $this->getMany(UserFriend::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserFriendsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserFriendsWithCreatedBy()
    {
       return $this->hasMany(UserFriend::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserFriendsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserFriend
     */            
    public function getUserFriendsWithModifiedByMany()
    {
       return $this->getMany(UserFriend::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserFriendsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserFriendsWithModifiedBy()
    {
       return $this->hasMany(UserFriend::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserOauthsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserOauth
     */            
    public function getUserOauthsWithDeletedByMany()
    {
       return $this->getMany(UserOauth::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserOauthsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserOauthsWithDeletedBy()
    {
       return $this->hasMany(UserOauth::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserOauthsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserOauth
     */            
    public function getUserOauthsWithCreatedByMany()
    {
       return $this->getMany(UserOauth::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserOauthsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserOauthsWithCreatedBy()
    {
       return $this->hasMany(UserOauth::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserOauthsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserOauth
     */            
    public function getUserOauthsWithModifiedByMany()
    {
       return $this->getMany(UserOauth::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserOauthsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserOauthsWithModifiedBy()
    {
       return $this->hasMany(UserOauth::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacApisWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacApi
     */            
    public function getUserRbacApisWithDeletedByMany()
    {
       return $this->getMany(UserRbacApi::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacApisWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacApisWithDeletedBy()
    {
       return $this->hasMany(UserRbacApi::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacApisWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacApi
     */            
    public function getUserRbacApisWithCreatedByMany()
    {
       return $this->getMany(UserRbacApi::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacApisWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacApisWithCreatedBy()
    {
       return $this->hasMany(UserRbacApi::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacApisWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacApi
     */            
    public function getUserRbacApisWithModifiedByMany()
    {
       return $this->getMany(UserRbacApi::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacApisWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacApisWithModifiedBy()
    {
       return $this->hasMany(UserRbacApi::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacCrudsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacCrud
     */            
    public function getUserRbacCrudsWithDeletedByMany()
    {
       return $this->getMany(UserRbacCrud::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacCrudsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacCrudsWithDeletedBy()
    {
       return $this->hasMany(UserRbacCrud::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacCrudsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacCrud
     */            
    public function getUserRbacCrudsWithCreatedByMany()
    {
       return $this->getMany(UserRbacCrud::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacCrudsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacCrudsWithCreatedBy()
    {
       return $this->hasMany(UserRbacCrud::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacCrudsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacCrud
     */            
    public function getUserRbacCrudsWithModifiedByMany()
    {
       return $this->getMany(UserRbacCrud::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacCrudsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacCrudsWithModifiedBy()
    {
       return $this->hasMany(UserRbacCrud::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacRestsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacRest
     */            
    public function getUserRbacRestsWithDeletedByMany()
    {
       return $this->getMany(UserRbacRest::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacRestsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacRestsWithDeletedBy()
    {
       return $this->hasMany(UserRbacRest::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacRestsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacRest
     */            
    public function getUserRbacRestsWithCreatedByMany()
    {
       return $this->getMany(UserRbacRest::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacRestsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacRestsWithCreatedBy()
    {
       return $this->hasMany(UserRbacRest::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacRestsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacRest
     */            
    public function getUserRbacRestsWithModifiedByMany()
    {
       return $this->getMany(UserRbacRest::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacRestsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacRestsWithModifiedBy()
    {
       return $this->hasMany(UserRbacRest::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacViewsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacView
     */            
    public function getUserRbacViewsWithDeletedByMany()
    {
       return $this->getMany(UserRbacView::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacViewsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacViewsWithDeletedBy()
    {
       return $this->hasMany(UserRbacView::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacViewsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacView
     */            
    public function getUserRbacViewsWithCreatedByMany()
    {
       return $this->getMany(UserRbacView::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacViewsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacViewsWithCreatedBy()
    {
       return $this->hasMany(UserRbacView::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUserRbacViewsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|UserRbacView
     */            
    public function getUserRbacViewsWithModifiedByMany()
    {
       return $this->getMany(UserRbacView::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUserRbacViewsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUserRbacViewsWithModifiedBy()
    {
       return $this->hasMany(UserRbacView::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceAdressesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceAdress
     */            
    public function getPlaceAdressesWithDeletedByMany()
    {
       return $this->getMany(PlaceAdress::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceAdressesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceAdressesWithDeletedBy()
    {
       return $this->hasMany(PlaceAdress::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceAdressesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceAdress
     */            
    public function getPlaceAdressesWithCreatedByMany()
    {
       return $this->getMany(PlaceAdress::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceAdressesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceAdressesWithCreatedBy()
    {
       return $this->hasMany(PlaceAdress::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceAdressesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceAdress
     */            
    public function getPlaceAdressesWithModifiedByMany()
    {
       return $this->getMany(PlaceAdress::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceAdressesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceAdressesWithModifiedBy()
    {
       return $this->hasMany(PlaceAdress::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceCountriesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceCountry
     */            
    public function getPlaceCountriesWithDeletedByMany()
    {
       return $this->getMany(PlaceCountry::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceCountriesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceCountriesWithDeletedBy()
    {
       return $this->hasMany(PlaceCountry::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceCountriesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceCountry
     */            
    public function getPlaceCountriesWithCreatedByMany()
    {
       return $this->getMany(PlaceCountry::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceCountriesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceCountriesWithCreatedBy()
    {
       return $this->hasMany(PlaceCountry::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceCountriesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceCountry
     */            
    public function getPlaceCountriesWithModifiedByMany()
    {
       return $this->getMany(PlaceCountry::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceCountriesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceCountriesWithModifiedBy()
    {
       return $this->hasMany(PlaceCountry::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceLocationsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceLocation
     */            
    public function getPlaceLocationsWithDeletedByMany()
    {
       return $this->getMany(PlaceLocation::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceLocationsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceLocationsWithDeletedBy()
    {
       return $this->hasMany(PlaceLocation::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceLocationsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceLocation
     */            
    public function getPlaceLocationsWithCreatedByMany()
    {
       return $this->getMany(PlaceLocation::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceLocationsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceLocationsWithCreatedBy()
    {
       return $this->hasMany(PlaceLocation::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceLocationsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceLocation
     */            
    public function getPlaceLocationsWithModifiedByMany()
    {
       return $this->getMany(PlaceLocation::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceLocationsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceLocationsWithModifiedBy()
    {
       return $this->hasMany(PlaceLocation::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceRegionsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceRegion
     */            
    public function getPlaceRegionsWithDeletedByMany()
    {
       return $this->getMany(PlaceRegion::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceRegionsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceRegionsWithDeletedBy()
    {
       return $this->hasMany(PlaceRegion::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceRegionsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceRegion
     */            
    public function getPlaceRegionsWithCreatedByMany()
    {
       return $this->getMany(PlaceRegion::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceRegionsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceRegionsWithCreatedBy()
    {
       return $this->hasMany(PlaceRegion::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceRegionsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceRegion
     */            
    public function getPlaceRegionsWithModifiedByMany()
    {
       return $this->getMany(PlaceRegion::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceRegionsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceRegionsWithModifiedBy()
    {
       return $this->hasMany(PlaceRegion::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getMenusWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|Menu
     */            
    public function getMenusWithDeletedByMany()
    {
       return $this->getMany(Menu::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getMenusWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getMenusWithDeletedBy()
    {
       return $this->hasMany(Menu::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getMenusWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|Menu
     */            
    public function getMenusWithCreatedByMany()
    {
       return $this->getMany(Menu::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getMenusWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getMenusWithCreatedBy()
    {
       return $this->hasMany(Menu::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getMenusWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|Menu
     */            
    public function getMenusWithModifiedByMany()
    {
       return $this->getMany(Menu::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getMenusWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getMenusWithModifiedBy()
    {
       return $this->hasMany(Menu::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getMenuImagesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|MenuImage
     */            
    public function getMenuImagesWithDeletedByMany()
    {
       return $this->getMany(MenuImage::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getMenuImagesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getMenuImagesWithDeletedBy()
    {
       return $this->hasMany(MenuImage::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getMenuImagesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|MenuImage
     */            
    public function getMenuImagesWithCreatedByMany()
    {
       return $this->getMany(MenuImage::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getMenuImagesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getMenuImagesWithCreatedBy()
    {
       return $this->hasMany(MenuImage::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getMenuImagesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|MenuImage
     */            
    public function getMenuImagesWithModifiedByMany()
    {
       return $this->getMany(MenuImage::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getMenuImagesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getMenuImagesWithModifiedBy()
    {
       return $this->hasMany(MenuImage::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getLangsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|Lang
     */            
    public function getLangsWithDeletedByMany()
    {
       return $this->getMany(Lang::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getLangsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getLangsWithDeletedBy()
    {
       return $this->hasMany(Lang::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getLangsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|Lang
     */            
    public function getLangsWithCreatedByMany()
    {
       return $this->getMany(Lang::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getLangsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getLangsWithCreatedBy()
    {
       return $this->hasMany(Lang::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getLangsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|Lang
     */            
    public function getLangsWithModifiedByMany()
    {
       return $this->getMany(Lang::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getLangsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getLangsWithModifiedBy()
    {
       return $this->hasMany(Lang::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getLangNationalitiesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|LangNationality
     */            
    public function getLangNationalitiesWithDeletedByMany()
    {
       return $this->getMany(LangNationality::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getLangNationalitiesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getLangNationalitiesWithDeletedBy()
    {
       return $this->hasMany(LangNationality::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getLangNationalitiesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|LangNationality
     */            
    public function getLangNationalitiesWithCreatedByMany()
    {
       return $this->getMany(LangNationality::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getLangNationalitiesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getLangNationalitiesWithCreatedBy()
    {
       return $this->hasMany(LangNationality::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getLangNationalitiesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|LangNationality
     */            
    public function getLangNationalitiesWithModifiedByMany()
    {
       return $this->getMany(LangNationality::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getLangNationalitiesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getLangNationalitiesWithModifiedBy()
    {
       return $this->hasMany(LangNationality::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaChessesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaChess
     */            
    public function getDynaChessesWithDeletedByMany()
    {
       return $this->getMany(DynaChess::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaChessesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaChessesWithDeletedBy()
    {
       return $this->hasMany(DynaChess::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaChessesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaChess
     */            
    public function getDynaChessesWithCreatedByMany()
    {
       return $this->getMany(DynaChess::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaChessesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaChessesWithCreatedBy()
    {
       return $this->hasMany(DynaChess::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaChessesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaChess
     */            
    public function getDynaChessesWithModifiedByMany()
    {
       return $this->getMany(DynaChess::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaChessesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaChessesWithModifiedBy()
    {
       return $this->hasMany(DynaChess::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaChessItemsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaChessItem
     */            
    public function getDynaChessItemsWithDeletedByMany()
    {
       return $this->getMany(DynaChessItem::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaChessItemsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaChessItemsWithDeletedBy()
    {
       return $this->hasMany(DynaChessItem::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaChessItemsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaChessItem
     */            
    public function getDynaChessItemsWithCreatedByMany()
    {
       return $this->getMany(DynaChessItem::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaChessItemsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaChessItemsWithCreatedBy()
    {
       return $this->hasMany(DynaChessItem::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaChessItemsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaChessItem
     */            
    public function getDynaChessItemsWithModifiedByMany()
    {
       return $this->getMany(DynaChessItem::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaChessItemsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaChessItemsWithModifiedBy()
    {
       return $this->hasMany(DynaChessItem::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaChessQueriesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaChessQuery
     */            
    public function getDynaChessQueriesWithDeletedByMany()
    {
       return $this->getMany(DynaChessQuery::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaChessQueriesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaChessQueriesWithDeletedBy()
    {
       return $this->hasMany(DynaChessQuery::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaChessQueriesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaChessQuery
     */            
    public function getDynaChessQueriesWithCreatedByMany()
    {
       return $this->getMany(DynaChessQuery::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaChessQueriesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaChessQueriesWithCreatedBy()
    {
       return $this->hasMany(DynaChessQuery::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaChessQueriesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaChessQuery
     */            
    public function getDynaChessQueriesWithModifiedByMany()
    {
       return $this->getMany(DynaChessQuery::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaChessQueriesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaChessQueriesWithModifiedBy()
    {
       return $this->hasMany(DynaChessQuery::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaConfigsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaConfig
     */            
    public function getDynaConfigsWithDeletedByMany()
    {
       return $this->getMany(DynaConfig::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaConfigsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaConfigsWithDeletedBy()
    {
       return $this->hasMany(DynaConfig::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaConfigsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaConfig
     */            
    public function getDynaConfigsWithCreatedByMany()
    {
       return $this->getMany(DynaConfig::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaConfigsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaConfigsWithCreatedBy()
    {
       return $this->hasMany(DynaConfig::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaConfigsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaConfig
     */            
    public function getDynaConfigsWithModifiedByMany()
    {
       return $this->getMany(DynaConfig::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaConfigsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaConfigsWithModifiedBy()
    {
       return $this->hasMany(DynaConfig::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaDynagridsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaDynagrid
     */            
    public function getDynaDynagridsWithDeletedByMany()
    {
       return $this->getMany(DynaDynagrid::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaDynagridsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaDynagridsWithDeletedBy()
    {
       return $this->hasMany(DynaDynagrid::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaDynagridsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaDynagrid
     */            
    public function getDynaDynagridsWithCreatedByMany()
    {
       return $this->getMany(DynaDynagrid::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaDynagridsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaDynagridsWithCreatedBy()
    {
       return $this->hasMany(DynaDynagrid::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaDynagridsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaDynagrid
     */            
    public function getDynaDynagridsWithModifiedByMany()
    {
       return $this->getMany(DynaDynagrid::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaDynagridsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaDynagridsWithModifiedBy()
    {
       return $this->hasMany(DynaDynagrid::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaDynagridDtlsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaDynagridDtl
     */            
    public function getDynaDynagridDtlsWithDeletedByMany()
    {
       return $this->getMany(DynaDynagridDtl::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaDynagridDtlsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaDynagridDtlsWithDeletedBy()
    {
       return $this->hasMany(DynaDynagridDtl::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaDynagridDtlsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaDynagridDtl
     */            
    public function getDynaDynagridDtlsWithCreatedByMany()
    {
       return $this->getMany(DynaDynagridDtl::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaDynagridDtlsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaDynagridDtlsWithCreatedBy()
    {
       return $this->hasMany(DynaDynagridDtl::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaDynagridDtlsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaDynagridDtl
     */            
    public function getDynaDynagridDtlsWithModifiedByMany()
    {
       return $this->getMany(DynaDynagridDtl::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaDynagridDtlsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaDynagridDtlsWithModifiedBy()
    {
       return $this->hasMany(DynaDynagridDtl::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaFiltersWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaFilter
     */            
    public function getDynaFiltersWithDeletedByMany()
    {
       return $this->getMany(DynaFilter::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaFiltersWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaFiltersWithDeletedBy()
    {
       return $this->hasMany(DynaFilter::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaFiltersWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaFilter
     */            
    public function getDynaFiltersWithCreatedByMany()
    {
       return $this->getMany(DynaFilter::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaFiltersWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaFiltersWithCreatedBy()
    {
       return $this->hasMany(DynaFilter::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaFiltersWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaFilter
     */            
    public function getDynaFiltersWithModifiedByMany()
    {
       return $this->getMany(DynaFilter::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaFiltersWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaFiltersWithModifiedBy()
    {
       return $this->hasMany(DynaFilter::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaMultisWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaMulti
     */            
    public function getDynaMultisWithDeletedByMany()
    {
       return $this->getMany(DynaMulti::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaMultisWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaMultisWithDeletedBy()
    {
       return $this->hasMany(DynaMulti::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaMultisWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaMulti
     */            
    public function getDynaMultisWithCreatedByMany()
    {
       return $this->getMany(DynaMulti::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaMultisWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaMultisWithCreatedBy()
    {
       return $this->hasMany(DynaMulti::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaMultisWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaMulti
     */            
    public function getDynaMultisWithModifiedByMany()
    {
       return $this->getMany(DynaMulti::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaMultisWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaMultisWithModifiedBy()
    {
       return $this->hasMany(DynaMulti::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaStatsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaStats
     */            
    public function getDynaStatsWithDeletedByMany()
    {
       return $this->getMany(DynaStats::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaStatsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaStatsWithDeletedBy()
    {
       return $this->hasMany(DynaStats::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaStatsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaStats
     */            
    public function getDynaStatsWithCreatedByMany()
    {
       return $this->getMany(DynaStats::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaStatsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaStatsWithCreatedBy()
    {
       return $this->hasMany(DynaStats::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDynaStatsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DynaStats
     */            
    public function getDynaStatsWithModifiedByMany()
    {
       return $this->getMany(DynaStats::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDynaStatsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDynaStatsWithModifiedBy()
    {
       return $this->hasMany(DynaStats::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getFaqsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|Faqs
     */            
    public function getFaqsWithDeletedByMany()
    {
       return $this->getMany(Faqs::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getFaqsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getFaqsWithDeletedBy()
    {
       return $this->hasMany(Faqs::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getFaqsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|Faqs
     */            
    public function getFaqsWithCreatedByMany()
    {
       return $this->getMany(Faqs::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getFaqsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getFaqsWithCreatedBy()
    {
       return $this->hasMany(Faqs::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getFaqsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|Faqs
     */            
    public function getFaqsWithModifiedByMany()
    {
       return $this->getMany(Faqs::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getFaqsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getFaqsWithModifiedBy()
    {
       return $this->hasMany(Faqs::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getFaqsManualsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|FaqsManual
     */            
    public function getFaqsManualsWithDeletedByMany()
    {
       return $this->getMany(FaqsManual::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getFaqsManualsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getFaqsManualsWithDeletedBy()
    {
       return $this->hasMany(FaqsManual::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getFaqsManualsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|FaqsManual
     */            
    public function getFaqsManualsWithCreatedByMany()
    {
       return $this->getMany(FaqsManual::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getFaqsManualsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getFaqsManualsWithCreatedBy()
    {
       return $this->hasMany(FaqsManual::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getFaqsManualsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|FaqsManual
     */            
    public function getFaqsManualsWithModifiedByMany()
    {
       return $this->getMany(FaqsManual::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getFaqsManualsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getFaqsManualsWithModifiedBy()
    {
       return $this->hasMany(FaqsManual::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getFaqsTypesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|FaqsType
     */            
    public function getFaqsTypesWithDeletedByMany()
    {
       return $this->getMany(FaqsType::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getFaqsTypesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getFaqsTypesWithDeletedBy()
    {
       return $this->hasMany(FaqsType::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getFaqsTypesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|FaqsType
     */            
    public function getFaqsTypesWithCreatedByMany()
    {
       return $this->getMany(FaqsType::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getFaqsTypesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getFaqsTypesWithCreatedBy()
    {
       return $this->hasMany(FaqsType::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getFaqsTypesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|FaqsType
     */            
    public function getFaqsTypesWithModifiedByMany()
    {
       return $this->getMany(FaqsType::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getFaqsTypesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getFaqsTypesWithModifiedBy()
    {
       return $this->hasMany(FaqsType::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getNewsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|News
     */            
    public function getNewsWithDeletedByMany()
    {
       return $this->getMany(News::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getNewsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getNewsWithDeletedBy()
    {
       return $this->hasMany(News::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getNewsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|News
     */            
    public function getNewsWithCreatedByMany()
    {
       return $this->getMany(News::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getNewsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getNewsWithCreatedBy()
    {
       return $this->hasMany(News::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getNewsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|News
     */            
    public function getNewsWithModifiedByMany()
    {
       return $this->getMany(News::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getNewsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getNewsWithModifiedBy()
    {
       return $this->hasMany(News::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getNewsTypesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|NewsType
     */            
    public function getNewsTypesWithDeletedByMany()
    {
       return $this->getMany(NewsType::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getNewsTypesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getNewsTypesWithDeletedBy()
    {
       return $this->hasMany(NewsType::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getNewsTypesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|NewsType
     */            
    public function getNewsTypesWithCreatedByMany()
    {
       return $this->getMany(NewsType::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getNewsTypesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getNewsTypesWithCreatedBy()
    {
       return $this->hasMany(NewsType::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getNewsTypesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|NewsType
     */            
    public function getNewsTypesWithModifiedByMany()
    {
       return $this->getMany(NewsType::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getNewsTypesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getNewsTypesWithModifiedBy()
    {
       return $this->hasMany(NewsType::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreAnalyticsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreAnalytics
     */            
    public function getCoreAnalyticsWithDeletedByMany()
    {
       return $this->getMany(CoreAnalytics::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreAnalyticsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreAnalyticsWithDeletedBy()
    {
       return $this->hasMany(CoreAnalytics::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreAnalyticsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreAnalytics
     */            
    public function getCoreAnalyticsWithCreatedByMany()
    {
       return $this->getMany(CoreAnalytics::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreAnalyticsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreAnalyticsWithCreatedBy()
    {
       return $this->hasMany(CoreAnalytics::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreAnalyticsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreAnalytics
     */            
    public function getCoreAnalyticsWithModifiedByMany()
    {
       return $this->getMany(CoreAnalytics::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreAnalyticsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreAnalyticsWithModifiedBy()
    {
       return $this->hasMany(CoreAnalytics::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreHistoriesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreHistory
     */            
    public function getCoreHistoriesWithDeletedByMany()
    {
       return $this->getMany(CoreHistory::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreHistoriesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreHistoriesWithDeletedBy()
    {
       return $this->hasMany(CoreHistory::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreHistoriesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreHistory
     */            
    public function getCoreHistoriesWithCreatedByMany()
    {
       return $this->getMany(CoreHistory::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreHistoriesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreHistoriesWithCreatedBy()
    {
       return $this->hasMany(CoreHistory::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreHistoriesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreHistory
     */            
    public function getCoreHistoriesWithModifiedByMany()
    {
       return $this->getMany(CoreHistory::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreHistoriesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreHistoriesWithModifiedBy()
    {
       return $this->hasMany(CoreHistory::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreInputsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreInput
     */            
    public function getCoreInputsWithDeletedByMany()
    {
       return $this->getMany(CoreInput::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreInputsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreInputsWithDeletedBy()
    {
       return $this->hasMany(CoreInput::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreInputsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreInput
     */            
    public function getCoreInputsWithCreatedByMany()
    {
       return $this->getMany(CoreInput::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreInputsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreInputsWithCreatedBy()
    {
       return $this->hasMany(CoreInput::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreInputsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreInput
     */            
    public function getCoreInputsWithModifiedByMany()
    {
       return $this->getMany(CoreInput::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreInputsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreInputsWithModifiedBy()
    {
       return $this->hasMany(CoreInput::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreMigrasWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreMigra
     */            
    public function getCoreMigrasWithDeletedByMany()
    {
       return $this->getMany(CoreMigra::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreMigrasWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreMigrasWithDeletedBy()
    {
       return $this->hasMany(CoreMigra::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreMigrasWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreMigra
     */            
    public function getCoreMigrasWithCreatedByMany()
    {
       return $this->getMany(CoreMigra::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreMigrasWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreMigrasWithCreatedBy()
    {
       return $this->hasMany(CoreMigra::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreMigrasWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreMigra
     */            
    public function getCoreMigrasWithModifiedByMany()
    {
       return $this->getMany(CoreMigra::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreMigrasWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreMigrasWithModifiedBy()
    {
       return $this->hasMany(CoreMigra::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreQueuesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreQueue
     */            
    public function getCoreQueuesWithDeletedByMany()
    {
       return $this->getMany(CoreQueue::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreQueuesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreQueuesWithDeletedBy()
    {
       return $this->hasMany(CoreQueue::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreQueuesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreQueue
     */            
    public function getCoreQueuesWithCreatedByMany()
    {
       return $this->getMany(CoreQueue::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreQueuesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreQueuesWithCreatedBy()
    {
       return $this->hasMany(CoreQueue::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreQueuesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreQueue
     */            
    public function getCoreQueuesWithModifiedByMany()
    {
       return $this->getMany(CoreQueue::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreQueuesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreQueuesWithModifiedBy()
    {
       return $this->hasMany(CoreQueue::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreSessionsWithUserIdMany
     * @return  null|\yii\db\ActiveRecord[]|CoreSession
     */            
    public function getCoreSessionsWithUserIdMany()
    {
       return $this->getMany(CoreSession::class, [
            'user_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreSessionsWithUserId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreSessionsWithUserId()
    {
       return $this->hasMany(CoreSession::class, [
            'user_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreSessionsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreSession
     */            
    public function getCoreSessionsWithCreatedByMany()
    {
       return $this->getMany(CoreSession::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreSessionsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreSessionsWithCreatedBy()
    {
       return $this->hasMany(CoreSession::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreSessionsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreSession
     */            
    public function getCoreSessionsWithModifiedByMany()
    {
       return $this->getMany(CoreSession::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreSessionsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreSessionsWithModifiedBy()
    {
       return $this->hasMany(CoreSession::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreSettingsWithUserIdMany
     * @return  null|\yii\db\ActiveRecord[]|CoreSetting
     */            
    public function getCoreSettingsWithUserIdMany()
    {
       return $this->getMany(CoreSetting::class, [
            'user_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreSettingsWithUserId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreSettingsWithUserId()
    {
       return $this->hasMany(CoreSetting::class, [
            'user_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreSettingsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreSetting
     */            
    public function getCoreSettingsWithDeletedByMany()
    {
       return $this->getMany(CoreSetting::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreSettingsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreSettingsWithDeletedBy()
    {
       return $this->hasMany(CoreSetting::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreSettingsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreSetting
     */            
    public function getCoreSettingsWithCreatedByMany()
    {
       return $this->getMany(CoreSetting::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreSettingsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreSettingsWithCreatedBy()
    {
       return $this->hasMany(CoreSetting::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreSettingsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreSetting
     */            
    public function getCoreSettingsWithModifiedByMany()
    {
       return $this->getMany(CoreSetting::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreSettingsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreSettingsWithModifiedBy()
    {
       return $this->hasMany(CoreSetting::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreTransactsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreTransact
     */            
    public function getCoreTransactsWithDeletedByMany()
    {
       return $this->getMany(CoreTransact::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreTransactsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreTransactsWithDeletedBy()
    {
       return $this->hasMany(CoreTransact::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreTransactsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreTransact
     */            
    public function getCoreTransactsWithCreatedByMany()
    {
       return $this->getMany(CoreTransact::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreTransactsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreTransactsWithCreatedBy()
    {
       return $this->hasMany(CoreTransact::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCoreTransactsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|CoreTransact
     */            
    public function getCoreTransactsWithModifiedByMany()
    {
       return $this->getMany(CoreTransact::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCoreTransactsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCoreTransactsWithModifiedBy()
    {
       return $this->hasMany(CoreTransact::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageActionsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageAction
     */            
    public function getPageActionsWithDeletedByMany()
    {
       return $this->getMany(PageAction::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageActionsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageActionsWithDeletedBy()
    {
       return $this->hasMany(PageAction::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageActionsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageAction
     */            
    public function getPageActionsWithCreatedByMany()
    {
       return $this->getMany(PageAction::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageActionsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageActionsWithCreatedBy()
    {
       return $this->hasMany(PageAction::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageActionsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageAction
     */            
    public function getPageActionsWithModifiedByMany()
    {
       return $this->getMany(PageAction::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageActionsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageActionsWithModifiedBy()
    {
       return $this->hasMany(PageAction::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageApisWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageApi
     */            
    public function getPageApisWithDeletedByMany()
    {
       return $this->getMany(PageApi::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageApisWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageApisWithDeletedBy()
    {
       return $this->hasMany(PageApi::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageApisWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageApi
     */            
    public function getPageApisWithCreatedByMany()
    {
       return $this->getMany(PageApi::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageApisWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageApisWithCreatedBy()
    {
       return $this->hasMany(PageApi::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageApisWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageApi
     */            
    public function getPageApisWithModifiedByMany()
    {
       return $this->getMany(PageApi::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageApisWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageApisWithModifiedBy()
    {
       return $this->hasMany(PageApi::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageApiTypesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageApiType
     */            
    public function getPageApiTypesWithDeletedByMany()
    {
       return $this->getMany(PageApiType::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageApiTypesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageApiTypesWithDeletedBy()
    {
       return $this->hasMany(PageApiType::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageApiTypesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageApiType
     */            
    public function getPageApiTypesWithCreatedByMany()
    {
       return $this->getMany(PageApiType::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageApiTypesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageApiTypesWithCreatedBy()
    {
       return $this->hasMany(PageApiType::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageApiTypesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageApiType
     */            
    public function getPageApiTypesWithModifiedByMany()
    {
       return $this->getMany(PageApiType::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageApiTypesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageApiTypesWithModifiedBy()
    {
       return $this->hasMany(PageApiType::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageAppsWithUserIdMany
     * @return  null|\yii\db\ActiveRecord[]|PageApp
     */            
    public function getPageAppsWithUserIdMany()
    {
       return $this->getMany(PageApp::class, [
            'user_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageAppsWithUserId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageAppsWithUserId()
    {
       return $this->hasMany(PageApp::class, [
            'user_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageAppsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageApp
     */            
    public function getPageAppsWithDeletedByMany()
    {
       return $this->getMany(PageApp::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageAppsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageAppsWithDeletedBy()
    {
       return $this->hasMany(PageApp::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageAppsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageApp
     */            
    public function getPageAppsWithCreatedByMany()
    {
       return $this->getMany(PageApp::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageAppsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageAppsWithCreatedBy()
    {
       return $this->hasMany(PageApp::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageAppsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageApp
     */            
    public function getPageAppsWithModifiedByMany()
    {
       return $this->getMany(PageApp::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageAppsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageAppsWithModifiedBy()
    {
       return $this->hasMany(PageApp::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageBlocksWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageBlocks
     */            
    public function getPageBlocksWithDeletedByMany()
    {
       return $this->getMany(PageBlocks::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageBlocksWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageBlocksWithDeletedBy()
    {
       return $this->hasMany(PageBlocks::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageBlocksWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageBlocks
     */            
    public function getPageBlocksWithCreatedByMany()
    {
       return $this->getMany(PageBlocks::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageBlocksWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageBlocksWithCreatedBy()
    {
       return $this->hasMany(PageBlocks::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageBlocksWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageBlocks
     */            
    public function getPageBlocksWithModifiedByMany()
    {
       return $this->getMany(PageBlocks::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageBlocksWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageBlocksWithModifiedBy()
    {
       return $this->hasMany(PageBlocks::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageBlocksTypesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageBlocksType
     */            
    public function getPageBlocksTypesWithDeletedByMany()
    {
       return $this->getMany(PageBlocksType::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageBlocksTypesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageBlocksTypesWithDeletedBy()
    {
       return $this->hasMany(PageBlocksType::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageBlocksTypesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageBlocksType
     */            
    public function getPageBlocksTypesWithCreatedByMany()
    {
       return $this->getMany(PageBlocksType::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageBlocksTypesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageBlocksTypesWithCreatedBy()
    {
       return $this->hasMany(PageBlocksType::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageBlocksTypesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageBlocksType
     */            
    public function getPageBlocksTypesWithModifiedByMany()
    {
       return $this->getMany(PageBlocksType::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageBlocksTypesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageBlocksTypesWithModifiedBy()
    {
       return $this->hasMany(PageBlocksType::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageThemesWithAuthorMany
     * @return  null|\yii\db\ActiveRecord[]|PageTheme
     */            
    public function getPageThemesWithAuthorMany()
    {
       return $this->getMany(PageTheme::class, [
            'author' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageThemesWithAuthor
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageThemesWithAuthor()
    {
       return $this->hasMany(PageTheme::class, [
            'author' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageThemesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageTheme
     */            
    public function getPageThemesWithDeletedByMany()
    {
       return $this->getMany(PageTheme::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageThemesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageThemesWithDeletedBy()
    {
       return $this->hasMany(PageTheme::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageThemesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageTheme
     */            
    public function getPageThemesWithCreatedByMany()
    {
       return $this->getMany(PageTheme::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageThemesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageThemesWithCreatedBy()
    {
       return $this->hasMany(PageTheme::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageThemesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageTheme
     */            
    public function getPageThemesWithModifiedByMany()
    {
       return $this->getMany(PageTheme::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageThemesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageThemesWithModifiedBy()
    {
       return $this->hasMany(PageTheme::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageThemeTypesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageThemeType
     */            
    public function getPageThemeTypesWithDeletedByMany()
    {
       return $this->getMany(PageThemeType::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageThemeTypesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageThemeTypesWithDeletedBy()
    {
       return $this->hasMany(PageThemeType::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageThemeTypesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageThemeType
     */            
    public function getPageThemeTypesWithCreatedByMany()
    {
       return $this->getMany(PageThemeType::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageThemeTypesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageThemeTypesWithCreatedBy()
    {
       return $this->hasMany(PageThemeType::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageThemeTypesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageThemeType
     */            
    public function getPageThemeTypesWithModifiedByMany()
    {
       return $this->getMany(PageThemeType::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageThemeTypesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageThemeTypesWithModifiedBy()
    {
       return $this->hasMany(PageThemeType::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageViewsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageView
     */            
    public function getPageViewsWithDeletedByMany()
    {
       return $this->getMany(PageView::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageViewsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageViewsWithDeletedBy()
    {
       return $this->hasMany(PageView::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageViewsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageView
     */            
    public function getPageViewsWithCreatedByMany()
    {
       return $this->getMany(PageView::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageViewsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageViewsWithCreatedBy()
    {
       return $this->hasMany(PageView::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageViewsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageView
     */            
    public function getPageViewsWithModifiedByMany()
    {
       return $this->getMany(PageView::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageViewsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageViewsWithModifiedBy()
    {
       return $this->hasMany(PageView::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageViewTypesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageViewType
     */            
    public function getPageViewTypesWithDeletedByMany()
    {
       return $this->getMany(PageViewType::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageViewTypesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageViewTypesWithDeletedBy()
    {
       return $this->hasMany(PageViewType::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageViewTypesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageViewType
     */            
    public function getPageViewTypesWithCreatedByMany()
    {
       return $this->getMany(PageViewType::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageViewTypesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageViewTypesWithCreatedBy()
    {
       return $this->hasMany(PageViewType::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageViewTypesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageViewType
     */            
    public function getPageViewTypesWithModifiedByMany()
    {
       return $this->getMany(PageViewType::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageViewTypesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageViewTypesWithModifiedBy()
    {
       return $this->hasMany(PageViewType::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageWidgetsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageWidget
     */            
    public function getPageWidgetsWithDeletedByMany()
    {
       return $this->getMany(PageWidget::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageWidgetsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageWidgetsWithDeletedBy()
    {
       return $this->hasMany(PageWidget::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageWidgetsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageWidget
     */            
    public function getPageWidgetsWithCreatedByMany()
    {
       return $this->getMany(PageWidget::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageWidgetsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageWidgetsWithCreatedBy()
    {
       return $this->hasMany(PageWidget::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageWidgetsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageWidget
     */            
    public function getPageWidgetsWithModifiedByMany()
    {
       return $this->getMany(PageWidget::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageWidgetsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageWidgetsWithModifiedBy()
    {
       return $this->hasMany(PageWidget::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageWidgetTypesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageWidgetType
     */            
    public function getPageWidgetTypesWithDeletedByMany()
    {
       return $this->getMany(PageWidgetType::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageWidgetTypesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageWidgetTypesWithDeletedBy()
    {
       return $this->hasMany(PageWidgetType::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageWidgetTypesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageWidgetType
     */            
    public function getPageWidgetTypesWithCreatedByMany()
    {
       return $this->getMany(PageWidgetType::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageWidgetTypesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageWidgetTypesWithCreatedBy()
    {
       return $this->hasMany(PageWidgetType::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPageWidgetTypesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|PageWidgetType
     */            
    public function getPageWidgetTypesWithModifiedByMany()
    {
       return $this->getMany(PageWidgetType::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPageWidgetTypesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPageWidgetTypesWithModifiedBy()
    {
       return $this->hasMany(PageWidgetType::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getMapsNavigatesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|MapsNavigate
     */            
    public function getMapsNavigatesWithDeletedByMany()
    {
       return $this->getMany(MapsNavigate::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getMapsNavigatesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getMapsNavigatesWithDeletedBy()
    {
       return $this->hasMany(MapsNavigate::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getMapsNavigatesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|MapsNavigate
     */            
    public function getMapsNavigatesWithCreatedByMany()
    {
       return $this->getMany(MapsNavigate::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getMapsNavigatesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getMapsNavigatesWithCreatedBy()
    {
       return $this->hasMany(MapsNavigate::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getMapsNavigatesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|MapsNavigate
     */            
    public function getMapsNavigatesWithModifiedByMany()
    {
       return $this->getMany(MapsNavigate::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getMapsNavigatesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getMapsNavigatesWithModifiedBy()
    {
       return $this->hasMany(MapsNavigate::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatGroupsWithOwnerMany
     * @return  null|\yii\db\ActiveRecord[]|ChatGroup
     */            
    public function getChatGroupsWithOwnerMany()
    {
       return $this->getMany(ChatGroup::class, [
            'owner' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatGroupsWithOwner
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatGroupsWithOwner()
    {
       return $this->hasMany(ChatGroup::class, [
            'owner' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatGroupsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatGroup
     */            
    public function getChatGroupsWithDeletedByMany()
    {
       return $this->getMany(ChatGroup::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatGroupsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatGroupsWithDeletedBy()
    {
       return $this->hasMany(ChatGroup::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatGroupsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatGroup
     */            
    public function getChatGroupsWithCreatedByMany()
    {
       return $this->getMany(ChatGroup::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatGroupsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatGroupsWithCreatedBy()
    {
       return $this->hasMany(ChatGroup::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatGroupsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatGroup
     */            
    public function getChatGroupsWithModifiedByMany()
    {
       return $this->getMany(ChatGroup::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatGroupsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatGroupsWithModifiedBy()
    {
       return $this->hasMany(ChatGroup::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMailsWithUserIdMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMail
     */            
    public function getChatMailsWithUserIdMany()
    {
       return $this->getMany(ChatMail::class, [
            'user_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMailsWithUserId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMailsWithUserId()
    {
       return $this->hasMany(ChatMail::class, [
            'user_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMailsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMail
     */            
    public function getChatMailsWithDeletedByMany()
    {
       return $this->getMany(ChatMail::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMailsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMailsWithDeletedBy()
    {
       return $this->hasMany(ChatMail::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMailsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMail
     */            
    public function getChatMailsWithCreatedByMany()
    {
       return $this->getMany(ChatMail::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMailsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMailsWithCreatedBy()
    {
       return $this->hasMany(ChatMail::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMailsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMail
     */            
    public function getChatMailsWithModifiedByMany()
    {
       return $this->getMany(ChatMail::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMailsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMailsWithModifiedBy()
    {
       return $this->hasMany(ChatMail::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMessagesWithSenderMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMessage
     */            
    public function getChatMessagesWithSenderMany()
    {
       return $this->getMany(ChatMessage::class, [
            'sender' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMessagesWithSender
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMessagesWithSender()
    {
       return $this->hasMany(ChatMessage::class, [
            'sender' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMessagesWithReceiverMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMessage
     */            
    public function getChatMessagesWithReceiverMany()
    {
       return $this->getMany(ChatMessage::class, [
            'receiver' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMessagesWithReceiver
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMessagesWithReceiver()
    {
       return $this->hasMany(ChatMessage::class, [
            'receiver' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMessagesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMessage
     */            
    public function getChatMessagesWithDeletedByMany()
    {
       return $this->getMany(ChatMessage::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMessagesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMessagesWithDeletedBy()
    {
       return $this->hasMany(ChatMessage::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMessagesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMessage
     */            
    public function getChatMessagesWithCreatedByMany()
    {
       return $this->getMany(ChatMessage::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMessagesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMessagesWithCreatedBy()
    {
       return $this->hasMany(ChatMessage::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMessagesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMessage
     */            
    public function getChatMessagesWithModifiedByMany()
    {
       return $this->getMany(ChatMessage::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMessagesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMessagesWithModifiedBy()
    {
       return $this->hasMany(ChatMessage::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMessagePublicsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMessagePublic
     */            
    public function getChatMessagePublicsWithDeletedByMany()
    {
       return $this->getMany(ChatMessagePublic::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMessagePublicsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMessagePublicsWithDeletedBy()
    {
       return $this->hasMany(ChatMessagePublic::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMessagePublicsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMessagePublic
     */            
    public function getChatMessagePublicsWithCreatedByMany()
    {
       return $this->getMany(ChatMessagePublic::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMessagePublicsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMessagePublicsWithCreatedBy()
    {
       return $this->hasMany(ChatMessagePublic::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatMessagePublicsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatMessagePublic
     */            
    public function getChatMessagePublicsWithModifiedByMany()
    {
       return $this->getMany(ChatMessagePublic::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatMessagePublicsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatMessagePublicsWithModifiedBy()
    {
       return $this->hasMany(ChatMessagePublic::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatNotifiesWithUserIdMany
     * @return  null|\yii\db\ActiveRecord[]|ChatNotify
     */            
    public function getChatNotifiesWithUserIdMany()
    {
       return $this->getMany(ChatNotify::class, [
            'user_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatNotifiesWithUserId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatNotifiesWithUserId()
    {
       return $this->hasMany(ChatNotify::class, [
            'user_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatNotifiesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatNotify
     */            
    public function getChatNotifiesWithDeletedByMany()
    {
       return $this->getMany(ChatNotify::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatNotifiesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatNotifiesWithDeletedBy()
    {
       return $this->hasMany(ChatNotify::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatNotifiesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatNotify
     */            
    public function getChatNotifiesWithCreatedByMany()
    {
       return $this->getMany(ChatNotify::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatNotifiesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatNotifiesWithCreatedBy()
    {
       return $this->hasMany(ChatNotify::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatNotifiesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatNotify
     */            
    public function getChatNotifiesWithModifiedByMany()
    {
       return $this->getMany(ChatNotify::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatNotifiesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatNotifiesWithModifiedBy()
    {
       return $this->hasMany(ChatNotify::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatPrivatesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatPrivate
     */            
    public function getChatPrivatesWithDeletedByMany()
    {
       return $this->getMany(ChatPrivate::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatPrivatesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatPrivatesWithDeletedBy()
    {
       return $this->hasMany(ChatPrivate::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatPrivatesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatPrivate
     */            
    public function getChatPrivatesWithCreatedByMany()
    {
       return $this->getMany(ChatPrivate::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatPrivatesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatPrivatesWithCreatedBy()
    {
       return $this->hasMany(ChatPrivate::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatPrivatesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatPrivate
     */            
    public function getChatPrivatesWithModifiedByMany()
    {
       return $this->getMany(ChatPrivate::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatPrivatesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatPrivatesWithModifiedBy()
    {
       return $this->hasMany(ChatPrivate::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatSubscribesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatSubscribe
     */            
    public function getChatSubscribesWithDeletedByMany()
    {
       return $this->getMany(ChatSubscribe::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatSubscribesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatSubscribesWithDeletedBy()
    {
       return $this->hasMany(ChatSubscribe::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatSubscribesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatSubscribe
     */            
    public function getChatSubscribesWithCreatedByMany()
    {
       return $this->getMany(ChatSubscribe::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatSubscribesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatSubscribesWithCreatedBy()
    {
       return $this->hasMany(ChatSubscribe::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getChatSubscribesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|ChatSubscribe
     */            
    public function getChatSubscribesWithModifiedByMany()
    {
       return $this->getMany(ChatSubscribe::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getChatSubscribesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getChatSubscribesWithModifiedBy()
    {
       return $this->hasMany(ChatSubscribe::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragAppsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragApp
     */            
    public function getDragAppsWithDeletedByMany()
    {
       return $this->getMany(DragApp::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragAppsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragAppsWithDeletedBy()
    {
       return $this->hasMany(DragApp::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragAppsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragApp
     */            
    public function getDragAppsWithCreatedByMany()
    {
       return $this->getMany(DragApp::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragAppsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragAppsWithCreatedBy()
    {
       return $this->hasMany(DragApp::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragAppsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragApp
     */            
    public function getDragAppsWithModifiedByMany()
    {
       return $this->getMany(DragApp::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragAppsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragAppsWithModifiedBy()
    {
       return $this->hasMany(DragApp::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragConfigsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragConfig
     */            
    public function getDragConfigsWithDeletedByMany()
    {
       return $this->getMany(DragConfig::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragConfigsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragConfigsWithDeletedBy()
    {
       return $this->hasMany(DragConfig::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragConfigsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragConfig
     */            
    public function getDragConfigsWithCreatedByMany()
    {
       return $this->getMany(DragConfig::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragConfigsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragConfigsWithCreatedBy()
    {
       return $this->hasMany(DragConfig::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragConfigsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragConfig
     */            
    public function getDragConfigsWithModifiedByMany()
    {
       return $this->getMany(DragConfig::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragConfigsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragConfigsWithModifiedBy()
    {
       return $this->hasMany(DragConfig::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragConfigDbsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragConfigDb
     */            
    public function getDragConfigDbsWithDeletedByMany()
    {
       return $this->getMany(DragConfigDb::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragConfigDbsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragConfigDbsWithDeletedBy()
    {
       return $this->hasMany(DragConfigDb::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragConfigDbsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragConfigDb
     */            
    public function getDragConfigDbsWithCreatedByMany()
    {
       return $this->getMany(DragConfigDb::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragConfigDbsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragConfigDbsWithCreatedBy()
    {
       return $this->hasMany(DragConfigDb::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragConfigDbsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragConfigDb
     */            
    public function getDragConfigDbsWithModifiedByMany()
    {
       return $this->getMany(DragConfigDb::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragConfigDbsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragConfigDbsWithModifiedBy()
    {
       return $this->hasMany(DragConfigDb::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragFormsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragForm
     */            
    public function getDragFormsWithDeletedByMany()
    {
       return $this->getMany(DragForm::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragFormsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragFormsWithDeletedBy()
    {
       return $this->hasMany(DragForm::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragFormsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragForm
     */            
    public function getDragFormsWithCreatedByMany()
    {
       return $this->getMany(DragForm::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragFormsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragFormsWithCreatedBy()
    {
       return $this->hasMany(DragForm::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragFormsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragForm
     */            
    public function getDragFormsWithModifiedByMany()
    {
       return $this->getMany(DragForm::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragFormsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragFormsWithModifiedBy()
    {
       return $this->hasMany(DragForm::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragFormDbsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragFormDb
     */            
    public function getDragFormDbsWithDeletedByMany()
    {
       return $this->getMany(DragFormDb::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragFormDbsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragFormDbsWithDeletedBy()
    {
       return $this->hasMany(DragFormDb::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragFormDbsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragFormDb
     */            
    public function getDragFormDbsWithCreatedByMany()
    {
       return $this->getMany(DragFormDb::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragFormDbsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragFormDbsWithCreatedBy()
    {
       return $this->hasMany(DragFormDb::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getDragFormDbsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|DragFormDb
     */            
    public function getDragFormDbsWithModifiedByMany()
    {
       return $this->getMany(DragFormDb::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getDragFormDbsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getDragFormDbsWithModifiedBy()
    {
       return $this->hasMany(DragFormDb::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsDegreesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsDegree
     */            
    public function getGovsDegreesWithDeletedByMany()
    {
       return $this->getMany(GovsDegree::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsDegreesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsDegreesWithDeletedBy()
    {
       return $this->hasMany(GovsDegree::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsDegreesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsDegree
     */            
    public function getGovsDegreesWithCreatedByMany()
    {
       return $this->getMany(GovsDegree::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsDegreesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsDegreesWithCreatedBy()
    {
       return $this->hasMany(GovsDegree::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsDegreesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsDegree
     */            
    public function getGovsDegreesWithModifiedByMany()
    {
       return $this->getMany(GovsDegree::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsDegreesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsDegreesWithModifiedBy()
    {
       return $this->hasMany(GovsDegree::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsEducationsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsEducation
     */            
    public function getGovsEducationsWithDeletedByMany()
    {
       return $this->getMany(GovsEducation::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsEducationsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsEducationsWithDeletedBy()
    {
       return $this->hasMany(GovsEducation::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsEducationsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsEducation
     */            
    public function getGovsEducationsWithCreatedByMany()
    {
       return $this->getMany(GovsEducation::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsEducationsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsEducationsWithCreatedBy()
    {
       return $this->hasMany(GovsEducation::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsEducationsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsEducation
     */            
    public function getGovsEducationsWithModifiedByMany()
    {
       return $this->getMany(GovsEducation::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsEducationsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsEducationsWithModifiedBy()
    {
       return $this->hasMany(GovsEducation::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsPositionsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsPosition
     */            
    public function getGovsPositionsWithDeletedByMany()
    {
       return $this->getMany(GovsPosition::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsPositionsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsPositionsWithDeletedBy()
    {
       return $this->hasMany(GovsPosition::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsPositionsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsPosition
     */            
    public function getGovsPositionsWithCreatedByMany()
    {
       return $this->getMany(GovsPosition::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsPositionsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsPositionsWithCreatedBy()
    {
       return $this->hasMany(GovsPosition::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsPositionsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsPosition
     */            
    public function getGovsPositionsWithModifiedByMany()
    {
       return $this->getMany(GovsPosition::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsPositionsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsPositionsWithModifiedBy()
    {
       return $this->hasMany(GovsPosition::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsSpecialitiesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsSpeciality
     */            
    public function getGovsSpecialitiesWithDeletedByMany()
    {
       return $this->getMany(GovsSpeciality::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsSpecialitiesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsSpecialitiesWithDeletedBy()
    {
       return $this->hasMany(GovsSpeciality::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsSpecialitiesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsSpeciality
     */            
    public function getGovsSpecialitiesWithCreatedByMany()
    {
       return $this->getMany(GovsSpeciality::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsSpecialitiesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsSpecialitiesWithCreatedBy()
    {
       return $this->hasMany(GovsSpeciality::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getGovsSpecialitiesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|GovsSpeciality
     */            
    public function getGovsSpecialitiesWithModifiedByMany()
    {
       return $this->getMany(GovsSpeciality::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getGovsSpecialitiesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getGovsSpecialitiesWithModifiedBy()
    {
       return $this->hasMany(GovsSpeciality::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufCompatriotsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufCompatriot
     */            
    public function getEyufCompatriotsWithDeletedByMany()
    {
       return $this->getMany(EyufCompatriot::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufCompatriotsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufCompatriotsWithDeletedBy()
    {
       return $this->hasMany(EyufCompatriot::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufCompatriotsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufCompatriot
     */            
    public function getEyufCompatriotsWithCreatedByMany()
    {
       return $this->getMany(EyufCompatriot::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufCompatriotsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufCompatriotsWithCreatedBy()
    {
       return $this->hasMany(EyufCompatriot::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufCompatriotsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufCompatriot
     */            
    public function getEyufCompatriotsWithModifiedByMany()
    {
       return $this->getMany(EyufCompatriot::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufCompatriotsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufCompatriotsWithModifiedBy()
    {
       return $this->hasMany(EyufCompatriot::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufDocumentsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufDocument
     */            
    public function getEyufDocumentsWithDeletedByMany()
    {
       return $this->getMany(EyufDocument::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufDocumentsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufDocumentsWithDeletedBy()
    {
       return $this->hasMany(EyufDocument::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufDocumentsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufDocument
     */            
    public function getEyufDocumentsWithCreatedByMany()
    {
       return $this->getMany(EyufDocument::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufDocumentsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufDocumentsWithCreatedBy()
    {
       return $this->hasMany(EyufDocument::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufDocumentsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufDocument
     */            
    public function getEyufDocumentsWithModifiedByMany()
    {
       return $this->getMany(EyufDocument::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufDocumentsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufDocumentsWithModifiedBy()
    {
       return $this->hasMany(EyufDocument::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufDocumentTypesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufDocumentType
     */            
    public function getEyufDocumentTypesWithDeletedByMany()
    {
       return $this->getMany(EyufDocumentType::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufDocumentTypesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufDocumentTypesWithDeletedBy()
    {
       return $this->hasMany(EyufDocumentType::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufDocumentTypesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufDocumentType
     */            
    public function getEyufDocumentTypesWithCreatedByMany()
    {
       return $this->getMany(EyufDocumentType::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufDocumentTypesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufDocumentTypesWithCreatedBy()
    {
       return $this->hasMany(EyufDocumentType::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufDocumentTypesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufDocumentType
     */            
    public function getEyufDocumentTypesWithModifiedByMany()
    {
       return $this->getMany(EyufDocumentType::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufDocumentTypesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufDocumentTypesWithModifiedBy()
    {
       return $this->hasMany(EyufDocumentType::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufFilesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufFile
     */            
    public function getEyufFilesWithDeletedByMany()
    {
       return $this->getMany(EyufFile::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufFilesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufFilesWithDeletedBy()
    {
       return $this->hasMany(EyufFile::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufFilesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufFile
     */            
    public function getEyufFilesWithCreatedByMany()
    {
       return $this->getMany(EyufFile::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufFilesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufFilesWithCreatedBy()
    {
       return $this->hasMany(EyufFile::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufFilesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufFile
     */            
    public function getEyufFilesWithModifiedByMany()
    {
       return $this->getMany(EyufFile::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufFilesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufFilesWithModifiedBy()
    {
       return $this->hasMany(EyufFile::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufInvoicesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufInvoice
     */            
    public function getEyufInvoicesWithDeletedByMany()
    {
       return $this->getMany(EyufInvoice::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufInvoicesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufInvoicesWithDeletedBy()
    {
       return $this->hasMany(EyufInvoice::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufInvoicesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufInvoice
     */            
    public function getEyufInvoicesWithCreatedByMany()
    {
       return $this->getMany(EyufInvoice::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufInvoicesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufInvoicesWithCreatedBy()
    {
       return $this->hasMany(EyufInvoice::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufInvoicesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufInvoice
     */            
    public function getEyufInvoicesWithModifiedByMany()
    {
       return $this->getMany(EyufInvoice::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufInvoicesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufInvoicesWithModifiedBy()
    {
       return $this->hasMany(EyufInvoice::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufInvoiceTypesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufInvoiceType
     */            
    public function getEyufInvoiceTypesWithDeletedByMany()
    {
       return $this->getMany(EyufInvoiceType::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufInvoiceTypesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufInvoiceTypesWithDeletedBy()
    {
       return $this->hasMany(EyufInvoiceType::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufInvoiceTypesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufInvoiceType
     */            
    public function getEyufInvoiceTypesWithCreatedByMany()
    {
       return $this->getMany(EyufInvoiceType::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufInvoiceTypesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufInvoiceTypesWithCreatedBy()
    {
       return $this->hasMany(EyufInvoiceType::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufInvoiceTypesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufInvoiceType
     */            
    public function getEyufInvoiceTypesWithModifiedByMany()
    {
       return $this->getMany(EyufInvoiceType::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufInvoiceTypesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufInvoiceTypesWithModifiedBy()
    {
       return $this->hasMany(EyufInvoiceType::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufManualsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufManual
     */            
    public function getEyufManualsWithDeletedByMany()
    {
       return $this->getMany(EyufManual::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufManualsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufManualsWithDeletedBy()
    {
       return $this->hasMany(EyufManual::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufManualsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufManual
     */            
    public function getEyufManualsWithCreatedByMany()
    {
       return $this->getMany(EyufManual::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufManualsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufManualsWithCreatedBy()
    {
       return $this->hasMany(EyufManual::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufManualsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufManual
     */            
    public function getEyufManualsWithModifiedByMany()
    {
       return $this->getMany(EyufManual::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufManualsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufManualsWithModifiedBy()
    {
       return $this->hasMany(EyufManual::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeed
     */            
    public function getEyufNeedsWithDeletedByMany()
    {
       return $this->getMany(EyufNeed::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedsWithDeletedBy()
    {
       return $this->hasMany(EyufNeed::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeed
     */            
    public function getEyufNeedsWithCreatedByMany()
    {
       return $this->getMany(EyufNeed::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedsWithCreatedBy()
    {
       return $this->hasMany(EyufNeed::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeed
     */            
    public function getEyufNeedsWithModifiedByMany()
    {
       return $this->getMany(EyufNeed::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedsWithModifiedBy()
    {
       return $this->hasMany(EyufNeed::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedCompatriotsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeedCompatriot
     */            
    public function getEyufNeedCompatriotsWithDeletedByMany()
    {
       return $this->getMany(EyufNeedCompatriot::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedCompatriotsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedCompatriotsWithDeletedBy()
    {
       return $this->hasMany(EyufNeedCompatriot::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedCompatriotsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeedCompatriot
     */            
    public function getEyufNeedCompatriotsWithCreatedByMany()
    {
       return $this->getMany(EyufNeedCompatriot::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedCompatriotsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedCompatriotsWithCreatedBy()
    {
       return $this->hasMany(EyufNeedCompatriot::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedCompatriotsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeedCompatriot
     */            
    public function getEyufNeedCompatriotsWithModifiedByMany()
    {
       return $this->getMany(EyufNeedCompatriot::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedCompatriotsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedCompatriotsWithModifiedBy()
    {
       return $this->hasMany(EyufNeedCompatriot::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedCountsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeedCount
     */            
    public function getEyufNeedCountsWithDeletedByMany()
    {
       return $this->getMany(EyufNeedCount::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedCountsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedCountsWithDeletedBy()
    {
       return $this->hasMany(EyufNeedCount::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedCountsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeedCount
     */            
    public function getEyufNeedCountsWithCreatedByMany()
    {
       return $this->getMany(EyufNeedCount::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedCountsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedCountsWithCreatedBy()
    {
       return $this->hasMany(EyufNeedCount::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedCountsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeedCount
     */            
    public function getEyufNeedCountsWithModifiedByMany()
    {
       return $this->getMany(EyufNeedCount::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedCountsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedCountsWithModifiedBy()
    {
       return $this->hasMany(EyufNeedCount::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufReportsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufReport
     */            
    public function getEyufReportsWithDeletedByMany()
    {
       return $this->getMany(EyufReport::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufReportsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufReportsWithDeletedBy()
    {
       return $this->hasMany(EyufReport::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufReportsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufReport
     */            
    public function getEyufReportsWithCreatedByMany()
    {
       return $this->getMany(EyufReport::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufReportsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufReportsWithCreatedBy()
    {
       return $this->hasMany(EyufReport::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufReportsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufReport
     */            
    public function getEyufReportsWithModifiedByMany()
    {
       return $this->getMany(EyufReport::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufReportsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufReportsWithModifiedBy()
    {
       return $this->hasMany(EyufReport::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufRequestsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufRequest
     */            
    public function getEyufRequestsWithDeletedByMany()
    {
       return $this->getMany(EyufRequest::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufRequestsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufRequestsWithDeletedBy()
    {
       return $this->hasMany(EyufRequest::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufRequestsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufRequest
     */            
    public function getEyufRequestsWithCreatedByMany()
    {
       return $this->getMany(EyufRequest::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufRequestsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufRequestsWithCreatedBy()
    {
       return $this->hasMany(EyufRequest::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufRequestsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufRequest
     */            
    public function getEyufRequestsWithModifiedByMany()
    {
       return $this->getMany(EyufRequest::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufRequestsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufRequestsWithModifiedBy()
    {
       return $this->hasMany(EyufRequest::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufReviewsWithEmployerMany
     * @return  null|\yii\db\ActiveRecord[]|EyufReview
     */            
    public function getEyufReviewsWithEmployerMany()
    {
       return $this->getMany(EyufReview::class, [
            'employer' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufReviewsWithEmployer
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufReviewsWithEmployer()
    {
       return $this->hasMany(EyufReview::class, [
            'employer' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufReviewsWithScholarMany
     * @return  null|\yii\db\ActiveRecord[]|EyufReview
     */            
    public function getEyufReviewsWithScholarMany()
    {
       return $this->getMany(EyufReview::class, [
            'scholar' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufReviewsWithScholar
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufReviewsWithScholar()
    {
       return $this->hasMany(EyufReview::class, [
            'scholar' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufReviewsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufReview
     */            
    public function getEyufReviewsWithDeletedByMany()
    {
       return $this->getMany(EyufReview::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufReviewsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufReviewsWithDeletedBy()
    {
       return $this->hasMany(EyufReview::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufReviewsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufReview
     */            
    public function getEyufReviewsWithCreatedByMany()
    {
       return $this->getMany(EyufReview::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufReviewsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufReviewsWithCreatedBy()
    {
       return $this->hasMany(EyufReview::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufReviewsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufReview
     */            
    public function getEyufReviewsWithModifiedByMany()
    {
       return $this->getMany(EyufReview::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufReviewsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufReviewsWithModifiedBy()
    {
       return $this->hasMany(EyufReview::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufScholarsWithUserIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufScholar
     */            
    public function getEyufScholarsWithUserIdMany()
    {
       return $this->getMany(EyufScholar::class, [
            'user_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufScholarsWithUserId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufScholarsWithUserId()
    {
       return $this->hasMany(EyufScholar::class, [
            'user_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufScholarsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufScholar
     */            
    public function getEyufScholarsWithDeletedByMany()
    {
       return $this->getMany(EyufScholar::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufScholarsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufScholarsWithDeletedBy()
    {
       return $this->hasMany(EyufScholar::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufScholarsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufScholar
     */            
    public function getEyufScholarsWithCreatedByMany()
    {
       return $this->getMany(EyufScholar::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufScholarsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufScholarsWithCreatedBy()
    {
       return $this->hasMany(EyufScholar::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufScholarsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufScholar
     */            
    public function getEyufScholarsWithModifiedByMany()
    {
       return $this->getMany(EyufScholar::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufScholarsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufScholarsWithModifiedBy()
    {
       return $this->hasMany(EyufScholar::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufTablesWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufTable
     */            
    public function getEyufTablesWithDeletedByMany()
    {
       return $this->getMany(EyufTable::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufTablesWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufTablesWithDeletedBy()
    {
       return $this->hasMany(EyufTable::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufTablesWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufTable
     */            
    public function getEyufTablesWithCreatedByMany()
    {
       return $this->getMany(EyufTable::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufTablesWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufTablesWithCreatedBy()
    {
       return $this->hasMany(EyufTable::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufTablesWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufTable
     */            
    public function getEyufTablesWithModifiedByMany()
    {
       return $this->getMany(EyufTable::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufTablesWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufTablesWithModifiedBy()
    {
       return $this->hasMany(EyufTable::class, [
            'modified_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufTicketsWithDeletedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufTicket
     */            
    public function getEyufTicketsWithDeletedByMany()
    {
       return $this->getMany(EyufTicket::class, [
            'deleted_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufTicketsWithDeletedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufTicketsWithDeletedBy()
    {
       return $this->hasMany(EyufTicket::class, [
            'deleted_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufTicketsWithCreatedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufTicket
     */            
    public function getEyufTicketsWithCreatedByMany()
    {
       return $this->getMany(EyufTicket::class, [
            'created_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufTicketsWithCreatedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufTicketsWithCreatedBy()
    {
       return $this->hasMany(EyufTicket::class, [
            'created_by' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufTicketsWithModifiedByMany
     * @return  null|\yii\db\ActiveRecord[]|EyufTicket
     */            
    public function getEyufTicketsWithModifiedByMany()
    {
       return $this->getMany(EyufTicket::class, [
            'modified_by' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufTicketsWithModifiedBy
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufTicketsWithModifiedBy()
    {
       return $this->hasMany(EyufTicket::class, [
            'modified_by' => 'id',
        ]);     
    }


    #endregion


}
