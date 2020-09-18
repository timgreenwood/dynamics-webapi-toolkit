<?php
/**
 * Copyright 2018-2019 AlexaCRM
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace AlexaCRM\WebAPI\OData;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

use Psr\Http\Message\RequestInterface;

/**
 * Represents a generic middleware for modifying transfer request options for Guzzle Client.
 */
class TransferOptionMiddleware implements MiddlewareInterface {

    protected string $optionName;

    /**
     * @var mixed
     */
    protected $optionValue;

    /**
     * ConnectionProxyMiddleware constructor.
     *
     * @param string $optionName
     * @param mixed $optionValue
     */
    public function __construct( string $optionName, $optionValue ) {
        $this->optionName = $optionName;
        $this->optionValue = $optionValue;
    }

    /**
     * Returns a Guzzle-compliant middleware.
     * Middleware should only operate with request options included in the transfer options list.
     *
     * @return callable
     *
     * @see http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html#creating-a-handler
     */
    public function getMiddleware(): callable {
        $self = $this;

        return static function ( callable $handler ) use ( $self ) {
            return static function ( RequestInterface $request, $options ) use ( $handler, $self ) {
                $options[ $self->optionName ] = $self->optionValue;

                return $handler( $request, $options );
            };
        };
    }
}
