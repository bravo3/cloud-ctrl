<?php
namespace Bravo3\CloudCtrl\Mappers\Google;

use Bravo3\CloudCtrl\Enum\Google\InstanceStateCode;
use Bravo3\CloudCtrl\Enum\InstanceState;

/**
 * NB: With Google you cannot tell if an instance is 'stopping' or 'terminating' - you just know it's powering down -
 *     this will be indicated with a STOPPING status code, followed by a STOPPED or TERMINATED status.
 */
class GoogleInstanceStateMapper
{

    /**
     * Convert a Google instance state code to an InstanceState object
     *
     * @param string $code
     * @return InstanceState
     */
    public static function fromGoogleCode($code)
    {
        switch ($code) {
            case InstanceStateCode::PROVISIONING:
                return InstanceState::PENDING();
            case InstanceStateCode::STAGING:
                return InstanceState::STARTING();
            case InstanceStateCode::RUNNING:
                return InstanceState::RUNNING();
            case InstanceStateCode::STOPPING:
                return InstanceState::STOPPING();
            case InstanceStateCode::STOPPED:
                return InstanceState::STOPPED();
            case InstanceStateCode::TERMINATED:
                return InstanceState::TERMINATED();
            default:
                return InstanceState::UNKNOWN();
        }
    }

    /**
     * Convert an InstanceState object to a Google status code
     *
     * @param InstanceState $state
     * @return int
     */
    public static function toGoogleCode(InstanceState $state)
    {
        switch ($state) {
            default:
            case InstanceState::PENDING():
                return InstanceStateCode::PROVISIONING;
            case InstanceState::STARTING():
                return InstanceStateCode::STAGING;
            case InstanceState::RUNNING():
                return InstanceStateCode::RUNNING;
            case InstanceState::TERMINATING():
            case InstanceState::STOPPING():
                return InstanceStateCode::STOPPING;
            case InstanceState::STOPPED():
                return InstanceStateCode::STOPPED;
            case InstanceState::TERMINATED():
                return InstanceStateCode::TERMINATED;
        }
    }

}