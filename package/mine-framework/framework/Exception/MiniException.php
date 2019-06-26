<?php
namespace guiguoershao\Exception;

use Exception;

/**
 * Class MiniException
 * @package guiguoershao\Exception
 */
class MiniException extends \Exception
{
    protected $type = 2;
    protected $line;
    protected $trace;

    /**
     * MiniException constructor.
     * @param string $message
     * @param int $code
     * @param ExceptionResponse $exceptionResponse | \Exception $exceptionResponse
     */
    public function __construct($message, $code = 500, $exceptionResponse = null)
    {
        $this->message = $message;
        $this->code = $code;
        if (!empty($exceptionResponse)) {
            $this->file = $exceptionResponse->getFile();
            $this->line = $exceptionResponse->getLine();
            $this->trace = $exceptionResponse->getTrace();
            $this->code = $exceptionResponse->getCode();
            $this->message = $exceptionResponse->getMessage();
        }
    }

    public function getStaceTraceAsString()
    {
        return $this->trace;
    }

    /**
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $code
     * @param $message
     * @param null $data
     * @param null $previous
     * @throws MiniException
     */
    public static function report($code, $message, $data = null, $previous = null)
    {
        throw new self($code, $message, $data, $previous);
    }
}