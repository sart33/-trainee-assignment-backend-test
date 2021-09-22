<?php

namespace App\Controller;

use App\Model\Ads;


class AdsController
{
    public function api() {

        $apiInputData = file_get_contents('php://input');
        if (empty($apiInputData)) {
            return false;
        } else {
            $queryInfo = json_decode($apiInputData, true);
            $result = (new Ads())->comeInto($queryInfo);
            if ($result !== false) {
                echo json_encode($result);
                return true;
            } else {
                echo json_encode('false');
                return false;
            }


        }
    }









}