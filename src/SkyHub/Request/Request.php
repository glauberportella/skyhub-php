<?php
// Copyright (c) 2015 Glauber Portella <glauberportella@gmail.com>

// Permission is hereby granted, free of charge, to any person obtaining a
// copy of this software and associated documentation files (the "Software"),
// to deal in the Software without restriction, including without limitation
// the rights to use, copy, modify, merge, publish, distribute, sublicense,
// and/or sell copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
// DEALINGS IN THE SOFTWARE.

namespace SkyHub\Request;

use SkyHub\Resource\ApiResource;
use SkyHub\Security\Auth;
use SkyHub\Exception\SkyHubException;
use SkyHub\Exception\NotFoundException;
use SkyHub\Exception\RequestException;

abstract class Request implements RequestInterface
{
    /**
     * Auth info (for X-User-Email and X-User-Token headers)
     *
     * @var \SkyHub\Security\Auth
     */
    protected $auth;

	/**
     * Pagination page param
     *
	 * @var integer
	 */
	protected $page = 1;

	/**
     * Pagination per page param
     *
	 * @var integer
	 */
	protected $perPage = 30;

    /**
     * Must be set for every child to the complete classname (with namespace) for the resource
     *
     * @var string
     */
    protected $resourceClassName;

    protected $curlHandler;

    /**
     * @var array
     */
    protected $extraHeaders;

    /**
     * Child must return the specific endpoint
     *
     * @return string
     */
    abstract public function endpoint();

    /**
     * Construt a Request
     *
     * @param Auth $auth SkyHub Auth information to send on headers
     * @param array $requestHeaders Additional headers
     */
    public function __construct(Auth $auth, array $requestHeaders = array())
    {
        $this->auth = $auth;
        $this->extraHeaders = $requestHeaders;
    }

