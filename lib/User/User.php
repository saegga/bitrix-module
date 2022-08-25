<?
namespace Sm\Dev\User;

class User extends UserFields {

	/**@var UserFields */
	private $userFields;
	/**
	 * User constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	protected function initFieldsInfo()
	{
		$this->userFields = [
			new Field('name', '', true, []),
			new Field('email', '', true, []),
		];
	}

	public function registerUser(){
		global $USER;

		$arFio = explode(' ', $this->getFieldValue('name'));
		$name = $arFio[1] ?? $arFio[0];
		$lastname = $arFio[1] ? $arFio[0] : '';
		$secondname = $arFio[2] ?? '';

		$login = $this->getFieldValue('login') ?? $this->getFieldValue('email');
		$password = $this->getFieldValue('password');
		$passwordConfirm = $this->getFieldValue('password_confirm');
		$email = $this->getFieldValue('email');

		$_REQUEST["USER_AGREEMENT"] = 'Y';

		$registerResult = $USER->Register(
			$login,
			$name,
			$lastname,
			$password,
			$passwordConfirm,
			$email,
			SITE_ID,
			'',
			0,
		false,
		false);

		if($registerResult['TYPE'] === 'OK') {
			$arUpdateFields = [
				'PERSONAL_PHONE' => $this->getFieldValue('phone'),
			];
			if(!empty($secondname)) {
				$arUpdateFields['SECOND_NAME'] = $secondname;
			}

			$USER->Update($registerResult['ID'], $arUpdateFields);
//			$this->result->setData($registerResult);
		} else {
//			$this->result->addError(new Error($registerResult['MESSAGE'], 'internal_error'));
		}
	}
}