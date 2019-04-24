<?php

declare(strict_types=1);

namespace Archette\Country;

use Doctrine\Common\Persistence\Mapping\Driver\AnnotationDriver;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Rixafy\Country\CountryFacade;
use Rixafy\Country\CountryFactory;
use Rixafy\Country\CountryRepository;

class CountryExtension extends CompilerExtension
{
	public function beforeCompile()
	{
		/** @var ServiceDefinition $annotationDriver */
		$annotationDriver = $this->getContainerBuilder()->getDefinitionByType(AnnotationDriver::class);
		$annotationDriver->addSetup('addPaths', [['vendor/rixafy/country']]);
	}

	public function loadConfiguration()
	{
		$this->getContainerBuilder()->addDefinition($this->prefix('countryFactory'))
			->setFactory(CountryFactory::class);

		$this->getContainerBuilder()->addDefinition($this->prefix('countryRepository'))
			->setFactory(CountryRepository::class);

		$this->getContainerBuilder()->addDefinition($this->prefix('countryFacade'))
			->setFactory(CountryFacade::class);
	}
}