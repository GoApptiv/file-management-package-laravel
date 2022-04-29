<?php

namespace GoApptiv\FileManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;
use GoApptiv\FileManagement\Models\FileManagement\Dto\FileManagementVariantLogData;

class FileVariantRequest extends FormRequest
{

    /**
     * Always return true
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Validation login request
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message.attributes' => array('required'),
            'message.data' => array('required')
        ];
    }
    
    /**
     * Fetch fields
     *
     * @return Collection
     */
    public function getData()
    {
        $messageData = $this->get('message');
        $dataString = $messageData['data'];

        $data = new FileManagementVariantLogData();
        $data->setDataString($dataString);
      
        return $data;
    }
}
