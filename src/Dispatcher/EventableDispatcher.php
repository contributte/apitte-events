<?php

namespace Apitte\Events\Dispatcher;

use Apitte\Core\Dispatcher\IDispatcher;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Apitte\Events\Event\FallbackEvent;
use Apitte\Events\Event\HandleEvent;
use Apitte\Events\Event\RouteEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventableDispatcher implements IDispatcher
{

	/** @var EventDispatcherInterface */
	private $dispatcher;

	/**
	 * @param EventDispatcherInterface $dispatcher
	 */
	public function __construct(EventDispatcherInterface $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}

	/**
	 * @param ApiRequest $request
	 * @param ApiResponse $response
	 * @return ApiResponse
	 */
	public function dispatch(ApiRequest $request, ApiResponse $response)
	{
		/** @var RouteEvent $routeEvent */
		$routeEvent = $this->dispatcher->dispatch(new RouteEvent($request, $response));

		// Early termination?
		if ($routeEvent->isTerminated()) return $routeEvent->getResponse();

		// If there is no match route <=> endpoint,
		if (!$routeEvent->isMatched()) {
			/** @var FallbackEvent $fallbackEvent */
			$fallbackEvent = $this->dispatcher->dispatch(new FallbackEvent($routeEvent->getRequest(), $routeEvent->getResponse()));

			if ($fallbackEvent->isTerminated()) return $fallbackEvent->getResponse();
		}

		/** @var HandleEvent $event */
		$handleEvent = $this->dispatcher->dispatch(new HandleEvent($request, $response));
	}

	/**
	 * @param ApiRequest $request
	 * @param ApiResponse $response
	 * @return ApiResponse
	 */
	protected function handle(ApiRequest $request, ApiResponse $response)
	{
		return $this->handler->handle($request, $response);
	}

	/**
	 * @param ApiRequest $request
	 * @param ApiResponse $response
	 * @return ApiResponse
	 */
	protected function fallback(ApiRequest $request, ApiResponse $response)
	{

		return $response;
	}

}
