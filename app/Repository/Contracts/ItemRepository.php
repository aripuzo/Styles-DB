<?php
/**
 * Created by PhpStorm.
 * User: Myorh
 * Date: 6/19/2017
 * Time: 7:49 PM
 */

namespace App\Repository\Contracts;


interface ItemRepository
{
    function addItem($itemData);

    function updateItem($itemId, $itemData);

    function deleteItem($itemId);

    function favItem($userId, $itemId);

    function bookmarkItem($userId, $itemId);

    function downloadItem($userId, $itemId);

    function getItem($itemId);

    function getItems($filters, $page, $order, $limit);

    function searchItems($term, $page, $order, $limit);
}