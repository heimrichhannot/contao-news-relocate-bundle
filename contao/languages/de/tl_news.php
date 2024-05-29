<?php
$lang = &$GLOBALS['TL_LANG']['tl_news'];

/*
 * Fields
 */
$lang['relocate'][0]                = 'Nachricht umziehen';
$lang['relocate'][1]                = 'Die Nachricht wird auf einen anderen Inhalt umgeleitet.';
$lang['relocateUrl'][0]             = 'Umleitungsziel';
$lang['relocateUrl'][1]             = 'Geben Sie die Ziel-URL für die Weiterleitung ein.';

/*
 * Reference
 */
$lang['reference']['relocate']['none']     = 'Inaktiv';
$lang['reference']['relocate']['deindex']  = 'Deindexierung (Pagerank geht verloren, Nachricht ist nicht mehr erreichbar)';
$lang['reference']['relocate']['redirect'] = 'Umzug (Pagerank wird auf Umleitungsziel übertragen, Nachricht bleibt erreichbar)';