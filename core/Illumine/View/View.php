<?php

namespace Illumine\View;

class View
{

    /**
     * The view collection instance.
     *
     * @var array \Illumine\View\View
     */
    private $data = [];

//    /**
//     * The view environment instance.
//     *
//     * @var \Illumine\View\Environment
//     */
//
//    private $environment;

//    /**
//     * Create a new view instance.
//     *
//     * @param  \Illumine\View\Environment  $environment
//     * @return void
//     */
//    public function __construct(Environment $environment)
//    {
//        $this->environment = $environment;
//    }

//    /**
//     * Get the view environment instance.
//     *
//     * @return \Illumine\View\Environment
//     */
//    public function getEnvironment()
//    {
//        return $this->environment;
//    }

    /**
     * Get the view data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the view data.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get a piece of view data.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->data[$key];
    }

    /**
     * Set a piece of view data.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Add a piece of view data.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return $this
     */
    public function add($key, $value)
    {
        if (isset($this->data[$key])) {
            $this->data[$key] .= $value;
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Add a view instance to the view data.
     *
     * @param  string  $key
     * @param  \Illumine\View\View  $view
     * @return $this
     */
    public function nest($key, View $view)
    {
        return $this->set($key, $view);
    }

    /**
     * Add a key / value pair to the view data.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return $this
     */
    public function with($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Add all of the view data to the view.
     *
     * @param  array  $data
     * @return $this
     */
    public function withAll(array $data)
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * Get the evaluated string content of the view.
     *
     * @return string
     */
    public function render($template)
    {
        ob_start();
        extract($this->data);
        require_once __DIR__."/../../../resources/views/{$template}.php";
        return ob_get_clean();
        //return $this->environment->getEngine()->get($this);
    }
}