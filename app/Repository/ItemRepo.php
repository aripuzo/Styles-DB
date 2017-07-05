<?php

namespace App\Repository;


use App\Repository\Contracts\ItemRepository;
use App\Item;
use App\Style;
use App\ItemStyle;
use App\Fabric;
use App\ItemFabric;
use App\Color;
use App\ItemColor;
use App\Image;
use App\ItemImage;
use App\Category;
use App\ItemCategory;
use App\Tag;
use App\ItemTag;
use App\Favorite;
use App\Comment;
use App\ItemComment;
use App\ItemDownload;
use App\ItemBookmark;

class ItemRepo implements ItemRepository
{
    function addItem($itemData) { // example code .. define update here and put your codes
        $item = new Item;
        $item->name = $itemData['name'];
        $item->description = $itemData['description'];
        $item-save();

        $stylesId = $itemData['stylesId'];
        if(isset($stylesId) && count($stylesId) > 0){
            foreach ($stylesId as $styleId) {
                $style = Style::find($styleId);
                if(isset($style)){
                    $itemStyle = new ItemStyle;
                    $itemStyle->item_id = $item->id;
                    $itemStyle->style_id = $styleId;
                    $itemStyle->save();
                }
            }
        }

        $categoriesId = $itemData['categoriesId'];
        if(isset($stylesId) && count($stylesId) > 0){
            foreach ($stylesId as $styleId) {
                $style = Style::find($styleId);
                if(isset($style)){
                    $itemStyle = new ItemStyle;
                    $itemStyle->item_id = $item->id;
                    $itemStyle->style_id = $styleId;
                    $itemStyle->save();
                }
            }
        }
    }

    function updateItem($itemId, $itemData) { // example code .. define update here and put your codes
        $item = Item::find($itemId);
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->phone = $userData['phone'];
        $user->save();
    }

    function favItem($userId, $itemId){
        $item = Item::find($itemId);
        $user = User::find($userId);
        $favItem = Favorite::where([['user_id', $userId], ['item_id', $itemId]])->get();
        if(isset($item) && isset($user) && (!isset($favItem) && count($favItem) == 0)){
            $fav = new Favorite;
            $fav->item_id = $itemId;
            $fav->user_id = $userId;
            $fav->save();
        }
    }

    function bookmarkItem($userId, $itemId){
        $item = Item::find($itemId);
        $user = User::find($userId);
        $bookmarkItem = ItemBookmark::where([['user_id', $userId], ['item_id', $itemId]])->get();
        if(isset($item) && isset($user) && (!isset($bookmarkItem) && count($bookmarkItem) == 0)){
            $bookmark = new ItemBookmark;
            $bookmark->item_id = $itemId;
            $bookmark->user_id = $userId;
            $bookmark->save();
        }
    }

    function downloadItem($userId, $itemId){
        $item = Item::find($itemId);
        $user = User::find($userId);
        $download = ItemDownload::where([['user_id', $userId], ['item_id', $itemId]])->first();
        if(isset($item) && isset($user)){
            if(!isset($download)){
                $download = new ItemDownload;
                $download->user_id = $userId;
                $download->item_id = $itemId;
            }
            $download->count += 1;
            $download->save();
            return $item->images;
        }
        return null;
    }

    function getItems($page, $order, $limit){
        
    }
}