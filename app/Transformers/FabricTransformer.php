<?php

namespace App\Transformers;

use App\Models\Fabric;
use League\Fractal\TransformerAbstract;

class FabricTransformer extends TransformerAbstract {
	public function transform(Fabric $fabric) {
		return [
			'id' => $fabric->id,
			'name' => $fabric->name,
			'links' => [
				'self' => url('/api/') . 'items/fabrics/' . $fabric->id,
			],
		];
	}
}