<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use phpDocumentor\Reflection\Types\Mixed_;
use Validator;

trait HandleApiRequestAndResponse
{
    /**
     * Variable store whether inputs are valid or not.
     *
     * @var bool
     */
    protected $isInputValid = true;
    
    /**
     * Message need to send as response.
     *
     * @var string
     */
    protected $msg = '';
    
    /**
     * Http status response code
     *
     * @var integer
     */
    protected $httpCode = 200;
    
    /**
     * Variable to store whether request processed successful or not
     *
     * @var boolean
     */
    protected $apiStatus = true;
    
    /**
     * data for response
     *
     * @var null|mixed
     */
    protected $resData = null;
    
    /**
     * rules for validation
     *
     * @var array
     */
    protected $validationRules = [];
    
    /**
     * Custom messages for validation
     *
     * @var array
     */
    protected $validationMessages = [];
    
    /**
     * Send API response/
     */
    final public function apiResponse(): JsonResponse
    {
        $arr = [
            'success' => $this->apiStatus,
            'message' => $this->msg
        ];
        
        if (!is_null($this->resData)) {
            $arr = array_merge(
                $arr,
                [ 'data' => $this->resData ]
            );
        }
        
        return response()->json($arr, $this->httpCode);
    }
    
    /**
     * Validate API request with given rules and messages
     *
     * @return void
     */
    final public function validateApiRequest(): void
    {
        $validator = Validator::make(request()->all(), $this->validationRules, $this->validationMessages);
        
        if ($validator->fails()) {
            $this->setResponseVars(
                $validator->errors()->first(),
                null,
                Response::HTTP_UNPROCESSABLE_ENTITY,
                false
            );
        }
    }
    
    /**
     * @param string $msg
     * @param mixed $resData
     * @param int $httpCode
     * @param bool $isValid
     */
    final public function setResponseVars( string $msg, $resData = null, int $httpCode = Response::HTTP_OK, bool $isValid = true): void
    {
        $this->apiStatus = in_array($httpCode, [Response::HTTP_OK, Response::HTTP_CREATED, Response::HTTP_ACCEPTED]);
        $this->httpCode = $httpCode;
        $this->msg = $msg;
        $this->isInputValid = $isValid;
        $this->resData = $resData;
    }
}