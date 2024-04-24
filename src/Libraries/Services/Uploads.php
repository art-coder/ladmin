<?php

namespace Artcoder\Ladmin\Libraries\Services;

use Image;

class Uploads
{

    public $disks;

    public function __construct($disks = '')
    {
        if ($disks) {
            $this->setDisks($disks);
        } else {
            $disks = config('filesystems.default');
            $this->setDisks($disks);
        }
    }

    public function setDisks($disks)
    {
        $this->disks = $disks;
        return $this;
    }

    public function file($file, $path = '')
    {
        // return $file;
        if ($this->disks == 'local') {
            return $this->upWithLocal($file, $path);
        } else {
            return $this->upWithClond($file, $path);
        }
    }

    public function fileWithThumb($file, $path = '', $width = 200, $height = false)
    {
        $url   = $this->file($file, $path);
        $thumb = $this->thumb($url, $width, $height);
        return [$url, $thumb];
    }

    public function fit($path, $width, $height = false)
    {
        if ($this->disks == 'local') {
            return $this->fitWithLocal($path, $width, $height);
        } else {
            return $this->fitWithClond($path, $width, $height);
        }
    }

    public function fitWithLocal($path, $width, $height)
    {
        $img  = Image::make(public_path($path));
        $temp = explode('.', $path);
        if (count($temp) != 2) {
            return $path;
        }
        $thumb = $temp[0] . '_fit' . '.' . $temp[1];
        if ($height) {
            $img->fit($width, $height)->save($thumb);
        } else {
            $img->fit($width, $width, function ($constraint) {
                $constraint->upsize();
            })->save($thumb);
        }
        return $thumb;
    }

    public function fitWithClond($path, $width, $height)
    {
        return null;
    }

    public function thumb($path, $width, $height = false)
    {
        if ($this->disks == 'local') {
            return $this->thumbWithLocal($path, $width, $height);
        } else {
            return $this->thumbWithClond($path, $width, $height);
        }
    }

    public function thumbWithLocal($path, $width, $height)
    {
        $img  = Image::make(public_path($path));
        $temp = explode('.', $path);
        if (count($temp) != 2) {
            return $path;
        }
        $thumb = $temp[0] . '_thumb' . '.' . $temp[1];
        if ($height) {
            $img->resize($width, $height)->save($thumb);
        } else {
            $img->resize($width, $width, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumb);
        }
        return $thumb;
    }

    public function thumbWithClond($path, $width, $height)
    {
        return null;
    }

    public function delete($path)
    {
        if ($this->disks == 'local') {
            return $this->deleteWithLocal($path);
        } else {
            return $this->deleteWithClond($path);
        }
    }

    protected function deleteWithClond($path)
    {
        return true;
    }

    protected function deleteWithLocal($path)
    {
        $disks = config('filesystems.disks.' . $this->disks);
        $path  = $disks['root'] . $path;
        if (file_exists($path)) {
            return @unlink($path);
        }
        return false;
    }

    protected function upWithClond($file, $folder = '')
    {
        if (!$folder) {
            $disks = config('filesystems.disks.' . $this->disks);
            if (isset($disks['root'])) {
                $folder =  $disks['root'];
            } else {
                $folder = date('Y/m');
            }
        }
        $ups    = $file->store($folder, $this->disks);
        $domain = isset($disks['url']) ? $disks['url'] : '';
        return $domain . '/' . $ups;
    }

    protected function upWithLocal($file, $path = '')
    {
        if (is_string($file)) {
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $file, $result)) {
                $type = $result[2];
                if ($path) {
                    $path = $path . '/' . date('Y/m/d', time());
                } else {
                    $path = date('Y/m/d', time());
                }
                $path = 'uploads/' . $path;
                if (!is_dir(public_path($path))) {
                    mkdir(public_path($path), 0777, true);
                }
                $files = $path . '/' . md5(time() . '_' . uniqid()) . ".{$type}";
                $path  = public_path($files);
                if (file_put_contents($path, base64_decode(str_replace($result[1], '', $file)))) {
                    return $files;
                }
                return '';
            }
            return '';
        } else {
            $path = $file->store(($path ? $path . '/' : '') . date('Y/m/d', time()));
            return '/uploads/' . $path;
        }
    }
}
