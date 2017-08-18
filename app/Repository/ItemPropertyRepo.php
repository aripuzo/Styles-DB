<?php


namespace App\Repository;

use App\Models\Item;
use App\Models\Style;
use App\Models\Fabric;
use App\Models\Color;
use App\Models\Image;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Designer;
use Illuminate\Support\Facades\DB;

use App\Repository\Contracts\ItemPropertyRepository;

class ItemPropertyRepo implements ItemPropertyRepository{
	function addStyle($styleData) {
        $style = new Style;
        $style->name = $styleData['name'];
        $style->slug = $styleData['slug'];
        $style->save();
        return $style;
    }

    function addItemStyle($itemId, $styleId) { 
    	// $itemStyle = new ItemStyle;
	    // $itemStyle->item_id = $itemId;
	    // $itemStyle->style_id = $styleId;
	    // $itemStyle->save();
        DB::table('item_style')->insert(
            ['style_id' => $styleId, 'item_id' => $itemId]
        );
    }

    function getStyle($styleId) {
        return Style::find($styleId);
    }

    function getStyleBySlug($slug) {
        return Style::where('slug', $slug)->first();
    }

    function getStyleByName($name) {
        return Style::where('name', $name)->first();
    }

    function addColor($colorData) {
        $color = new Color;
        $color->name = $colorData['name'];
        $color->slug = $colorData['slug'];
        $color->save();
        return $color;
    }

    function addItemColor($itemId, $colorId) { 
    	DB::table('item_color')->insert(
            ['color_id' => $colorId, 'item_id' => $itemId]
        );
    }

    function getColor($colorId) {
        return Color::find($colorId);
    }

    function getColorByName($name) {
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
    	DB::table('item_tag')->insert(
            ['tag_id' => $tagId, 'item_id' => $itemId]
        );
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
    	DB::table('item_fabric')->insert(
            ['fabric_id' => $fabricId, 'item_id' => $itemId]
        );
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

    function addCategory($categoryData) { // example code .. define update here and put your codes
        $category = new Category;
        $category->name = $categoryData['name'];
        $category->slug = $categoryData['slug'];
        $category->save();
        return $category;
    }

    function addItemCategory($itemId, $categoryId) { 
    	DB::table('item_category')->insert(
            ['category_id' => $categoryId, 'item_id' => $itemId]
        );
    }

    function getCategoryBySlug($slug) { // example code .. define update here and put your codes
        return Category::where('slug', $slug)->first();
    }

    function getCategoryByName($name) { // example code .. define update here and put your codes
        return Category::where('name', $name)->first();
    }

    function addImage($itemId, $url, $imageId = null) { 
    	$image = new Image;
	    $image->item_id = $itemId;
	    $image->url = $url;
        if(!empty($imageId))
            $image->image_id = $imageId;
	    $image->save();
    }

    function getDesignerByName($name) { // example code .. define update here and put your codes
        return Designer::where('name', $name)->first();
    }

    function addDesigner($designerData) { // example code .. define update here and put your codes
        $designer = new Designer;
        $designer->name = $designerData['name'];
        $designer->slug = $designerData['slug'];
        $designer->save();
        return $designer;
    }
}
