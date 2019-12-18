<?php

namespace Powerhouse\Gate\Http;

class Request
{

    /**
     * Repository.
     * 
     * @var array
     */
    private static $repository = [
        'input' => []
    ];
    
    /**
     * Indicates whether the object has already been initialized.
     * 
     * @var bool
     */
    private static $init = false;

    /**
     * Create a new instance of Request.
     */
    public function __construct()
    {
        if (! self::$init) {
            parse_str(file_get_contents("php://input"), self::$repository['input']);
            self::$init = true;
        }
    }

    /**
     * Get the http GET request variables.
     * 
     * @param  string  $name
     * @return string
     */
    public function get(string $name)
    {
        return $_GET[$name] ?? null;
    }

    /**
     * Get the http POST request variables.
     * 
     * @param  string  $name
     * @return string
     */
    public function post(string $name)
    {
        return $_POST[$name] ?? null;
    }

    /**
     * Get the http INPUT request variables.
     * 
     * @param  string  $name
     * @return string
     */
    public function input(string $name)
    {
        return self::$repository[$name] ?? null;
    }

    /**
     * Get the http FILE request data.
     * 
     * @param  string  $name
     * @return string
     */
    public function file(string $name)
    {
        return $_FILES[$name] ?? null;
    }

    /**
     * Get the http request variables.
     * 
     * @param  string  $name
     * @return string
     */
    public function __get(string $name)
    {
        switch (http()->method()) {
            case 'GET':
                return $this->get($name);
            case 'POST':
                return $this->post($name);
            default:
                return $this->input($name);
        }
    }

}