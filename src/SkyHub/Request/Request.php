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

use Httpful\Httpful;
use Httpful\Request as HttpfulRequest;
use Httpful\Response as HttpfulResponse;
use Httpful\Mime;

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

    /**
     * Request template
     *
     * @var \Httpful\Request A requet template
     */
    private $requestTemplate;

    /**
     * SkyHub json handler
     *
     * @var \SkyHub\Handler\JsonHandler
     */
    private $jsonHandler;

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
     * @param array $requestHeaders Additional headers to pass on request template
     */
    public function __construct(Auth $auth, array $requestHeaders = array())
    {
        $this->auth = $auth;

        $this->jsonHandler = new \SkyHub\Handlers\JsonHandler();
        $this->jsonHandler->init(array());
        Httpful::register(\Httpful\Mime::JSON, $this->jsonHandler);

        // creates a request template, every request must have the auth headers
        $this->requestTemplate = $this->createRequestTemplate($requestHeaders);

        HttpfulRequest::ini($this->requestTemplate);
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

        $response = \Httpful\Request::get($url)->send();
        
        $this->checkResponseErrors($response);

        $resources = $this->responseToResources($response);

        return $resources;
    }

    /**
     * Saves a Resource
     *
     * @param  ApiResource $resource
     * @return \Httpful\Response
     */
    public function post(ApiResource $resource)
    {
        $url = $this->endpoint();

        $body = $this->createPostBody($resource);

        $response = \Httpful\Request::post($url)
                ->body($body)
                ->sendsJson()
                ->send();

        $this->checkResponseErrors($response);

        return $response;
    }

    /**
     * Updates a Resource
     *
     * @param  mixed      $code     String code, or a ApiResourceInterface object with code field
     * @param  ApiResource $resource
     * @return \Httpful\Response
     */
    public function put(ApiResource $resource)
    {
        $idField = $resource->getIdField();

        $url = $this->generateUrl($resource->{$idField});
        $body = $this->createPutBody($resource);
        $response = \Httpful\Request::put($url)
            ->body($body)
            ->sendsJson()
            ->send();

        $this->checkResponseErrors($response);

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
        $response = \Httpful\Request::delete($url)->send();

        $this->checkResponseErrors($response);

        return $response;
    }

    /**
     * Transform a Response to a ApiResourceInterface
     *
     * @param  \Httpful\Response $response
     * @return ApiResourceInterface array
     */
    public function responseToResources(\Httpful\Response $response)
    {
        $resources = null;

        if (!isset($response->body) || !$response->body)
            return null;

        if (is_array($response->body)) {
            $resources = array();
            foreach ($response->body as $data) {
                $object = new $this->resourceClassName;
                foreach ($data as $prop => $val) {
                    $object->$prop = $val;
                }
                $resources[] = $object;
            }
        } else {
            $resources = new $this->resourceClassName;
            foreach ($response->body as $prop => $val) {
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
     * Returns headers from request template
     * 
     * @return array
     */
    public function getHeaders()
    {
        return $this->requestTemplate->headers;
    }

    /**
     * Factory method to create the request template on object construction
     * 
     * @param  array  $requestHeaders Additional headers, if any, use array('header' => 'value')
     * @return HttpfulRequest to use as template
     */
    protected function createRequestTemplate(array $requestHeaders = array())
    {
        if (!$this->auth) {
            throw new \Exception('[\SkyHub\Request\Request] Informações de autenticação não estão presentes. Verifique se configurou o $auth no construtor.');
        }

        $template = HttpfulRequest::init()
            ->followRedirects(true)
            ->addHeader('X-User-Email', $this->auth->getEmail())
            ->addHeader('X-Api-Key', $this->auth->getToken())
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
        ;

        if (count($requestHeaders)) {
            foreach ($requestHeaders as $header => $value) {
                $template->addHeader($header, $value);
            }
        }

        return $template;
    }

    /**
     * Throw API exceptions based on response status code
     *
     * @param  HttpfulResponse $response The response to verify
     * @throws \SkyHub\Exception\SkyHubException according to response status code
     */
    protected function checkResponseErrors(HttpfulResponse $response)
    {
        if ($response->code >= 200 && $response->code < 300) {
            return;
        }

        if (!$response->body) {
            return;
        }

        $message = '';
        if (property_exists($response->body, 'error')) {
            $message = $response->body->error;
        } elseif (property_exists($response->body, 'message')) {
            $message = $response->body->message;
        }

        switch ($response->code) {
            case 400: // Requisição mal-formada
                throw new \SkyHub\Exception\MalformedRequestException($message);
                break;
            case 401: // Erro de autenticação
                throw new \SkyHub\Exception\UnauthorizedException($message);
                break;
            case 403: // Erro de autorização
                throw new \SkyHub\Exception\ForbiddenException($message);
                break;
            case 404: // Recurso não encontrado
                throw new \SkyHub\Exception\NotFoundException($message);
                break;
            case 405: // Metodo não suportado
                throw new \SkyHub\Exception\MethodNotAllowedException($message);
                break;
            case 422: // Erro semântico
                throw new \SkyHub\Exception\SemanticalErrorException($message);
                break;
            case 500: // Erro na API
                throw new \SkyHub\Exception\SkyHubException($message);
                break;
            default:
                throw new \SkyHub\Exception\SkyHubException('Erro desconhecido.');
        }
    }
}