<?php
namespace Aoloe\CoderDojoZh;

/**
 * Read and write the registration data from/to json files.
 */
class Storage
{
    /**
     * Default storage path.
     * @const
     */
    const PATH = __DIR__ . '/../data';

    /**
     * Path where the json file are stored.
     * @var string
     */
    private $path = null;

    /**
     * @param string $path (optional) the path where the json file are stored.
     */
    public function __construct($path = null)
    {
        $this->path = is_null($path) ? self::PATH : $path;
    }

    public function getEvent($event)
    {
        $result = null;
        $filepath = $this->path.'/'.$event.'.json';
        if (file_exists($filepath)) {
            $result = file_get_contents($filepath);
            $result = json_decode($result, true);
        }
        return $result;
    }
    
    public function setEvent($event, $data)
    {
        $filepath = $this->path.'/'.$event.'.json';
        $result = file_put_contents($filepath, json_encode($data));
    }

    public function create($details = null)
    {
        if (isset($data)) {
        }
    }
}
