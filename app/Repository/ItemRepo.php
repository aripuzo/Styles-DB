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
use App\Repository\ItemPropertyRepo;

class ItemRepo implements ItemRepository
{
    public $itemProperty;

    public function __construct(){
        $this->itemPropertyRepo = new ItemPropertyRepo;
    }

    function addItem($itemData) { // example code .. define update here and put your codes
        $item = new Item;
        $item->name = $itemData['name'];
        $item->description = $itemData['description'];
        $item->save();

        $images = $itemData['images'];
        foreach ($images as $s) {
            $this->itemPropertyRepo->addImage($item->id, $s);
        }

        $categories = $itemData['categories'];
        foreach ($categories as $s) {
            $category = $this->itemPropertyRepo->getCategory($s);
            if(isset($category)){
                $this->itemPropertyRepo->addItemCategory($item->id, $s);
            }
        }

        $styles = $itemData['styles'];
        foreach ($styles as $s) {
            $style = $this->itemPropertyRepo->getStyle($s);
            if(isset($style)){
                $this->itemPropertyRepo->addItemStyle($item->id, $s);
            }
        }

        if(isset($itemData['add_styles'])){
            $add_styles = explode(',' , $itemData['add_styles']);
            foreach ($add_styles as $s) {
                $style = $this->itemPropertyRepo->getStyleByName($s);
                if(!isset($style)){
                    $styleData = ['name' => $s, 'slug' => $this->slugify($s)];
                    $style = $this->itemPropertyRepo->addStyle($styleData);
                }
                $this->itemPropertyRepo->addItemStyle($item->id, $style->id);
            }
        }

        $fabrics = $itemData['fabrics'];
        foreach ($fabrics as $s) {
            $fabric = $this->itemPropertyRepo->getFabric($s);
            if(isset($fabric)){
                $this->itemPropertyRepo->addItemFabric($item->id, $s);
            }
        }

        if(isset($itemData['add_fabrics'])){
            $add_fabrics = explode(',' , $itemData['add_fabrics']);
            foreach ($add_fabrics as $s) {
                $fabric = $this->itemPropertyRepo->getFabricByName($s);
                if(!isset($fabric)){
                    $fabricData = ['name' => $s, 'slug' => $this->slugify($s)];
                    $fabric = $this->itemPropertyRepo->addFabric($fabricData);
                }
                $this->itemPropertyRepo->addItemFabric($item->id, $fabric->id);
            }
        }

        if(isset($itemData['tags'])){
            $tags = $itemData['tags'];
            foreach ($tags as $s) {
                $tag = $this->itemPropertyRepo->getTag($s);
                if(isset($tag)){
                    $this->itemPropertyRepo->addItemStyle($item->id, $s);
                }
            }
        }

        if(isset($itemData['add_tags'])){
            $add_tags = explode(',' , $itemData['add_tags']);
            foreach ($add_tags as $s) {
                $tag = $this->itemPropertyRepo->getTagByName($s);
                if(!isset($tag)){
                    $tagData = ['name' => $s, 'slug' => $this->slugify($s)];
                    $tag = $this->itemPropertyRepo->addTag($tagData);
                }
                $this->itemPropertyRepo->addItemTag($item->id, $tag->id);
            }
        }

        $colors = $itemData['colors'];
        foreach ($colors as $s) {
            $color = $this->itemPropertyRepo->getColor($s);
            if(isset($color)){
                $this->itemPropertyRepo->addItemColor($item->id, $s);
            }
        }

        if(isset($itemData['add_colors'])){
            $add_colors = $itemData['add_colors'];
            foreach ($add_colors as $s) {
                $color = $this->itemPropertyRepo->getColorByName($s);
                if(!isset($color)){
                    $colorData = ['name' => $s, 'slug' => $this->slugify($s)];
                    $color = $this->itemPropertyRepo->addColor($colorData);
                }
                $this->itemPropertyRepo->addItemFabric($item->id, $fabric->id);
            }
        }
    }

    private function slugify($s){
        return str_replace(" ","_", strtolower($s));
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
            return count($favItem) + 1;
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
            return count($bookmark) + 1;
        }
        return false;
    }

    function downloadItem($userId, $itemId){
        $item = Item::find($itemId);
        $user = User::find($userId);
        //$download = ItemDownload::where([['user_id', $userId], ['item_id', $itemId]])->first();
        if(isset($item) && isset($user)){
            //if(!isset($download)){
                $download = new ItemDownload;
                $download->user_id = $userId;
                $download->item_id = $itemId;
            //}
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
            $item->whereHas('itemStyles', function($query) use($filters) {
                    $query->whereHas('style', function($query) use($filters) {
                        $query->where( 'slug', $filters['style'] );
                    });
                });
        if (isset($filters['category']))
            $item->whereHas('itemCategories', function($query) use($filters) {
                    $query->whereHas('category', function($query) use($filters) {
                        $query->where( 'slug', $filters['category'] );
                    });
                });
        if (isset($filters['fabric']))
            $item->whereHas('itemFabrics', function($query) use($filters) {
                    $query->whereHas('fabric', function($query) use($filters) {
                        $query->where( 'slug', $filters['fabric'] );
                    });
                });
        if (isset($filters['color']))
            $item->whereHas('itemColors', function($query) use($filters) {
                    $query->whereHas('color', function($query) use($filters) {
                        $query->where( 'slug', $filters['color'] );
                    });
                });
        if (isset($order['orderBy']))
            $item->orderBy($order['orderBy'], $order['orderDir']);

        return $item->paginate($limit);
        
    }

    function searchItems($term, $page, $order, $limit = 15){
        $item = Item::query();
        $item->where('name', 'like', '%' . $term . '%')
                ->orWhereHas('itemCategories', function($query) use($term) {
                    $query->whereHas('category', function($query) use($term) {
                        $query->where( 'name', 'like', '%'.$term.'%' );
                    });
                })
                ->orWhereHas('itemFabrics', function($query) use($term) {
                    $query->whereHas('fabric', function($query) use($term) {
                        $query->where( 'name', 'like', '%'.$term.'%' );
                    });
                })
                ->orWhereHas('itemStyles', function($query) use($term) {
                    $query->whereHas('style', function($query) use($term) {
                        $query->where( 'name', 'like', '%'.$term.'%' );
                    });
                })
                ->orWhereHas('itemTags', function($query) use($term) {
                    $query->whereHas('tag', function($query) use($term) {
                        $query->where( 'name', 'like', '%'.$term.'%' );
                    });
                })
                ->orWhereHas('itemColors', function($query) use($term) {
                    $query->whereHas('color', function($query) use($term) {
                        $query->where( 'name', $term );
                    });
                })
                ->orWhere('description', 'like', '%' . $term . '%');
        if (isset($order['orderBy']))
            $item->orderBy($order['orderBy'], $order['orderDir']);
        return $item->paginate($limit);
    }

    function getPopularItems($filters, $page = 1, $limit = 15){
        $order = ['orderBy' => 'favorites', 'orderDir' => 'asc'];
        return $this->getItems($filters, $page, $order, $limit);
    }
}