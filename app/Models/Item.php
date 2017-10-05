<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model {
	use SoftDeletes;

	public function styles() {
		return $this->belongsToMany('App\Models\Style', 'item_style')->withTimestamps();
	}

	public function categories() {
		return $this->belongsToMany('App\Models\Category', 'item_category')->withTimestamps();
	}

	public function fabrics() {
		return $this->belongsToMany('App\Models\Fabric', 'item_fabric');
	}

	public function tags() {
		return $this->belongsToMany('App\Models\Tag', 'item_tag');
	}

	public function bookmarks() {
		return $this->hasMany('App\Models\Bookmark');
	}

	public function comments() {
		return $this->hasMany('App\Models\Comment');
	}

	public function colors() {
		return $this->belongsToMany('App\Models\Color', 'item_color');
	}

	public function images() {
		return $this->hasMany('App\Models\Image');
	}

	public function ratings() {
		return $this->hasMany('App\Models\Rating');
	}

	public function downloads() {
		return $this->hasMany('App\Models\Download');
	}

	public function user() {
		return $this->belongsTo('App\Models\User');
	}

	public function designer() {
		return $this->belongsTo('App\Models\Designer');
	}

	public function favorites() {
		return $this->hasMany('App\Models\Favorite');
	}

	public function getName() {
		if (isset($this->name)) {
			return $this->name;
		}

		$name = '';
		if (isset($this->fabrics) && $this->fabrics->count() > 0) {
			$i = 0;
			foreach ($this->fabrics as $fabric) {
				if (($fabric->name != 'Sample' && $fabric->name != 'Plain') || $this->fabrics->count() > 1) {
					if ($i > 0) {
						if ($i == $this->fabrics->count() - 1) {
							$name .= 'and ';
						} else {
							$name .= ', ';
						}
					}

					$name .= $fabric->name . ' ';
					$i++;
				}
			}
		}
		if (isset($this->styles) && $this->styles->count() > 0) {
			$i = 0;
		}

		foreach ($this->styles as $style) {

			if ($i > 0) {
				if ($i == $this->styles->count() - 1) {
					$name .= 'and ';
				} else {
					$name .= ', ';
				}
			}

			$name .= $style->name . ' ';
			$i++;

		}
		return trim($name);
	}

	public function getSEOTitle() {
		return $this->categories->first()->name . ' | ' . $this->getName();
	}

	public function getURLName() {
		return urlencode($this->getName());
	}

	public function getURL() {
		return url('/') . '/item/' . $this->id;
	}

	public function getUserId() {
		if ($this->user) {
			return $this->user->id;
		}

		return 0;
	}

	public function getDesignerId() {
		if ($this->designer) {
			return $this->designer->id;
		}

		return 0;
	}

	public function getAveRating() {
		if ($this->ratings && $this->ratings->count() > 0) {
			return $this->ratings->avg('rating');
		}

		return 0;
	}

	public function getSEODescription() {
		return $this->description;
	}

	public function getSEOKeywords() {
		$keywords = array_merge($this->tags->pluck('name')->toArray(), array_merge($this->fabrics->pluck('name')->toArray(), array_merge($this->styles->pluck('name')->toArray(), array_merge($this->colors->pluck('name')->toArray(), config('seotools.meta.defaults.keywords')))));
		return $keywords;
	}

	public function getCategoriesLabel() {
		$s = '';
		$i = 0;
		foreach ($this->categories as $category) {
			if ($i > 0) {
				$s .= '<span>,</span></li>';
			}

			$s .= '<li>' . $category->name;
			$i++;
		}
		echo $s . '</li>';
	}

	public function getCategoryLabel() {
		return $this->categories->first()->name;
	}

	public function getFabricsLabel() {
		$s = '';
		$i = 0;
		foreach ($this->fabrics as $fabric) {
			if ($i > 0) {
				$s .= ', ';
			}

			$s .= $fabric->name;
			$i++;
		}
		return $s;
	}

	public function getDownloadsLabel() {
		return isset($this->downloads) && $this->downloads->sum('count') > 0 ? $this->downloads->sum('count') : '';
	}

	public function getBookmarksLabel() {
		return $this->bookmarks->count() > 0 ? $this->bookmarks->count() : '';
	}

	public function getLikesLabel() {
		return $this->favorites->count() > 0 ? $this->favorites->count() : '';
	}

	public function getCommentsLabel() {
		return $this->comments->count() > 0 ? $this->comments->count() : '';
		//https://graph.facebook.com/v2.4/?fields=share{comment_count}&amp;id=<YOUR_URL>
	}

	public function getCommentsLabelSingle() {
		return ($this->comments->count() > 0 ? $this->comments->count() : 'No') . ' comment(s)';
		//https://graph.facebook.com/v2.4/?fields=share{comment_count}&amp;id=<YOUR_URL>
	}

	public function getAverageRating() {
		return $this->ratings->avg('rating');
	}

	public function getImage() {
		// if(isset($this->images->first()->image_id))
		//     return Cloudder::show($this->images->first()->image_id);
		if (isset($this->images->first()->url)) {
			return $this->images->first()->url;
		}

	}

	public function getUserName() {
		if (isset($this->user)) {
			return $this->user->getName();
		} else {
			return 'Shakara';
		}

	}

	public function getUserLink() {
		if (isset($this->user)) {
			return $this->user->getLink();
		} else {
			return '#';
		}

	}

	public function getCreatedAt() {
		$dt = Carbon::parse($this->created_at);
		//return $this->created_at;
		return $dt->toFormattedDateString();
	}

	public function getDesigner() {
		if (isset($this->designer)) {
			return $this->designer;
		} else {
			return null;
		}

	}

}
