<?php

/**
 * Description of UserRepository
 *
 * @author ari
 */

namespace App\Repository;

use App\Repository\Contracts\UserRepository;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Download;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Service\Recommendation;

class UserRepo implements UserRepository {

    // private $reviews = array(
    //     '2' => array(
    //         'i20' => 3.0,
    //         'i24' => 3.5,
    //         'i26' => 3.0,
    //     ),
    //     '3' => array(
    //         'i21' => 1.5,
    //         'i20' => 4.0,
    //         'i29' => 1.0,
    //         'i26' => 4.5,
    //         'i22' => 4.0
    //     ),
    //     '4' => array(
    //         'i21' => 1.5,
    //         'i24' => 4.0,
    //         'i29' => 1.0,
    //         'i27' => 4.5,
    //         'i20' => 4.0
    //     ),
    //     '5' => array(
    //         'i24' => 1.5,
    //         'i28' => 4.0,
    //         'i29' => 1.0,
    //         'i26' => 4.5,
    //         'i20' => 4.0
    //     ),
    // );
    // private $critics =array();

    // function getRecommendedTest($userId, $limit = 15){
    //     // $this->critics = json_decode('[{"item_id":21,"user_id":2,"designer_id":1},{"item_id":22,"user_id":3,"designer_id":4},{"item_id":27,"user_id":4,"designer_id":5},{"item_id":28,"user_id":3,"designer_id":6},{"item_id":29,"user_id":5,"designer_id":8}]');
    //     // $prefs = array();
    //     // foreach ($this->critics as $rating) {
    //     //     $book = array('i'.$rating->item_id => $rating->designer_id);
    //     //     Recommendation::setdefault($prefs, $rating->user_id, $book);
    //     //     if($prefs[$rating->user_id] !=  $book)
    //     //         $prefs[$rating->user_id][] = $book;
    //     // }
    //     // var_dump($prefs);
    //     // echo '<br><br><br>';
    //     $prefs = $this->reviews;
    //     if(count($prefs) > 2 && isset($prefs[$userId])){
    //         $itemsim = Recommendation::calculateSimilarItems($prefs);
    //         $recs = Recommendation::getRecommendedItems($prefs, $itemsim, $userId);
    //         $recs_val = array();
    //         foreach($recs as $r => $value)
    //             $recs_val[] = (int)substr($r, 1);
    //         $items = Item::whereIn('id', $recs_val)->paginate($limit);
    //         return $items;
    //     }
    // }

    function checkUsername($username){

    }

    static function insertUser($userData, $role = null) {
        $user = User::where('email', $userData['email'])->orWhere('username', $userData['username'])->first();
        if(isset($user))
            return $user;
        $user = User::create([
            'username' => $userData['username'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
            'sex' => $userData['sex'],
            'token' => $userData['token'],
            'signup_ip_address' => $userData['signup_ip_address'],
            'verified' => $userData['verified'],
        ]);

        if(isset($role))
            $user->attachRole($role);
        return $user;
    }

    function updateUser($userId, $userData) {
        $user = User::find($userId);
        $user->name = $userData['name'];
        //$user->email = $userData['email'];
        $user->phone = $userData['phone'];

        $user->save();
        return $user;
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
        $itemsRated = array();
        $favs = Favorite::where('user_id', $userId)->get();
        foreach ($favs as $fav) {
            Recommendation::setdefault($itemsRated, $fav->item->id, 0);
            $itemsRated[$fav->item->id] += 1;
        }
        $comments = Comment::where('user_id', $userId)->get();
        foreach ($comments as $comment) {
            Recommendation::setdefault($itemsRated, $comment->item->id, 0);
            $itemsRated[$comment->item->id] += 1;
        }
        return array($user->id => $itemsRated, );
    }

    function getItemRating($userId, $item){
        $user = User::find($userId);
        $itemsRated = array();
        $favs = Favorite::where('user_id', $userId)->get();
        foreach ($favs as $fav) {
            Recommendation::setdefault($itemsRated, $fav->item->id, 0);
            $itemsRated[$fav->item->id] += 1;
        }
        $comments = Comment::where('user_id', $userId)->get();
        foreach ($comments as $comment) {
            Recommendation::setdefault($itemsRated, $comment->item->id, 0);
            $itemsRated[$comment->item->id] += 1;
        }
        return array($user->id => $itemsRated, );
    }

}
