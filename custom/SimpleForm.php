<?php
/**
 * User: yuriy
 * Date: 24.12.14 18:15
 */

namespace app\custom;


use yii\base\Model;
use yii\helpers\Html;

/**
 * Class SimpleForm
 * @package app\custom
 *
 * $form = new SimpleForm([
 *     'rules' => [[['till', 'sections'], 'required']],
 *
 *     'defaults' => [
 *         'from' => date('Y-m-d H:i:s'),
 *         'sections' => function() { return Sections::findFirst(); },
 *     ],
 *
 *     // [optional]
 *     // apply defaults only when form is not submitted, check submit-state by specified field
 *     'submitField' => 'submit',
 * ]);
 *
 * $form->load($req->post());
 */
class SimpleForm extends Model
{
	public $rules;

    /** @var array these defaults applied only if form not submitted or if $this->submitField not specified */
    public $defaults = [];

    /** @var array these defaults applied every time before form load */
    public $stickyDefaults = [];

	public $formName = '';
	public $submitField = '';

	protected $_attrs;
	protected $_scenarios;
    protected $_isSubmitted = null;
    protected $_validated;

    public function init()
	{
		parent::init();

		// init attributes emulation
		$scenarios = $this->scenarios();
		$scenario = $this->getScenario();
		$this->_attrs = isset($scenarios[$scenario]) ? array_fill_keys($scenarios[$scenario], null) : [];
	}

	public function rules()
	{
		return $this->rules;
	}

    /**
     * Load passed data and apply all defaults
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null)
    {
        $applyDefaults = true;
        if ($this->submitField) {
            if (isset($data[$this->submitField])) {
                $this->_isSubmitted = true;
                $applyDefaults = false;
            } else {
                $this->_isSubmitted = false;
            }
        }

        if ($applyDefaults && $this->defaults) {
            foreach ($this->defaults as $key => $val) {
                $this->$key = $val;
            }
        }
        if ($this->stickyDefaults) {
            foreach ($this->stickyDefaults as $key => $val) {
                $this->$key = $val;
            }
        }

        return parent::load($data, $formName);
    }

    private function _applyDefaults($defaults)
    {
        foreach ($defaults as $key => $val) {
            $val        = is_callable($val) ? call_user_func($val) : $val;
            $this->$key = $val;
        }
    }

    public function isSubmitted()
    {
        if (!$this->submitField)
            throw new \Exception('Submit Field not specified');

        if ($this->_isSubmitted === null)
            throw new \Exception('isSubmitted called before form load');

        return $this->_isSubmitted;
    }

    /**
     * Get value after validation of null if validation failed
     * @param mixed $attribute
     * @return mixed|null
     */
    public function getValid($attribute)
    {
        if (!$this->_validated) {
            $this->validate();
        }

        return count($this->getErrors($attribute)) === 0 ? $this->$attribute : null;
    }

	public function __get($field)
	{
		return $this->_attrs[$field];
	}

	public function __set($field, $value)
	{
		$this->_attrs[$field] = $value;
	}

	public function attributes()
	{
		return $this->_attrs;
	}

	public function scenarios()
	{
		if ($this->_scenarios === null) {
			$this->_scenarios = parent::scenarios();
		}
		return $this->_scenarios;
	}

	public function formName()
	{
		return $this->formName === null ? parent::formName() : $this->formName;
	}

    public function afterValidate()
    {
        $this->_validated = true;
        return parent::afterValidate();
    }

    /**
     * Hidden input to check if form is applyed or not
     * @return string
     */
    public function getFormLoadIndicatorHtml()
    {
        return Html::hiddenInput('_fload', 1);
    }
}
 