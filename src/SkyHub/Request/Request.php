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
use Httpful\Request as HttpfulRequest;

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
     * Child must return the specific endpoint
     * 
     * @return string
     */
    abstract public function endpoint();

    /**
     * Construt a Request
     * 
     * @param Auth $auth SkyHub Auth information to send on headers
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;

        // creates a request template, every request must have the auth headers
        $this->requestTemplate = HttpfulRequest::init()
            ->expectsJson()
            ->addHeader('X-User-Email', $this->auth->getEmail())
            ->addHeader('X-User-Token', $this->auth->getToken())
        ;

        HttpfulRequest::ini($this->requestTemplate);
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
        if (isset($response->body->error)) {
            if (1 === preg_match('/não foi possível encontrar/i', $response->body->error)) {
                throw new NotFoundException($response->body->error);
            }

            throw new SkyHubException($response->body->error);
        }

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

        $response = null;

        // SkyHub API POST return no response or an empty response
        // Httpful think it is an error so we catch the exception and proceed
        // normally. 
        // 
        // TODO: Think how to deal with it or change it when SkyHub team change the response for a POST
        try {
            $response = \Httpful\Request::post($url)
                ->body($this->createPostBody($resource))
                ->sendsJson()
                ->send();
        } catch (\Exception $e) {
            if ($e->getMessage() == 'Unable to parse response as JSON') {
                // keep working
            } else {
                throw new RequestException($e->getMessage(), $e->getCode());
            }
        }

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
        $response = \Httpful\Request::put($url)
            ->body($this->createPutBody($resource))
            ->sendsJson()
            ->send();
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
        $response = \Httpful\Request::delete($url);
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
    protected function createPostBody(ApiResource $resource)
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
    protected function createPutBody(ApiResource $resource)
    {
        return json_encode($resource);
    }
}