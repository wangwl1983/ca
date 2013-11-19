<?php

/**
 *
 * @author wangwl
 */
abstract class SoapProcessor {

    private $_requestXml;
    private $_replyXml;
    protected $_xpath;

    /**
     * 
     * @param string $xml
     */
    public function __construct($xml) {
        try {
            $requestXml = new DOMDocument();
            $requestXml->loadXML($xml);
            $this->_xpath = new DOMXPath($requestXml);
        } catch (Exception $ex) {
            $this->raiseError($ex);
        }
    }

    public function findNodeByName($name, $item = 0) {
        
    }

    public function findNodeTextByName($name, $item = 0) {
        
    }

    /**
     * Read Meta Data
     * @param string $name
     * @return string
     */
    public function readMeta($name) {
        try {
            $nodes = $this->_requestXml->getElementsByTagName($name);
            if ($nodes->length == 0) {
                throw new Exception('Cannot find node ' . $name);
            }
            return $nodes->item(0)->textContent;
        } catch (Exception $ex) {
            $this->raiseError($ex);
        }
    }

    /**
     * 
     * @param string $name
     * @param string $context
     * @return string
     */
    public function readData($name, $context = "Data") {
        $context = $this->getNode($context);
        return $this->readByContext($name, $context);
    }

    /**
     * 
     * @param string $name
     * @param DOMNode $context
     * @throws Exception
     */
    public function readByContext($name, $context) {
        try {
            $xpath = new DOMXPath($this->_requestXml);
            $nodes = $xpath->query($name, $context);
            if ($nodes->length == 0) {
                throw new Exception("Cannot find node: {$name} in context {$context->nodeName}");
            }
            return $nodes->item(0)->textContent;
        } catch (Exception $ex) {
            $this->raiseError($ex);
        }
    }

    /**
     * 
     * @param string $name
     * @param int $i
     * @return DOMNode
     * @throws Exception
     */
    public function getNode($name, $i = 0) {
        try {
            $nodes = $this->_requestXml->getElementsByTagName($name);
            if ($nodes->length == 0) {
                throw new Exception("Cannot find node: {$name}");
            } else {
                return $nodes->item($i);
            }
        } catch (Exception $ex) {
            $this->raiseError($ex);
        }
    }

    /**
     * Raise error in this class
     * @param mixed $ex
     * @throws Exception
     */
    protected function raiseError($ex) {
        if (is_string($ex)) {
            throw new Exception($ex);
        } elseif ($ex instanceof Exception) {
            throw $ex;
        } else {
            throw new Exception("Unknown Exception");
        }
    }

    abstract public function processData();

    abstract public function run();
}
