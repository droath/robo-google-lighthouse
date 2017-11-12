<?php

namespace Droath\RoboGoogleLighthouse\Task;

use Robo\Common\ExecOneCommand;
use Robo\Exception\TaskException;
use Robo\Task\BaseTask;

/**
 * Google lighthouse task for Robo.
 */
class GoogleLighthouse extends BaseTask
{
    use ExecOneCommand;

    /**
     * Google lighthouse URL.
     *
     * @var string
     */
    protected $url;

    /**
     * Google lighthouse executable.
     *
     * @var string
     */
    protected $executable;

    /**
     * Constructor for the google lighthouse command.
     *
     * @param string $pathToGoogleLighthouse
     *   The path to the google lighthouse.
     */
    public function __construct($pathToGoogleLighthouse = null)
    {
        $this->executable = isset($pathToGoogleLighthouse)
            ? $pathToGoogleLighthouse
            : $this->findExecutable('lighthouse');

        if (!$this->executable) {
            throw new TaskException(
                __CLASS__,
                'Unable to find the lighthouse executable.'
            );
        }
    }

    /**
     * Set the site URL.
     *
     * @param string $url
     *   The URL to run the report on.
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Save the trace contents & screenshots to disk.
     *
     * @return self
     */
    public function saveAssests()
    {
        $this->option('save-assets');

        return $this;
    }

    /**
     * Save all gathered artifacts to disk.
     *
     * @return self
     */
    public function saveArtifacts()
    {
        $this->option('save-artifacts');

        return $this;
    }

    /**
     * Prints a list of all available audits and exits.
     *
     * @return self
     */
    public function listAllAudits()
    {
        $this->option('list-all-audits');

        return $this;
    }

    /**
     * Prints a list of all required trace categories and exits.
     *
     * @return self
     */
    public function listTraceCategories()
    {
        $this->option('list-trace-categories');

        return $this;
    }

    /**
     * Additional categories to capture with the trace (comma-delimited).
     *
     * @param array $categories
     *   An array of additional categories.
     *
     * @return self
     */
    public function additionalTraceCategories(array $categories)
    {
        $this->option('additional-trace-categories', implode(',', $categories));

        return $this;
    }

    /**
     * The path to the config JSON.
     *
     * @param string $path
     *   The path to the configuration.
     *
     * @return self
     */
    public function configPath($path)
    {
        if (!file_exists($path)) {
            throw new TaskException(
                 __CLASS__,
                'The lighthouse configuration path does not existent.'
            );
        }

        $this->option('config-path', $path);

        return $this;
    }

    /**
     * Custom flags to pass to Chrome (space-delimited).
     *
     * @param array $flags
     *   An array of custom flags. For a full list of flags,
     *   see http://peter.sh/experiments/chromium-command-line-switches/.
     *
     * @return self
     */
    public function chromeFlags(array $flags)
    {
        if (!empty($flags)) {
            $chrome_flags = implode(' ', $flags);
            $this->option('chrome-flags', "'$chrome_flags'");
        }

        return $this;
    }

    /**
     * Use a performance-test-only configuration.
     *
     * @return self
     */
    public function performanceTestOnly()
    {
        $this->option('perf');

        return $this;
    }

    /**
     * Set the port to use for the debugging protocol.
     *
     * @param integer $port
     *   The port number.
     *
     * @return self
     */
    public function setPort($port = 0)
    {
        if (!is_numeric($port)) {
            throw new TaskException(
                'The lighthouse port argument is not numeric.'
            );
        }
        $this->option('port', $port);

        return $this;
    }

    /**
     * Set the hostname for the debugging protocol
     *
     * @param string $hostname
     *   The hostname.
     *
     * @return self
     */
    public function setHostname($hostname = 'localhost')
    {
        $this->option('hostname', $hostname);

        return $this;
    }

    /**
     * The timeout to wait before the page is considered done loading and the
     * run should continue.
     *
     * @param integer $timeout
     *   The timeout in milliseconds.
     *
     * @return self
     */
    public function setMaxWaitForLoad($timeout = 30000)
    {
        if (!is_numeric($port)) {
            throw new TaskException(
                'The lighthouse timeout argument is not numeric.'
            );
        }

        $this->option('max-wait-for-load', $timeout);

        return $this;
    }

    /**
     * Set format for report results.
     *
     * @param string $format
     *   The report results format.
     *
     * @return self
     */
    public function setOutput($format = 'domhtml')
    {
        if (!in_array($format, ['json', 'html', 'domhtml'])) {
            throw new TaskException(
                 __CLASS__,
                'The lighthouse output format is not allowed.'
            );
        }

        $this->option('output', $format);

        return $this;
    }

    /**
     * Set output path for the report results.
     *
     * @param string $path
     *   The path to the report results.
     *
     * @return self
     */
    public function setOutputPath($path)
    {
        $this->option('output-path', $path);

        return $this;
    }

    /**
     * Open HTML report in browser.
     *
     * @return self
     */
    public function enableView()
    {
        $this->option('view');

        return $this;
    }

    /**
     * Disable clearing the browser cache and other storage APIs before a run.
     *
     * @return self
     */
    public function disableStorageReset()
    {
        $this->option('disable-storage-reset');

        return $this;
    }

    /**
     * Disable Nexus 5X emulation.
     *
     * @return self
     */
    public function disableDeviceEmulation()
    {
        $this->option('disable-device-emulation');

        return $this;
    }

    /**
     * Disable CPU throttling.
     *
     * @return self
     */
    public function disableCpuThrottling()
    {
        $this->option('disable-cpu-throttling');

        return $this;
    }

    /**
     * Disable network throttling
     *
     * @return self
     */
    public function disableNetworkThrottling()
    {
        $this->option('disable-network-throttling');

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();
        $this->printTaskInfo(
            'Running Docker-Compose: {command}',
            ['command' => $command]
        );

        return $this->executeCommand($command);
    }

    /**
     * Get docker-compose command.
     *
     * @return string
     */
    protected function getCommand()
    {
        return "{$this->executable} {$this->arguments} {$this->url}";
    }
}
