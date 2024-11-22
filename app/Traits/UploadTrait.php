<?php

namespace App\Traits;

trait UploadTrait
{
    private function imageUpload($images,$imageColumn = null)
    {                
        $uploadedImage = [];
        
        if(is_array($images))
        {
            foreach($images AS $image)
            {
               $uploadedImage[] = [$imageColumn => $image->store('products','public')];
            }
        }
        else
        {
            $uploadedImage = $images->store('logo','public');
        }
        
        return $uploadedImage;
    }
}

