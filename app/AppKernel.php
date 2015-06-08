<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new Payum\Bundle\PayumBundle\PayumBundle(),
            new Nelmio\CorsBundle\NelmioCorsBundle(),

            // NAD bundles
            new NAD\FrontendUserBundle\NADFrontendUserBundle(),
            new NAD\BackendUserBundle\NADBackendUserBundle(),
            new NAD\PageBundle\NADPageBundle(),
            new NAD\SearchBundle\NADSearchBundle(),
            new NAD\ProductBundle\NADProductBundle(),
            new NAD\CartBundle\NADCartBundle(),
            new NAD\OrderBundle\NADOrderBundle(),
            new NAD\NavigationBundle\NADNavigationBundle(),
            new NAD\AddressingBundle\NADAddressingBundle(),
            new NAD\ContactBundle\NADContactBundle(),
            new NAD\ConfigBundle\NADConfigBundle(),
            new NAD\SitemapBundle\NADSitemapBundle(),
            new NAD\ResourceBundle\NADResourceBundle(),
            new NAD\FixtureBundle\NADFixtureBundle(),

        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}