<?php
$lang = &$GLOBALS['TL_LANG']['tl_news'];

/*
 * Fields
 */
$lang['relocate'][0]                = 'Relocate article';
$lang['relocate'][1]                = 'The article will be redirected to another content.';
$lang['relocateUrl'][0]             = 'Redirect target';
$lang['relocateUrl'][1]             = 'Enter the target URL for the redirection.';

/*
 * Reference
 */
$lang['reference']['relocate']['none']     = 'Inactive';
$lang['reference']['relocate']['deindex']  = 'Deindexing (Pagerank is lost, article is no longer accessible)';
$lang['reference']['relocate']['redirect'] = 'Relocation (Pagerank is transferred to the redirection target, article remains accessible)';