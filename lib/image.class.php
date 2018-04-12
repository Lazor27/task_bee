<?php

class Image {
    public $path ;
    public $tmp_path ;
    public $max_x_size = 320;
    public $max_y_size = 240;

    public function resize($file, $type = 1, $quality = null)
    {
        $tmp_path = $this->tmp_path;
        $quality = 75;

        if ($file['type'] == 'image/jpg')
            $source = imagecreatefromjpeg($file['tmp_name']);
        elseif ($file['type'] == 'image/png')
            $source = imagecreatefrompng($file['tmp_name']);
        elseif ($file['type'] == 'image/gif')
            $source = imagecreatefromgif($file['tmp_name']);

        $src = $source;
        $w_src = imagesx($src);
        $h_src = imagesy($src);
        $w = $this->max_x_size;
        $h = $this->max_y_size;

        if ($w_src > $w  )
        {
            if($w_src > $h_src ) {
                $ratio = $w_src / $w;
            }else {
                $ratio = $h_src / $h;
            }

        $w_dest = round($w_src/$ratio);
        $h_dest = round($h_src/$ratio);

        $dest = imagecreatetruecolor($w_dest, $h_dest);
        imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

        imagejpeg($dest, $tmp_path . $file['name'], $quality);
        imagedestroy($dest);
        imagedestroy($src);

        return $file['name'];
        } else {
            // Вывод картинки и очистка памяти
        imagejpeg($src, $tmp_path . $file['name'], $quality);
        imagedestroy($src);

        return $file['name'];
        }
    }

    public function delete_tmp($name)
    {   copy($this->tmp_path . $name, $this->path . $name);
        unlink($this->tmp_path . $name);
        rmdir($this->tmp_path);
    }

    public function  __construct($path , $tmp_path)
    {
        $this->path = $path;
        $this->tmp_path = $tmp_path;
    }
}