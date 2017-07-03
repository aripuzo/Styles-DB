<?php


/**
 * Description of UserRepository
 *
 * @author olaar
 */

namespace App\Repository\Contracts;

interface UserRepository {
  
    function updateUser($userId, $userData); // example of how to use..
    function getUser($userId);
    function deleteUser($userId);
}
