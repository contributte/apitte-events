<?php

namespace Apitte\Events\Event;

use Apitte\Core\Schema\Endpoint;

class RouteEvent extends BaseCycleEvent
{

	/** @var Endpoint */
	protected $endpoint;

	/**
	 * @return bool
	 */
	public function isMatched()
	{
		return $this->endpoint !== NULL;
	}

	/**
	 * @param Endpoint $endpoint
	 */
	public function match(Endpoint $endpoint)
	{
		$this->endpoint = $endpoint;
	}

	/**
	 * @return Endpoint
	 */
	public function getEndpoint()
	{
		return $this->endpoint;
	}

}
