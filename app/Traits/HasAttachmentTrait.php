<?php
/*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/

namespace App\Traits;

use Image;
use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait HasAttachmentTrait
{
    private $path = '';

    /**
     * Morph Many relation with Attachment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachmentable')
            ->withDefault([
                'id'=>null,
                'image_path'=>$this->_defaultImagePath()
            ]);
    }


    protected static function bootHasAttachmentTrait()
    {
        self::deleting(function ($model) {
            Storage::disk(config('filesystems.default'))->delete($model->attachment->url);
            $model->attachment()->delete();
            /*if (method_exists($model->attachments())){
                $model->attachments()->delete();
            }*/

        });
    }
    public function uploadImage($image)
    {
        $this->path = storage_path('app/public');
        $extension = strtolower($image->getClientOriginalExtension());
        $arr = explode('.', $image->getClientOriginalName());

        $file_original_name= null;
        for ($i = 0; $i < count($arr) - 1; $i++) {
            if ($i == 0) {
                $file_original_name .= $arr[$i];
            } else {
                $file_original_name .= "." . $arr[$i];
            }
        }
//        $path = $image->store($this->path, 'local');
        $size = $image->getSize();

        try {
            $path = $this->storePublicly($image);

            $img = Image::make($image->getRealPath())->encode();

            $height = $img->height();
            $width = $img->width();
            if ($width > $height && $width > 1500) {
                $img->resize(1500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } elseif ($height > 1500) {
                $img->resize(null, 800, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $img->save($this->path.'/'.$path);
            clearstatcache();
            $size = $img->filesize();

            if (env('FILESYSTEM_DRIVER') == 's3') {
                Storage::disk('s3')->put($path, file_get_contents( $this->path.'/'.$path));
                unlink($this->path.'/'.$path);
            }

            $attachment = $this->attachment()->create([
                'user_id'=> auth()->id(),
                'file_original_name'=> $file_original_name,
                'file_name'=>$image->hashName(),
                'file_size'=>$size,
                'extension'=>$extension,
                'url'=>$path
            ]);
            if(!empty($attachment)){
                return $attachment->id;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
    public function singleUploadImage($image)
    {
//        return $image;
        $this->path = storage_path('app/public');
        $extension = strtolower($image->getClientOriginalExtension());
        $arr = explode('.', $image->getClientOriginalName());

        $file_original_name= null;
        for ($i = 0; $i < count($arr) - 1; $i++) {
            if ($i == 0) {
                $file_original_name .= $arr[$i];
            } else {
                $file_original_name .= "." . $arr[$i];
            }
        }
//        $path = $image->store($this->path, 'local');
        $size = $image->getSize();
        try {
            $path = $this->storePublicly($image);

            $img = Image::make($image->getRealPath())->encode();

            $height = $img->height();
            $width = $img->width();
            if ($width > $height && $width > 1500) {
                $img->resize(1500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } elseif ($height > 1500) {
                $img->resize(null, 800, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $img->save($this->path.'/'.$path);
            clearstatcache();
            $size = $img->filesize();

            if (env('FILESYSTEM_DRIVER') == 's3') {
                Storage::disk('s3')->put($path, file_get_contents( $this->path.'/'.$path));
                unlink($this->path.'/'.$path);
            }

            tap($this->attachment, function ($previous) use ($file_original_name, $path, $image, $size, $extension) {
                try {
                    $attach = $this->attachment()->create([
                        'user_id'=> auth()->id(),
                        'file_original_name'=> $file_original_name,
                        'file_name'=>$image->hashName(),
                        'file_size'=>$size,
                        'extension'=>$extension,
                        'url'=>$path
                    ]);

                    if (!empty($previous)) {
                        $previous->delete();
                    }
                    return $attach->id;
                }catch (\Exception $exception){
                    return false;
                }
            });
        } catch (\Exception $e) {
            return false;
        }
    }

    public function singleFileUpload($uploadFile)
    {
//        return $uploadFile;
        $this->path = storage_path('app/public');
        $extension = strtolower($uploadFile->getClientOriginalExtension());
        $arr = explode('.', $uploadFile->getClientOriginalName());

        $file_original_name= null;
        for ($i = 0; $i < count($arr) - 1; $i++) {
            if ($i == 0) {
                $file_original_name .= $arr[$i];
            } else {
                $file_original_name .= "." . $arr[$i];
            }
        }
        $size = $uploadFile->getSize();
        try {
            $path = $this->storePublicly($uploadFile);
            $previous = $this->attachment;
            try {
                $attachment = $this->attachment()->create([
                    'user_id'=> auth()->id(),
                    'file_original_name'=> $file_original_name,
                    'file_name'=>$uploadFile->hashName(),
                    'file_size'=>$size,
                    'extension'=>$extension,
                    'url'=>$path
                ]);
                if (!empty($previous) && !empty($previous->id)) {
                    $previous->delete();
                }
                return $attachment->id;
            }catch (\Exception $exception){
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateBase64Attachment($image, $userId)
    {
        if($image){
            $ImageData = base64_decode($image);

            $imageInfo = getimagesizefromstring($ImageData);
            $ext = image_type_to_extension($imageInfo[2]);
            $name =  md5(rand(111111, 999999). time()).$ext;
            $url = $this->table.'/'.$name;
            $data = Storage::put($url,$ImageData);
            $ext = explode('.', $ext);
            $extension = $ext[1];
            try {
                $attachment = $this->attachment()->create([
                    'user_id'=> $userId,
                    'file_original_name'=> $name,
                    'file_name'=>$name,
                    'file_size'=>null,
                    'extension'=>$extension,
                    'type'=>Attachment::type[$extension],
                    'url'=>$url
                ]);
                return $attachment->id;
            }catch (\Exception $exception){
                $this->attachment()->delete();
            }
        }
    }

    public function copyAndRestore($exitAttachment)
    {
        $this->path = storage_path('app/public/');
        try {
            $name =  md5(rand(111111, 999999). time()).'.'.$exitAttachment->extension;
            $path = $this->table.'/'.$name;

            $data = Storage::copy($exitAttachment->url, $path);
            if(!$data){
                return  false;
            }
            if (env('FILESYSTEM_DRIVER') == 's3') {
                Storage::disk('s3')->put($path, file_get_contents( $this->path.'/'.$path));
                unlink($this->path.'/'.$path);
            }

            $file_original_name = $exitAttachment->file_original_name;
            $size = $exitAttachment->file_size;
            $extension = $exitAttachment->extension;
            try {
                $attachment = $this->attachment()->create([
                    'user_id'=> auth()->id(),
                    'file_original_name'=> $file_original_name,
                    'file_name'=>$name,
                    'file_size'=>$size,
                    'extension'=>$extension,
                    'type'=>Attachment::type[$extension],
                    'url'=>$path
                ]);

                return $attachment->id;
            }catch (\Exception $exception){
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    private function storePublicly(UploadedFile $photo)
    {
        return $photo->storePublicly(
            $this->table, ['disk' => config('filesystems.default')]
        );
    }


    public function singleAttachment(UploadedFile $photo)
    {
        $url= $photo->storePublicly(
            $this->table, ['disk' => config('filesystems.default')]
        );
        tap($this->attachment, function ($previous) use ($url) {
            try {
                $attachment = $this->attachment()->create([
                    'url'=>$url
                ]);
                return $attachment->id;
            }catch (\Exception $exception){
                $this->attachment()->delete();
            }
        });
    }
    public function updateInventoryExcel(UploadedFile $photo)
    {
        $url= $photo->storePublicly(
            $this->table, ['disk' => config('filesystems.default')]
        );
        $this->attachments()->create([
            'url'=>$url
        ]);
        return $url;
    }



    private function _defaultImagePath(){
        return asset('images/no-image-available.jpg');
    }
}
