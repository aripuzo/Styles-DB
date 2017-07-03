<?php
/**
 * Created by PhpStorm.
 * User: Myorh
 * Date: 6/19/2017
 * Time: 7:50 PM
 */

namespace App\Repository;


use App\Repository\Contracts\TransactionRepository;
use App\Transaction;

class TransactionRepo implements TransactionRepository
{


    function transact($user, $action, $amount,$description)
    {
        $transaction = new Transaction;
        $transaction->action = $action;
        $transaction->amount = $amount;
        $transaction->description = $description;
        $user->transaction()->save($transaction);
    }

    function getTransactions($userId){
        if(Transaction::where('user_id',$userId)->count() > 0){
        return Transaction::where('user_id',$userId)->get();
        }
        else {
            return null;
        }
    }
}