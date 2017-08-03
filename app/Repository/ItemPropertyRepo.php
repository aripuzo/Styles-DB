<?php


namespace App\Repository;

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

use App\Repository\Contracts\ItemPropertyRepository;

class ItemPropertyRepo implements ItemPropertyRepository{
	function addStyle($styleData) { // example code .. define update here and put your codes
        $style = new Style;
        $style->name = $styleData['name'];
        $style->slug = $styleData['slug'];
        $style->save();
        return $style;
    }

    function addItemStyle($itemId, $styleId) { 
    	$itemStyle = new ItemStyle;
	    $itemStyle->item_id = $itemId;
	    $itemStyle->style_id = $styleId;
	    $itemStyle->save();
    }

    function getStyle($styleId) { // example code .. define update here and put your codes
        return Style::find($styleId);
    }

    function getStyleBySlug($slug) { // example code .. define update here and put your codes
        return Style::where('slug', $slug)->first();
    }

    function getStyleByName($name) { // example code .. define update here and put your codes
        return Style::where('name', $name)->first();
    }

    function addColor($colorData) { // example code .. define update here and put your codes
        $color = new Color;
        $color->name = $colorData['name'];
        $color->slug = $colorData['slug'];
        $color->save();
        return $color;
    }

    function addItemColor($itemId, $colorId) { 
    	$itemColor = new ItemColor;
	    $itemColor->item_id = $itemId;
	    $itemColor->color_id = $colorId;
	    $itemColor->save();
    }

    function getColor($colorId) { // example code .. define update here and put your codes
        return Color::find($colorId);
    }

    function getColorByName($name) { // example code .. define update here and put your codes
        return Color::where('name', $name)->first();
    }

    function addTag($tagData) { // example code .. define update here and put your codes
        $tag = new Tag;
        $tag->name = $tagData['name'];
        $tag->slug = $tagData['slug'];
        $tag->save();
        return $tag;
    }

    function addItemTag($itemId, $tagId) { 
    	$itemTag = new ItemTag;
	    $itemTag->item_id = $itemId;
	    $itemTag->tag_id = $tagId;
	    $itemTag->save();
    }

    function getTag($tagId) { // example code .. define update here and put your codes
        return Tag::find($tagId);
    }

    function getTagByName($name) { // example code .. define update here and put your codes
        return Tag::where('name', $name)->first();
    }

    function addFabric($fabricData) { // example code .. define update here and put your codes
        $fabric = new Fabric;
        $fabric->name = $fabricData['name'];
        $fabric->slug = $fabricData['slug'];
        $fabric->save();
        return $fabric;
    }

    function addItemFabric($itemId, $fabricId) { 
    	$itemFabric = new ItemFabric;
	    $itemFabric->item_id = $itemId;
	    $itemFabric->fabric_id = $fabricId;
	    $itemFabric->save();
    }

    function getFabric($fabricId) { // example code .. define update here and put your codes
        return Fabric::find($fabricId);
    }

    function getFabricByName($name) { // example code .. define update here and put your codes
        return Fabric::where('name', $name)->first();
    }

    function getCategory($categoryId) { // example code .. define update here and put your codes
        return Category::find($categoryId);
    }

    function addItemCategory($itemId, $categoryId) { 
    	$itemCategory = new ItemCategory;
	    $itemCategory->item_id = $itemId;
	    $itemCategory->category_id = $categoryId;
	    $itemCategory->save();
    }

    function getCategoryBySlug($slug) { // example code .. define update here and put your codes
        return Category::where('slug', $slug)->first();
    }

    function addImage($itemId, $url) { 
    	$image = new Image;
	    $image->item_id = $itemId;
	    $image->url = $url;
	    $image->save();
    }
}
