<?php

namespace HeimrichHannot\NewsRelocateBundle\EventListener;

use Contao\Config;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Contao\NewsModel;
use Contao\Search;
use HeimrichHannot\NewsRelocateBundle\News\Relocate;
use Symfony\Component\HttpFoundation\RequestStack;

class NewsArticleListener
{
    private bool $valueHasChanged = false;

    public function __construct(
        private readonly RequestStack $requestStack,
    )
    {
    }

    #[AsCallback(table: 'tl_news', target: 'config.onload')]
    public function onConfigLoadCallback(DataContainer $dc = null): void
    {
        if (!$dc || ! $dc->id || ($model = NewsModel::findByPk($dc->id)) === null) {
            return;
        }

        if (Relocate::DEINDEX->value === $model->relocate) {
            if ($model->robots == 'noindex,nofollow') {
                $GLOBALS['TL_DCA']['tl_news']['fields']['robots']['eval']['disabled'] = true;
            }
        }

    }

    #[AsCallback(table: 'tl_news', target: 'config.onsubmit')]
    public function onConfigSubmitCallback(DataContainer $dc): void
    {
        if (!$dc->id) {
            return;
        }

        $model = NewsModel::findByPk($dc->id);
        if (null === $model) {
            return;
        }

        $model->refresh();
        if (Relocate::DEINDEX->value === $model->relocate) {
            if ($model->robots !== 'noindex,nofollow') {
                $model->robots = 'noindex,nofollow';
                $model->save();
            }

            if ($this->valueHasChanged) {
                $url = $model->getRelated('pid')?->getRelated('jumpTo')
                    ?->getAbsoluteUrl(sprintf(
                        Config::get('useAutoItem') ? '/%s' : '/items/%s',
                        $model->alias
                    ));
                if ($url) {
                    Search::removeEntry($url);
                }
            }
        }
    }

    #[AsCallback(table: 'tl_news', target: 'fields.relocate.save')]
    public function onFieldsRelocateSaveCallback(mixed $value, DataContainer $dc): mixed
    {
        $model = NewsModel::findByPk($dc->id);
        if (null === $model) {
            return $value;
        }

        if ($model->relocate !== $value) {
            $this->valueHasChanged = true;
        }

        return $value;
    }
}