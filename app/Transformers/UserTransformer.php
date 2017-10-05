<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {
	public function transform(User $user) {
		return [
			'id' => $user->id,
			'name' => $user->name,
			'email' => $user->email,
			'username' => $user->username,
			'avatar' => $user->getAvatar(),
			'download_count' => $user->downloads->count(),
			'upload_count' => $user->items->count(),
			'like count' => $user->favorites->count(),
			'avatar' => $user->getAvatar(),
			'social' => $user->social,
			'created_at' => $user->social,
		];
	}
}