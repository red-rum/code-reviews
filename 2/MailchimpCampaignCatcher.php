<?php

namespace App\Http\Middleware;

use Closure;

class MailchimpCampaignCatcher
{
	const MAILCHIMP_CAMPAIGN = 'mc_cid';
	const MAILCHIMP_SUBSCRIBER = 'mc_eid';

	public function handle($request, Closure $next)
	{
		if ($request->has(self::MAILCHIMP_CAMPAIGN))
		{
			$this->setCampaignSession($request);
		}

		if ($request->has(self::MAILCHIMP_SUBSCRIBER))
		{
			$this->setCampaignSubscriberSession($request);
		}

		return $next($request);
	}

	protected function setCampaignSession($request): Void
	{
		$campaign = $request->query(self::MAILCHIMP_CAMPAIGN);

		if (!empty($campaign))
		{
			$request->session()
				->put('campaign_id', $campaign);
		}
	}

	protected function setCampaignSubscriberSession($request): Void
	{
		$subscriber = $request->query(self::MAILCHIMP_SUBSCRIBER);

		if (!empty($subscriber))
		{
			$request->session()
				->put('campaign_subscriber_id', $subscriber);
		}
	}
}
