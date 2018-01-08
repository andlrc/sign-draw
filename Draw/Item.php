<?php

class Item {
    private $width = 0;
    private $height = 0;
    private $image = NULL;
    private $backgroundColor = 'none';
    private $value = '';

    public $posHorizontalAlign = 'left';	/* left, center, right */
    public $posVerticalAlign = 'top';		/* top, center, bottom */
    public $posHorizontalOffset = 0;		/* integer */
    public $posVerticalOffset = 0;		/* integer */

    public static function create($config) {
        $className = ucfirst($config['type']);
        return new $className($config);
    }

    public function __construct($config) {
        if (isset($config['width']))
            $this->setWidth($config['width']);
        if (isset($config['height']))
            $this->setHeight($config['height']);

        if (isset($config['backgroundColor']))
            $this->backgroundColor = $config['backgroundColor'];

        if (isset($config['value']))
            $this->value = $config['value'];

        if (isset($config['posHorizontalAlign']))
            $this->posHorizontalAlign = $config['posHorizontalAlign'];
        if (isset($config['posVerticalAlign']))
            $this->posVerticalAlign = $config['posVerticalAlign'];

        if (isset($config['posHorizontalOffset']))
            $this->posHorizontalOffset = $config['posHorizontalOffset'];
        if (isset($config['posVerticalOffset']))
            $this->posVerticalOffset = $config['posVerticalOffset'];
    }
    protected function createImage() {
        if ($this->image)
            throw new Exception('Image already created');
        $img = new Imagick();
        $img->newImage($this->getWidth(), $this->getHeight(), $this->backgroundColor, 'png');
        $this->image = $img;
    }
    public function finalize() {
        $img = $this->getImage();
        return $img;
    }
    public function getImage() {
        if (!$this->image)
            throw new Exception('Image not created');
        return $this->image;
    }
    protected function getValue() {
        return $this->value;
    }

    protected function setWidth($w) {
        $this->width = $w;
    }
    protected function setHeight($h) {
        $this->height = $h;
    }
    public function getWidth($withOffset = FALSE) {
        $width = $this->width;
        if ($withOffset)
            $width += $this->posHorizontalOffset;

        return $width;
    }
    public function getHeight($withOffset = FALSE) {
        $height = $this->height;
        if ($withOffset)
            $height += $this->posVerticalOffset;

        return $height;
    }

    /* Returns the width the canvas needs to render, returns 0 when the canvas
     * is floating */
    protected function getCanvasWidth() {
        if ($this->posHorizontalAlign !== 'center')
            return $this->getWidth(TRUE);
        else
            return 0;
    }

    /* Returns the height the canvas needs to render, returns 0 when the canvas
     * is floating */
    protected function getCanvasHeight() {
        if ($this->posVerticalAlign !== 'center')
            return $this->getHeight(TRUE);
        else
            return 0;
    }

}

?>
