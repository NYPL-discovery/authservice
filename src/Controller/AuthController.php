<?php
namespace NYPL\Services\Controller;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use NYPL\Services\Model\DataModel\BasePatron\AuthPatron;
use NYPL\Services\Model\Response\ErrorResponse\AuthErrorResponse;
use NYPL\Services\Model\Response\SuccessResponse\TokenResponse;
use NYPL\Services\Model\DecodedToken;
use NYPL\Services\Model\TokenInformation;
use NYPL\Starter\APIException;
use NYPL\Starter\Controller;
use NYPL\Starter\Filter;

final class AuthController extends Controller
{
    const IDENTITY_COOKIE_NAME = 'nyplIdentityPatron';

    protected function getTokenResponse($accessToken = '')
    {
        try {
            $decoded = JWT::decode(
                $accessToken,
                file_get_contents(__DIR__ . '/../../static/pubkey.pem'),
                ['RS256', 'HS256']
            );

            $accessToken = new DecodedToken((array) $decoded);

            $patron = new AuthPatron();
            $patron->addFilter(
                new Filter(null, null, false, $accessToken->getSub())
            );
            $patron->read();

            $tokenCompilation = new TokenInformation();
            $tokenCompilation->setDecodedToken($accessToken);
            $tokenCompilation->setPatron($patron);

            return $this->getResponse()->withJson(
                new TokenResponse($tokenCompilation)
            );
        } catch (ExpiredException $exception) {
            $authErrorResponse = new AuthErrorResponse();
            $authErrorResponse->setExpired(true);

            throw new APIException(
                $exception->getMessage(),
                null,
                0,
                null,
                401,
                $authErrorResponse
            );
        }
    }

    /**
     * @return string
     */
    protected function getIdentityString()
    {
        if ($this->getRequest()->getCookieParam(self::IDENTITY_COOKIE_NAME)) {
            return $this->getRequest()->getCookieParam(self::IDENTITY_COOKIE_NAME);
        }

        if ($this->getRequest()->getQueryParam(self::IDENTITY_COOKIE_NAME)) {
            return urldecode($this->getRequest()->getQueryParam(self::IDENTITY_COOKIE_NAME));
        }
    }

    /**
     * @return string
     * @throws APIException
     */
    protected function getAccessToken()
    {
        $nyplIdentity = json_decode($this->getIdentityString(), true);

        if (!isset($nyplIdentity['access_token'])) {
            throw new APIException('Access token was not found');
        }

        return $nyplIdentity['access_token'];
    }

    /**
     * @SWG\Get(
     *     path="/v0.1/auth/patron/tokens/{token}",
     *     summary="Get a Patron's Token information",
     *     tags={"auth"},
     *     operationId="getToken",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="Token",
     *         in="path",
     *         name="token",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/TokenResponse")
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Invalid or expired token",
     *         @SWG\Schema(ref="#/definitions/AuthErrorResponse")
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Generic server error",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     )
     * )
     */
    public function getToken($token)
    {
        return $this->getTokenResponse($token);
    }

//    /**
//     * @SWG\Get(
//     *     path="/v0.1/auth/patron/logins",
//     *     summary="Get a Patron's login state",
//     *     tags={"auth"},
//     *     operationId="getLogin",
//     *     consumes={"application/json"},
//     *     produces={"application/json"},
//     *     @SWG\Response(
//     *         response=200,
//     *         description="Successful operation",
//     *         @SWG\Schema(ref="#/definitions/TokenResponse")
//     *     ),
//     *     @SWG\Response(
//     *         response="401",
//     *         description="Invalid or expired token",
//     *         @SWG\Schema(ref="#/definitions/AuthErrorResponse")
//     *     ),
//     *     @SWG\Response(
//     *         response="500",
//     *         description="Generic server error",
//     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
//     *     )
//     * )
//     */
//    public function getLogin()
//    {
//        return $this->getTokenResponse($this->getAccessToken());
//    }
}
