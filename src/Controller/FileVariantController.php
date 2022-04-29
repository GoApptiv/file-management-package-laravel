<?php

namespace GoApptiv\FileManagement\Controller;

use Illuminate\Http\Request;
use GoApptiv\FileManagement\Services\FileManagement\FileManagementService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use GoApptiv\FileManagement\Requests\FileVariantRequest;
use GoApptiv\FileManagement\Events\ConfirmFileVariant;
use GoApptiv\FileManagement\Models\FileManagement\Dto\FileManagementVariantLogData;

class FileVariantController extends Controller
{
    /** @var FileManagementService */
    private $fileManagementService;

    /**
     * Constructor.
     *
     * @param FileManagementService $fileManagementService
     */
    public function __construct(FileManagementService $fileManagementService)
    {
        $this->fileManagementService = $fileManagementService;
    }

    /**
     * Update Variant Id and status by UUID
     *
     * @param Request $request
     *
     * @return Object
     *
     */
    public function updateVariantDetails(FileVariantRequest $request)
    {
        try {
            $requestData = $request->getData();
            $dataString = $requestData->getDataString();

            $decodedDataString = base64_decode($dataString, true);
            $json = json_decode($decodedDataString, true);
            Log::info("Last json-decode status:... ". json_last_error());

            $uuid = $json['message']['uuid'];
            $status = $json['message']['status'];
            $variantId = $json['message']['variantId'];

            $requestData = new FileManagementVariantLogData();
            $requestData->setUuid($uuid);
            $requestData->setStatus($status);
            $requestData->setVariantId($variantId);

            Log::info("Updating status for uuid: " .$uuid);
            $response = $this->fileManagementService->updateStatusByUuid($uuid, $status);

            Log::info("Updated status for uuid: " .$uuid);

            Log::info("Dispatching event...");
            ConfirmFileVariant::dispatch($requestData);
            
            return response()->json(
                ['status' => $status,
                'message' => $response]
            );
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::info("Error Occured: " . $e->getMessage());
            return response()->json(
                ['status' => $status,
                'message' => $e->getMessage()]
            );
        }
    }
}
