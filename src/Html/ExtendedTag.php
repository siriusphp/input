<?php
namespace Sirius\Forms\Html;

/**
 * Extended class for building HTML elements.
 *
 * It offers an interface similar to jQuery's DOM handling functionality
 * (besides the Input's class functionality)
 * - before(): add something bofore the element
 * - after(): add something after the element;
 */
class ExtendedTag extends BaseTag
{

    /**
     * The HTML tag
     *
     * @var string
     */
    protected $tag = 'div';

    /**
     * Is the element self enclosing
     *
     * @var bool
     */
    protected $isSelfClosing = false;

    /**
     * Name of the input element / label
     *
     * @var string
     */
    protected $name;

    /**
     * Items (strings) to be added before the element
     *
     * @var array
     */
    protected $before = array();

    /**
     * Items (strings) to be added after the element
     *
     * @var array
     */
    protected $after = array();

    /**
     * Factory method to allow for chaining since setters return the same object
     *
     * @param array $options
     * @param string $tag
     * @param bool $isSelfClosing
     * @return \Sirius\Forms\Html\Tag
     */
    static function create($options = array(), $tag = null, $isSelfClosing = false)
    {
        $widget = new static($options);
        if ($tag && is_string($tag)) {
            $widget->tag = $tag;
            $widget->isSelfClosing = $isSelfClosing;
        }
        return $widget;
    }

    function __construct($options = array())
    {
        if (isset($options['attrs'])) {
            parent::__construct($options['attrs']);
        } else {
            parent::__construct();
        }
        if (isset($options['data'])) {
            $this->setData($options['data']);
        }
        if (isset($options['text'])) {
            $this->setText($options['text']);
        }
    }

    /**
     * Add a string or a stringifiable object immediately before the element
     *
     * @param string|object $stringOrObject
     * @return \Sirius\Forms\Renderer\Widget\Base
     */
    function before($stringOrObject)
    {
        array_unshift($this->before, $stringOrObject);
        return $this;
    }

    /**
     * Add a string or a stringifiable object immediately after the element
     *
     * @param string|object $stringOrObject
     * @return \Sirius\Forms\Renderer\Widget\Base
     */
    function after($stringOrObject)
    {
        array_push($this->after, $stringOrObject);
        return $this;
    }

    /**
     * Add something before and after the element.
     * Proxy for calling before() and after() simoultaneously
     *
     * @param string|object $before
     * @param string|object $after
     * @return \Sirius\Forms\Renderer\Widget\Base
     */
    function wrap($before, $after)
    {
        return $this->before($before)->after($after);
    }

    /**
     * Render the element
     *
     * @return string
     */
    function render()
    {
        $before = '';
        foreach ($this->before as $item) {
            $before .= (string)$item;
        }
        $after = '';
        foreach ($this->after as $item) {
            $after .= (string)$item;
        }
        return $before . parent::render() . $after;
    }


}

