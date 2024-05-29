<?php

namespace HeimrichHannot\NewsRelocateBundle\News;

enum Relocate: string
{
    case NONE = 'none';
    case DEINDEX = 'deindex';
    case REDIRECT = 'redirect';
}