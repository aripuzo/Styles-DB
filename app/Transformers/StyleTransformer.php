<?php

namespace App\Transformers;

use App\Models\Style;
use League\Fractal\TransformerAbstract;

class StyleTransformer extends TransformerAbstract {
	public function transform(Style $style) {
		return [
			'id' => $style->id,
			'name' => $style->name,
			'parent_id' => $style->parent_id,
			'links' => [
				'self' => url('/api/') . 'items/styles/' . $style->id,
			],
		];
	}
}