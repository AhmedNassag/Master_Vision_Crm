<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
    }

    public function uploadFiles($files, $image_sizes=null)
    {
        $images = array();
        foreach ($files as $file) {

            $img = $this->uploadFile($file, $image_sizes);
            if (!empty($img)) {
                $images[] = $img;
            }
        }
        return $images;
    }
    public function uploadFile($file,$image_sizes=null)
    {
        $folder = storage_path('uploads');
        $filename = $file->getClientOriginalName();
        $date_append = date("Y-m-d-His-");
        $upload_success = $file->move($folder, $date_append . $filename);
        if ($upload_success) {
            $public = true;
            $upload = Upload::create([
                "name" => $filename,
                "path" => $folder . DIRECTORY_SEPARATOR . $date_append . $filename,
                "extension" => pathinfo($filename, PATHINFO_EXTENSION),
                "caption" => pathinfo($filename, PATHINFO_FILENAME),
                "hash" => "",
                "public" => $public,
                "user_id" => Auth::user()->id
            ]);
            // apply unique random hash to file
            while (true) {
                $hash = strtolower(Str::random(20));
                if (!Upload::where("hash", $hash)->count()) {
                    $upload->hash = $hash;
                    break;
                }
            }
            $upload->save();
            if(!in_array(strtolower($upload->extension),['docx','pdf','docs','doc']))
            {
                Helpers::resize($upload, 0, 0, 0);
                if(!empty($image_sizes))
                {
                    foreach($image_sizes as $thumb=>$sizes)
                    {
                        if(is_array($sizes) && count($sizes)==2)
                            Helpers::resize($upload,$sizes[0],$sizes[1],$thumb);
                    }
                }
            }
            return $upload->id;
        }
    }


    public function checkAvailabilityToDelete($id, $array_data, $child = array(), $json = false)
    {
        $message = 'couldn`t be deleted there is related ';
        $error = array();
        if (count($child)) {

            foreach ($array_data as $key => $one) {
                // if table has this id
                if ($key == "Role" || $key=='Permission')
                    $model = "Spatie\\Permission\\Models\\" . $key;
                else
                    $model = "App\\Models\\" . $key;
                if (!isset($child[$key])) {
                    $count_array = 0;
                    $count = $model::where($one[1], $id)->count();
                    if ($json)
                        $count_array = $model::whereRaw('json_contains(' . $one[1] . ', \'["' . $id . '"]\')')->orWhereRaw('json_contains(' . $one[1] . ', \'[' . $id . ']\')')->count();
                    if ($count > 0 || $count_array > 0) {
                        if (!in_array($one[0], $error))
                            $error[] = $one[0];
                    }
                } else {
                    $items = $model::where($one[1], $id)->get();
                    
                    if ($child[$key][0] == "Role" || $child[$key][0]=='Permission')
                        $child_model = "Spatie\\Permission\\Models\\" . $key;
                    else
                        $child_model = "App\\Models\\" . $key;
                    foreach ($items as $item) {
                        $count = $model::where($child[$key][1], $item->id)->count();
                        if ($json)
                            $count_array = $model::whereRaw('json_contains(' . $child[$key][1] . ', \'["' . $item->id . '"]\')')->orWhereRaw('json_contains(' . $child[$key][1] . ', \'[' . $item->id . ']\')')->count();
                        if ($count > 0 || $count_array > 0) {
                            if (!in_array($child[$key][2], $error))
                                $error[] = $child[$key][2];
                        }
                    }
                }
            }
        } else {
            foreach ($array_data as $key => $one) {
                // if table has this id
                if ($key == "Role" || $key=='Permission')
                    $model = "Spatie\\Permission\\Models\\" . $key;
                else
                    $model = "App\\Models\\" . $key;
                $count_array = 0;
                $count = $model::where($one[1], $id)->count();
                if ($json)
                    $count_array = $model::whereRaw('json_contains(' . $one[1] . ', \'["' . $id . '"]\')')->orWhereRaw('json_contains(' . $one[1] . ', \'[' . $id . ']\')')->count();
                if ($count > 0 || $count_array > 0) {
                    if (!in_array($one[0], $error))
                        $error[] = $one[0];
                }
                if(isset($one[2]) && isset($one[3]))
                {
                    $count_array = 0;
                    $count = $model::where($one[3], $id)->count();
                    if ($json)
                        $count_array = $model::whereRaw('json_contains(' . $one[3] . ', \'["' . $id . '"]\')')->orWhereRaw('json_contains(' . $one[3] . ', \'[' . $id . ']\')')->count();
                    if ($count > 0 || $count_array > 0) {
                        if (!in_array($one[2], $error))
                            $error[] = $one[2];
                    }
                }
            }
        }
        if (count($error))
            return $message . "(" . implode(" - ", $error) . ")";
        // if not
        return FALSE;
    }
    public function slug($name)
    {
        return strtolower(str_replace(" ", "-", preg_replace("/[^\x{0600}-\x{06FF}A-Za-z0-9\s\/]/u", "", trim($name))));
    }
}
