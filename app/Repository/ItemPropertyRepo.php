<?php

namespace App\Repository;

use App\Models\Category;
use App\Models\Color;
use App\Models\Designer;
use App\Models\Fabric;
use App\Models\Image;
use App\Models\Style;
use App\Models\Tag;
use App\Repository\Contracts\ItemPropertyRepository;
use Illuminate\Support\Facades\DB;

/**
 * Repo class for database operations of all Item properties
 */
class ItemPropertyRepo implements ItemPropertyRepository {
	function addStyle($styleData) {
		$style = new Style;
		$style->name = $styleData['name'];
		$style->slug = $styleData['slug'];
		if (isset($styleData['parent_id'])) {
			$style->parent_id = $styleData['parent_id'];
		}

		$style->save();
		return $style;
	}

	function addItemStyle($itemId, $styleId) {
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

	function addTag($tagData) {
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

	function getTag($tagId) {
		return Tag::find($tagId);
	}

	function getTagByName($name) {
		return Tag::where('name', $name)->first();
	}

	function addFabric($fabricData) {
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

	function getFabric($fabricId) {
		return Fabric::find($fabricId);
	}

	function getFabricByName($name) {
		return Fabric::where('name', $name)->first();
	}

	function getCategory($categoryId) {
		return Category::find($categoryId);
	}

	function addCategory($categoryData) {
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

	function getCategoryBySlug($slug) {
		return Category::where('slug', $slug)->first();
	}

	function getCategoryByName($name) {
		return Category::where('name', $name)->first();
	}

	function getImageByUrl($url) {
		return Image::where('url', $url)->first();
	}

	function addImage($itemId, $url, $imageId = null) {
		$image = new Image;
		$image->item_id = $itemId;
		$image->url = $url;
		if (!empty($imageId)) {
			$image->image_id = $imageId;
		}

		$image->save();
	}

	function getDesignerByName($name) {
		return Designer::where('name', $name)->first();
	}

	function addDesigner($designerData) {
		$designer = new Designer;
		$designer->name = $designerData['name'];
		$designer->slug = $designerData['slug'];
		$designer->save();
		return $designer;
	}

	static function getStyles($categoryId = null) {
		if (!isset($categoryId) || $categoryId == 0) {
			return Style::whereNull('parent_id')->get();
		} else {
			$styles = Style::whereNull('parent_id')->get();
			$selected = [];
			foreach ($styles as $key => $style) {
				if ($style->hasCategoryItems($categoryId)) {
					$selected[] = $styles->pull($key);
				}
			}
			return $selected;
		}
	}

	static function getFabrics($categoryId = null) {
		if (!isset($categoryId) || $categoryId == 0) {
			return Fabric::get();
		} else {
			$fabrics = Fabric::get();
			$selected = [];
			foreach ($fabrics as $key => $fabric) {
				if ($fabric->hasCategoryItems($categoryId)) {
					$selected[] = $fabrics->pull($key);
				}
			}
			return $selected;
		}
	}

	static function getCategories() {
		return Category::get();
	}
}
