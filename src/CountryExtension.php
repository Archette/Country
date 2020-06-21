<?php

declare(strict_types=1);

namespace Archette\Country;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Rixafy\Country\CountryFacade;
use Rixafy\Country\CountryFactory;
use Rixafy\Country\CountryRepository;
use Rixafy\Country\Command\CountryUpdateCommand;

class CountryExtension extends CompilerExtension
{
	public function beforeCompile(): void
	{
		if (class_exists('Nettrine\ORM\DI\Helpers\MappingHelper')) {
			\Nettrine\ORM\DI\Helpers\MappingHelper::of($this)
				->addAnnotation('Rixafy\Country', __DIR__ . '/../../../rixafy/country');
		} else {
			/** @var ServiceDefinition $annotationDriver */
			$annotationDriver = $this->getContainerBuilder()->getDefinitionByType(MappingDriver::class);
			$annotationDriver->addSetup('addPaths', [['vendor/rixafy/country']]);
		}
	}

	public function loadConfiguration(): void
	{
		$this->getContainerBuilder()->addDefinition($this->prefix('countryFactory'))
			->setFactory(CountryFactory::class);

		$this->getContainerBuilder()->addDefinition($this->prefix('countryRepository'))
			->setFactory(CountryRepository::class);

		$this->getContainerBuilder()->addDefinition($this->prefix('countryFacade'))
			->setFactory(CountryFacade::class);

		$this->getContainerBuilder()->addDefinition($this->prefix('countryUpdateCommand'))
			->setFactory(CountryUpdateCommand::class)
			->addTag('console.command', 'rixafy:country:update');
	}
}
