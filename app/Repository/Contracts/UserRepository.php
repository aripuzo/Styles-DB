<?php

namespace App\Repository\Contracts;

interface UserRepository {
  
    function updateUser($userId, $userData);

    function updatePassword($userId, $newPassword);

    function deleteUser($userId);

    function getUser($userId);

    function getItemsWithRating($userId);
}
