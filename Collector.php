<?php

namespace Crada\Apidoc;

class Collector {

    protected $description;
    protected $method;
    protected $route;
    protected $params;
    protected $headers;
    protected $returnHeaders;
    protected $return;
    protected $body;

    public function __construct() {
        $this->init();
    }

    public function init() {
        $this->description = array();
        $this->method = array(array('type' => 'get'));
        $this->route = array();
        $this->params = array();
        $this->headers = array();
        $this->returnHeaders = array();
        $this->return = array();
        $this->body = array();
    }

    public function description($section, $description = '') {
        $this->description[0] = compact('section', 'description');
        return $this;
    }

    public function method($type) {
        $this->method[0] = compact('type');
        return $this;
    }

    public function route($name) {
        $this->route[0] = compact('name');
        return $this;
    }

    public function param($name, $type='', $nullable=true, $description='', $sample=null) {
        $this->params[] = compact('name', 'type', 'nullable', 'description', 'sample');
        return $this;
    }

    public function header($name, $type='', $nullable=true, $description='') {
        $this->headers[] = compact('name', 'type', 'nullable', 'description');
        return $this;
    }

    public function returnHeader($sample) {
        $this->returnHeaders[] = compact('sample');
        return $this;
    }

    public function returns($type, $sample) {
        $this->return[0] = compact('type', 'sample');
        return $this;
    }

    public function body($sample) {
        $this->body[0] = compact('sample');
        return $this;
    }

    public function build($initAfterBuild = true) {
        $result = array();

        $keys = array(
            'description',
            'method',
            'route',
            'params',
            'headers',
            'returnHeaders',
            'return',
            'body',
        );

        foreach ($keys as $key) {
            if (empty($this->{$key})) continue;
            $result['Api'.ucfirst($key)] = $this->{$key};
        }

        if ($initAfterBuild) {
            $this->init();
        }

        return array(
            $result['ApiMethod'][0]['type'] => $result,
        );
    }
}