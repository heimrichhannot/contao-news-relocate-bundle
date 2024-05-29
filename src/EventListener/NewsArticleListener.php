<?php

namespace HeimrichHannot\NewsRelocateBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Contao\NewsModel;
use HeimrichHannot\NewsRelocateBundle\News\Relocate;

class NewsArticleListener
{
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

        if (Relocate::DEINDEX->value === $model->relocate) {
            $model->robots = 'noindex,nofollow';
            $model->save();
        }
    }
}