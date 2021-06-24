<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CabangModel;
use App\Models\GoogleTokenModel;
use Google_Client;

class GoogleApiServices extends BaseController
{

    protected $client;
    protected $service;
    protected $serviceDriveFile;
    protected $ClientId     = '979082150599-v5udges2nfddnlfjhc87oh3e9udef2k5.apps.googleusercontent.com';
    protected $ClientSecret = 'vF_sz9v5MhsaUuXRCW0ZLFPo';
    protected $tokenModel;
    protected $absensi;
    protected $cabangModel;

    public function __construct()
    {
        $this->tokenModel = new GoogleTokenModel();
        $this->client = new Google_Client();
        $this->absensi = new AbsensiController();
        $this->cabangModel = new CabangModel();
        $lastId = null;
        // get access Token
        $tokens = $this->tokenModel->get()->getLastRow();

        if ($tokens) {
            $lastId = $tokens->token_id;
        }

        if ($tokens) {
            $access_token   = $tokens->access_token;
            $refresh_token  = $tokens->refresh_token;
            $expires_in     = $tokens->expires_in;
            $scope          = $tokens->scope;
            $token_type     = $tokens->token_type;
            $created        = $tokens->created;

            $token = [
                'access_token'  => $access_token,
                'refresh_token' => $refresh_token,
                'expires_in'    => $expires_in,
                'scope'         => $scope,
                'token_type'    => $token_type,
                'created'       => $created,
            ];


            $this->client->setAccessToken($token);
        }

        $this->client->setClientId($this->ClientId);
        $this->client->setClientSecret($this->ClientSecret);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
        $this->client->setRedirectUri(base_url('/absensi/add'));
        $this->client->setScopes('https://www.googleapis.com/auth/drive');

        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $tokens = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                $accessTokens = $tokens['access_token'];
                $refresh_token = $tokens['refresh_token'];
                $expires_in = $tokens['expires_in'];
                $scope = $tokens['scope'];
                $token_type = $tokens['token_type'];
                $created = $tokens['created'];

                if ($lastId) {
                    $this->tokenModel->save([
                        'token_id'      => $lastId,
                        'access_token'  => $accessTokens,
                        'refresh_token' => $refresh_token,
                        'expires_in'    => $expires_in,
                        'scope'         => $scope,
                        'token_type'    => $token_type,
                        'created'       => $created,
                    ]);
                } else {
                    $this->tokenModel->save([
                        'access_token'  => $accessTokens,
                        'refresh_token' => $refresh_token,
                        'expires_in'    => $expires_in,
                        'scope'         => $scope,
                        'token_type'    => $token_type,
                        'created'       => $created,
                    ]);
                }

                $tokens = [
                    'access_token'  => $accessTokens,
                    'refresh_token' => $refresh_token,
                    'expires_in'    => $expires_in,
                    'scope'         => $scope,
                    'token_type'    => $token_type,
                    'created'       => $created,
                ];

                $this->client->setAccessToken($tokens);
            } else {

                if (!isset($_GET['code'])) {
                    $authUrl = $this->client->createAuthUrl();
                    header("Location: $authUrl");
                    exit();
                } else {

                    $code = $_GET['code'];
                    $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);
                    $accessTokens = $accessToken['access_token'];
                    $refresh_token = $accessToken['refresh_token'];
                    $expires_in = $accessToken['expires_in'];
                    $scope = $accessToken['scope'];
                    $token_type = $accessToken['token_type'];
                    $created = $accessToken['created'];

                    if ($lastId) {
                        $this->tokenModel->save([
                            'token_id'      => $lastId,
                            'access_token'  => $accessTokens,
                            'refresh_token' => $refresh_token,
                            'expires_in'    => $expires_in,
                            'scope'         => $scope,
                            'token_type'    => $token_type,
                            'created'       => $created,
                        ]);
                    } else {
                        $this->tokenModel->save([
                            'access_token'  => $accessTokens,
                            'refresh_token' => $refresh_token,
                            'expires_in'    => $expires_in,
                            'scope'         => $scope,
                            'token_type'    => $token_type,
                            'created'       => $created,
                        ]);
                    }

                    $tokens = [
                        'access_token'  => $accessTokens,
                        'refresh_token' => $refresh_token,
                        'expires_in'    => $expires_in,
                        'scope'         => $scope,
                        'token_type'    => $token_type,
                        'created'       => $created,
                    ];

                    $this->client->setAccessToken($tokens);
                }
            }
        }
        $this->service = new \Google_Service_Drive($this->client);
        $this->serviceDriveFile = new \Google_Service_Drive_DriveFile($this->client);
    }


    public function searchPplKidsFolder()
    {
        $response = $this->service->files->listFiles([
            'q' => "mimeType = 'application/vnd.google-apps.folder' and name = 'PPL KOPO' and trashed=false",
        ]);

        $parentsID = '';
        $responselength = count($response->getFiles());

        if ($responselength > 0) {
            $parentsID = $response->getFiles()[0]->getId();
        } else {
            $parentsID = null;
        }

        return $parentsID;
    }

    public function search_parents_date_folder($name, $parent_id)
    {
        $response = $this->service->files->listFiles([
            'q' => "'$parent_id' in parents and name = '$name'",
        ]);

        $exist_id = '';
        if ($response['files']) {
            $exist_id  = $response['files'][0]['id'];
        } else {
            $response = $this->create_folder($name, $parent_id);
            $exist_id = $response->id;
        }

        return $exist_id;
    }

    public function search_group_date_folder($name, $parent_id)
    {
        $response = $this->service->files->listFiles([
            'q' => "'$parent_id' in parents and name contains '$name'",
        ]);

        $exist_id = '';
        if ($response['files']) {
            $exist_id  = $response['files'][0]['id'];
        } else {
            $response = $this->create_folder($name, $parent_id);
            $exist_id = $response->id;
        }

        return $exist_id;
    }

    public function search_parents_folder($name, $parent_id)
    {
        $response = $this->service->files->listFiles([
            'q' => "'$parent_id' in parents and name contains '$name'",
        ]);

        $exist_id = '';
        if ($response['files']) {
            $exist_id  = $response['files'][0]['id'];
        } else {
            $response = $this->create_folder($name, $parent_id);
            $exist_id = $response->id;
        }

        return $exist_id;
    }

    public function push_file($name, $parent_id, $data, $file)
    {
        $filenames = $name . '.' . $data;
        $response = $this->service->files->listFiles([
            'q' => "'$parent_id' in parents and name contains '$filenames'",
        ]);


        if (!$response['files']) {
            $fileMetadata = new \Google_Service_Drive_DriveFile(array(
                //Set the Random Filename
                'name' => $name . '.' . $data,
                //Set the Parent Folder
                'parents' => array($parent_id) // this is the folder id
            ));

            $newFile = $this->service->files->create(
                $fileMetadata,
                array(
                    'data' => file_get_contents($file),
                    'uploadType' => 'resumable'
                )
            );

            $newFile = $newFile['id'];
        } else {
            $newFile = $response['files'][0]['id'];
        }

        return $newFile;
    }

    public function delteFile($id)
    {
        $this->serviceDriveFile->setTrashed(true);
        $res = $this->service->files->update($id, $this->serviceDriveFile);

        return $res;
    }

    public function create_folder($name, $parent_id)
    {
        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name'     => $name,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents'  => [$parent_id],
        ]);

        $folder = $this->service->files->create($fileMetadata);

        return $folder;
    }
}
