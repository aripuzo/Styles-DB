<?php

namespace App\Repository;


use App\Repository\Contracts\ItemRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Item;
use App\Models\Style;
use App\Models\Designer;
use App\Models\Fabric;
use App\Models\Color;
use App\Models\Image;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Favorite;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Download;
use App\Models\Bookmark;
use App\Service\Recommendation;
use App\Repository\ItemPropertyRepo;
use App\Repository\StatRepo;

class ItemRepo implements ItemRepository
{
    public $itemPropertyRepo, $statRepo;
    private $minutes = 1440;

    public function __construct(){
        $this->itemPropertyRepo = new ItemPropertyRepo;
        $this->statRepo = new StatRepo;
    }

    function addItem($itemData) { // example code .. define update here and put your codes
        $item = new Item;
        if(isset($itemData['name']))
            $item->name = $itemData['name'];
        if(isset($itemData['designer'])){
            $designer = $this->itemPropertyRepo->getDesignerByName($s);
            if(!isset($designer)){
                $designerData = ['name' => $s];
                $designer = $this->itemPropertyRepo->addDesigner($designerData);
            }
            $item->designer_id = $designer->id;
        }
        if(isset($itemData['user_id'])){
            $user = User::find($itemData['user_id']);
            if(isset($user))
                $item->user_id = $user->id;
        }
        $item->save();

        $images = $itemData['images'];
        foreach ($images as $s) {
            $this->itemPropertyRepo->addImage($item->id, $s);
        }

        if(isset($itemData['categories'])){
            $categories = $itemData['categories'];
            foreach ($categories as $s) {
                $category = $this->itemPropertyRepo->getCategory($s);
                if(isset($category)){
                    $this->itemPropertyRepo->addItemCategory($item->id, $s);
                }
            }
        }

        if(isset($itemData['add_categories'])){
            $add_categories = explode(',' , $itemData['add_categories']);
            foreach ($add_categories as $s) {
                $category = $this->itemPropertyRepo->getCategoryByName($s);
                if(!isset($category)){
                    $categoryData = ['name' => $s, 'slug' => $this->slugify($s)];
                    $category = $this->itemPropertyRepo->addcategory($categoryData);
                }
                $this->itemPropertyRepo->addItemCategory($item->id, $category->id);
            }
        }

        if(isset($itemData['styles'])){
            $styles = $itemData['styles'];
            foreach ($styles as $s) {
                $style = $this->itemPropertyRepo->getStyle($s);
                if(isset($style)){
                    $this->itemPropertyRepo->addItemStyle($item->id, $s);
                }
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

        if(isset($itemData['fabrics'])){
            $fabrics = $itemData['fabrics'];
            foreach ($fabrics as $s) {
                $fabric = $this->itemPropertyRepo->getFabric($s);
                if(isset($fabric)){
                    $this->itemPropertyRepo->addItemFabric($item->id, $s);
                }
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
                    $this->itemPropertyRepo->addItemTag($item->id, $s);
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

        if(isset($itemData['colors'])){
            $colors = $itemData['colors'];
            foreach ($colors as $s) {
                $color = $this->itemPropertyRepo->getColor($s);
                if(isset($color)){
                    $this->itemPropertyRepo->addItemColor($item->id, $s);
                }
            }
        }

        if(isset($itemData['add_colors'])){
            $add_colors = explode(',' , $itemData['add_colors']);
            foreach ($add_colors as $s) {
                $color = $this->itemPropertyRepo->getColorByName($s);
                if(!isset($color)){
                    $colorData = ['name' => $s, 'slug' => $this->slugify($s)];
                    $color = $this->itemPropertyRepo->addColor($colorData);
                }
                $this->itemPropertyRepo->addItemColor($item->id, $color->id);
            }
        }
    }

    private function slugify($s){
        return urlencode(str_replace(" ","_", strtolower($s)));
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
        $item->delete();
    }

    function favItem($userId, $itemId){
        $item = Item::find($itemId);
        $user = User::find($userId);
        $favItem = Favorite::where([['user_id', $userId], ['item_id', $itemId]])->get();
        if(isset($item) && isset($user)){
            if(!isset($favItem) || $favItem->count() == 0){
                $fav = new Favorite;
                $fav->item_id = $itemId;
                $fav->user_id = $userId;
                $fav->save();
                $this->rateItem($userId, $itemId);
                return (count($favItem) + 1) .' <i class="fa fa-heart"></i>';
            }
            else{
                $favItem->first()->delete();
                $this->rateItem($userId, $itemId);
                return (count($favItem) - 1) . ' <i class="fa fa-heart-o"></i>';
            }
        }
        return false;
    }

    function bookmarkItem($userId, $itemId){
        $item = Item::find($itemId);
        $user = User::find($userId);
        $bookmarkItem = Bookmark::where([['user_id', $userId], ['item_id', $itemId]])->get();
        if(isset($item) && isset($user)){
            if(!isset($bookmarkItem) || $bookmarkItem->count() == 0){
                $bookmark = new Bookmark;
                $bookmark->item_id = $itemId;
                $bookmark->user_id = $userId;
                $bookmark->save();
                $this->rateItem($userId, $itemId);
                return (count($bookmarkItem) + 1) . ' <i class="fa fa-bookmark"></i>';
            }
            else{
                $bookmarkItem->first()->delete();
                $this->rateItem($userId, $itemId);
                return (count($bookmarkItem) - 1) . ' <i class="fa fa-bookmark-o"></i>';
            }
        }
        return false;
    }

    function downloadItem($userId, $itemId){
        $item = Item::find($itemId);
        // if(isset($userId))
        //     $user = User::find($userId);
        $download = Download::where([['item_id', $itemId], ['user_id', $userId]])->first();
        if(isset($item)){
            if(!isset($download)){
                $download = new Download;
                $download->count = 0;
                $download->item_id = $itemId;
                if(isset($userId))
                    $download->user_id = $userId;
            }
            $download->count += 1;
            $download->save();
            if(isset($userId))
                $this->rateItem($userId, $itemId);
            return $item->images->first()->url;
        }
        return null;
    }

    private function getItemRating($userId, $itemId){
        $rating = 0;
        $favs = Favorite::where([['user_id', $userId], ['item_id', $itemId]])->get();
        if(isset($favs) && $favs->count())
            $rating += 1;
        $books = Bookmark::where([['user_id', $userId], ['item_id', $itemId]])->get();
        if(isset($books) && $books->count())
            $rating += 1;
        $downloads = Download::where([['user_id', $userId], ['item_id', $itemId]])->get();
        if(isset($downloads) && $downloads->count())
            $rating += 2;
        $comments = Comment::where([['user_id', $userId], ['item_id', $itemId]])->get();
        foreach ($comments as $comment) {
            $rating += 0.5;
        }
        return $rating;
    }

    function rateItem($userId, $itemId){
        $rating = Rating::where([['item_id', $itemId], ['user_id', $userId]])->first();
        if(!isset($rating) || $rating->count() == 0){
            $rating = new Rating;
            $rating->item_id = $itemId;
            $rating->user_id = $userId;
        }
        $rating->rating = $this->getItemRating($userId, $itemId);
        $rating->save();
        return $rating;
    }

    function commentOnItem($userId, $itemId, $text, $commentId = null){
        $item = Item::find($itemId);
        $user = User::find($userId);
        if(isset($item) && isset($user)){
            $comment = new Comment;
            $comment->user_id = $userId;
            $comment->item_id = $itemId;
            $comment->text = $text;
            if(isset($commentId))
                $comment->parent_id = $commentId;
            $comment->save();
            $this->rateItem($userId, $itemId);
            return $comment;
        }
        return null;
    }

    function getItem($itemId){
        return Item::find($itemId);
    }

    function getDummyItems($limit = 15){
        $item = Item::where('id', 0)->paginate($limit);
    }

    function getItems($filters, $order, $limit = 15){
        $item = Item::query();
        if (isset($filters['style']))
            $item->whereHas('styles', function($query) use($filters) {
                    $query->where( 'slug', $filters['style'] );
                });
        if (isset($filters['category']))
            $item->whereHas('categories', function($query) use($filters) {
                    $query->where( 'slug', $filters['category'] );
                });
        if (isset($filters['fabric']))
            $item->whereHas('fabrics', function($query) use($filters) {
                    $query->where( 'slug', $filters['fabric'] );
                });
        if (isset($filters['color']))
            $item->whereHas('colors', function($query) use($filters) {
                    $query->where( 'slug', $filters['color'] );
                });
        if (isset($order['orderBy'])){
            if($order['orderBy'] == 'created_at'){
                $item->orderBy($order['orderBy'], $order['orderDir']);
            }
            else{
                $item->withCount($order['orderBy'])->orderBy($order['orderBy'].'_count', 'desc');
            } 
        }
        return $item->paginate($limit);
        
    }

    function searchItems($term, $order, $limit = 15){
        $item = Item::query();
        $item->where('name', 'like', '%' . $term . '%')
                ->orWhereHas('categories', function($query) use($term) {
                    $query->where( 'name', 'like', '%'.$term.'%' );
                })
                ->orWhereHas('fabrics', function($query) use($term) {
                    $query->where( 'name', 'like', '%'.$term.'%' );
                })
                ->orWhereHas('styles', function($query) use($term) {
                    $query->where( 'name', 'like', '%'.$term.'%' );
                })
                ->orWhereHas('tags', function($query) use($term) {
                    $query->where( 'name', 'like', '%'.$term.'%' );
                })
                ->orWhereHas('colors', function($query) use($term) {
                    $query->where( 'name', 'like', '%'.$term.'%' );
                })
                ->orWhereHas('designer', function($query) use($term) {
                    $query->where( 'name', 'like', '%'.$term.'%' );
                })
                ->orWhere('description', 'like', '%' . $term . '%');
        if (strpos($term, ' ') !== false){
        $terms = explode(' ', $term);
        if(count($terms) > 1)
            foreach ($terms as $s) {
                //check related words
                //denim jean,blouse top
                if(!$this->exclude($s)){
                    $item->orWhereHas('categories', function($query) use($s) {
                            $query->where( 'name', 'like', '%'.$s.'%' );
                        })
                        ->orWhereHas('fabrics', function($query) use($s) {
                            $query->where( 'name', 'like', '%'.$s.'%' );
                        })
                        ->orWhereHas('styles', function($query) use($s) {
                            $query->where( 'name', 'like', '%'.$s.'%' );
                        })
                        ->orWhereHas('tags', function($query) use($s) {
                            $query->where( 'name', 'like', '%'.$s.'%' );
                        })
                        ->orWhereHas('colors', function($query) use($s) {
                            $query->where( 'name', 'like', '%'.$s.'%' );
                        });
                }
            }
        }
        if (isset($order['orderBy']))
            $item->orderBy($order['orderBy'], $order['orderDir']);
        //$statRepo->itemSeached($term, $results, $user_id = null)
        return $item->paginate($limit);
    }

    private function exclude($s){
        if($s == 'and' || $s == 'if' || $s == 'of' || $s == 'by' || $s == 'as' || $s == 'for' || $s == 'with')
            return true;
        return false;
    }

    function getSimilarItems($itemId, $limit = 3){
        $ratings = Rating::whereNotNull('user_id')->get();
        $itemRatings = $ratings->where('item_id', $itemId);
        if($ratings->count() >= 100 && isset($itemRatings)){
            $prefs = array();
            foreach ($ratings as $rating) {
                $book = array('i'.$rating->item_id => $rating->rating);
                Recommendation::setdefault($prefs, $rating->user_id, $book);
                if($prefs[$rating->user_id] !=  $book)
                    $prefs[$rating->user_id][] = $book;
            }
            if(count($prefs) > 5){
                $itemsim = Recommendation::calculateSimilarItems($prefs);
                $recs = array_slice($itemsim[$itemId], 0, 3);
                $recs_val = array();
                foreach($recs as $r => $value)
                    $recs_val[] = (int)substr($r, 1);
                if(isset($recs_val) && count($recs_val) > 10){
                    $items = Item::find($recs_val);
                    return $items;
                }
            }
        }
        $item = $this->getItem($itemId);
        $sty = $item->styles->first()->name;
        return Item::where('id', "!=", $itemId)
                ->whereHas('styles', function($query) use($sty) {
                    $query->where( 'name', $sty );
                })
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
    }
    
    function getRecommendedItems($userId, $order, $limit = 15){
        $ratings = Rating::whereNotNull('user_id')->get();
        $myRatings = $ratings->where('user_id', $userId);
        if($ratings->count() >= 100 && isset($myRatings)){
            $prefs = Cache::remember('item_sim', $this->minutes, function () use($ratings) {
                $prefs = array();
                foreach ($ratings as $rating) {
                    $book = array('i'.$rating->item_id => $rating->rating);
                    Recommendation::setdefault($prefs, $rating->user_id, $book);
                    if($prefs[$rating->user_id] !=  $book)
                        $prefs[$rating->user_id][] = $book;
                }
                return $prefs;
            });
            if(count($prefs) > 10 && isset($prefs[$userId])){
                $itemsim = Cache::remember('item_sim', $this->minutes, function () use($prefs) {
                    return Recommendation::calculateSimilarItems($prefs);
                });
                $recs = Recommendation::getRecommendedItems($prefs, $itemsim, $userId);
                $recs_val = array();
                foreach($recs as $r => $value)
                    $recs_val[] = (int)substr($r, 1);
                if(isset($recs_val) && count($recs_val) > 10){
                    $items = Item::whereIn('id', $recs_val)->paginate($limit);
                    return $items;
                }
            }
        }
        $user = User::find($userId);
        if(isset($user->sex)){
            if($user->sex == 'male')
                $category = $this->itemPropertyRepo->getCategoryBySlug('men');
            else
                $category = $this->itemPropertyRepo->getCategoryBySlug('women');
            return Item::whereHas('categories', function($query) use($category) {
                        $query->where( 'name', $category->name );
                    })
                    // ->whereHas('ratings', function($query) use($userId) {
                    //     $query->where( 'user_id', '!=', $userId );
                    // })
                    ->withCount('ratings')->orderBy('ratings_count', 'desc')
                    ->paginate($limit);
        }
        return Item::paginate($limit);
    }
}