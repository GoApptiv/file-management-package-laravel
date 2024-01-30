<?php

namespace GoApptiv\FileManagement\Services\FileManagement;

use GoApptiv\FileManagement\Constants;
use GoApptiv\FileManagement\Models\FileManagement\File;
use GoApptiv\FileManagement\Models\FileManagement\FileManagementLogData;
use GoApptiv\FileManagement\Models\FileManagement\Dto\FileManagementVariantLogData;
use GoApptiv\FileManagement\Repositories\FileManagement\FileManagementLogRepositoryInterface;
use GoApptiv\FileManagement\Repositories\FileManagement\FileManagementVariantLogRepositoryInterface;
use GoApptiv\FileManagement\Services\Endpoints;
use GoApptiv\FileManagement\Services\Utils;
use GoApptiv\FileManagement\Traits\RestCall;
use GoApptiv\FileManagement\Traits\RestResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class FileManagementService
{
    use RestCall;
    use RestResponse;

    /** @var FileManagementLogRepositoryInterface */
    private $fileManagementLogRepository;

    /** @var FileManagementVariantLogRepositoryInterface */
    private $fileManagementVariantLogRepository;


    /**
     * @param FileManagementLogRepositoryInterface $fileManagementRepository
     * @param FileManagementVariantLogRepositoryInterface $fileManagementVariantLogRepository
     */
    public function __construct(
        FileManagementLogRepositoryInterface $fileManagementLogRepository,
        FileManagementVariantLogRepositoryInterface $fileManagementVariantLogRepository
    ) {
        $this->fileManagementLogRepository = $fileManagementLogRepository;
        $this->fileManagementVariantLogRepository = $fileManagementVariantLogRepository;
    }

    /**
     * Get upload URL
     *
     * @param string $templateCode
     * @param File $file
     *
     * @return mixed
     */
    public function getUploadUrl($templateCode, $file)
    {
        Log::info("GENERATING REFERENCE NUMBER...");
        $referenceNumber = Utils::generateReferenceNumber($file->getName());

        $data = collect([
            "referenceNumber" => $referenceNumber,
            "templateCode" => $templateCode,
            "file" => collect([
                "type" => $file->getType(),
                "name" => $file->getName(),
                "size" => $file->getSizeInBytes()
            ])
        ]);

        try {
            $requestData = new FileManagementLogData();
            $requestData->setReferenceNumber($data["referenceNumber"]);
            $requestData->setTemplateCode($data["templateCode"]);
            $requestData->setFileName($data["file"]["name"]);
            $requestData->setFileType($data["file"]["type"]);
            $requestData->setFileSizeInBytes($data["file"]["size"]);
            $requestData->setStatus(Constants::$REQUESTED);

            Log::info("Logging upload url request for reference number:" . $referenceNumber);
            $request = $this->fileManagementLogRepository->store($requestData);

            Log::info("Requesting upload url from File Management Service for reference number:" . $referenceNumber);
            $response = $this->makeRequest(
                Constants::$POST_METHOD,
                $data->toArray(),
                env("FILE_MANAGEMENT_URL").Endpoints::$GET_FILE_UPLOAD_URL,
                $this->getFileMangementHeader(),
                []
            );

            Log::info("UPDATING UPLOAD URL AND STATUS FOR REFERENCE NUMBER:" . $referenceNumber);
            $this->fileManagementLogRepository->updateStatusAndUuidById($request->id, Constants::$GENERATED, $response["uuid"]);

            return $this->success($response);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::info("ERROR WHILE GETTING UPLOAD URL FOR REFERENCE NUMBER:" . $referenceNumber . $e->getMessage());
            $errors = $this->getErrors($e);

            $this->fileManagementLogRepository->updateStatusAndErrorsById($request->id, Constants::$FAILED, $errors);
            return $this->error($e->getCode(), $errors);
        }
    }


    /**
     * Confirm upload
     * @param string $uuid
     *
     * @return mixed
     */
    public function confirmUpload($uuid)
    {
        try {
            Log::info("CONFIRMING FILE UPLOAD TO FILE MANAGEMENT SERVICE FOR UUID:" . $uuid);
            $response = $this->makeRequest(
                Constants::$PUT_METHOD,
                [
                    "uuid" => $uuid
                ],
                env("FILE_MANAGEMENT_URL").Endpoints::$CONFIRM_FILE_UPLOAD,
                $this->getFileMangementHeader(),
                []
            );

            Log::info("UPDATING CONFIRM STATUS FOR UUID:" . $uuid);
            $this->fileManagementLogRepository->updateStatusByUuid($uuid, Constants::$CONFIRMED);

            return $this->success($response);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::info("ERROR WHILE CONFIRMING UPLOAD FOR UUID:" . $uuid . $e->getMessage());
            $errors = $this->getErrors($e);

            $this->fileManagementLogRepository->updateStatusAndErrorsByUuid($uuid, Constants::$FAILED, $e->getMessage());
            return $this->error($e->getCode(), $errors);
        }
    }

    /**
     * Get Read URL
     *
     * @param string $uuid
     *
     * @return $mixed
     */
    public function getReadUrl($uuid)
    {
        try {
            Log::info("REQUESTING READ URL FOR UUID:" . $uuid);
            $response = $this->makeRequest(
                Constants::$GET_METHOD,
                [],
                env("FILE_MANAGEMENT_URL") . Endpoints::$GET_FILE_READ_URL . $uuid,
                $this->getFileMangementHeader(),
                []
            );

            return $this->success($response);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::info("ERROR WHILE GETTING READ URL FOR UUID:" . $uuid . $e->getMessage());
            return $this->error($e->getCode());
        }
    }

    /**
     * Get Read URL in Bulk
     *
     * @param Collection $uuids
     *
     * @return $mixed
     */
    public function getBulkReadUrl($uuids)
    {
        try {
            Log::info("REQUESTING READ URL FOR UUID:" . $uuids);
            $response = $this->makeRequest(
                Constants::$POST_METHOD,
                $uuids->toArray(),
                env("FILE_MANAGEMENT_URL") . Endpoints::$GET_BULK_FILE_READ_URL,
                $this->getFileMangementHeader(),
                []
            );

            return $this->success($response);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::info("ERROR WHILE GETTING READ URL FOR UUIDS:" . $uuids . $e->getMessage());
            return $this->error($e->getCode());
        }
    }

    /**
     * Archive Uploaded Files
     *
     * @param string $uuid
     *
     * @return $mixed
     */
    public function archive($uuid)
    {
        try {
            Log::info("ARCHIVING FILE WITH UUID:" . $uuid);
            $response = $this->makeRequest(
                Constants::$PUT_METHOD,
                [
                    "uuid" => $uuid
                ],
                env("FILE_MANAGEMENT_URL") . Endpoints::$ARCHIVE_FILES,
                $this->getFileMangementHeader(),
                []
            );

            Log::info("UPDATING STATUS TO ARCHIVED FOR UUID:" . $uuid);
            $this->fileManagementLogRepository->updateStatusByUuid($uuid, Constants::$DELETED);

            return $this->success($response);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::info("ERROR WHILE GETTING READ URL FOR UUIDS:" . $uuid . $e->getMessage());
            return $this->error($e->getCode());
        }
    }

    /**
     * Get Headers for FileManagement API call
     */
    public function getFileMangementHeader()
    {
        return [
            "content" => Constants::$APPLICATION_JSON,
            "accept" => Constants::$APPLICATION_JSON,
            "Authorization" => "Bearer" . " " . env("FILE_MGMT_TOKEN")
        ];
    }

    /**
     * Get Errors
     *
     * @param \GuzzleHttp\Exception\RequestException $e
     *
     * @return mixed
     */
    public function getErrors($e)
    {
        if ($e->getCode() == 400) {
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody()->getContents();
                $errorCollection = json_decode($response, true);

                if (array_key_exists('errors', $errorCollection)) {
                    return $errorCollection['errors'];
                } else {
                    return 'SERVER ERROR';
                }
            }
        }
    }

    /**
     * Create File variant
     *
     * @param string $uuid
     * @param string $pluginCode
     *
     * @return bool
     *
     */
    public function createFileVariant($uuid, $pluginCode)
    {
        try {
            Log::info("CREATING FILE VARIANTS:");

            Log::info("Saving variant details in database...");
            $data = new FileManagementVariantLogData($uuid);
            $data->setVariantType($pluginCode);
            $this->fileManagementVariantLogRepository->store($data);

            $response = $this->makeRequest(
                Constants::$POST_METHOD,
                [
                    "uuid" => $uuid,
                    "plugins" => [collect([
                        "code" => $pluginCode
                    ])]
                ],
                env("FILE_MANAGEMENT_URL").Endpoints::$FILE_VARIANTS,
                $this->getFileMangementHeader(),
                []
            );
    
            $variantId = $response['data']['plugin'][0]['variantId'];
            Log::info("Updating response status for uuid...");
            $this->updateVariantIdByUuid($uuid, $variantId);
            
            Log::info("FILE VARIANT CREATED SUCCESSFULLY FOR UUID: ". $uuid);
            
            return $this->success($response);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::info("ERROR WHILE CREATING FILE VARIANT:" . $uuid . $e->getMessage());
            $this->updateStatusAndErrorsByUuid($uuid, Constants::$FAILED, $e->getMessage());
            return $this->error($e->getCode());
        }
    }

    /**
     * Update Variant Id and status by UUID
     *
     * @param string $uuid
     * @param string $status
     *
     * @return int
     *
     */
    public function updateVariantIdByUuid($uuid, $variantId)
    {
        return $this->fileManagementVariantLogRepository->updateVariantIdByUuid($uuid, $variantId);
    }

    /**
    * Updates the status and errors by uuid
    *
    * @param string $uuid
    * @param string $errors
    *
    * @return int
    */
    public function updateStatusAndErrorsByUuid($uuid, $status, $errors)
    {
        return $this->fileManagementVariantLogRepository->updateStatusAndErrorsByUuid($uuid, $status, $errors);
    }

    /**
     * Get URL for File variant
     *
     * @param string $uuid
     *
     * @return string $url
     */
    public function getReadUrlForVariants($uuid)
    {
        try {
            Log::info("FETCHING URL FOR VARIANT ID:" . $uuid);
            $response = $this->makeRequest(
                Constants::$GET_METHOD,
                [
                    "uuid" => $uuid
                ],
                env("FILE_MANAGEMENT_URL") . Endpoints::$GET_FILE_VARIANT_URL.$uuid,
                $this->getFileMangementHeader(),
                []
            );
            return $this->success($response);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::info("ERROR WHILE FETCHING URL FOR VARIANT ID:" . $uuid . $e->getMessage());
            return $this->error($e->getCode());
        }
    }

    /**
     * Updates the status by uuid
     *
     * @param string $uuid
     * @param string $status
     *
     * @return int
     */
    public function updateStatusByUuid($uuid, $status)
    {
        return $this->fileManagementVariantLogRepository->updateStatusByUuid($uuid, $status);
    }
}
