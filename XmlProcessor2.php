<?php

class XmlProcessor {

    private $_dom;
    private $_rootTag;
    private $_fragments = array();

    /**
     * Constructor of XmlProcessor
     * @param mixed $root
     * @throws DOMException
     */
    public function __construct($root = "Package") {
        try {
            $this->_dom = new DOMDocument("1.0", "GB18030");
            if (isset($root) && !empty($root)) {
                $this->_rootTag = $this->_dom->createElement($root);
                $this->_dom->appendChild($this->_rootTag);
            } else {
                throw new DOMException("No root element name supplied.");
            }
        } catch (DOMException $ex) {
            $this->raiseError($ex);
        }
    }

    /**
     * Load XML string
     * @param string $xml
     * @throws DOMException
     */
    public function loadXML($xml) {
        try {
            $this->_dom->loadXML($xml);
            $this->_dom->encoding = "GB18030";
            $this->_rootTag = $this->_dom->firstChild;
        } catch (DOMException $ex) {
            throw $ex;
        }
    }

    /**
     * Export root node or return xml as string.
     * @param boolean $partial
     * @return mixed
     * @throws Exception
     */
    public function saveXML($partial = false) {
        try {
            if (!empty($this->_fragments)) {
                $this->serializeFragments();
            }
            if ($partial) {
                return $this->_rootTag;
            } else {
                $this->_dom->formatOutput = true;
                return $this->_dom->saveXML();
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Overload magic method.
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value) {
        $this->setNodeValue($name, $value);
    }

    /**
     * Overload magic method.
     * @param string $name
     * @return string
     */
    public function __get($name) {
        return $this->getNodeValue($name);
    }

    /**
     * Set node value, if the node does not exist, create it first.
     * @param string $name
     * @param string $value
     * @throws Exception
     */
    private function setNodeValue($name, $value) {
        try {
            $node = $this->getNode($name) == NUll ? $this->addNode($name) : $this->getNode($name);
            $node->nodeValue = $value;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Get node value, if node does not exist, throw exception.
     * @param string $name
     * @return string
     * @throws Exception
     */
    private function getNodeValue($name) {
        try {
            $node = $this->getNode($name);
            if ($node != null) {
                return $node->nodeValue;
            } else {
                throw new Exception("No node: " . $name);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Create a node and append to root element.
     * @param string $name
     * @return DOMNode
     * @throws DOMException
     */
    public function addNode($name) {
        try {
            $node = $this->_dom->createElement($name);
            $this->_rootTag->appendChild($node);
            return $node;
        } catch (DOMException $ex) {
            throw $ex;
        }
    }

    /**
     * Retrive a node by name. if more than one node uses the name, only retrive
     * the first one.
     * @param string $name
     * @return DOMNode
     */
    public function getNode($name) {
        return $this->_dom->getElementsByTagName($name)->item(0);
    }

    /**
     * Get all node named $name.
     * @param string $name
     * @return DOMNodeList
     */
    public function getNodes($name) {
        return $this->_dom->getElementsByTagName($name);
    }

    private function serializeFragments() {

        foreach ($this->_fragments as $name => $frags) {
            $tagName = ucfirst($name) . "s";
            $node = $this->addNode($tagName);
            foreach ($frags as $frag) {
                $n = $this->_dom->importNode($frag->saveXML(true), true);
                $node->appendChild($n);
            }
        }
    }

    private function raiseError($error) {
        if ($error instanceof Exception) {
            throw $error;
        } else if (is_string($error)) {
            throw new Exception($error);
        }
    }

    /**
     * 
     * @param string $name
     * @return this
     * @throws Exception
     */
    public function addFragment($name, $group) {
        try {
            if (isset($group) && !empty($group)) {
                if (!isset($this->_fragments[$name])) {
                    $this->_fragments[$name] = array();
                }
            }
            $class = __CLASS__;
            $subDoc = new $class($name);
            $this->_fragments[$name][] = $subDoc;
            return $subDoc;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}
