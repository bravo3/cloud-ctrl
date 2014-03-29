<?php
namespace Bravo3\NetworkProxy;

use Bravo3\NetworkProxy\Implementation\FtpProxy;
use Bravo3\NetworkProxy\Implementation\HttpProxy;
use Bravo3\NetworkProxy\Implementation\SocksProxy;

/**
 * Abstract implementation of the NetworkProxyCollectionInterface
 */
abstract class AbstractNetworkProxyCollection implements NetworkProxyCollectionInterface
{
    const PROTOCOL_HTTP = 'http';
    const PROTOCOL_HTTPS = 'https';
    const PROTOCOL_FTP = 'ftp';

    /**
     * @var FtpProxy
     */
    protected $ftp_proxy;

    /**
     * @var HttpProxy
     */
    protected $http_proxy;

    /**
     * @var HttpProxy
     */
    protected $https_proxy;

    /**
     * @var SocksProxy
     */
    protected $socks_proxy;

    function __construct($http_proxy = null, $https_proxy = null, $ftp_proxy = null, $socks_proxy = null)
    {
        $this->http_proxy  = $http_proxy;
        $this->https_proxy = $https_proxy;
        $this->ftp_proxy   = $ftp_proxy;
        $this->socks_proxy = $socks_proxy;
    }


    /**
     * Set the FTP proxy
     *
     * @param FtpProxy $ftp_proxy
     * @return $this
     */
    public function setFtpProxy($ftp_proxy)
    {
        $this->ftp_proxy = $ftp_proxy;
        return $this;
    }

    /**
     * Get the FTP proxy
     *
     * @return FtpProxy|null
     */
    public function getFtpProxy()
    {
        return $this->ftp_proxy;
    }

    /**
     * Set the HTTP proxy
     *
     * @param HttpProxy $http_proxy
     * @return $this
     */
    public function setHttpProxy($http_proxy)
    {
        $this->http_proxy = $http_proxy;
        return $this;
    }

    /**
     * Get the HTTP proxy
     *
     * @return HttpProxy
     */
    public function getHttpProxy()
    {
        return $this->http_proxy;
    }

    /**
     * Set the HTTPS proxy
     *
     * @param HttpProxy $https_proxy
     * @return $this
     */
    public function setHttpsProxy($https_proxy)
    {
        $this->https_proxy = $https_proxy;
        return $this;
    }

    /**
     * Get the HTTPS proxy
     *
     * @return HttpProxy
     */
    public function getHttpsProxy()
    {
        return $this->https_proxy;
    }

    /**
     * Set the SOCKS proxy
     *
     * @param SocksProxy $socks_proxy
     * @return $this
     */
    public function setSocksProxy($socks_proxy)
    {
        $this->socks_proxy = $socks_proxy;
        return $this;
    }

    /**
     * Get the SOCKS proxy
     *
     * @return SocksProxy
     */
    public function getSocksProxy()
    {
        return $this->socks_proxy;
    }

}
 