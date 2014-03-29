<?php
namespace Bravo3\NetworkProxy\Implementation;

use Bravo3\NetworkProxy\AbstractNetworkProxyCollection;
use Bravo3\NetworkProxy\NetworkProxyInterface;

/**
 * A collection of proxies suitable for using in multi-protocol configuration
 */
class NetworkProxyCollection extends AbstractNetworkProxyCollection
{

    /**
     * Get the most appropriate proxy for the protocol
     *
     * @param string $protocol
     * @return NetworkProxyInterface|null
     */
    public function getProxy($protocol)
    {
        $proxy = $this->socks_proxy;
        if ($protocol == self::PROTOCOL_HTTP && $this->http_proxy) {
            $proxy = $this->http_proxy;
        } elseif ($protocol == self::PROTOCOL_HTTPS && $this->https_proxy) {
            $proxy = $this->https_proxy;
        } elseif ($protocol == self::PROTOCOL_FTP && $this->ftp_proxy) {
            $proxy = $this->ftp_proxy;
        }
        return $proxy;
    }

}
 