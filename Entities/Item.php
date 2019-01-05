<?php

namespace Modules\Item\Entities;

use Cog\Flag\Traits\Classic\HasActiveFlag;
use Cog\Flag\Traits\Classic\HasVerifiedFlag;
use Cog\Flag\Traits\Inverse\HasDraftedFlag;

class Item extends BaseItem
{
	use HasDraftedFlag;
	use HasActiveFlag;
	use HasVerifiedFlag;

	protected static $singleTableType = Item::class;

	/**
	 * Set the Verified flag to not apply on global
	 * @return bool
	 */
	public function shouldApplyVerifiedFlagScope()
	{
		return false;
	}

	/**
	 * Set the Drafted flag to not apply on global
	 * @return bool
	 */
	public function shouldApplyDraftedFlagScope()
	{
		return false;
	}
}
