<?php
/**
 * Created by PhpStorm.
 * User: J.Hauck
 * Date: 29.05.2017
 * Time: 21:18
 */

namespace AppBundle\Services;


class CustomerService
{
    public function test() {
        return 'test';
    }

    public function createProcessArray($street, $number, $zipcode, $city, $country) {
        return array(
            'street' => $street,
            'number' => $number,
            'zipcode' =>$zipcode,
            'city' => $city,
            'country' =>$country
        );
    }
}