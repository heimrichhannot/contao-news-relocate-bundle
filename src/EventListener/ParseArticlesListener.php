<?php

namespace HeimrichHannot\NewsRelocateBundle\EventListener;

use Contao\Controller;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\InsertTag\InsertTagParser;
use Contao\FrontendTemplate;
use Contao\Module;
use HeimrichHannot\UtilsBundle\Util\Utils;
use ModuleNewsReader;

#[AsHook('parseArticles', priority: 128)]
class ParseArticlesListener
{
    public function __construct(
        private readonly InsertTagParser $insertTagParser,
        private readonly Utils $utils,

    )
    {
    }

    public function __invoke(FrontendTemplate $template, array $newsEntry, Module $module): void
    {
        if (!$module instanceof ModuleNewsReader) {
            return;
        }

        $article = (object) $newsEntry;

        if (!$article->relocate || $article->relocate == 'none') {
            return;
        }

        $page = $this->utils->request()->getCurrentPageModel();

        $page->noSearch = true;

        $url = $this->insertTagParser->replaceInline($article->relocateUrl);

        if (!$url) {
            return;
        }

        switch ($article->relocate) {
            case 'deindex':
                $page->robots = 'noindex,nofollow';
                Controller::redirect($url);
                break;
            case 'redirect':
                // news article is still available, but google index will transfer page rank to new url
                $this->container->get('huh.head.tag.link_canonical')->setContent($url);
                break;
        }



        return;
    }
}