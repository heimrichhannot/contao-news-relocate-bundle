<?php

namespace HeimrichHannot\NewsRelocateBundle\Event;

use Contao\PageModel;
use Symfony\Contracts\EventDispatcher\Event;

class GenerateArticleUrlEvent extends Event
{
    public ?string $url = null;

    public function __construct(
        public readonly PageModel$page,
        public readonly array $article,
    )
    {
    }
}