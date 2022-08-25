<?
namespace Sm\Dev\User;

abstract class UserFields{

	private $fieldsInfo =[];
	private $requestFields = [];
	/**
	 * UserFields constructor.
	 */
	abstract protected function initFieldsInfo();
	abstract protected function registerUser();

	public function __construct()
	{
		$this->initFieldsInfo();

	}
	public function register($data){
		$this->requestFields = $data;
		if(!empty($data)){
			$this->registerUser();
		}
	}

	/* @return array|Field */
	public function getFieldInfoByKey($keyName){
		if(!empty($this->fieldsInfo[$keyName])){
			return $this->fieldsInfo[$keyName];
		}else{
			return [];
		}
	}

	public function getFieldValue($fieldName){
		return $this->requestFields[$fieldName] ?? null;
	}
	/**
	 * @return array
	 */
	public function getRequestFields(): array
	{
		return $this->requestFields;
	}

}

class Field{
	//TODO - valid fileds method
	private $fieldName;
	private $title;
	private $required;
	private $rules;

	private $titleKey;
	private $requiredKey;
	private $rulesKey;


	public function getArrInfo(){
		return [
			$this->getFieldName() => [
				$this->getTitleKey() => $this->getTitle(),
				$this->getRequiredKey() => $this->getRequired(),
				$this->getRequiredKey() => $this->getRules(),
			]
		];
	}

	/**
	 * Field constructor.
	 * @param $keyName
	 * @param $title
	 * @param $required
	 * @param $rules
	 */
	public function __construct($keyName, $title, $required, $rules, $titleKey = 'title', $rulesKey = 'rules', $requiredKey = 'required')
	{
		$this->fieldName = $keyName;
		$this->title = $title;
		$this->required = $required;
		$this->rules = $rules;

		$this->titleKey = $titleKey;
		$this->rulesKey = $rulesKey;
		$this->requiredKey = $requiredKey;
	}

	/**
	 * @return mixed|string
	 */
	public function getTitleKey(): string
	{
		return $this->titleKey;
	}

	/**
	 * @param mixed|string $titleKey
	 */
	public function setTitleKey(string $titleKey)
	{
		$this->titleKey = $titleKey;
	}

	/**
	 * @return mixed|string
	 */
	public function getRequiredKey(): string
	{
		return $this->requiredKey;
	}

	/**
	 * @param mixed|string $requiredKey
	 */
	public function setRequiredKey(string $requiredKey)
	{
		$this->requiredKey = $requiredKey;
	}

	/**
	 * @return mixed|string
	 */
	public function getRulesKey(): string
	{
		return $this->rulesKey;
	}

	/**
	 * @param mixed|string $rulesKey
	 */
	public function setRulesKey(string $rulesKey)
	{
		$this->rulesKey = $rulesKey;
	}

	/**
	 * @return mixed
	 */
	public function getFieldName()
	{
		return $this->fieldName;
	}

	/**
	 * @param mixed $fieldName
	 */
	public function setFieldName($fieldName)
	{
		$this->fieldName = $fieldName;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getRequired()
	{
		return $this->required;
	}

	/**
	 * @param mixed $required
	 */
	public function setRequired($required)
	{
		$this->required = $required;
	}

	/**
	 * @return mixed
	 */
	public function getRules()
	{
		return $this->rules;
	}

	/**
	 * @param mixed $rules
	 */
	public function setRules($rules)
	{
		$this->rules = $rules;
	}


}