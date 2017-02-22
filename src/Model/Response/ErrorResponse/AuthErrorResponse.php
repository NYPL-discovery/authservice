<?php
namespace NYPL\Services\Model\Response\ErrorResponse;

use NYPL\Starter\Model\Response\ErrorResponse;

/**
 * @SWG\Definition(title="AuthErrorResponse", type="object")
 */
class AuthErrorResponse extends ErrorResponse
{
    /**
     * @SWG\Property(example=false)
     * @var bool
     */
    public $expired = false;

    /**
     * @return boolean
     */
    public function isExpired()
    {
        return $this->expired;
    }

    /**
     * @param boolean $expired
     */
    public function setExpired($expired)
    {
        $this->expired = (bool) $expired;
    }
}
