<?php

class Image extends Item {
    public function __construct($config) {
        parent::__construct($config);

        $img2 = new Imagick($this->getValue());

        /* Take dimensions from the referred image if none is provided */
        if ($this->getWidth() === 0)
            $this->setWidth($img2->getImageWidth());
        if ($this->getHeight() === 0)
            $this->setHeight($img2->getImageHeight());

        $this->createImage();
        $img = $this->getImage();
        $img2->resizeImage($this->getWidth(), $this->getHeight(), imagick::FILTER_UNDEFINED, 1);
        $img->compositeImage($img2, Imagick::COMPOSITE_DEFAULT, 0, 0);
    }
}

?>
