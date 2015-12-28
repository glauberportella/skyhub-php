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

class SaleSystemRequest extends Request
{
    protected $resourceClassName = '\SkyHub\Resource\SaleSystem';

    public function endpoint()
    {
        return RequestInterface::SKYHUB_BASE_API_ENDPOINT . '/sale_systems';
    }

    /**
     * Transform a Response to a ApiResourceInterface
     * 
     * @override
     * @param  \Httpful\Response $response
     * @return ApiResourceInterface array
     */
    public function responseToResources(\Httpful\Response $response)
    {
        $resources = null;

        if (is_array($response->body)) {
            $o = new $this->resourceClassName;
            $sytems = array();
            foreach ($response->body as $data) {
                $sytems[] = $data;
            }
            $o->sytems = $sytems;
            $resources[] = $o;
        } else {
            $resources = new $this->resourceClassName;
            foreach ($response->body as $prop => $val) {
                $resources->$prop = $val;
            }
        }

        return $resources;
    }

    public function post(ApiResource $resource)
    {
    	// no support on SkyHub API
        throw new MethodNotAllowedException();
    }

    public function put(ApiResource $resource)
    {
    	// no support on SkyHub API
        throw new MethodNotAllowedException();
    }

    /**
     * Not yet supported on SkyHub API
     * 
     * @param  mixed $code
     * @throws MethodNotAllowedException
     */
    public function delete($code)
    {
        // no support on SkyHub API
        throw new MethodNotAllowedException();
    }
}