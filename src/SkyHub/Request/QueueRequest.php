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
use SkyHub\Exception\RequestException;

class QueueRequest extends Request
{
    protected $resourceClassName = '\SkyHub\Resource\Order';

    public function endpoint()
    {
        return RequestInterface::SKYHUB_BASE_API_ENDPOINT . '/queues/orders';
    }

    public function orders()
    {
        $url = $this->generateUrl(null, array());

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
     * @throws MethodNotAllowedException
     */
    public function get($code = null, array $params = array())
    {
        return $this->orders();
    }

    public function post(ApiResource $resource)
    {
        throw new MethodNotAllowedException();
    }

    public function put(ApiResource $resource)
    {
        throw new MethodNotAllowedException();
    }
}