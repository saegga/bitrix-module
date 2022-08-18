<?
use Bitrix\Main;

IncludeModuleLangFile(__FILE__);

if(class_exists("sm_dev")) return;

Class sm_dev extends CModule{

	var $MODULE_ID = "sm.dev";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "N";
	var $PARTNER_NAME;
	var $PARTNER_URI;

	public function __construct()
	{
		$arModuleVersion = array();

		include(__DIR__.'/version.php');

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = GetMessage("SM_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("SM_MODULE_DESCRIPTION");

		$this->PARTNER_NAME = GetMessage("SM_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage('SM_PARTNER_URI');
	}

	function InstallEvents()
	{
		$eventManager = \Bitrix\Main\EventManager::getInstance();
		// тестовый обработчик для примера
		$eventManager->registerEventHandler("main", "OnEpilog", "sm.dev", "\\SM\\Dev\\Events\\Main", "defaultEventMethodRegister");

		return true;
	}

	function UnInstallEvents()
	{
		$eventManager = \Bitrix\Main\EventManager::getInstance();
		// тестовый обработчик для примера
		$eventManager->unRegisterEventHandler("main", "OnEpilog", "sm.dev", "\\SM\\Dev\\Events\\Main", "defaultEventMethodRegister");

		return true;
	}

	function DoInstall()
	{
		global $USER, $APPLICATION;

		if ($USER->IsAdmin())
		{
			if ($this->InstallDB())
			{
				$this->InstallEvents();
				// $this->InstallFiles();
			}
			
		}
	}
	function DoUninstall()
	{
		global $USER, $APPLICATION, $step;
		if ($USER->IsAdmin()){
			$step = (int)$step;
			if ($step < 2)
			{
				$APPLICATION->IncludeAdminFile(GetMessage("SM_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/local/modules/sm.dev/install/unstep1.php");
			}
			elseif ($step == 2){

				if (!empty($errorMessages))
				{
					$APPLICATION->ResetException();
					$APPLICATION->ThrowException(implode(' ', $errorMessages));
				}
				else
				{
					$this->UnInstallDB(array(
						"save_tables" => $_REQUEST["save_tables"],
					));
					//message types and templates
					if ($_REQUEST["save_templates"] != "Y")
					{
						//$this->UnInstallEvents();
					}
					$this->UnInstallEvents();
					
					$this->UnInstallFiles();
					$GLOBALS["errors"] = $this->errors;
				}
				$APPLICATION->IncludeAdminFile(GetMessage("SM_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/local/modules/sm.dev/install/unstep2.php");
			}
		}
	}

	
	function InstallDB($arParams = array())
	{
		global $DB, $DBType, $APPLICATION;
		$this->errors = false;
		// Database tables creation
		if (!$DB->Query("SELECT 'x' FROM sm_option_item WHERE 1=0", true))
		{
			$this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/local/modules/sm.dev/install/db/".mb_strtolower($DB->type)."/install.sql");
		}
		if ($this->errors !== false)
		{
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
		else
		{
			// $this->InstallTasks();
			RegisterModule("sm.dev");
			CModule::IncludeModule("sm.dev");
			// RegisterModuleDependences('iblock', 'OnIBlockPropertyBuildList', 'highloadblock', 'CIBlockPropertyDirectory', 'GetUserTypeDescription');
		}
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		global $DB, $DBType, $APPLICATION;
		$this->errors = false;
		if (!array_key_exists("save_tables", $arParams) || $arParams["save_tables"] != "Y")
		{
			// remove user data
			CModule::IncludeModule("sm.dev");

			// $result = \Bitrix\Highloadblock\HighloadBlockTable::getList();
			// while ($hldata = $result->fetch())
			// {
			// 	\Bitrix\Highloadblock\HighloadBlockTable::delete($hldata['ID']);
			// }

			//$this->UnInstallTasks();

			// remove hl system data
			$this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/local/modules/sm.dev/install/db/".mb_strtolower($DB->type)."/uninstall.sql");
		}

		UnRegisterModule("sm.dev");

		//UnRegisterModuleDependences("main", "OnBeforeUserTypeAdd", "highloadblock", '\Bitrix\Highloadblock\HighloadBlockTable', "OnBeforeUserTypeAdd");

		if ($this->errors !== false)
		{
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
		return true;
	}

	private function isVersionD7()
    {
        return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '14.00.00');
    }
}