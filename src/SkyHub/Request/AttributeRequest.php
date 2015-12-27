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
use SkyHub\Resource\Attribute;
use SkyHub\Exception\MethodNotAllowedException;

use Httpful\Request as HttpfulRequest;


class AttributeRequest extends Request
{
    protected $resourceClassName = '\SkyHub\Resource\Attribute';

    public function endpoint()
    {
        return RequestInterface::SKYHUB_BASE_API_ENDPOINT . '/attributes';
    }

    /**
     * @throws MethodNotAllowedException
     */
    public function get($code = null, array $params = array())
    {
        // no support on SkyHub API
        throw new MethodNotAllowedException();
    }

    /**
     * @throws MethodNotAllowedException
     */
    public function delete($code)
    {
        // no support on SkyHub API
        throw new MethodNotAllowedException();
    }
}