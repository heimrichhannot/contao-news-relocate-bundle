<?php

namespace HeimrichHannot\NewsRelocateBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use HeimrichHannot\NewsBundle\HeimrichHannotContaoNewsBundle;
use HeimrichHannot\NewsRelocateBundle\HeimrichHannotNewsRelocateBundle;

class Plugin implements BundlePluginInterface
{

    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(HeimrichHannotNewsRelocateBundle::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class,
                    'news_plus',
                    HeimrichHannotContaoNewsBundle::class,
                ])
        ];
    }
}