<?php

/*
 * @author NurbekMakhmudov
 */

namespace zetsoft\models\test;

use zetsoft\system\actives\ZActiveRecord;

class TestActiveQuery extends ZActiveRecord
{
    /**
     * @author NurbekMakhmudov
     */
    public function getItems()
    {
        /**
         *  many-to-many ikkita jadval asosida bitta jadval tuzilgan bo'lsa
         *  ushbu jadvallardagi malumotlar olish uchun ishlatiladi
         *  https://yiiframework.com.ua/ru/doc/guide/2/db-active-record/
         */
        return $this->hasMany(Item::className(), ['id' => 'item_id'])
            ->viaTable('order_item', ['order_id' => 'id']);
    }



}