<?php
namespace framework;

/**
 *
 */
class Tpl
{
    protected $viewDir = './app/view';
    protected $cacheDir = './cache';
    protected $lifeTime = 3600;
    protected $vars = [];
    public function __construct($viewDir = null, $cacheDir = null, $lifeTime = null)
    {
        if (!empty($viewDir)) {
            if ($this->checkDir($viewDir)) {
                $this->viewDir = $viewDir;
            }
        }
        if (!empty($cacheDir)) {
            if ($this->checkDir($cacheDir)) {
                $this->cacheDir = $cacheDir;
            }
        }
        if (!empty($lifeTime)) {
            $this->lifeTime = $lifeTime;
        }
    }
    public function checkDir($dirPath)
    {
        if (!file_exists($dirPath) || !is_dir($dirPath)) {
            return mkdir($dirPath, 0755, true);
        }
        if (!is_writable($dirPath) || !is_readable($dirPath)) {
            return chmod($dirPath, 0755);
        }
        return true;
    }

    public function assign($name, $value)
    {
        $this->vars[$name] = $value;
    }
    /**
     *string $viewName 模板文件名
     *boolean $isInclude 是否需要包含进来再编译
     *boolean $uri 分页
     */
    public function display($viewName, $isInclude = true, $uri = null)
    {
        //拼接模板文件的全路径
        $viewPath = rtrim($this->viewDir, '/') . '/' . $viewName;
        if (!file_exists($viewPath)) {die('模板不存在');}
        //拼接缓存文件的全路径
        $cacheName = md5($viewName . $uri) . '.php';
        $cachePath = rtrim($this->cacheDir, '/') . '/' . $cacheName;
        //判断缓存文件是否存在，过期，被修改
        if (!file_exists($cachePath)) {
            $php = $this->complie($viewPath);
            file_put_contents($cachePath, $php);
        } else {
            $isTimeout = (filectime($cachePath) + $this->lifeTime) > time() ? false : true;
            $isChange = filemtime($cachePath) > filemtime($viewPath) ? false : true;
            if ($isTimeout || $isChange) {
                $php = $this->complie($viewPath);
                file_put_contents($cachePath, $php);
            }
        }
        //判断缓存文件是否需要包含进来
        if ($isInclude) {
            extract($this->vars);
            include $cachePath;
        }

    }

    protected function complie($filePath)
    {
        $html = file_get_contents($filePath);
        $arr = [
            '{$%%}' => '<?=$\1;?>',
            '{foreach %%}' => '<?php foreach(\1): ?>',
            '{/foreach}' => '<?php endforeach ?>',
            '{include %%}' => '',
            '{if %%}' => '<?php if (\1): ?>',
        ];

        foreach ($arr as $key => $value) {
            $pattern = '#' . str_replace('%%', '(.+?)', preg_quote($key, '#')) . '#';
            if (strstr($pattern, 'include')) {
                $html = preg_replace_callback($pattern, [$this, 'parseInclude'], $html);
            } else {
                $html = preg_replace($pattern, $value, $html);
            }
        }

        return $html;
    }
    //$data匹配到的内容
    protected function parseInclude($data)
    {
        $fileName = trim($data[1], '\'"');
        echo $fileName;
        $this->display($fileName, false);
        $cacheName = md5($fileName) . '.php';
        $cachePath = rtrim($this->cacheDir, '/') . '/' . $cacheName;
        return '<?php include"' . $cachePath . '"?>';
    }
}
