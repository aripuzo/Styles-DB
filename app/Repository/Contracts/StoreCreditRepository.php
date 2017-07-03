<?php

/**
 * Description of StoreCreditRepository
 *
 * @author olaar
 */

namespace App\Repository\Contracts;

interface StoreCreditRepository {
    //put your code here
    function createWallet($user);
    function addCredit($userId,$amount);
    function deduct($userId,$amount);
    function getWallet($userId);

}
