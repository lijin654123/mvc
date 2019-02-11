<?php
class Psr4Autoload
{
    protected $maps = [];
    public function __construct()
    {
        spl_autoload_register([$this, 'autoload']);
    }

    public function autoload($className)
    {
        $pos = strrpos($className, '\\');
        $namespace = substr($className, 0, $pos);
        $realClass = substr($className, $pos + 1);
        $this->mapLoad($namespace, $realClass);
    }
    public function mapLoad($namespace, $realClass)
    {
        if (array_key_exists($namespace, $this->maps)) {
            $namespace = $this->maps[$namespace];
        }
        $namespace = rtrim(str_replace('\\', '/', $namespace), '/') . '/';
        $filePath = $namespace . $realClass . '.php';
        if (file_exists($filePath)) {
            include $filePath;
        } else {
            die;
        }
    }
    public function addMaps($namespace, $path)
    {
        if (array_key_exists($namespace, $this->maps)) {
            die('已映射');
        }
        $this->maps[$namespace] = $path;
    }
}
