<?php

namespace App\Domain\Product\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\UploadedFile;
use Helper;

class ProductDTO extends DataTransferObject
{

    /* @var integer */
    public $id;
    /* @var string */
    public $name;
    /* @var string */
    public $description;
    /* @var string */
    public $image;
    /* @var integer|null */
    public $user_id;

    public static function fromRequest($request){
        return new self([
            'id' => $request['id'] ?? null,
            'name' => $request['name'] ?? null,
            'description' => $request['description'] ?? null,
            'image' => $request['image'] ?? null,
            'user_id' => $request['user_id'] ?? null,
        ]);
    }

    public function setDefaultValues(){
        $this->id = $this->id ?? null;
        $this->first_name = $this->first_name ?? null;
        $this->last_name = $this->last_name ?? null;
        $this->email = $this->email ?? null;
        $this->phone = $this->phone ?? null;
        $this->role_id = $this->role_id ?? null;
        $this->image = $this->getImage();
    }

    private function getImage(){
        $path = 'products/image/';
        if($this->image == null) return null;
        if($this->image instanceof UploadedFile)
            return $path . Helper::saveFileGetLinkWithName($this->image, $path)['fileName'];
        return $this->image;
    }
}
