<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StoreCreditRepository
 *
 * @author olaar
 */
namespace App\Repository;

use App\Repository\Contracts\StoreCreditRepository;
use App\Wallet;

class StoreCreditRepo implements StoreCreditRepository{ // all deletes should be soft delete
    //put your code here

    function createWallet($user)
    {
        $wallet = new Wallet;
        $wallet->balance = 0;
        $wallet->is_blocked = 0;
        $user->wallet()->save($wallet);
    }

    function addCredit($userId, $amount)
    {
        $wallet = Wallet::where('user_id',$userId)->first();
        $wallet->balance = $wallet->balance + $amount;
        $wallet->save();
    }

    function deduct($userId, $amount)
    {
        $wallet = Wallet::where('user_id',$userId)->first();
        if($wallet->balance < 0  || $amount > $wallet->balance){
            return false;
        }else{
            $wallet->balance = $wallet->balance - $amount;
            $wallet->save();
            return true;
        }

    }

    function getWallet($userId)
    {
        return Wallet::where('user_id',$userId)->first();
    }
}
