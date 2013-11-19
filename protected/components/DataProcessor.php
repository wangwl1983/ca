<?php

/**
 * Description of DataProcessor
 *
 * @author wangwl
 * @property DOMDocument $_dom
 */
class DataProcessor {

    private $_dom;
    private $_backEnd = array();

    public function __construct($file) {
        $this->_dom = new DOMDocument();
        $this->_dom->load($file);
    }

    /**
     * 
     * @param string $search
     * @return mixed
     * @throws Exception
     */
    public function findNodes($search) {
        echo get_class($this);
        try {
            if (preg_match("/^\//", $search)) {
                return $this->findByXQuery($search);
            } else {
                return $this->findByTagName($search);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function findByXQuery($search) {
        try {
            echo __FUNCTION__;
            $xPath = new DOMXPath($this->_dom);
            return $xPath->query($search);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function findByTagName($search) {
        try {
            echo __FUNCTION__;
            return $this->_dom->getElementsByTagName($search);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function addNode($name, $parent, $value) {
        
    }

    public function addNodeGroup($name) {
        
    }

    public function debug() {
        print_r($this->_backEnd);
    }

}