    protected function curlInit()
    {
        $this->curlHandler = curl_init();

        $headers = array(
            'accept: application/json',
            'content-type: application/json',
            'x-api-key: '.$this->auth->getToken(),
            'x-user-email: '.$this->auth->getEmail(),
        );

        if (count($this->extraHeaders)) {
            foreach ($this->extraHeaders as $header => $value) {
                $headers[] = sprintf('%s: %s', $header, $value);
            }
        }

        // prepare auth headers on curl
        curl_setopt_array($this->curlHandler, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => RequestInterface::MAX_REDIRS,
            CURLOPT_TIMEOUT => RequestInterface::TIMEOUT,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
            CURLOPT_HTTPHEADER => $headers,
        ));
    }

    protected function curlClose()
    {
        curl_close($this->curlHandler);
    }

    /**
     * Gets the auth.
     *
     * @return     \SkyHub\Security\Auth  The auth.
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * Gets a resource
     *
     * @param  mixed $code   String or resource instance
     * @param  array  $params Extra params to add to request
     * @return ApiResourceInterface An ApiResourceInterface concrete object array if no $code is informed or a single resource if $code is informed
     */
    public function get($code = null, array $params = array())
    {
        if ($code instanceof $this->resourceClassName) {
            $code = $code->code;
        }

        $url = $this->generateUrl($code, $params);

        $this->curlInit();

        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_setopt($this->curlHandler, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = json_decode(curl_exec($this->curlHandler));
        $responseCode = curl_getinfo($this->curlHandler, CURLINFO_HTTP_CODE);

        $curlError = curl_error($this->curlHandler);
        $curlErrorNo = curl_errno($this->curlHandler);
        if ($curlError) {
            throw new RequestException(sprintf('[%s] %s', $curlErrorNo, $curlError));
        }

        $this->curlClose();

        $this->checkResponseErrors($responseCode, $response);

        $resources = $this->responseToResources($response);

        return $resources;
    }

    /**
     * Saves a Resource
     *
     * @param  ApiResource $resource
     * @return stdClass Response
     */
    public function post(ApiResource $resource)
    {
        $url = $this->endpoint();

        $body = $this->createPostBody($resource);

        $this->curlInit();
        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_setopt($this->curlHandler, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->curlHandler, CURLOPT_POSTFIELDS, $body);

        $response = json_decode(curl_exec($this->curlHandler));
        $responseCode = curl_getinfo($this->curlHandler, CURLINFO_HTTP_CODE);

        $curlError = curl_error($this->curlHandler);
        $curlErrorNo = curl_errno($this->curlHandler);
        if ($curlError) {
            throw new RequestException(sprintf('[%s] %s', $curlErrorNo, $curlError));
        }

        $this->curlClose();

        $this->checkResponseErrors($responseCode, $response);

        return $response;
    }

    /**
     * Updates a Resource
     *
     * @param  mixed      $code     String code, or a ApiResourceInterface object with code field
     * @param  ApiResource $resource
     * @return stdClass Response
     */
    public function put(ApiResource $resource)
    {
        $idField = $resource->getIdField();

        $url = $this->generateUrl($resource->{$idField});
        $body = $this->createPutBody($resource);

        $this->curlInit();
        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_setopt($this->curlHandler, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->curlHandler, CURLOPT_POSTFIELDS, $body);

        $response = json_decode(curl_exec($this->curlHandler));
        $responseCode = curl_getinfo($this->curlHandler, CURLINFO_HTTP_CODE);

        $curlError = curl_error($this->curlHandler);
        $curlErrorNo = curl_errno($this->curlHandler);
        if ($curlError) {
            throw new RequestException(sprintf('[%s] %s', $curlErrorNo, $curlError));
        }

        $this->curlClose();

        $this->checkResponseErrors($responseCode, $response);

        return $response;
    }

    /**
     * Deletes a Resource
     *
     * @param  mixed $code String code or the ApiResourceInterface instance
     * @return \Httpful\Response
     */
    public function delete($code)
    {
        if ($code instanceof $this->resourceClassName) {
            $idField = $code->getIdField();
            $code = $code->{$idField};
        }

        $url = $this->generateUrl($code);

        $this->curlInit();
        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_setopt($this->curlHandler, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $response = json_decode(curl_exec($this->curlHandler));
        $responseCode = curl_getinfo($this->curlHandler, CURLINFO_HTTP_CODE);

        $curlError = curl_error($this->curlHandler);
        $curlErrorNo = curl_errno($this->curlHandler);
        if ($curlError) {
            throw new RequestException(sprintf('[%s] %s', $curlErrorNo, $curlError));
        }

        $this->curlClose();

        $this->checkResponseErrors($responseCode, $response);

        return $response;
    }

    /**
     * Transform a Response to a ApiResourceInterface
     *
     * @param  stdClass $response
     * @return ApiResourceInterface array or instance
     */
    public function responseToResources($response)
    {
        $resources = null;

        if (!$response)
            return null;

        if (is_array($response)) {
            $resources = array();
            foreach ($response as $data) {
                $object = new $this->resourceClassName;
                foreach ($data as $prop => $val) {
                    $object->$prop = $val;
                }
                $resources[] = $object;
            }
        } else {
            $resources = new $this->resourceClassName;
            foreach ($response as $prop => $val) {
                $resources->$prop = $val;
            }
        }

        return $resources;
    }

    /**
     * Generates a URL with or without path and params
     *
     * @param  string $path
     * @param  array  $params
     * @return string
     */
    public function generateUrl($path = null, array $params = array())
    {
        $url = $this->endpoint();

        if (!empty($path))
            $url .= '/'.$path;

        if (!empty($params))
            $url .= '?'.http_build_query($params);

        return $url;
    }

    /**
     * Gets the value of page.
     *
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Sets the value of page.
     *
     * @param integer $page the page
     *
     * @return self
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Gets the value of perPage.
     *
     * @return integer
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Sets the value of perPage.
     *
     * @param integer $perPage the per page
     *
     * @return self
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * Customize, if needed, the post body to send
     *
     * @param  ApiResource $resource
     * @return json encoded
     */
    public function createPostBody(ApiResource $resource)
    {
        if (!empty($resource->resourceRequestKey))
            return json_encode(array($resource->resourceRequestKey => $resource));

        return json_encode($resource);
    }

    /**
     * Customize, if needed, the put body to send
     *
     * @param  ApiResource $resource
     * @return json encoded
     */
    public function createPutBody(ApiResource $resource)
    {
        if (!empty($resource->resourceRequestKey))
            return json_encode(array($resource->resourceRequestKey => $resource));

        return json_encode($resource);
    }

    /**
     * Throw API exceptions based on response status code
     *
     * @param  HttpfulResponse $response The response to verify
     * @throws \SkyHub\Exception\SkyHubException according to response status code
     */
    protected function checkResponseErrors($responseCode, $response)
    {
        if ($responseCode >= 200 && $responseCode < 300) {
            return;
        }

        $message = null;
        if (is_object($response)) {
            if (property_exists($response, 'error')) {
                $message = $response->error;
            } elseif (property_exists($response, 'message')) {
                $message = $response->message;
            }
        } elseif (is_array($response)) {
            if (isset($response['error'])) {
                $message = $response['error'];
            } elseif (isset($response['message'])) {
                $message = $response['message'];
            }
        }

        switch ($responseCode) {
            case 400: // Requisição mal-formada
                if (!empty($message)) {
                    throw new \SkyHub\Exception\MalformedRequestException($message);
                } else {
                    throw new \SkyHub\Exception\MalformedRequestException();
                }
                break;
            case 401: // Erro de autenticação
                if (!empty($message)) {
                    throw new \SkyHub\Exception\UnauthorizedException($message);
                } else {
                    throw new \SkyHub\Exception\UnauthorizedException();
                }
                break;
            case 403: // Erro de autorização
                if (!empty($message)) {
                    throw new \SkyHub\Exception\ForbiddenException($message);
                } else {
                    throw new \SkyHub\Exception\ForbiddenException();
                }
                break;
            case 404: // Recurso não encontrado
                if (!empty($message)) {
                    throw new \SkyHub\Exception\NotFoundException($message);
                } else {
                    throw new \SkyHub\Exception\NotFoundException();
                }
                break;
            case 405: // Metodo não suportado
                if (!empty($message)) {
                    throw new \SkyHub\Exception\MethodNotAllowedException($message);
                } else {
                    throw new \SkyHub\Exception\MethodNotAllowedException();
                }
                break;
            case 422: // Erro semântico
                if (!empty($message)) {
                    throw new \SkyHub\Exception\SemanticalErrorException($message);
                } else {
                    throw new \SkyHub\Exception\SemanticalErrorException();
                }
                break;
            case 500: // Erro na API
                if (!empty($message)) {
                    throw new \SkyHub\Exception\SkyHubException($message);
                } else {
                    throw new \SkyHub\Exception\SkyHubException();
                }
                break;
        }
    }
}