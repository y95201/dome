<?php
/*
 * @Author: Y95201 
 * @Date: 2022-04-01 14:41:21 
 * @Last Modified by: Y95201
 * @Last Modified time: 2022-04-08 15:45:41
 */
namespace Y95201\Core;
use Y95201\Core\Arr;
class Collection 
{
    /**
     * The collection data.
     */
    protected $items = [];

    /**
     * set data.
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Return all items.
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Return specific items.
     */
    public function only(array $keys)
    {
        $return = [];
        foreach ($keys as $key) {
            $value = $this->get($key);
            if (!is_null($value)) {
                $return[$key] = $value;
            }
        }
        return $return;
    }

    /**
     * Get all items except for those with the specified keys.
     */
    public function except($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        return new static(Arr::except($this->items, $keys));
    }

    /**
     * Merge data.
     */
    public function merge($items)
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }
        return $this->all();
    }

    /**
     * To determine Whether the specified element exists.
     */
    public function has($key)
    {
        return !is_null(Arr::get($this->items, $key));
    }

    /**
     * Retrieve the first item.
     */
    public function first()
    {
        return reset($this->items);
    }

    /**
     * Retrieve the last item.
     */
    public function last()
    {
        $end = end($this->items);
        reset($this->items);
        return $end;
    }

    /**
     * add the item value.
     */
    public function add($key, $value)
    {
        Arr::set($this->items, $key, $value);
    }

    /**
     * Set the item value.
     */
    public function set($key, $value)
    {
        Arr::set($this->items, $key, $value);
    }

    /**
     * Retrieve item from Collection.
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->items, $key, $default);
    }

    /**
     * Remove item form Collection.
     */
    public function forget($key)
    {
        Arr::forget($this->items, $key);
    }

    /**
     * Build to array.
     */
    public function toArray()
    {
        return $this->all();
    }

    /**
     * Build to json.
     */
    public function toJson($option = JSON_UNESCAPED_UNICODE)
    {
        return json_encode($this->all(), $option);
    }

    /**
     * To string.
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Get a data by key.
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON.
     */
    public function jsonSerialize()
    {
        return $this->items;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object.
     */
    public function serialize()
    {
        return serialize($this->items);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator.
     */
    public function getIterator()
    {
        return ArrayIterator($this->items);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object.
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object.
     */
    public function unserialize($serialized)
    {
        return $this->items = unserialize($serialized);
    }
    
    /**
     * Assigns a value to the specified data.
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Whether or not an data exists by key.
     */
    public function __isset($key)
    {
        return $this->has($key);
    }

    /**
     * Unsets an data by key.
     */
    public function __unset($key)
    {
        $this->forget($key);
    }

    /**
     * var_export.
     */
    public function __set_state()
    {
        return $this->all();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists.
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset.
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            $this->forget($offset);
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve.
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->get($offset) : null;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set.
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }
}