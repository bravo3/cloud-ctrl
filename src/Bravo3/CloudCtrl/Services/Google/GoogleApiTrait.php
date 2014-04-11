<?php
namespace Bravo3\CloudCtrl\Services\Google;

use Bravo3\Cache\CachingServiceTrait;
use Bravo3\CloudCtrl\Entity\Google\GoogleCredential;
use Bravo3\CloudCtrl\Exceptions\InvalidCredentialsException;
use Bravo3\CloudCtrl\Interfaces\Credentials\CredentialInterface;
use Bravo3\CloudCtrl\Services\Common\CloudServiceAwareComponent;
use Bravo3\CloudCtrl\Services\Google\Io\GoogleIo;

/**
 *
 */
trait GoogleApiTrait
{
    use CachingServiceTrait;

    protected $token_key = 'google_oauth_token';


    /**
     * Get the Google client for a given scope
     *
     * @param string[]         $scope
     * @param GoogleCredential $credentials
     * @return \Google_Client
     */
    public function getClient($scope, GoogleCredential $credentials)
    {
        $client = new \Google_Client();
        $client->setApplicationName($credentials->getApplicationName());

        $io = new GoogleIo($client);
        $io->setTimeout(5);

        if ($this instanceof CloudServiceAwareComponent) {
            $io->setProxy($this->getCloudService()->getProxy());
        }

        $client->setIo($io);

        // Grab the oauth token
        $token = $this->getCacheItem($this->token_key);
        if ($token->isHit()) {
            $client->setAccessToken($token->get());
        }

        // Load the key in PKCS 12 format
        // - you need to download this from the Google API Console when the service account was created
        $key = file_get_contents($credentials->getPrivateKeyFile());
        //$private_key_password = 'notasecret'; // Not sure if this is abstracted by the Google SDK, or just not required

        $client->setAssertionCredentials(
            new \Google_Auth_AssertionCredentials($credentials->getSecret(), $scope, $key)
        );
        $client->setClientId($credentials->getIdentity());

        return $client;
    }

    /**
     * Save the oauth token back to the caching layer after a successful request
     *
     * @param \Google_Client $client
     */
    public function cacheAuthToken(\Google_Client $client)
    {
        $access_token_json = $client->getAccessToken();
        if ($access_token_json) {
            $access_token_obj = json_decode(($access_token_json));
            $access_token     = $access_token_obj->access_token;

            $token = $this->getCacheItem($this->token_key);
            $token->set($access_token, $access_token_obj->expires_in);
        }
    }


    /**
     * Checks the credentials are suitable for Google API calls - throws an exception if invalid
     *
     * @param CredentialInterface $credentials
     * @return GoogleCredential
     * @throws InvalidCredentialsException
     */
    public function validateGoogleCredentials(CredentialInterface $credentials)
    {
        if (!($credentials instanceof GoogleCredential)) {
            throw new InvalidCredentialsException("Invalid credentials: expected 'GoogleCredential'");
        }

        if (!file_exists($credentials->getPrivateKeyFile())) {
            throw new InvalidCredentialsException("Private key file does not exist: ".
                                                  $credentials->getPrivateKeyFile());
        }

        return $credentials;
    }

    /**
     * Set the cache key for the oauth token
     *
     * @param string $token_key
     * @return $this
     */
    public function setTokenKey($token_key)
    {
        $this->token_key = $token_key;
        return $this;
    }

    /**
     * Get the cache key for the oauth token
     *
     * @return string
     */
    public function getTokenKey()
    {
        return $this->token_key;
    }
}
 