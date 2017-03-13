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
use SkyHub\Exception\RequestException;
use SkyHub\Exception\MethodNotAllowedException;

class OrderRequest extends Request
{
	protected $resourceClassName = '\SkyHub\Resource\Order';

	public function endpoint()
    {
        return RequestInterface::SKYHUB_BASE_API_ENDPOINT . '/orders';
    }

    /**
     * Create a test order on API
     * @param  ApiResource $resource
     * @return bool
     */
    public function createTest(ApiResource $resource)
    {
        return parent::post($resource);
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

    public function getNotSynced()
    {
        return $this->get(null, array(
            'filters' => array('sync_status' => array(''=>'NOT_SYNCED'))
        ));
    }

    public function approval(ApiResource $resource)
    {
        if (!isset($resource->status))
            return;

        $idField = $resource->getIdField();

        $url = $this->generateUrl($resource->{$idField}.'/approval');

        $this->curlInit();

        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_setopt($this->curlHandler, CURLOPT_CUSTOMREQUEST, 'POST');

        $body = json_encode(array('status' => $resource->status));
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

    public function exported(ApiResource $resource)
    {
    	if (!isset($resource->exported)) {
            $resource->exported = false;
        }
    	
    	$idField = $resource->getIdField();

		$url = $this->generateUrl($resource->{$idField}.'/exported');

        $this->curlInit();
        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_setopt($this->curlHandler, CURLOPT_CUSTOMREQUEST, 'PUT');
        $body = json_encode(array('exported' => $resource->exported));
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

	public function cancel(ApiResource $resource)
	{
		$idField = $resource->getIdField();

		$url = $this->generateUrl($resource->{$idField}.'/cancel');

        $this->curlInit();

        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_setopt($this->curlHandler, CURLOPT_CUSTOMREQUEST, 'POST');

        $body = json_encode(array('status' => $resource->status));
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

	public function delivery(ApiResource $resource)
	{
		$idField = $resource->getIdField();

		$url = $this->generateUrl($resource->{$idField}.'/delivery');

        $this->curlInit();

        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_setopt($this->curlHandler, CURLOPT_CUSTOMREQUEST, 'POST');

        $body = json_encode(array('status' => $resource->status));
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

	public function shipments(ApiResource $resource)
	{
		$idField = $resource->getIdField();

		$url = $this->generateUrl($resource->{$idField}.'/shipments');

        $this->curlInit();

        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_setopt($this->curlHandler, CURLOPT_CUSTOMREQUEST, 'POST');

        $body = json_encode($resource);
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

    public function invoice(ApiResource $resource)
    {
        $idField = $resource->getIdField();
        
        $url = $this->generateUrl($resource->{$idField}.'/invoice');

        $this->curlInit();

        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_setopt($this->curlHandler, CURLOPT_CUSTOMREQUEST, 'POST');

        $body = json_encode($resource);
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
    }
}