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

    function rateItem($userId, $itemId);

    function commentOnItem($userId, $itemId, $text, $commentId);

    function getItem($itemId);

    function getItems($filters, $order, $limit);

    function searchItems($term, $order, $limit);

    function getSimilarItems($itemId, $limit);

    function getRecommendedItems($userId, $order, $limit);
}