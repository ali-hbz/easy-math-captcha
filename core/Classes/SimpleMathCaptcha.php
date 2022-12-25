<?php

namespace Core\Classes;

class SimpleMathCaptcha
{
    private $width = 150;

    private $height = 50;

    private $xAxis = 35;

    private $yAxis = 40;

    private $backgroundColorRGB = [204, 229, 255];

    private $textFontSize = 30;

    private $textColorRGB = [0, 64, 133];

    private $textFont = 'aovel';

    private $textFontPath = [
        'aovel' => __DIR__ . '/../../assets/fonts/aovel.ttf',
        'iransans' => __DIR__ . '/../../assets/fonts/iransans.ttf',
    ];

    private $question;

    private $answer;

    public function __construct()
    {
        $firstNumber = rand(1, 5);
        $secondNumber = rand(1, 5);
        $this->question = "$firstNumber + $secondNumber";
        $this->answer = $firstNumber + $secondNumber;
    }

    public function output()
    {
        try {
            $image = $this->createImage();
            if (!$image) {
                throw new \Exception('some problem to render captcha image.');
            }

            header('Content-Type: image/png');
            imagepng($image);
            imagedestroy($image);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function setTextColor($red, $green, $blue)
    {
        $this->textColorRGB = [$red, $green, $blue];
    }

    public function setBackgroundColor($red, $green, $blue)
    {
        $this->backgroundColorRGB = [$red, $green, $blue];
    }

    public function getAnswer(): int
    {
        return $this->answer;
    }

    public function setFont($name)
    {
        $font = null;
        if (in_array($name, array_keys($this->textFontPath))) {
            $font = $name;
        } else if (count($this->textFontPath) >= 1) {
            $font = array_reverse($this->textFontPath);
            $font = end($font);
        }

        if ($font) {
            $this->textFont = $font;
        }
    }

    // region private
    private function createImage()
    {
        try {
            $image = imagecreatetruecolor($this->width, $this->height);

            if (!$image) {
                throw new  \Exception("new image can't be create.");
            }

            if (!empty($this->textColorRGB) && count($this->textColorRGB) == 3) {
                $this->textColorRGB = array_map(function ($item) {
                    return intval($item);
                }, $this->textColorRGB);

                $textColor = imagecolorexact($image, $this->textColorRGB[0], $this->textColorRGB[1], $this->textColorRGB[2]);
            }

            if (!empty($this->backgroundColorRGB) && count($this->backgroundColorRGB) == 3) {
                $this->backgroundColorRGB = array_map(function ($item) {
                    return intval($item);
                }, $this->backgroundColorRGB);

                $backgroundColor = imagecolorallocate($image, $this->backgroundColorRGB[0], $this->backgroundColorRGB[1], $this->backgroundColorRGB[2]);
            }

            if (empty($backgroundColor) || empty($textColor)) {
                throw new \Exception('captcha text and background color not set.');
            }

            if (empty($this->textFontPath)) {
                throw new \Exception('captcha text font not valid.');
            }

            imagefill($image, 0, 0, $backgroundColor);

            imagefttext(
                $image,
                $this->textFontSize,
                0,
                $this->xAxis,
                $this->yAxis,
                $textColor,
                $this->textFontPath[$this->textFont],
                $this->question
            );

            return $image;

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }
    // endregion
}