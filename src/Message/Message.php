<?php
namespace Tarach\LSM\Message;

use Tarach\LSM\Config;
use Tarach\LSM\SessionStorage\TStorageAccess;
use Tarach\LSM\TConfigAccess;

class Message
{
    use TConfigAccess;
    use TStorageAccess;
    
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
     * Assignes variables
     * 
     * @param   int|null  $index
     * @param   Config    $Config        Optional when empty Config object from Laravels IoC will be used 
     */
    public function __construct($index = null, Config $Config = null)
    {
        $this->setIndex($index);
        if(!is_null($Config))
        {
            $this->setConfig($Config);
        }
    }

    /**
     * Creates new instance of itself and returns it
     * 
     * @param   int       $index
     * @param   Config    $Config
     * @return static
     */
    public static function createInstance($index, Config $Config = null)
    {
        return new static($index, $Config);
    }

    public function exists()
    {
        $index = $this->getIndex();
        return $this->getSessionStorage()->has($this->getConfig()->getPrefix().$index);
    }
    /**
     * Loads message from session
     * 
     * @return $this
     */
    public function load()
    {
        $index = $this->getIndex();
        if(is_null($index))
        {
            throw new \InvalidArgumentException('Loading session message failed. Index is not set.');
        }

        $this->setData($this->getSessionStorage()->get($this->getConfig()->getPrefix().$index));
        
        return $this;
    }
    /**
     * Saves new message data into session or overwrites existing one. 
     * 
     * @return $this
     */
    public function save()
    {
        $index = $this->getIndex();
        if(is_null($index))
        {
            $index = tlsm_messages()->getLastIndex();
            $index = $index === false ? 0 : $index + 1;
        }
        $this->setIndex($index);
        
        $this->getSessionStorage()->set($this->getConfig()->getPrefix().$index, $this->getData());
        
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
        $this->getSessionStorage()->remove($this->getConfig()->getPrefix().$index);

        return $this;
    }
    
    // aliases
    /**
     * Sets method to ::METHOD_PERSIST
     * equivalent of setMethod(self::METHOD_PERSIST);
     * 
     * @return $this
     */
    public function persist()
    {
        $this->setMethod(self::METHOD_PERSIST);
        return $this;
    }
    /**
     * Sets method to ::METHOD_FLASH
     * equivalent of setMethod(self::METHOD_FLASH);
     * 
     * @return $this
     */
    public function flash()
    {
        $this->setMethod(self::METHOD_FLASH);
        return $this;
    }
    /**
     * Sets method to ::METHOD_REMOVABLE
     * equivalent of setMethod(self::METHOD_REMOVABLE);
     *
     * @return $this
     */
    public function removable()
    {
        $this->setMethod(self::METHOD_REMOVABLE);
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
     * Appends new CSS classes
     * 
     * @param string|array $class
     * @return $this
     */
    public function addClasses($class)
    {
        if(is_array($class))
        {
            $class = implode(' ', $class);
        }
        $this->setClasses($this->getClasses().' '.$class);
        return $this;
    }
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