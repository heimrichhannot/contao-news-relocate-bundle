<?php

namespace HeimrichHannot\NewsRelocateBundle\EventListener;

use Contao\Config;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Database;
use Contao\PageModel;
use HeimrichHannot\NewsRelocateBundle\Event\GenerateArticleUrlEvent;
use HeimrichHannot\NewsRelocateBundle\News\Relocate;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsHook('getSearchablePages', priority: -1)]
class GetSearchablePagesListener
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(array $pages, $rootId = 0, bool $isSitemap = false, string $language = null): array
    {
        if (!$isSitemap) {
            return $pages;
        }

        $result = Database::getInstance()
            ->prepare('SELECT id,pid,alias,published FROM tl_news WHERE relocate = ? AND robots != ? AND published = ?')
            ->execute(Relocate::DEINDEX->value, 'noindex,nofollow', '1');

        if ($result->numRows < 1) {
            return $pages;
        }

        while ($article = $result->fetchAssoc()) {
            $pageId = Database::getInstance()
                ->prepare('SELECT jumpTo FROM tl_news_archive WHERE id = ?')
                ->execute($article['pid']);
            if ($pageId->numRows < 1) {
                continue;
            }
            $page = PageModel::findByPk($pageId->fetchEach('jumpTo')[0]);
            if (!$page) {
                continue;
            }

            /** @var GenerateArticleUrlEvent $event */
            $event = $this->eventDispatcher->dispatch(new GenerateArticleUrlEvent($page, $article));

            if (!$event->url) {
                $url = $page->getAbsoluteUrl(sprintf(
                    Config::get('useAutoItem') ? '/%s' : '/items/%s',
                    $article['alias']
                ));
            } else {
                $url = $event->url;
            }

            if ($url) {
                if (false !== ($key = array_search($url, $pages))) {
                    unset($pages[$key]);
                }
            }
        }

        return $pages;
    }
}