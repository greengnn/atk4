<?php
/**
 * Text input with Javascript Date picker
 * It draws date in locale format (taken from $config['locale']['date'] setting) and stores it in
 * MySQL acceptable date format (YYYY-MM-DD)
 */
class Form_Field_DatePicker extends Form_Field {
	function init(){
		parent::init();
        //$this->api->jui->addWidget('datepicker')->activate('.'.$this->name);
	}
	function getInput($attr=array()){
		// $this->value contains date in MySQL format
		// we need it in locale format
		return parent::getInput(array_merge(
			array(
				'value'=>date($this->api->getConfig('locale/date'),strtotime($this->value)),
			),$attr
		));
	}
	function set($value){
		// value can be valid date format, as in config['locale']['date']
		list($d,$m,$y)=explode('/',$value);
		if($y)$value=join('/',array($m,$d,$y));
		$value=date('Y-m-d',strtotime($value));
		return parent::set($value);
	}
}