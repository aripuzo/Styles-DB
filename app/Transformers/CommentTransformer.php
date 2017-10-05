<?php

namespace App\Transformers;

use App\Models\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract {
	public function transform(Comment $comment) {
		return [
			'id' => $comment->id,
			'content' => $comment->text,
			'item_id' => $comment->item_id,
			'user_id' => $comment->user_id,
			'created_at' => $comment->created_at,
		];
	}
}