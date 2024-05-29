<?php

namespace HeimrichHannot\NewsRelocateBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Contao\NewsBundle\ContaoNewsBundle;
use HeimrichHannot\NewsBundle\HeimrichHannotContaoNewsBundle;
use HeimrichHannot\NewsRelocateBundle\HeimrichHannotNewsRelocateBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

class Plugin implements BundlePluginInterface, ConfigPluginInterface
{

    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(HeimrichHannotNewsRelocateBundle::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class,
                    ContaoNewsBundle::class,
                    'news_plus',
                    HeimrichHannotContaoNewsBundle::class,
                ])
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig)
    {
        $loader->load('@HeimrichHannotNewsRelocateBundle/config/services.yaml');
    }
}