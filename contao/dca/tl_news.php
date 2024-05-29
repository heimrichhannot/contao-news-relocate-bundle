<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use HeimrichHannot\NewsRelocateBundle\News\Relocate;

$dca = &$GLOBALS['TL_DCA']['tl_news'];

$apply = function (PaletteManipulator $pm) {
    $pm->applyToPalette('default', 'tl_news')
        ->applyToPalette('internal', 'tl_news')
        ->applyToPalette('article', 'tl_news')
        ->applyToPalette('external', 'tl_news');
};

$apply(PaletteManipulator::create()->removeField('relocate'));
$apply(PaletteManipulator::create()->addField('relocate', 'expert_legend', PaletteManipulator::POSITION_APPEND));

$dca['palettes']['__selector__'][] = 'relocate';

$dca['subpalettes']['relocate_deindex'] = 'relocateUrl';
$dca['subpalettes']['relocate_redirect'] = 'relocateUrl';

$fields = [
    'relocate' => [
        'inputType' => 'radio',
        'options' => array_column(Relocate::cases(), 'value'),
        'reference' => &$GLOBALS['TL_LANG']['tl_news']['reference']['relocate'],
        'exclude' => true,
        'filter' => true,
        'explanation' => 'relocate',
        'eval' => [
            'submitOnChange' => true,
            'tl_class' => 'clr',
            'helpwizard' => true,
        ],
        'sql' => "varchar(12) NOT NULL default 'none'",
    ],
    'relocateUrl' => [
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'dcaPicker' => true, 'tl_class' => 'full wizard'],
        'sql' => "varchar(255) NOT NULL default ''",
    ],
];

$dca['fields'] = array_merge($dca['fields'], $fields);