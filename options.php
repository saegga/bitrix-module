<?
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

$module_id = 'sm.dev';

if (!Loader::includeModule($module_id))
{
	return;
}


$context = Application::getInstance()->getContext();
$request = $context->getRequest();
$docRoot = $context->getServer()->getDocumentRoot();

Loc::loadMessages($docRoot . BX_ROOT . "/modules/main/options.php");
Loc::loadMessages(__FILE__);

$tabs = [
	[
		"DIV" => "edit1",
		"TAB" => Loc::getMessage("SM_TAB_SET"),
		"TITLE" => Loc::getMessage("SM_TAB_TITLE_SET"),
	],
];

$tabControl = new CAdminTabControl("tabControl", $tabs);


$backUrl = $request->get('back_url_settings');
$arDefaultValues = array(
	'BLOCK_NEW_USER_LF_SITE' => 'N',
);
$allOptions = [
	[
		'CODE' => 'enable_active',
		'NAME' => Loc::getMessage('SM_ENABLE_ACTIVE') . ':',
		'PARAMS' => [
			'TYPE' => 'checkbox'
		]
	],
];
$filterOptions = [
	[
		'CODE' => 'client_id',
		'NAME' => Loc::getMessage('REST_OPT_LOG_FILTER_CLIENT_ID') . ' (client_id):',
		'SIZE' => 45,
	],
	[
		'CODE' => 'password_id',
		'NAME' => Loc::getMessage('REST_OPT_LOG_FILTER_PASSWORD_ID') . ' (password_id):',
		'SIZE' => 45,
	],
	[
		'CODE' => 'scope',
		'NAME' => Loc::getMessage('REST_OPT_LOG_FILTER_SCOPE') . ' (scope):',
		'SIZE' => 12,
	],
	[
		'CODE' => 'method',
		'NAME' => Loc::getMessage('REST_OPT_LOG_FILTER_METHOD') . ' (method):',
		'SIZE' => 45,
	],
	[
		'CODE' => 'user_id',
		'NAME' => Loc::getMessage('REST_OPT_LOG_FILTER_USER_ID') . ' (user_id):',
		'SIZE' => 6,
	],
];

// post save
if ($Apply.$RestoreDefaults <> '' && \check_bitrix_sessid())
{
	if ($RestoreDefaults <> '')
	{
		include_once('default_option.php');
		if (is_array($sm_default_option))
		{
			foreach ($sm_default_option as $option => $value)
			{
				\COption::setOptionString($module_id, $option, $value);
			}
		}
	}
	else
	{
		foreach ($allOptions as $option)
		{
			if ($option[0] == 'header')
			{
				continue;
			}

			$code = $option['CODE'];
			$val = ${$code};
			$val = trim($val);

			switch ($option['PARAMS']['TYPE']):
				case 'checkbox':
					if ($val <> 'Y')
					{
						$val = 'N';
					}
					break;
				case 'float':
					$precision = $option['PARAMS']['PRECISION'] ? : 0;
					$val = round($val, $precision);
					break;
			endswitch;

			if($option['PARAMS']['ABS'] && $option['PARAMS']['ABS'] == 'Y')
			{
				$val = abs($val);
			}

			\COption::setOptionString($module_id, $code, $val);
		}

		if ($_REQUEST["clear_data"] === "y")
		{
			// \Bitrix\Rest\LogTable::clearAll();
		}

		if (array_key_exists('ACTIVE', $_REQUEST))
		{
			$ACTIVE = intval($_REQUEST['ACTIVE']);
			if ($ACTIVE > 0 && $ACTIVE <= 86400)
			{
				\COption::setOptionString($module_id, 'log_end_time', time() + $ACTIVE);
			}
			else
			{
				\COption::removeOption($module_id, 'log_end_time');
			}
		}

		$filters = array();
		foreach ($filterOptions as $option)
		{
			$val = trim($_REQUEST["log_filters"][$option["CODE"]]);
			if ($val)
			{
				$filters[$option["CODE"]] = $val;
			}
		}
		\COption::setOptionString($module_id, "log_filters", serialize($filters));
	}

	\LocalRedirect(
		$APPLICATION->GetCurPage() .
		'?mid=' . urlencode($mid) .
		'&lang=' . urlencode(LANGUAGE_ID) .
		'&back_url_settings=' . urlencode($backUrl) .
		'&' . $tabControl->ActiveTabParam());
}

