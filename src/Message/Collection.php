<?php
namespace Tarach\LSM\Message;

use Tarach\LSM\SessionStorage\TStorageAccess;

class Collection implements \Iterator, \Countable
{
    use TStorageAccess;
    
    /**
     * Inversion of control container id
     */
    const IOC_ID = 'tlsm_messages';
    
    /**
     * Iterator index
     * 
     * @var int
     */
    private $index = 0;
    /**
     * Unique prefix for messages
     * 
     * @var string
     */
    private $prefix = 'tarach_lsm_';

    /**
     * Creates new failure type message saves it and return object handler
     *
     * @param string $msg
     * @return Message
     */
    public function failure($msg)
    {
        return $this->message($msg, Message::TYPE_FAILURE);
    }
    /**
     * Creates new notify type message saves it and return object handler
     *
     * @param string $msg
     * @return Message
     */
    public function notify($msg)
    {
        return $this->message($msg, Message::TYPE_NOTIFY);
    }
    /**
     * Creates new success type message saves it and return object handler
     *
     * @param string $msg
     * @return Message
     */
    public function success($msg)
    {
        return $this->message($msg, Message::TYPE_SUCCESS);
    }
    /**
     * Creates new warning type message saves it and return object handler
     * 
     * @param string $msg
     * @return Message
     */
    public function warning($msg)
    {
        return $this->message($msg, Message::TYPE_WARNING);
    }
    /**
     * Creates new message and saves it
     * 
     * @param string $msg
     * @param int $type
     * @return Message
     */
    public function message($msg, $type)
    {
        return Message::createInstance(null, $this)
            ->setType($type)
            ->setMessage($msg)
            ->save();
    }
    
    // countable
    /**
     * @inheritdoc
     */
    public function count()
    {
        $count = 0;
        foreach($this as $Message)
        {
            $count++;
        }
        return $count;
    }
    
    // iterator
    /**
     * @inheritdoc
     */
    public function current()
    {
        return Message::createInstance($this->index(), $this)->load();
    }
    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->index++;
    }
    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->getPrefix().$this->index();
    }
    /**
     * Returns numeric index of current item
     * 
     * @return int
     */
    public function index()
    {
        return $this->index;
    }
    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->getSessionStorage()->has($this->key());
    }
    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->index = 0;
    }

    // getters
    /**
     * Return last index or bool false when there is no valid messages
     * 
     * @return int|false
     */
    public function getLastIndex()
    {
        $this->rewind();
        $index = -1;
        while($this->valid())
        {
            $index = $this->index();
            $this->next();
        }
        return $index < 0 ? false : $index;
    }
    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    // setters
    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }
    
    
}