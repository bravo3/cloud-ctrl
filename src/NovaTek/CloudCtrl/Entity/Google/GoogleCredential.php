<?php
namespace NovaTek\CloudCtrl\Entity\Google;

use NovaTek\CloudCtrl\Interfaces\Common\ProjectAwareInterface;
use NovaTek\CloudCtrl\Interfaces\Common\ProjectAwareTrait;
use NovaTek\CloudCtrl\Interfaces\Credentials\AbstractCredential;

/**
 * For Google;
 * - Your `identity` is the 'client ID' in the Google console
 * - Your `secret` is the 'service account name', which is an email address in the Google console
 */
class GoogleCredential extends AbstractCredential implements ProjectAwareInterface
{
    use ProjectAwareTrait;

    /**
     * @var string Name of your application when presenting credentials to Google
     */
    protected $application_name;

    /**
     * @var string
     */
    protected $private_key_file;


    /**
     * Create a new Google Credential
     *
     * @param string $client_id        Looks like "958633929774-jrit03r724s4er57ujvlqr4c6eb236oe.apps.googleusercontent.com"
     * @param string $account_name     Looks like "958633929774-jrit03r724s4er57ujvlqr4c6eb236oe@developer.gserviceaccount.com"
     * @param string $private_key_file Path to the credentials private key file
     * @param string $project_id       ID for the project you're connecting to
     * @param string $application_name Optional, define an application name to make OAuth queries with
     */
    function __construct(
        $client_id = null,
        $account_name = null,
        $private_key_file = null,
        $project_id = null,
        $application_name = 'Service Application'
    ) {
        parent::__construct($client_id, $account_name);
        $this->setPrivateKeyFile($private_key_file);
        $this->setProjectId($project_id);
        $this->setApplicationName($application_name);
    }


    /**
     * Set Application Name
     *
     * @param string $application_name
     * @return $this
     */
    public function setApplicationName($application_name)
    {
        $this->application_name = $application_name;
        return $this;
    }

    /**
     * Get Application Name
     *
     * @return string
     */
    public function getApplicationName()
    {
        return $this->application_name;
    }

    /**
     * Set PrivateKeyFile
     *
     * @param string $private_key_file
     * @return $this
     */
    public function setPrivateKeyFile($private_key_file)
    {
        $this->private_key_file = $private_key_file;
        return $this;
    }

    /**
     * Get PrivateKeyFile
     *
     * @return string
     */
    public function getPrivateKeyFile()
    {
        return $this->private_key_file;
    }

}