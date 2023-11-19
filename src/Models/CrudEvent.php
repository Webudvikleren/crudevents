<?php

namespace Webudvikleren\CrudEvents\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CrudEvent extends Model
{
	protected $guarded = [];
	protected $table = 'crud_events';

	public function scopePublic(Builder $query): void
	{
		$query->where('public', true);
	}
}