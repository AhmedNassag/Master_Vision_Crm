<?php
namespace App\Http;
use Illuminate\Support\Facades\Route;
use App\Models\Upload;
use File;
use Image;
class Helpers { 
 
    public static function menuActive($route_name)
    {
        return Route::currentRouteName() == $route_name ? 'active' : '';
    }
 
    public static function manage_slug($lang) {
        $data = null;
        
        //general
        $data['name'] = "name_" . $lang; 
        $data['description'] = "description_" . $lang;
        $data['short_desc'] = "short_desc_" . $lang; 
        $data['sitename'] = "sitename_" . $lang; 
        $data['address'] = "address_" . $lang;
        $data['about_title'] = "about_title_". $lang;
        $data['about_short_desc'] = "about_short_desc_" . $lang; 
        $data['about_desc'] = "about_desc_" . $lang; 
        
                    
        return (Object) $data;
    }
    
    public static function view_image($value, $thumb=0)
    {
        if($value != 0) {
            $upload = \App\Models\Upload::find($value);
        }
        if(isset($upload->id)) {
            if(url("files/".$upload->hash.'/'.$upload->name.'/'.$thumb))
                return url("files/".$upload->hash.'/'.$upload->name.'/'.$thumb);
            else
            {
                $upload=\App\Models\Upload::find(0);
                return url("files/".$upload->hash.'/'.$upload->name.'/'.$thumb);
            }
        }
        $upload=\App\Models\Upload::find(0);
        return url("files/".$upload->hash.'/'.$upload->name.'/'.$thumb);
    }
    public static function resize($image, $width=0, $height=0, $thumb=1)
    {
        $path=$image->path;
        $new_path = storage_path("thumbnails/".basename($image->path));
        if($thumb==0)
            $new_path=$path;
        else if($thumb==2)
        {
            $new_path = storage_path("thumbnails/thumb-".basename($image->path));
        }
        $file_name= basename($path);
        $date=str_replace($image->name,"",$file_name);
        
        //dd($folder,$file_name,$date);
        if(!file_exists($path))
            return;
        $file=new File($path);
        list($org_width, $org_height) = getimagesize($path);
        if(!empty($width) && !empty($height))
        {
            if($org_height>$org_width) //if heidht is greater
            {
                if($height<$width) //if height is greater but in resize is smaller resize according to height
                {
                    $new_height=$height;
                    $new_width=floor($new_height*$org_width/$org_height);
                }
                else //if height is greater and also in resize resize according to width
                {
                    $new_width=$width;
                    $new_height=floor($new_width*$org_height/$org_width);
                }
            }
            else if($org_height<$org_width)
            {
                if($height>$width) //if height is smaller but in resize is greater resize according to width
                {
                    $new_width=$width;
                    $new_height=floor($new_width*$org_height/$org_width);
                }
                else //if height is smaller and also in resize resize according to height
                {

                    $new_height=$height; 
                    $new_width=floor($new_height*$org_width/$org_height);
                }
            }
            else //if square resize to the smallest
            {
                $new_height =$new_width=min(array($width, $height));
            }
        }
        else
        {
            list($new_width, $new_height) = getimagesize($path);
        }
        
        $no_type=false;
        $extension= exif_imagetype($path);
        
        $thumb = imagecreatetruecolor($new_width, $new_height);
                
        switch($extension)
        {
            case IMAGETYPE_GIF:
                $source =imagecreatefromgif($path);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $org_width, $org_height);
                imagegif($thumb, $new_path);    break;
            case IMAGETYPE_JPEG:
                $source =imagecreatefromjpeg($path);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $org_width, $org_height);
                imagejpeg($thumb, $new_path);
            break;
            case IMAGETYPE_PNG:
                $source =imagecreatefrompng($path);
                imagealphablending($thumb, false);
                imagesavealpha($thumb,true);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $org_width, $org_height);
                imagepng($thumb,$new_path);
            break;
            /*case IMAGETYPE_WEBP:
                $source=imagecreatefromwebp($path);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $org_width, $org_height);
                imagewebp($thumb, $new_path);
            break;*/
            default:
                Image::make($path)->resize($new_width, $new_height)->save($new_path);
            break;
        }
        
        //$upload_success = Input::file('file')->move($folder, $date_append.$filename);

    }
    
    public static function slug($name){
        return strtolower(str_replace(" ", "-", preg_replace("/[^\x{0600}-\x{06FF}A-Za-z0-9\s\/]/u", "",trim($name))));
    }
    public static function default_image($header=false)
    {
        if($header)
            return 'assets/imgs/bg11.jpg';
        return 'files/tunxh9knve9t4ys8leya/logo-wide.png';
    }
}