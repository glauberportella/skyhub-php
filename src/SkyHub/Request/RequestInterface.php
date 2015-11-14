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

namespace GlauberPortella\SkyHub\Request;

use GlauberPortella\SkyHub\Resource\ApiResourceInterface;

interface RequestInterface
{
	const SKYHUB_BASE_API_ENDPOINT = 'https://in.skyhub.com.br';
	
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
	public function get($code = null);

	/**
	 * Sends a POST request
	 * 
	 * @param  ApiResourceInterface $resource The resource to be sent
	 * @return void
	 */
	public function post(ApiResourceInterface $resource);

	/**
	 * Sends a PUT request
	 * 
	 * @param  string|ApiResourceInterface $code String representing the resource code (ID) or the ApiResourceInterface instance with the code attribute set
	 * @return ApiResourceInterface The updated resource
	 */
	public function put($code);

	/**
	 * Sends a DELETE request
	 * 
	 * @param  string|ApiResourceInterface $code String representing the resource code (ID) or the ApiResourceInterface instance with the code attribute set
	 * @return void
	 */
	public function delete($code);
}