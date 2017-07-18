<?php

namespace App\Traits;

use Image;
use Storage;

trait UploadTrait {

    private $storage_path = 'storage/';

    /**
     * @method upload for upload action
     *
     * @param String $location determine storage location
     * @param Array $files file to be uploaded
     * @param Array $dimensions dimensions for files
     *
     * @return string $filename | $filenames
     */
    public function upload($location, $files, $dimensions) {
        if (count($files) == 1) {
            // Only One Photo is Being Uploaded
            return $this->uploadSingleOrMultiple($location, $files, $dimensions);
        } else {
            //Multiple Files Are Being Uploaded
            $multiple[] = 'm_files';
            foreach ($files as $file) {
                $multiple[] = $this->uploadSingleOrMultiple($location, $file, $dimensions);
            }
            return $multiple;
        }
    }

    /**
     * @method generateHashName
     *
     * @param $file file to be uploaded
     * @param $location location for the file
     * @param $prepend string to be prepended to filename
     *
     * @return String Hashname
     */
    public function generateHashName($file, $location, $prepend = null) {
        // returns string in the form: $location/bf5db5c75904dac712aea27d45320403.jpeg
        if (is_null($prepend)) {
            return $file->hashName($location);
        }
        // Referencing explode() directly throws reference only string exception
        $name = explode('/', $file->hashName($location));
        return $location . '/thumbnails/'  . array_pop($name);
    }

    /**
     * @method uploadAction
     *
     * @param $file file to be uploaded
     * @param $photo filename generated
     *
     * @return Boolean true| false for upload success or failure
     */
    public function uploadAction($file, $photo, $dim) {
        $image = Image::make($file);
        $image->fit($dim[1], $dim[2], function ($constraint) {
            $constraint->aspectRatio();
        });
        if (Storage::disk('public')->put($photo, (string) $image->encode())) {
            return true;
        }
        return false;
    }

    /**
     * @method uploading to upload the file | files
     *
     * @param $file file to be uploaded
     * @param $photo filename generated
     * @param $dim dimensions of the file
     *
     * @return Boolean true| false for upload success or failure
     */
    public function uploading($location, $file, $dim) {
        $photo = $this->generateHashName($file, $location, $dim[0]);
        if ($this->uploadAction($file, $photo, $dim)) {
            return $this->storage_path . $photo;
        }
        return false;
    }

    /**
     * @method uploadSingleOrMultiple determine if multiple dimensions of the file is being uploaded
     *
     * @param $file file to be uploaded
     * @param $photo filename generated
     * @param $dim dimensions of the file
     *
     * @return Boolean true| false for upload success or failure
     */
    public function uploadSingleOrMultiple($location, $file, $dimensions) {
        // Check that the dimensions provided is not a multi-dimensional array
        if (! is_array($dimensions[0]) == 1) {
            // For single dimensions
            return $this->uploading($location, $file, $dimensions);
        } else {
            // For multiple dimensions
            // To tell that the array returned is multiple dimensions
            $photo[] = 'm_dim';
            foreach ($dimensions as $dim) {
                $photo[] = $this->uploading($location, $file, $dim);
            }
            return $photo;
        }
    }
}
