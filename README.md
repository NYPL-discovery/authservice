# Deprecated

As of August 2024, this codebase and the relevant AWS Lambda has been decommissioned and will not be supported. The Platform API endpoint this app served was `/v0.1/patron/tokens/{token}` and will be removed. Please contact the NYPL LSP or Remediation teams with any questions.

## Previous usage

Searching within the `nypl` and `nypl-discovery` Github orgs, the [`nypl-header-app`](https://github.com/NYPL/nypl-header-app) contains code that hits the endpoint this service supports to display a patron's name. This feature was removed so the code is not active. If we ever add this feature back, we'll revisit how to best support it through a backend service.

Note: the `dgx-header-component` repo flagged below is deprecated and not supported.

-----

# NYPL Auth Service

This app serves the following endpoint:

`GET /v0.1/auth/patron/tokens/{token}`

Given a patron's access token, this service validates the token and responds with the decoded token and certain other patron properties. The `token` param that is expected can be derived by decoding the patron's `nyplIdentityPatron` JWT encoded cookie and using the `.access_token` property contained therein. That value happens also to be a JWT token. The main consumer of this services is [dgx-header-component](https://github.com/NYPL/dgx-header-component/blob/68d89f1b35c7bd8ae6cf9f957387165af5be02df/src/utils/utils.js#L244), which uses this service to fetch patron properties for display.

This package is intended to be used as a Lambda-based Auth Service using the [NYPL PHP Microservice Starter](https://github.com/NYPL/php-microservice-starter).

This package adheres to [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/), and [PSR-4](http://www.php-fig.org/psr/psr-4/) (using the [Composer](https://getcomposer.org/) autoloader).

## Installation

* Initialize the `Config` class.

## Requirements

* PHP >=7.0

## Features

## Usage

### Swagger Documentation Generator

Create a Swagger route to generate Swagger specification documentation:

~~~~
$service->get("/swagger", function (Request $request, Response $response) {
    return SwaggerGenerator::generate(__DIR__ . "/src", $response);
});
~~~~
