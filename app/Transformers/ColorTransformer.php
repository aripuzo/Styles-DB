<?php

namespace App\Transformers;

use App\Models\Color;
use League\Fractal\TransformerAbstract;

class ColorTransformer extends TransformerAbstract {
	public function transform(Color $color) {
		return [
			'id' => $color->id,
			'name' => $color->name,
			'links' => [
				'self' => url('/api/') . 'items/colors/' . $color->id,
			],
		];
	}
}