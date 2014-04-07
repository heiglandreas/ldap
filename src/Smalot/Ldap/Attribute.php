<?php

/**
 * @file
 *          PHP library which handle LDAP data. Can parse too LDIF file.
 *
 * @author  Sébastien MALOT <sebastien@malot.fr>
 * @license MIT
 * @url     <https://github.com/smalot/ldap>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Smalot\Ldap;

/**
 * Class Attribute
 *
 * @package Smalot\Ldap
 */
class Attribute
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $values;

    /**
     * @param string $name
     * @param mixed  $values
     */
    public function __construct($name, $values = array())
    {
        $this->name = $name;
        $this->set($values);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param string $default
     *
     * @return string
     */
    public function getValue($default = '')
    {
        if (count($this->values)) {
            return implode(',', $this->values);
        } else {
            return $default;
        }
    }

    /**
     * @param mixed $values
     *
     * @return $this
     */
    public function set($values)
    {
        if (!is_array($values)) {
            if (null !== $values) {
                $values = array($values);
            } else {
                $values = array();
            }
        }

        $values       = array_unique($values);
        $this->values = array_values($values);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function has($value)
    {
        return (array_search($value, $this->values) !== false);
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function add($value)
    {
        $values   = $this->values;
        $values[] = $value;

        $this->set($values);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function remove($value)
    {
        if ($key = array_search($value, $this->values)) {
            unset($this->values[$key]);
            $this->values = array_values($this->values);
        }

        return $this;
    }
}
