<?php

namespace Apitte\Events\DI;

use Apitte\Core\DI\AbstractPlugin;
use Apitte\Core\DI\ApiExtension;
use Apitte\Events\Dispatcher\EventableDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventsPlugin extends AbstractPlugin
{

	const PLUGIN_NAME = 'events';

	/**
	 * @param ApiExtension $extension
	 */
	public function __construct(ApiExtension $extension)
	{
		parent::__construct($extension);
		$this->name = self::PLUGIN_NAME;
	}

	/**
	 * Register services
	 *
	 * @return void
	 */
	public function loadPluginConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->getDefinition($this->extension->prefix('core.dispatcher'))
			->setFactory(EventableDispatcher::class);

		$builder->addDefinition($this->prefix('dispatcher'))
			->setClass(EventDispatcher::class);
	}

}
