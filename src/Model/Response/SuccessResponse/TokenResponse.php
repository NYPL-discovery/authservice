<?php
namespace NYPL\Services\Model\Response\SuccessResponse;

use NYPL\Services\Model\TokenInformation;
use NYPL\Starter\Model\Response\SuccessResponse;

/**
 * @SWG\Definition(title="TokenResponse", type="object")
 */
class TokenResponse extends SuccessResponse
{
    /**
     * @SWG\Property
     * @var TokenInformation
     */
    public $data;

}
