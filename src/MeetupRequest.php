<?php
namespace Aoloe\CoderDojoZh;

/**
 * Collection of requests used for the meetup's registration management.
 */
class MeetupRequest
{
    /**
     * Instance of the Aoloe\Meetup class
     * @var \Aoloe\Meetup
     */
    private $api = null;

    /**
     * The name of your group on meetup
     * @var string
     */
    private $groupName = null;

    public function __construct($groupName, $apiKey)
    {
        $this->groupName = $groupName;
        $this->api = new \Aoloe\Meetup(['key' => $apiKey]);
    }

    public function getDetails($eventId) {
        return $this->api->get(strtr(
            '/:groupName/events/:eventId',
            [
                ':groupName' => $this->groupName,
                ':eventId' => $eventId
            ]
       ));
    }

    public function getRsvps($eventId) {
        return $this->api->get(strtr(
            '/:groupName/events/:eventId/rsvps',
            [
                ':groupName' => $this->groupName,
                ':eventId' => $eventId
            ]
       ));
    }
}
