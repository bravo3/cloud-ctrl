<?php
namespace Bravo3\CloudCtrl\Services\Google\Io;

use Bravo3\NetworkProxy\Implementation\HttpProxy;
use Bravo3\NetworkProxy\Implementation\SocksProxy;
use Bravo3\NetworkProxy\NetworkProxyInterface;
use Google_Http_Request;
use Google_IO_Abstract;
use Google_IO_Exception;

/**
 * A copy of the Google_IO_Curl class with added proxy support and bug fixes on the setOptions() function
 */
class GoogleIo extends Google_IO_Abstract
{
    const NO_QUIRK_VERSION = 0x071F00; // hex for version 7.31.0
    const CACERTS_PEM = '/cacerts.pem';

    protected $options = array();

    /**
     * @var NetworkProxyInterface
     */
    protected $proxy = null;


    /**
     * Execute an HTTP Request
     *
     * @param \Google_Http_Request $request the http request to be executed
     * @throws \Google_IO_Exception
     * @return array
     */
    public function executeRequest(Google_Http_Request $request)
    {
        $curl = curl_init();

        if ($request->getPostBody()) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request->getPostBody());
        }

        $requestHeaders = $request->getRequestHeaders();
        if ($requestHeaders && is_array($requestHeaders)) {
            $curlHeaders = array();
            foreach ($requestHeaders as $k => $v) {
                $curlHeaders[] = "$k: $v";
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, $curlHeaders);
        }

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getRequestMethod());
        curl_setopt($curl, CURLOPT_USERAGENT, $request->getUserAgent());

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);

        curl_setopt($curl, CURLOPT_URL, $request->getUrl());

        if ($request->canGzip()) {
            curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        }

        // Additional CURL options
        foreach ($this->options as $key => $var) {
            curl_setopt($curl, $key, $var);
        }

        // SOCKS/HTTP proxy
        if ($this->proxy) {
            // If we have an HTTP or SOCKS proxy - tell curl which we're using
            if ($this->proxy instanceof HttpProxy) {
                curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            } elseif ($this->proxy instanceof SocksProxy) {
                curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            }

            // Proxy hostname & port - required
            curl_setopt($curl, CURLOPT_PROXY, $this->proxy->getHostname());
            curl_setopt($curl, CURLOPT_PROXYPORT, $this->proxy->getPort());

            // Optional authentication
            if ($this->proxy->getUsername()) {
                curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->proxy->getUsername().':'.$this->proxy->getPassword());
            }
        }

        // Google CA cert - use from the Google bundle
        if (!isset($this->options[CURLOPT_CAINFO])) {
            $r = new \ReflectionClass('\Google_IO_Curl');
            curl_setopt($curl, CURLOPT_CAINFO, dirname($r->getFileName()).static::CACERTS_PEM);
        }

        // Execute request
        $response = curl_exec($curl);

        if ($response === false) {
            throw new Google_IO_Exception(curl_error($curl));
        }
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

        $responseBody         = substr($response, $headerSize);
        $responseHeaderString = substr($response, 0, $headerSize);
        $responseHeaders      = $this->getHttpResponseHeaders($responseHeaderString);
        $responseCode         = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        return array($responseBody, $responseHeaders, $responseCode);
    }

    /**
     * Set options that update the transport implementation's behavior.
     *
     * @param $options
     */
    public function setOptions($options)
    {
        $this->options = array_replace($this->options, $options);
    }

    /**
     * Set the maximum request time in seconds.
     *
     * @param int $timeout Timeout in seconds
     */
    public function setTimeout($timeout)
    {
        // Since this timeout is really for putting a bound on the time
        // we'll set them both to the same. If you need to specify a longer
        // CURLOPT_TIMEOUT, or a tigher CONNECTTIMEOUT, the best thing to
        // do is use the setOptions method for the values individually.
        $this->options[CURLOPT_CONNECTTIMEOUT] = $timeout;
        $this->options[CURLOPT_TIMEOUT]        = $timeout;
    }

    /**
     * Get the maximum request time in seconds.
     *
     * @return int Timeout in seconds
     */
    public function getTimeout()
    {
        return $this->options[CURLOPT_TIMEOUT];
    }

    /**
     * Determine whether "Connection Established" quirk is needed
     *
     * @return boolean
     */
    protected function _needsQuirk()
    {
        $ver        = curl_version();
        $versionNum = $ver['version_number'];
        return $versionNum < static::NO_QUIRK_VERSION;
    }

    /**
     * Set Proxy
     *
     * @param NetworkProxyInterface $proxy
     * @return $this
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
        return $this;
    }

    /**
     * Get Proxy
     *
     * @return NetworkProxyInterface
     */
    public function getProxy()
    {
        return $this->proxy;
    }

}
