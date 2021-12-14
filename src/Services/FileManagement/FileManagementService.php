<?php

namespace GoApptiv\FileManagement\Services\FileManagement;

use Exception;
use GoApptiv\FileManagement\Constants;
use GoApptiv\FileManagement\Models\FileManagement\File;
use GoApptiv\FileManagement\Models\FileManagement\FileManagementLogData;
use GoApptiv\FileManagement\Repositories\FileManagement\FileManagementLogRepositoryInterface;
use GoApptiv\FileManagement\Services\Endpoints;
use GoApptiv\FileManagement\Services\Utils;
use GoApptiv\FileManagement\Traits\RestCall;
use GoApptiv\FileManagement\Traits\RestResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class FileManagementService
{
    use RestCall,RestResponse;

    /** @var FileManagementLogRepositoryInterface */
    private $fileManagementLogRepository;
    
    /**
     * @param FileManagementLogRepositoryInterface $fileManagementRepository
     */
    public function __construct(FileManagementLogRepositoryInterface $fileManagementLogRepository)
    {
        $this->fileManagementLogRepository = $fileManagementLogRepository;
    }

    /**
     * Get upload URL
     *
     * @param string $templateCode
     * @param File $file
     *
     * @return mixed
     */
    public function getUploadUrl(string $templateCode, File $file)
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
                $data,
                env("FILE_MANAGEMENT_URL").Endpoints::$GET_FILE_UPLOAD_URL,
                $this->getFileMangementHeader(),
                []
            );

            Log::info("UPDATING UPLOAD URL AND STATUS FOR REFERENCE NUMBER:" . $referenceNumber);
            $this->fileManagementLogRepository->updateStatusAndUuidById($request->id, Constants::$GENERATED, $response["uuid"]);

            return $this->success($response);
        } catch (Exception $e) {
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
    public function confirmUpload(string $uuid)
    {
        try {
            Log::info("CONFIRMING FILE UPLOAD TO FILE MANAGEMENT SERVICE FOR UUID:" . $uuid);
            $response = $this->makeRequest(
                Constants::$PUT_METHOD,
                collect([
                    "uuid" => $uuid
                ]),
                env("FILE_MANAGEMENT_URL").Endpoints::$CONFIRM_FILE_UPLOAD,
                $this->getFileMangementHeader(),
                []
            );

            Log::info("UPDATING CONFIRM STATUS FOR UUID:" . $uuid);
            $this->fileManagementLogRepository->updateStatusByUuid($uuid, Constants::$CONFIRMED);

            return $this->success($response);
        } catch (Exception $e) {
            Log::info("ERROR WHILE CONFIRMING UPLOAD FOR UUID:" . $uuid . $e->getMessage());
            $errors = $this->getErrors($e);

            $this->fileManagementLogRepository->updateStatusAndErrorsByUuid($uuid, Constants::$FAILED, $e->getMessage());
            return $this->error($e->getCode());
        }
    }

    /**
     * Get Read URL
     *
     * @param string $uuid
     *
     * @return $mixed
     */
    public function getReadUrl(string $uuid)
    {
        try {
            Log::info("REQUESTING READ URL FOR UUID:" . $uuid);
            $response = $this->makeRequest(
                Constants::$GET_METHOD,
                collect([]),
                env("FILE_MANAGEMENT_URL") . Endpoints::$GET_FILE_READ_URL . $uuid,
                $this->getFileMangementHeader(),
                []
            );

            return $this->success($response);
        } catch (Exception $e) {
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
    public function getBulkReadUrl(Collection $uuids)
    {
        try {
            Log::info("REQUESTING READ URL FOR UUID:" . $uuids);
            $response = $this->makeRequest(
                Constants::$POST_METHOD,
                $uuids,
                env("FILE_MANAGEMENT_URL") . Endpoints::$GET_BULK_FILE_READ_URL,
                $this->getFileMangementHeader(),
                []
            );

            return $this->success($response);
        } catch (Exception $e) {
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
    public function archive(string $uuid)
    {
        try {
            Log::info("ARCHIVING FILE WITH UUID:" . $uuid);
            $response = $this->makeRequest(
                Constants::$PUT_METHOD,
                collect([
                    "uuid" => $uuid
                ]),
                env("FILE_MANAGEMENT_URL") . Endpoints::$ARCHIVE_FILES,
                $this->getFileMangementHeader(),
                []
            );

            Log::info("UPDATING STATUS TO ARCHIVED FOR UUID:" . $uuid);
            $this->fileManagementLogRepository->updateStatusByUuid($uuid, Constants::$DELETED);

            return $this->success($response);
        } catch (Exception $e) {
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
     * @param Exception $e
     *
     * @return mixed
     */
    public function getErrors(Exception $e)
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
        } else {
            return $e->getResponse()->getBody()->getContents();
        }
    }
}
