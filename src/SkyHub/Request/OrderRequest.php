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
use SkyHub\Exception\MethodNotAllowedException;

class OrderRequest extends Request
{
	protected $resourceClassName = '\SkyHub\Resource\Order';

	public function endpoint()
    {
        return RequestInterface::SKYHUB_BASE_API_ENDPOINT . '/orders';
    }

    /**
     * Method not allowed
     */
    public function post(ApiResource $resource)
    {
        throw new MethodNotAllowedException();
    }

    /**
     * Method not allowed
     */
    public function put(ApiResource $resource)
    {
        throw new MethodNotAllowedException();
    }

    /**
     * Method not allowed
     */
    public function delete($code)
    {
        throw new MethodNotAllowedException();
    }

    public function exported(ApiResource $resource)
    {
    	if (!isset($resource->exported))
    		return;
    	
    	$idField = $resource->getIdField();

		$url = $this->generateUrl($resource->{$idField}.'/exported');

        $response = null;

        try {
            $response = \Httpful\Request::put($url)
                ->body(json_encode(array('exported' => $resource->exported)))
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

	public function cancel(ApiResource $resource)
	{
		$idField = $resource->getIdField();

		$url = $this->generateUrl($resource->{$idField}.'/cancel');

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

	public function delivery(ApiResource $resource)
	{
		$idField = $resource->getIdField();

		$url = $this->generateUrl($resource->{$idField}.'/delivery');

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

	public function shipments(ApiResource $resource)
	{
		$idField = $resource->getIdField();

		$url = $this->generateUrl($resource->{$idField}.'/shipments');

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
}