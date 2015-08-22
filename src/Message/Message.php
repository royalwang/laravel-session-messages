<?php
namespace Tarach\LSM\Message;

class Message
{
    // types of messages
    /**
     * Message type
     */
    const TYPE_FAILURE = 0;
    /**
     * Message type
     */
    const TYPE_NOTIFY = 1;
    /**
     * Message type
     */
    const TYPE_SUCCESS = 2;
    /**
     * Message type
     */
    const TYPE_WARNING = 3;
    
    // methods of handling messages after display
    /**
     * Display message and remove it automatically. ( default )
     */
    const METHOD_FLASH = 1;
    /**
     * Display message until its removal from code.
     */
    const METHOD_PERSIST = 2;
    /**
     * Display message until its removal by user or from code.
     */
    const METHOD_REMOVABLE = 3;

    // types of data stored in session array variable
    const DATA_CLASSES = 0;
    const DATA_MESSAGE = 1;
    const DATA_METHOD = 2;
    const DATA_TYPE = 3;
    
    /**
     * Defined message types
     * 
     * @var array
     */
    private $types = [
        0 => 'failure',
        1 => 'notify',
        2 => 'success',
        3 => 'warning'
    ];
    /**
     * @see getData()
     * 
     * @var array
     */
    private $data = [
        self::DATA_CLASSES => 'msg-box',
        self::DATA_MESSAGE => '',
        self::DATA_METHOD => self::METHOD_FLASH,
        self::DATA_TYPE => self::TYPE_NOTIFY
    ];
    
    /**
     * Numeric index of current message
     * 
     * @var int
     */
    private $index;
    /**
     * @var Collection
     */
    private $Collection;

    /**
     * Assignes variables
     * 
     * @param int|null $index
     * @param Collection $C
     */
    public function __construct($index, Collection $C)
    {
        $this->setIndex($index);
        $this->setCollection($C);
    }

    /**
     * Creates new instance of itself and returns it
     * 
     * @param $index
     * @param Collection $C
     * @return static
     */
    public static function createInstance($index, Collection $C)
    {
        return new static($index, $C);
    }

    public function exists()
    {
        $index = $this->getIndex();
        $Collection = $this->getCollection();
        return $Collection->getSessionStorage()->has($Collection->getPrefix().$index);
    }
    /**
     * Loads message from session
     * 
     * @return $this
     */
    public function load()
    {
        $index = $this->getIndex();
        $Collection = $this->getCollection();
        if(is_null($index))
        {
            throw new \InvalidArgumentException('Loading session message failed. Index is not set.');
        }

        $this->setData($Collection->getSessionStorage()->get($Collection->getPrefix().$index));
        
        return $this;
    }
    /**
     * Saves new message data into session or overwrites existing one. 
     * 
     * @return $this
     */
    public function save()
    {
        $Collection = $this->getCollection();
        
        $index = $this->getIndex();
        if(is_null($index))
        {
            $index = $Collection->getLastIndex();
            $index = $index === false ? 0 : $index + 1;
        }
        $this->setIndex($index);
        
        $Collection->getSessionStorage()->set($Collection->getPrefix().$index, $this->getData());
        
        return $this;
    }
    /**
     * Removes stored message from session
     * 
     * @return $this
     */
    public function remove()
    {
        $index = $this->getIndex();
        $Collection = $this->getCollection();
        $Collection->getSessionStorage()->remove($Collection->getPrefix().$index);

        return $this;
    }
    
    // getters
    /**
     * Returns space separated CSS classes
     * 
     * @return string|null
     */
    public function getClasses()
    {
        return $this->data[self::DATA_CLASSES];
    }
    /**
     * Returns message data that will be save to session.
     * 
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * Returns message to be displayed on next request
     * 
     * @return string|null
     */
    public function getMessage()
    {
        return $this->data[self::DATA_MESSAGE];
    }
    /**
     * Returns method to handle the message after display. Refer to class constants ::METHOD_.
     * 
     * @return int
     */
    public function getMethod()
    {
        return $this->data[self::DATA_METHOD];
    }
    /**
     * @return Collection
     */
    public function getCollection()
    {
        return $this->Collection;
    }
    /**
     * Returns numeric id of message
     * 
     * @return int|null
     */
    public function getIndex()
    {
        return $this->index;
    }
    /**
     * Returns numeric type of message that will be converted to CSS class 
     * 
     * @return int|null
     */
    public function getType()
    {
        return $this->data[self::DATA_TYPE];
    }

    // setters
    /**
     * @see getClasses()
     * 
     * @param string $classes
     * @return $this
     */
    public function setClasses($classes)
    {
        $this->data[self::DATA_CLASSES] = $classes;
        return $this;
    }
    /**
     * @see getData()
     * 
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }
    /**
     * @see getMessage()
     * 
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->data[self::DATA_MESSAGE] = $message;
        return $this;
    }
    /**
     * @see getMethod()
     * 
     * @param int $method
     * @return $this
     */
    public function setMethod($method)
    {
        if($method == self::METHOD_REMOVABLE)
        {
            $this->setClasses($this->getClasses().' removable');
        }
        $this->data[self::DATA_METHOD] = $method;
        return $this;
    }
    /**
     * @param Collection $C
     * @return $this
     */
    public function setCollection(Collection $C)
    {
        $this->Collection = $C;
        return $this;
    }
    /**
     * @see getIndex()
     * 
     * @param int $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }
    /**
     * Assignes value and sets classes string
     * 
     * @see setClasses()
     * 
     * @param int $type
     * @return $this
     */
    public function setType($type)
    {
        if(!isset($this->types[$type]))
        {
            throw new \InvalidArgumentException('Invalid message type.');
        }
        $this->setClasses($this->getClasses().' '.$this->types[$type]);

        $this->data[self::DATA_TYPE] = $type;
        return $this;
    }


}