$tabControl->Begin();
?>

<form method="post" name="sm_mod_form" action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?=urlencode($mid)?>&amp;lang=<? echo LANGUAGE_ID ?>">
	<? echo bitrix_sessid_post(); ?>
	<?
	    $tabControl->BeginNextTab();
	?>

    	<? foreach($allOptions as $option): ?>
		<? if ($option['CODE'] == 'header'):?>
			<tr class="heading">
				<td colspan="2">
					<?= $option['NAME'];?>
				</td>
			</tr>
			<?if (isset($option['PARAMS'])):?>
				<tr>
					<td></td>
					<td>
						<?
						echo BeginNote();
						echo $option['PARAMS'];
						echo EndNote();
						?>
					</td>
				</tr>
			<?endif;?>
			<? continue;
		endif;
		?>
		<?
			$params = $option['PARAMS'];
			$val = \COption::getOptionString(
				$module_id,
				$option['CODE'],
				isset($option['DEFAULT']) ? $option['DEFAULT'] : null
			);
		?>
		<tr>
			<td valign="top" width="40%"><?
				if ($params['TYPE'] == 'checkbox')
				{
					echo '<label for="' . \htmlspecialcharsbx($option['CODE']) . '">'.$option['NAME'].'</label>';
				}
				else
				{
					echo $option['NAME'];
				}
				?></td>
			<td valign="middle" width="60%">
				<? if ($params['TYPE'] == 'checkbox'): ?>
					<input
						type="checkbox"
						name="<?=\htmlspecialcharsbx($option['CODE'])?>"
						id="<?=\htmlspecialcharsbx($option['CODE'])?>"
						value="Y"
						<?=($val == 'Y') ? 'checked="checked" ' : '';?>
					/>
				<? else: ?>
					<input
						type="text"
						size="<?=$params['SIZE']?>"
						maxlength="255"
						value="<?=\htmlspecialcharsbx($val)?>"
						name="<?=\htmlspecialcharsbx($option['CODE'])?>"
					/>
				<? endif;?>
			</td>
		</tr>
	<?
	endforeach;?>
    
    <? $tabControl->Buttons(); ?>
<?=bitrix_sessid_post();?>
	<input type="submit" name="Apply" value="<?=GetMessage("MAIN_APPLY")?>" title="<?=GetMessage("MAIN_OPT_APPLY_TITLE")?>">
	<input type="button" title="<?echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>" OnClick="RestoreDefaults();" value="<?echo GetMessage("MAIN_RESTORE_DEFAULTS")?>">

	<? if ($backUrl <> ''): ?>
		<input
			type="button"
			name="Cancel"
			value="<?=Loc::getMessage('MAIN_OPT_CANCEL')?>"
			title="<?=Loc::getMessage('MAIN_OPT_CANCEL_TITLE')?>"
			onclick="window.location='<?=\htmlspecialcharsbx(CUtil::addslashes($backUrl)) ?>'"/>
		<input type="hidden" name="back_url_settings" value="<?=\htmlspecialcharsbx($backUrl)?>"/>
	<? endif ?>
    <?$tabControl->End();?>
</form>

<script type="text/javascript">
	function RestoreDefaults()
	{
		if(confirm('<?echo AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>'))
			window.location = "<?echo $APPLICATION->GetCurPage()?>?RestoreDefaults=Y&lang=<?=LANGUAGE_ID?>&mid=<?echo urlencode($mid)?>&<?echo bitrix_sessid_get()?>";
	}
</script>