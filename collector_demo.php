<?php

spl_autoload_register(function ($className) {
    $className = ltrim($className, '\\');
    $fileName = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    require substr($fileName, strlen('Crada\\Apidoc\\'));
});

use Crada\Apidoc\Builder;
use Crada\Apidoc\Exception;
use Crada\Apidoc\Collector;

$docs = array();

$c = new Collector;
$docs[] = $c->description('User', 'Retrieve an User Info.')->route('/api/user/{id}')->build();
$docs[] = $c->description('User', 'Create User.')->method('post')->route('/api/user')
    ->param('name', 'String', false, 'username')
    ->body(http_build_query(array(
        'email' => 'php@html.js.cn',
    )))
    ->returns('object', json_encode(array(
        'id' => uniqid(),
    )))
    ->build();

$output_dir = __DIR__ . '/apidocs';
$output_file = 'api.html'; // defaults to index.html

try {
    $builder = new Builder($docs, $output_dir, 'Api Title', $output_file);
    $builder->generate();
} catch (Exception $e) {
    echo 'There was an error generating the documentation: ', $e->getMessage();
}
