<?php
namespace Bravo3\NetworkProxy;

use Bravo3\NetworkProxy\Implementation\FtpProxy;
use Bravo3\NetworkProxy\Implementation\HttpProxy;
use Bravo3\NetworkProxy\Implementation\SocksProxy;

/**
 * A collection containing an HTTP, HTTPS, FTP and SOCKS proxy
 */
interface NetworkProxyCollectionInterface
{

    /**
     * Get the most appropriate proxy for the protocol
     *
     * @param string $protocol
     * @return NetworkProxyInterface|null
     */
    public function getProxy($protocol);


    /**
     * Set the FTP proxy
     *
     * @param FtpProxy $ftp_proxy
     * @return $this
     */
    public function setFtpProxy($ftp_proxy);

    /**
     * Get the FTP proxy
     *
     * @return FtpProxy|null
     */
    public function getFtpProxy();

    /**
     * Set the HTTP proxy
     *
     * @param HttpProxy $http_proxy
     * @return $this
     */
    public function setHttpProxy($http_proxy);

    /**
     * Get the HTTP proxy
     *
     * @return HttpProxy
     */
    public function getHttpProxy();

    /**
     * Set the HTTPS proxy
     *
     * @param HttpProxy $https_proxy
     * @return $this
     */
    public function setHttpsProxy($https_proxy);

    /**
     * Get the HTTPS proxy
     *
     * @return HttpProxy
     */
    public function getHttpsProxy();

    /**
     * Set the SOCKS proxy
     *
     * @param SocksProxy $socks_proxy
     * @return $this
     */
    public function setSocksProxy($socks_proxy);

    /**
     * Get the SOCKS proxy
     *
     * @return SocksProxy
     */
    public function getSocksProxy();
}
 