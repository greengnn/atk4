<?php
// PHP5 is still unable to deliver multiple inheritance (MI) and probably won't be able
// to do it at all. People consider multiple inheritance a bad style just as they
// consider GOTO to be a bad style. However there are some cases when implementation
// using MI or GOTO turns out to be much better style than the same implementation without
// them. Assuming you are not paranoidal hater of MI, you might find this class useful.
//
// The reason I came to using this class is because I had the following class structure:
//
//  Form
//  AjaxForm inherited from Form
//  Filter inherited from Form
//
//  AjaxForm and Filter were very different, but I wanted to create
//
//  AjaxFilter
//
//  which would be inherited from both.

class MultipleInheritance {

    private $_mapings=array();

    function _setParents($classes){
        //$this->_build_mappings($classes,'vars');
        foreach($classes as $class){
            $e=get_class_methods($class);
            foreach($e as $entry){
                if(!isset($this->_mapings[$entry])){
                    $this->_mapings[$entry]=$class;
                }
            }
        }
    }

    function __call($name,$args){
        // look up which class we have to go into
        if(!isset($this->_mapings[$name])){
            lowlevel_error('Method is not defined '.get_class($this).'::'.$name);
        }


        $class = $this->_mapings[$name];
        return call_user_func_array(array($class,$name),$args);
    }
}
