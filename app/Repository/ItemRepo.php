<?php

namespace App\Repository;


use App\Repository\Contracts\ItemRepository;
use Illuminate\Support\Facades\DB;
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

    function deleteItem($itemId) { // example code .. define update here and put your codes
        $item = Item::find($itemId);
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
            return true;
        }
        return false;
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

    function getItem($itemId){
        return Item::find($itemId);
    }

    function getItems($filters, $page = 1, $order, $limit = 15){
        $item = Item::query();
        if (isset($filters['style']))
            $item->whereHas('styles', function($query) use($filters) {
                    $query->where('slug', $filters['style']);
                });
        if (isset($filters['category']))
            $item->whereHas('categories', function($query) use($filters) {
                    $query->where('slug', $filters['category']);
                });
        if (isset($filters['fabric']))
            $item->whereHas('fabrics', function($query) use($filters) {
                    $query->where('slug', $filters['fabric']);
                });
        if (isset($filters['color']))
            $item->whereHas('colors', function($query) use($filters) {
                    $query->where('slug', $filters['color']);
                });
        if (isset($order['orderBy']))
            $item->orderBy($order['orderBy'], $order['orderDir']);

        return $item->paginate($limit)->url($page);
        
    }

    function searchItems($term, $page, $order, $limit = 15){
        $item = Item::query();
        $item->where('name', 'like', '%' . $term . '%')
                ->orWhereHas('categories', function($query) use($term) {
                    $query->where('name', 'like', '%'.$term.'%');
                })
                ->orWhereHas('styles', function($query) use($term) {
                    $query->where('name', 'like', '%'.$term.'%');
                })
                // ->orWhereHas('item_styles', function($query) use($term) {
                //     $query->whereHas('styles', function($query)
                //     {
                //         $query->where( 'name', 'like', '%'.$term.'%' );
                //     });
                // })
                ->orWhere('description', 'like', '%' . $term . '%');
        if (isset($order['orderBy']))
            $item->orderBy($order['orderBy'], $order['orderDir']);
        return $item->paginate($limit)->url($page);
    }
}