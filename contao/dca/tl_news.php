<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$dca = &$GLOBALS['TL_DCA']['tl_news'];

PaletteManipulator::create()
    ->addField('relocate', 'expert_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_news')
    ->applyToPalette('internal', 'tl_news')
    ->applyToPalette('article', 'tl_news')
    ->applyToPalette('external', 'tl_news')
;

$dca['palettes']['__selector__'][] = 'relocate';

$dca['subpalettes']['relocate_deindex'] = 'relocateUrl';
$dca['subpalettes']['relocate_redirect'] = 'relocateUrl';

$fields = [
    'relocate' => [
        'label' => &$GLOBALS['TL_LANG']['tl_news']['relocate'],
        'inputType' => 'radio',
        'options' => ['none', 'deindex', 'redirect'],
        'reference' => &$GLOBALS['TL_LANG']['tl_news']['reference']['relocate'],
        'exclude' => true,
        'sql' => "varchar(12) NOT NULL default 'none'",
        'eval' => ['submitOnChange' => true],
    ],
    'relocateUrl' => [
        'label' => &$GLOBALS['TL_LANG']['tl_news']['relocateUrl'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'text',
        'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'dcaPicker' => true, 'tl_class' => 'full wizard'],
        'sql' => "varchar(255) NOT NULL default ''",
    ],
];

$dca['fields'] = array_merge($dca['fields'], $fields);