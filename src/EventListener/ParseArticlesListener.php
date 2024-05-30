<?php

namespace HeimrichHannot\NewsRelocateBundle\EventListener;

use Contao\Controller;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\InsertTag\InsertTagParser;
use Contao\CoreBundle\Routing\ResponseContext\HtmlHeadBag\HtmlHeadBag;
use Contao\CoreBundle\Routing\ResponseContext\ResponseContextAccessor;
use Contao\FrontendTemplate;
use Contao\Module;
use Contao\ModuleNewsReader;
use HeimrichHannot\NewsRelocateBundle\News\Relocate;
use HeimrichHannot\UtilsBundle\Util\Utils;

#[AsHook('parseArticles', priority: 128)]
class ParseArticlesListener
{
    public function __construct(
        private readonly InsertTagParser $insertTagParser,
        private readonly Utils $utils,
        private readonly ResponseContextAccessor $responseContextAccessor,
    ) {
    }

    public function __invoke(FrontendTemplate $template, array $newsEntry, Module $module): void
    {
        if (!$module instanceof ModuleNewsReader) {
            return;
        }

        $article = (object) $newsEntry;

        if (!$article->relocate || $article->relocate == Relocate::NONE->value) {
            return;
        }

        $page = $this->utils->request()->getCurrentPageModel();

        $url = $this->insertTagParser->replaceInline($article->relocateUrl);

        if (!$url) {
            return;
        }

        switch ($article->relocate) {
            case Relocate::DEINDEX->value:
                $page->robots = 'noindex,nofollow';
                $page->noSearch = true;
                Controller::redirect($url);
            case Relocate::REDIRECT->value:
                // news article is still available, but google index will transfer page rank to new url
                $this->responseContextAccessor->getResponseContext()?->get(HtmlHeadBag::class)?->setCanonicalUri($url);
                break;
        }
    }
}