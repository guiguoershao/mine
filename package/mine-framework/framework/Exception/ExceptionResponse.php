<?php
namespace guiguoershao\Exception;
/**
 * Class ExceptionResponse
 * @package guiguoershao\Exception
 */
class ExceptionResponse
{
    private $type = 0;
    private $line;
    private $trace;
    private $message;
    private $code;
    private $file;

    /**
     * ExceptionResponse constructor.
     * @param $response
     */
    public function __construct($response)
    {
        $this->message = isset($response['message'])?$response['message']:"";
        $this->code = isset($response['code'])?$response['code']:"";
        $this->type = isset($response['type'])?$response['type']:"";
        $this->line = isset($response['line'])?$response['line']:"";
        $this->trace = isset($response['trace'])?$response['trace']:"";
        $this->file = isset($response['file'])?$response['file']:"";
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @return mixed
     */
    public function getTrace()
    {
        return $this->trace;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
}