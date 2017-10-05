<?php

namespace App\Transformers;

use App\Models\Item;
use Illuminate\Support\Facades\App;
use League\Fractal\TransformerAbstract;

class ItemTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
		'images', 'categories', 'fabrics', 'styles', 'tags', 'colors',
	];
	protected $availableIncludes = [
		'user',
	];

	public function transform(Item $item) {
		return [
			'id' => (int) $item->id,
			'name' => $item->getName(),
			'description' => $item->description,
			'links' => [
				'self' => url('/') . '/item/' . $item->id,
			],
			'created_at' => $item->created_at->toDateTimeString(),
			'like_count' => (int) $item->favorites->count(),
			'downlaod_count' => (int) $item->downloads->count(),
			'comment count' => (int) $item->downloads->count(),
			'user_id' => (int) $item->getUserId(),
			'designer_id' => (int) $item->getDesignerId(),
			'rating' => $item->getAveRating(),
		];
	}

	public function includeImages(Item $item) {
		return $this->collection($item->images, App::make(ImageTransformer::class));
	}

	public function includeCategories(Item $item) {
		return $this->collection($item->categories, App::make(CategoryTransformer::class));
	}

	public function includeStyles(Item $item) {
		return $this->collection($item->styles, App::make(StyleTransformer::class));
	}

	public function includeFabrics(Item $item) {
		return $this->collection($item->fabrics, App::make(FabricTransformer::class));
	}

	public function includeColors(Item $item) {
		return $this->collection($item->colors, App::make(ColorTransformer::class));
	}

	public function includeTags(Item $item) {
		return $this->collection($item->tags, App::make(TagTransformer::class));
	}

	public function includeUser(Item $item) {
		if (!$item->user) {
			return;
		}

		return $this->item($item->user, App::make(UserTransformer::class));
	}
}