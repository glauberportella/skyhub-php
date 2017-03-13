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

interface RequestInterface
{
	const SKYHUB_BASE_API_ENDPOINT 	= 'https://in.skyhub.com.br';
	const PAGE_PARAM_NAME 			= 'page';
	const PER_PAGE_PARAM_NAME 		= 'per_page';

	const MAX_REDIRS = 10;
	const TIMEOUT = 30;

	/**
	 * Returns an API endpoint URL
	 * @return [type] [description]
	 */
	public function endpoint();

	/**
	 * Sends a GET request
	 *
	 * @param  string|ApiResourceInterface $code String representing the resource code (ID) or the ApiResourceInterface instance with the code attribute set
	 * @return Array|ApiResourceInterface Returns array of ApiResourceInterface instances or a ApiResourceInterface instance only
	 */
	public function get($code = null, array $params = array());

	/**
	 * Sends a POST request
	 *
	 * @param  ApiResourceInterface $resource The resource to be sent
	 * @return void
	 */
	public function post(ApiResource $resource);

	/**
	 * Sends a PUT request
	 *
	 * @param  ApiResourceInterface object with the new data to save
	 * @return ApiResourceInterface The updated resource
	 */
	public function put(ApiResource $resource);

	/**
	 * Sends a DELETE request
	 *
	 * @param  string|ApiResourceInterface $code String representing the resource code (ID) or the ApiResourceInterface instance with the code attribute set
	 * @return void
	 */
	public function delete($code);

	/**
	 * Converts a response from api to a resource object
	 *
	 * @param  mixed $response JSON response
	 * @return ApiResourceInterface
	 */
	public function responseToResources($response);

	public function generateUrl($path = null, array $params = array());
}