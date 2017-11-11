<?php

namespace Droath\RoboGoogleLighthouse\Task;

/**
 * Load Google lighthouse Robo tasks.
 */
trait loadTasks
{
    /**
     * Google lighthouse command task.
     */
    protected function taskGoogleLighthouse($pathToGoogleLighthouse = null)
    {
        return $this->task(GoogleLighthouse::class, $pathToGoogleLighthouse);
    }
}
