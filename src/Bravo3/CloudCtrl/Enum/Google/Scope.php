<?php
namespace Bravo3\CloudCtrl\Enum\Google;

/**
 * Does this exist in the Google API somewhere?
 */
class Scope
{
    const COMPUTE_READ  = \Google_Service_Compute::COMPUTE_READONLY;
    const COMPUTE_WRITE = \Google_Service_Compute::COMPUTE;
}
 