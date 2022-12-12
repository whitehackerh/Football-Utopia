<?php

namespace App\Http\Responders;

class BaseResponder {
    private $responseParameter = [];
    private $statusCode = 200;
    private $apiName;
    private $successful = 'success';
    private $responseCode = '000';
    private $data;

    /**
     * @summary constructor
     * @param string $apiName
     * @param expandException $exceptions
     */
    public function __construct($apiName, $exceptions = null) {
        $this->apiName = $apiName;
        if ($exceptions) {
            $this->successful = 'failure';
            $this->statusCode = 400;
            $this->responseCode = $exceptions->getCode();
            $this->data['errors'] = $exceptions->getErrors();
        }
    }

    /**
     * @summary Set response parameter
     * @param array $data
     * @return void
     */
    public function setResponse($data) {
        $this->responseParameter['responseCode'] = $this->responseCode;
        $this->responseParameter['time'] = self::getTime();
        $this->responseParameter['apiName'] = $this->apiName;
        $this->responseParameter['successful'] = $this->successful;
        if ($this->successful == 'success') {
            $this->responseParameter['data'] = $data;
        } else {
            $this->responseParameter['data'] = $this->data;
        }
    }

    /**
     * @summary Get response parameter
     * @return JSON
     */
    public function getResponse() {
        return response()->json($this->responseParameter, $this->statusCode);
    }

    /**
     * @summary download
     * @return file
     */
    public function download() {

    }

    /**
     * @summary Get current time
     * @return string current time
     */
    static function getTime() {
        return date("m-d-Y H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3);
    }
}