<?php
namespace Aoloe\CoderDojoZh;

/**
 * Join the stored data with the filtered data from Meetup.
 */
class Data
{
    private $app = null;

    private $topic = [];

    /**
     * @param string $banner url to a banner image
     */
    private $banner = [];

    /**
     * @param string $path (optional) the path where the json file are stored.
     */
    public function __construct($app, $topic, $banner)
    {
        $this->app = $app;
        $this->topic = $topic;
        $this->banner = $banner;
    }

    public function getEvent($eventId)
    {
        return $this->getMeetupEventUsefulFields($this->app->meetup->getDetails($eventId));
    }

    public function getRvsp($eventId)
    {
        $result = [/*'raw' => $rvsps, */'yes' => [], 'waitlist' => []];
        $event = $this->getEvent($eventId);

        $storage = $this->app->storage->getEvent($eventId);

        $rvsps = $this->app->meetup->getRsvps($eventId);

        foreach ($rvsps as $item) {
            if ($item['response'] !== 'no') {
                $result[$item['response']][] = $this->getMeetupRvspUsefulFields($item, $storage);
            }
        }
        return $result;
    }

    public function setParticipants($eventId, $userId, $participants)
    {
        $storage = $this->app->storage->getEvent($eventId);

        if (is_null($storage)) {
            // will get an exception and crash if the event does not exist
            $event = $this->getEvent($eventId);
            $storage = [];
        }

        $storageId = 'id-'.$userId;
        if (array_key_exists($storageId, $storage)) {
            $storage[$storageId]['participants'] = $participants;
        } else {
            $storage[$storageId] = [
                'id' => $userId,
                'participants' => $participants
            ];
        }

        $this->app->storage->setEvent($eventId, $storage);
    }

    private function getMeetupEventUsefulFields($event)
    {
        return [
            'id' => $event['id'],
            'title' => $event['name'],
            // 'date' => $event['time'] + $event['utc_offset'], // unix time in milliseconds to be converted to date and time
            'date' => $event['time'], // unix time in milliseconds to be converted to date and time
            'venue' => [
                'name' => $event['venue']['name'],
                'address' => [
                    'street' => [
                        $event['venue']['address_1']
                    ],
                    'city' => $event['venue']['city']
                ]
            ],
            'topic' => $this->topic,
            'banner' => $this->banner,
        ];
    }

    private function getMeetupRvspUsefulFields($item, $storage)
    {
        $storageId = 'id-'.$item['member']['id'];
        return [
            'id' => $item['member']['id'],
            'name' => $item['member']['name'],
            'thumbnail' => array_key_exists('photo', $item['member']) ? $item['member']['photo']['thumb_link'] : null,
            'guests' => $item['guests'],
            'participants' => isset($storage) && array_key_exists($storageId, $storage) ? $storage[$storageId]['participants'] :array_fill(0, count($this->topic), 0)
        ];
    }
}
