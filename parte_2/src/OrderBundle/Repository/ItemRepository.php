<?php

namespace OrderBundle\Repository;

use MyFramework\DataBase\ORM;
use OrderBundle\Entity\Item;

class ItemRepository extends ORM
{
    /**
     * @param $itemID
     * @return Item
     */
    public function findByID($itemID)
    {
        return parent::findByID($itemID);
    }
}