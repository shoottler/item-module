<?php

namespace Modules\Item\Entities;

use App\Models\BaseModel;



abstract class BaseItem extends BaseModel
{
	protected $table = 'items';

	public static $rules = [];

	protected $fillable =
		[
			'company_id',
			'name',
			'description',
			'is_drafted'
		];
	protected static $persisted =
		[
			'company_id',
			'name',
			'description',
			'is_drafted'
		];
	public $searchableColumns = [
		'name','description'
	];
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $singleTableSubclasses = [
		// TODO: Iterate through the enabled modules that are items and put them here.
	];
}
