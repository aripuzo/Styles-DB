<?php
/**
 * Created by PhpStorm.
 * User: Myorh
 * Date: 6/19/2017
 * Time: 7:49 PM
 */

namespace App\Repository\Contracts;


interface TransactionRepository
{
    function transact($user,$action,$amount,$description);
    function getTransactions($userId);
}