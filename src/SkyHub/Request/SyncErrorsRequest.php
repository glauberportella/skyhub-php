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

class FreightsRequest extends Request
{
    protected $resourceClassName = '\SkyHub\Resource\SyncErrors';

    public function endpoint()
    {
        return RequestInterface::SKYHUB_BASE_API_ENDPOINT . '/sync_errors';
    }

    /**
     * Get sync_errors categories
     *
     * @return void
     */
    public function categories()
    {
        $url = $this->endpoint() . '/categories';
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
        // @todo transform resource to SyncErrorCategory resource
        $resources = $this->responseToResources($response);

        return $resources;
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
}