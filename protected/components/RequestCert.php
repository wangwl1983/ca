<?php

/**
 * Process cert request package
 * REQ:
 * <pre>
 * <?xml version="1.0" encoding="GB18030" ?>
 * <Package>
 * <OperatorID>string</OperatorID>
 * <Data>
 * <Unit>
 * <UnitName/>
 * <UnitRegion/>
 * <UnitTaxNo/>
 * <UnitPaperNo/>
 * <Envsn/>
 * <CertValidPeriod/>
 * <ContactName/>
 * <ContactPhone/>
 * </Unit>
 * </Data>
 * </Package>
 * </pre>
 */

/**
 * Description of RequestCert
 *
 * @author wangwl
 */
class RequestCert extends SoapProcessor {

    public function init() {
        
    }

    public function process() {
        
    }

    public function run() {
        return __CLASS__ . $this->_data;
    }

    public function processData() {
        
    }

}
