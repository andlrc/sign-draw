<?php

class Group extends Item {
    public function __construct($config) {
        parent::__construct($config);

        $this->layout = $config['layout'];

        $width = $this->getWidth();
        $height = $this->getHeight();

        $this->items = [];
        foreach ($config['items'] as $itemConfig) {
            $item = Item::create($itemConfig);
            array_push($this->items, $item);

            /* Figure out width and height for the group */
            switch ($this->layout) {
            case 'vertical':
                $width = max($width, $item->getCanvasWidth());
                $height += $item->getCanvasHeight();
                break;
            case 'horizontal':
                $width += $item->getCanvasWidth();
                $height = max($height, $item->getCanvasHeight());
                break;
            case 'absolute':
                /* NOOP */
                break;
            }
        }

        $this->setWidth($width);
        $this->setHeight($height);
    }

    private function getAbsoluteX($item) {
        switch ($item->posHorizontalAlign) {
        case 'left':
            return $item->posHorizontalOffset;
        case 'right':
            return $this->getWidth() - $item->posHorizontalOffset - $item->getWidth();
        case 'center':
            return $this->getWidth()/2 - $item->getWidth()/2 + $item->posHorizontalOffset;
            break;
        }
    }

    private function getAbsoluteY($item) {
        switch ($item->posVerticalAlign) {
        case 'top':
            return $item->posVerticalOffset;
        case 'bottom':
            return $this->getHeight() - $item->posVerticalOffset - $item->getHeight();
        case 'center':
            return $this->getHeight()/2 - $item->getHeight()/2 + $item->posVerticalOffset;
        }
    }

    private function getRelativeX($item, &$bounds) {
        switch ($item->posHorizontalAlign) {
        case 'left':
            $x = $bounds[0] + $item->posHorizontalOffset;
            $bounds[0] = $x + $item->getWidth();
            break;
        case 'right':
            $x = $bounds[1] + $item->posHorizontalOffset - $item->getWidth();
            $bounds[1] = $x;
            break;
        case 'center':
            $x = $this->getAbsoluteX($item);
        }
        return $x;
    }

    private function getRelativeY($item, &$bounds) {
        switch ($item->posVerticalAlign) {
        case 'top':
            $y = $bounds[0] + $item->posVerticalOffset;
            $bounds[0] = $y + $item->getHeight();
            break;
        case 'bottom':
            $y = $bounds[1] + $item->posVerticalOffset - $item->getHeight();
            $bounds[1] = $y;
            break;
        case 'center':
            $y = $this->getAbsoluteY($item);
        }
        return $y;
    }

    public function finalize() {
        /* Child groups inherit our size if the "layout" dictates it */
        foreach ($this->items as $item) {
            if ($item instanceof Group) {
                switch ($this->layout) {
                case 'vertical':
                    $item->setWidth($this->getWidth());
                    break;
                case 'horizontal':
                    $item->setHeight($this->getHeight());
                    break;
                case 'absolute':
                    /* NOOP */
                }
            }
            $item->finalize();
        }

        $this->createImage();
        $img = $this->getImage();

        switch ($this->layout) {
        case 'vertical':
            $bounds = [0, $this->getHeight()];
            break;
        case 'horizontal':
            $bounds = [0, $this->getWidth()];
            break;
        case 'absolute':
            /* NOOP */
        }

        foreach ($this->items as $item) {
            $itemImage = $item->getImage();

            $x = 0;
            $y = 0;

            switch ($this->layout) {
            case 'vertical':
                $x = $this->getAbsoluteX($item);
                $y = $this->getRelativeY($item, $bounds);

                break;
            case 'horizontal':
                $x = $this->getRelativeX($item, $bounds);
                $y = $this->getAbsoluteY($item);

                break;
            case 'absolute':
                $x = $this->getAbsoluteX($item);
                $y = $this->getAbsoluteY($item);
                break;
            }

            $img->compositeImage($itemImage, Imagick::COMPOSITE_DEFAULT, $x, $y);
        }
        return parent::finalize();
    }
}

?>
