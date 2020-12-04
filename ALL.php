<?php

/**
 *
 *
 * Author:  Asror Zakirov
 *
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models;

use zetsoft\service\App\eyuf\Chat;
use zetsoft\service\App\eyuf\Davlat;
use zetsoft\service\App\eyuf\Docs;
use zetsoft\service\App\eyuf\Excel2;
use zetsoft\service\App\eyuf\Grapes;
use zetsoft\service\App\eyuf\Grapes_;
use zetsoft\service\App\eyuf\Main;
use zetsoft\service\App\eyuf\Margin;
use zetsoft\service\App\eyuf\Pdf;
use zetsoft\service\App\eyuf\User;
use zetsoft\service\App\eyuf\Word;
use zetsoft\service\App\eyuf\ZReport;
use yii\base\Component;
use zetsoft\system\Az;


/**
 * Class    Eyuf
 * @package zetsoft\models\ALL
 *
 *
 */
class ALL
{

    public static function run()
    {
        return [

            'shop' => Azl.'Магазины',
            'ware' => Azl.'Склады',
            'auto' => Azl.'Машины',
            'pays' => Azl.'Платежы',
            'disc' => Azl.'Скидки',
            'calls' => Azl.'Звонки',
            'user' => Azl.'Пользователи',
            'place' => Azl.'Места',
            'menu' => Azl.'Меню',
            'lang' => Azl.'Языки',
            'dyna' => Azl.'Таблица',
            'faqs' => Azl.'Вопросы',

            'news' => Azl.'Новости',
            'core' => Azl.'Ядро',
            'page' => Azl.'Страницы',
            'maps' => Azl.'Карты',
            'chat' => Azl.'Чат',
            'drag' => Azl.'Дизайнер',
            'tree' => Azl.'Дерево моделей',

            'govs' => Azl.'Управление',
            'doft' => Azl.'Грузоперевозка',

            'cpas' => Azl.'CPA сети',
            /**
             * Test
             */
            'test' => Azl.'Тестовые',

        ];
      
    }

}
