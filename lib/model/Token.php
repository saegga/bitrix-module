<?
namespace Sm\Dev\Model;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;

class TokenTable extends DataManager {

	const TOKEN_LIVE_TIME = '1 month';

	public static function getTableName()
	{
		return 'b_token_table_oauth';
	}

	public static function getMap()
	{
		return [
			new IntegerField('ID', [
				'primary' => true,
				'autocomplete' => true,
			]),
			new IntegerField('USER_ID', [
				'require' => true,
			]),
			new StringField('REFRESH_TOKEN', [
				'require' => true
			]),
			new StringField('FINGERPRINT', [
				'require' => true
			]),
			new StringField('IP', [
				'require' => true
			]),
			new DatetimeField('EXPIRES', [
				'require' => true,
				'default_value' => function(){
					$date = new \DateTime();
					return $date->add(new \DateInterval(self::TOKEN_LIVE_TIME));
				}
			]),
			new DatetimeField('CREATE', [
				'require' => true,
				'default_value' => function(){
					return $date = new \DateTime();
				}
			]),
		];
	}
}