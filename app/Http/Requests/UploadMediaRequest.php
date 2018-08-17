<?php

namespace App\Http\Requests;

use App\Media;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;


class UploadMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file.*'=>['required',
                        'mimetypes:video/*,image/*',
                        'max:20000'
                      ],
        ];
    }


    /**
     * @return Media
     */
    public function createMedia()
    {
        $file =  $this->file[0]->store('public');

        return Media::create([
            'name'=>$file,
            'type'=>$this->file[0]->getClientMimeType()
        ]);

    }
}
