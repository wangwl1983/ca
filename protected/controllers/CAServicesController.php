<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CAServicesController
 *
 * @author wangwl
 */
class CAServicesController extends Controller {

    public $rawPOST;
    public $SOAP_HEADERS;

    public function actions() {
        return array(
            'service' => array(
                'class' => 'CWebServiceAction',
                'serviceOptions' => array(
                    "generatorConfig" => array(
                        "class" => "CWsdlGenerator",
                        "serviceName" => 'IntaRA',
                        'namespace' => 'IntaRA',
                    ),
                ),
            ),
        );
    }

    /**
     * 
     * @param string $user
     * @return string
     * @soap
     */
    public function auth($authPackage) {

        return $authPackage;
    }

    /**
     * 
     * @param string $requestPackage
     * @return string
     * @soap
     */
    public function RequestCert($requestPackage) {
        return $this->beforeSoapProcess(__FUNCTION__, $requestPackage);
    }

    /**
     * 
     * @param string $auditPackage
     * @return string
     * @soap
     */
    public function AuditCert($auditPackage) {
        return $auditPackage;
    }

    /**
     * 
     * @param string $downloadPackage
     * @return string
     * @soap
     */
    public function DownloadCert($downloadPackage) {
        return $downloadPackage;
    }

    /**
     * 
     * @param string $updatePackage
     * @return string
     * @soap
     */
    public function UpdateCert($updatePackage) {
        return $updatePackage;
    }

    /**
     * 
     * @param string $queryPackage
     * @return string
     * @soap
     */
    public function QueryUnitDetail($queryPackage) {
        return $queryPackage;
    }

    /**
     * 
     * @param string $queryPackage
     * @return string
     * @soap
     */
    public function QueryUnits($queryPackage) {
        return $queryPackage;
    }

    /**
     * 
     * @param string $certString
     * @return string
     * @soap
     */
    public function UploadCert(string $certString) {
        return $certString;
    }

    /**
     * 
     * @param string $msg
     * @return strings
     */
    private function answerPackage($msg) {
        return $msg;
    }

    public function actionTe() {
        echo $this->soapProcess("RequestCert", "Fuck you!");
    }

    /**
     * Wrapper of soap processes
     * First decrypt data received from client, processes data, and then 
     * encrypt data so that encrypted data can send to client.
     * @param string $class
     * @param string $data
     * @return string
     */
    private function soapProcess($class, $data) {
        $processor = new $class($this->beforeSoapProcess($data));
        return $this->afterSoapProcess($processor->run());
    }

    /**
     * Decrypt data that received from client
     * @param string $data
     * @return string
     */
    private function beforeSoapProcess($data) {
        return $data;
    }

    /**
     * Encrypt data so that can send to client
     * @param type $data
     * @return type
     */
    private function afterSoapProcess($data) {
        return $data;
    }

}

?>
