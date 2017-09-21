<?php

namespace Apitte\Events\Event;

use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;

class BaseCycleEvent extends AbstractEvent
{
	/** @var ApiRequest */
	protected $request;

	/** @var ApiResponse */
	protected $response;

	/** @var bool */
	protected $terminated = FALSE;

	/**
	 * @param ApiRequest $request
	 * @param ApiResponse $response
	 */
	public function __construct(ApiRequest $request, ApiResponse $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	/**
	 * GETTERS/SETTERS *********************************************************
	 */

	/**
	 * @return ApiRequest
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * @return ApiResponse
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * @return bool
	 */
	public function isTerminated()
	{
		return $this->terminated;
	}

	/**
	 * @param ApiResponse $response
	 * @return void
	 */
	public function terminate(ApiResponse $response)
	{
		$this->terminated = TRUE;
		$this->response = $response;
	}

}
