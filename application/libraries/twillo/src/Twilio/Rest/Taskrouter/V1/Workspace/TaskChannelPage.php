<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class TaskChannelPage extends Page {
    /**
     * @param Version $version Version that contains the resource
     * @param Response $response Response from the API
     * @param array $solution The context solution
     */
    public function __construct(Version $version, Response $response, array $solution) {
        parent::__construct($version, $response);

        // Path Solution
        $this->solution = $solution;
    }

    /**
     * @param array $payload Payload response from the API
     * @return TaskChannelInstance \Twilio\Rest\Taskrouter\V1\Workspace\TaskChannelInstance
     */
    public function buildInstance(array $payload): TaskChannelInstance {
        return new TaskChannelInstance($this->version, $payload, $this->solution['workspaceSid']);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        return '[Twilio.Taskrouter.V1.TaskChannelPage]';
    }
}