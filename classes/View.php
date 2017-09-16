<?php


namespace App\Classes;


class View
    implements \Iterator

{

    private $data = [];

    public function render($url)
    {
        foreach ($this->data as $key => $val) {
            $$key = $val;
        }
        ob_start();
        include __DIR__ . '/../views/' . $url;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;

    }

    public function display($template){
        echo $this->render($template);
    }


    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }

    public function __get($k)
    {
        return $this->data[$k];
    }



// Итератор для работы с объектом как с массивом
    public function current()
    {
        $data = current($this->data);
        return $data;
    }


    public function next()
    {
        $data = next($this->data);
        return $data;
    }


    public function key()
    {
        $data = key($this->data);
        return $data;
    }


    public function valid()
    {
        $key = key($this->data);
        $data = ($key !== NULL && $key !== FALSE);
        return $data;
    }


    public function rewind()
    {
        reset($this->data);
    }
}
