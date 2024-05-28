<?php

namespace HeimrichHannot\NewsRelocateBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\FrontendTemplate;
use Contao\Module;

#[AsHook('parseArticles', priority: 128)]
class ParseArticlesListener
{
    public function __invoke(FrontendTemplate $template, array $newsEntry, Module $module): void
    {

    }
}