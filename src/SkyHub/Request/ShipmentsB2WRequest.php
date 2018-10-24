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

class ShipmentsB2WRequest extends Request
{
    protected $resourceClassName = '\SkyHub\Resource\Freights';

    public function endpoint()
    {
        return RequestInterface::SKYHUB_BASE_API_ENDPOINT . '/shipments/b2w';
    }

    /**
     * Agrupar PLP
     * 
     * @param  array  $order_remote_codes Data formatted as array [""265358194401", "265358194401", "265358194401""] of order remote codes
     * @return JSON
     */
    public function agruparPLP(array $order_remote_codes)
    {
        $url = $this->endpoint();

        $body = json_encode(array(
            'order_remote_codes' => $order_remote_codes
        ));

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
     * Desagrupar PLP
     * 
     * @param  string $plp_id PLP ID
     * @return JSON
     */
    public function desagruparPLP($plp_id)
    {
        $url = $this->endpoint();

        $body = json_encode(array(
            'plp_id' => $plp_id
        ));

        $this->curlInit();
        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_setopt($this->curlHandler, CURLOPT_POSTFIELDS, $body);
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
     * RecuperarPLP PDF
     * 
     * @param  string  $plp_id PLP ID
     * @param  boolean $json   If true return json else return PDF
     * @return JSON|PDF
     */
    public function recuperarPLP($plp_id, $json = false)
    {
        $url = $this->endpoint() . '/view?plp_id='.$plp_id;

        $this->curlHandler = curl_init();

        $headers = array(
            'content-type: application/json',
            'x-api-key: '.$this->auth->getToken(),
            'x-user-email: '.$this->auth->getEmail(),
        );

        if ($json) {
            $headers[] = 'accept: application/json';
        } else {
            $headers[] = 'accept: application/pdf';
        }

        if (count($this->extraHeaders)) {
            foreach ($this->extraHeaders as $header => $value) {
                $headers[] = sprintf('%s: %s', $header, $value);
            }
        }

        curl_setopt_array($this->curlHandler, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => RequestInterface::MAX_REDIRS,
            CURLOPT_TIMEOUT => RequestInterface::TIMEOUT,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
        ));

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
     * Pedidos aptos para agrupamento
     *
     * Atualmente é disponibilizado 20 pedidos por página via API, porém o mesmo pode realizar a paginação
     * Segue abaixo como realizar a paginação de pedidos aptos para agrupamento
     * https://api.skyhub.com.br/shipments/b2w/to_group?offset=1
     * O limite de pedidos para incluir no agrupamento atualmente é de 25
     * 
     * @param  integer $offset Optional, integer to pagination offset
     * @return JSON
     */
    public function pedidosAptosAgrupamento($offset = null)
    {
        $url = $this->endpoint() . '/to_group';

        if (!is_null($offset) && !empty($offset)) {
            $url . '?offset=' . intval($offset);
        }

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