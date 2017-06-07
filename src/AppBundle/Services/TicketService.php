<?php
/**
 * Created by PhpStorm.
 * User: J.Hauck
 * Date: 29.05.2017
 * Time: 21:18
 */

namespace AppBundle\Services;


class TicketService
{
    public function test() {
        return 'test';
    }

    public function createProcessArray($data, $titel, $freeform, $times) {
        $time = date("Y-m-d H:i:s");

        $responsible = get_current_user();

        $process = array(
            'titel' => $titel,
            'freeform' =>$freeform,
            'times' => $times,
            'id' =>$responsible,
            'time' => $time,
        );

        $data[] = $process;

        return $data;
    }
}