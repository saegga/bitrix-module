<?
require_once 'constants.php';

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler("main", "onEpilog", array("\Sm\Dev\Events\Main", "defaultEventMethod"));