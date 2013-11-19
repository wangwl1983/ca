<?php

/**
 * XmlProcessor wrapper of DOMDocument
 * @author wangwl
 * First: User creates a document, and the document should has a root element,
 * the name of root element, that can be setted in constructor.
 * If user omit the name of root element, this class use "<Package/>" as root
 * element.
 * 
 * Second: this class has a node pointor, that elements which are created by 
 * this class will insert in.
 * 
 * Third: The node pointor would change when call createFragment function, and 
 * the counter: $_elementStack[] will record the change.
 * 
 * At the end, when call renderXml function, return the xml string.
 */
class XmlProcessor {

    private $_dom;
    private $_node;
    private $_fragments = array();

    const TYPE_NODE = 0;
    const TYPE_NAME = 1;
    const TYPE_XML = 2;

    /**
     * Constructor of xml processor
     * if $root is string, then document will create a new document, with root 
     * element named $root, if $root is a node, then create a document fragment,
     * and push it into fragment stack.
     * @param mixed $root
     */
    public function __construct($root = "Package", $type=self::TYPE_NAME) {
        $this->_dom = new DOMDocument("1.0", "GB18030");
        switch ($type) {
            case self::TYPE_NODE:
                $this->importNode($root);
                break;
            case self::TYPE_NAME:
                $this->createRoot($root);
                break;
            case self::TYPE_XML:
                $this->loadXML($root);
                break;
        }
    }

    private function importNode($node) {
        try {
            if (($_node = $this->_dom->importNode($node)) !== false) {
                $this->_node = $this->_dom->importNode($node);
            }
        } catch (DOMException $ex) {
            $this->raiseError($ex);
        }
    }

    private function createRoot($name) {
        try {
            $this->_node = $this->_dom->createElement($name);
            $this->_dom->appendChild($this->_node);
        } catch (Exception $ex) {
            $this->raiseError($ex);
        }
    }

    private function loadXML($xmlString) {
        try {
            if ($this->_dom->loadXML($xmlString) && $this->_dom->childNodes->length == 1) {
                $this->_node = $this->_dom->firstChild;
            } else {
                throw new Exception("XML error, or more than one root element");
            }
        } catch (Exception $ex) {
            $this->raiseError($ex);
        }
    }

    /**
     * Throw Exception, if param is string the throw new Exception, if param is
     * instance of Exception, just throw it. If param is not a string or an 
     * instance of Exception, do nothing.
     * @param mixed $ex
     * @throws Exception
     */
    private function raiseError($ex) {
        if ($ex instanceof Exception) {
            throw $ex;
        } elseif (is_string($ex)) {
            throw new Exception($ex);
        }
    }

    /**
     * Export core xml to string.
     * @return mixed
     */
    public function renderXML($fragment = false) {
        if (count($this->_fragments > 0)) {
            foreach ($this->_fragments as $fragment) {
                $this->_node->appendChild($fragment->getFrament);
            }
        }

        return $this->_dom->saveXML();
    }

    /**
     * Set node value
     * @param string $name
     * @param string $value
     * @return boolean
     */
    private function setValue($name, $value) {
        if (($node = $this->getNode($name)) != null) {
            $node->nodeValue = $value;
        } else {
            $this->createNode($name, $value);
        }
    }

    /**
     * Get node value.
     * @param type $name
     * @return mixed
     */
    private function getValue($name) {
        if (($node = $this->getNode($name)) != null) {
            return $node->nodeValue;
        } else {
            return null;
        }
    }

    /**
     * overload magic method __get.
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        return $this->getValue($name);
    }

    /**
     * overload magic method __set.
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value) {
        $this->setValue($name, $value);
    }

    /**
     * Add a node.
     * @param string $nodeName
     * @param string $value
     */
    public function createNode($name, $value = null) {
        $node = $this->_dom->createElement($name, $value);
        $this->_node->appendChild($node);
    }

    /**
     * Remove a node by name.
     * @param string $nodeName
     */
    public function removeNode($node) {
        if (($node = $this->getNode($node)) !== NULL) {
            $this->_rootNode->removeChild($node);
        }
    }

    /**
     * Search a node by name.
     * @param type $nodeName
     */
    private function getNode($nodeName) {
        return $this->_dom->getElementsByTagName($nodeName)->item(0);
    }

    public function createFragment($fragmentName) {
        $_f = $this->_dom->createDocumentFragment();
        $_f->appendChild($this->_dom->createElement($fragmentName));
        $_this = __CLASS__;
        $fragment = new $_this($_f, self::TYPE_NODE);
        $this->_fragments[] = $fragment;
        return $fragment;
    }

}
