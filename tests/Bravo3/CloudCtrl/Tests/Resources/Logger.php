<?php
namespace Bravo3\CloudCtrl\Tests\Resources;

use Psr\Log\AbstractLogger;

/**
 * Dummy logger
 */
class Logger extends AbstractLogger
{
    protected $history = '';

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        $this->history .= $level.': '.$message."\n";
    }

    /**
     * Get History
     *
     * @return string
     */
    public function getHistory()
    {
        return $this->history;
    }

}
 