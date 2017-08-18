<?php
namespace App\Repository;

use App\Repository\Contracts\StatRepository;
use Illuminate\Support\Facades\DB;

class StatRepo  implements StatRepository{
    function categoryViewed($categoryId, $user_id = null){
        DB::table('category_view')->insert(
		    ['category_id' => $categoryId, 'user_id' => $user_id]
		);
    }

    function styleViewed($styleId, $user_id = null){
        DB::table('style_view')->insert(
		    ['style_id' => $styleId, 'user_id' => $user_id]
		);
    }

    function itemViewed($itemId, $user_id = null){
        DB::table('item_view')->insert(
		     ['item_id' => $itemId, 'user_id' => $user_id]
		 );
    }

    function designerViewed($designerId, $user_id = null){
        DB::table('designer_view')->insert(
             ['designer_id' => $itemId, 'user_id' => $user_id]
         );
    }

    function fabricViewed($fabricId, $user_id = null){
        DB::table('fabric_view')->insert(
		     ['fabric_id' => $fabricId, 'user_id' => $user_id]
		 );
    }

    function itemSearched($term, $results, $user_id = null){
        $last = DB::table('search_terms')
                ->where([['term', $term],['term', $user_id]])
                ->first();
        if(!isset($last))
            DB::table('search_terms')->insert(
    		    ['term' => $term, 'result' => $results, 'user_id' => $user_id]
    		);
    }

    function searchSuggestion($term){
        $terms = DB::table('search_terms')
                ->where('term', 'like', '%'.$term.'%')
                ->pluck('term')
                ->toArray();
                
        return array_unique($terms);
    }
}
