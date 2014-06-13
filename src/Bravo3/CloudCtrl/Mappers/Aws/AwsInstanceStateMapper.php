<?php
namespace Bravo3\CloudCtrl\Mappers\Aws;

use Bravo3\CloudCtrl\Enum\Aws\InstanceStateCode;
use Bravo3\CloudCtrl\Enum\InstanceState;

class AwsInstanceStateMapper
{

    /**
     * Convert an AWS instance state code to an InstanceState object
     *
     * @param $code
     * @return InstanceState
     */
    public static function fromAwsCode($code)
    {
        $code = (int)$code;
        switch ($code) {
            case InstanceStateCode::PENDING:
                return InstanceState::STARTING();
            case InstanceStateCode::RUNNING:
                return InstanceState::RUNNING();
            case InstanceStateCode::STOPPING:
                return InstanceState::STOPPING();
            case InstanceStateCode::STOPPED:
                return InstanceState::STOPPED();
            case InstanceStateCode::SHUTTING_DOWN:
                return InstanceState::TERMINATING();
            case InstanceStateCode::TERMINATED:
                return InstanceState::TERMINATED();
            default:
                return InstanceState::UNKNOWN();
        }
    }

    /**
     * Convert an AWS instance state name to an InstanceState object
     *
     * @param $code
     * @return InstanceState
     */
    public static function fromAwsName($name)
    {
        /** @var InstanceStateCode $code */
        $code = InstanceStateCode::memberByKey(strtoupper(str_replace('-', '_', $name)));
        return self::fromAwsCode($code->value());
    }

    /**
     * Convert an InstanceState object to an AWS status code
     *
     * @param InstanceState $state
     * @return int
     */
    public static function toAwsCode(InstanceState $state)
    {
        switch ($state) {
            default:
            case InstanceState::STARTING():
                return InstanceStateCode::PENDING;
            case InstanceState::RUNNING():
                return InstanceStateCode::RUNNING;
            case InstanceState::STOPPING():
                return InstanceStateCode::STOPPING;
            case InstanceState::STOPPED():
                return InstanceStateCode::STOPPED;
            case InstanceState::TERMINATING():
                return InstanceStateCode::SHUTTING_DOWN;
            case InstanceState::TERMINATED():
                return InstanceStateCode::TERMINATED;
        }
    }

    /**
     * Convert an InstanceState object to an AWS status name
     *
     * @param InstanceState $state
     * @return string
     */
    public static function toAwsName(InstanceState $state)
    {
        $code = self::toAwsCode($state);
        $aws_state = InstanceStateCode::memberByValue($code);
        return str_replace('_', '-', strtolower($aws_state->key()));
    }

}