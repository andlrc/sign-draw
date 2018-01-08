<?php

class Text extends Item {
    public function __construct($config) {
        parent::__construct($config);

        $this->setFont($config['fontFamily']);
        $this->setFontSize($config['fontSize']);
        $this->setFillColor($config['color']);

        $draw = new ImagickDraw();
        $draw->setFont($this->font);
        $draw->setFontSize($this->fontSize);
        $draw->setFillColor($this->fillColor);

        /* Set font quality */
        $draw->setStrokeAntialias(true);
        $draw->setTextAntialias(true);

        /* Detect the bounds of the text */
        $img = new Imagick();
        $metrics = $img->queryFontMetrics($draw, $this->getValue(), FALSE);
        $width = $metrics['textWidth'];
        $height = $metrics['textHeight'];
        $ascender = $metrics['ascender'];

        $this->setWidth($width);
        $this->setHeight($height);

        /* Create the image */
        $this->createImage();
        $img = $this->getImage();
        $img->annotateImage($draw, 0, $ascender, 0, $this->getValue());

    }
    private function setFont($fontName) {
        $this->font = "./$fontName.ttf";
    }
    private function setFontSize($fontSize) {
        $this->fontSize = $fontSize;
    }
    private function setFillColor($color) {
        $this->fillColor = $color;
    }
}

?>
