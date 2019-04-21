<?php

namespace OrderBundle\Repository;

use MyFramework\DataBase\ORM;
use OrderBundle\Entity\Order;

class OrderRepository extends ORM
{
    public function save(Order $order)
    {
        return $this->save($order);
    }
}