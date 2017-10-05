<?php

namespace App\Transformers;

use App\Models\Image;
use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract {
	public function transform(Image $image) {
		return [
			'id' => $image->id,
			'url' => $image->url,
		];
	}
}