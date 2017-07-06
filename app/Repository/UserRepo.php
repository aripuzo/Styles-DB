<?php

/**
 * Description of UserRepository
 *
 * @author ari
 */

namespace App\Repository;

use App\Address;
use App\Repository\Contracts\UserRepository;
use App\User;
use App\Item;

class UserRepo implements UserRepository { // all deletes should be soft delete
//put your code here

    function updateUser($userId, $userData) { // example code .. define update here and put your codes
        $user = User::find($userId);
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->phone = $userData['phone'];
        $user->avatar = $userData['avatar'];

        $address = User::find($userId)->address;
        if ($address == null) {
            $address = new Address;
            $address->address1 = $userData['address'];
            $address->city = $userData['city'];
            $address->state = $userData['state'];
            $address->country = $userData['country'];
            $user->address()->save($address);
        } else {
            $address->address1 = $userData['address'];
            $address->city = $userData['city'];
            $address->state = $userData['state'];
            $address->country = $userData['country'];
            $user->address()->save($address);
        }

        $user->save();
    }

    function updatePassword($userId, $newPassword) { // example code .. define update here and put your codes
        $user = User::find($userId);
        $user->password = bcrypt($newPassword);
        $user->save();
    }

    function deleteUser($userId) { //define delete here and put your codes
    }

    function getUser($userId) {
        return User::find($userId);
    }

    function getItemsWithRating($userId){
        $user = User::find($userId);
    }

}
