<?php

namespace App\Http\Controllers;

use App\Models\Reports\AsteriskCall;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;

class GoogleUploadController extends Controller
{
    protected $client;
    protected $folder_id='1e9afx2JnwcsLN42NWp0JGQZvD-Wo6Iby';
    protected $service;
    protected $ClientId     = '275696472712-13rps1r2orjvfcqfidvra4rufc8f41cq.apps.googleusercontent.com';
    protected $ClientSecret = '4OWKnhzwg-DDCvj_UiFddq0s';
    protected $refreshToken = '1//04eehbZXb93WvCgYIARAAGAQSNwF-L9IrFMtoF4TEy_Aw3dZvhZa1SRXmkR0Q-5C0HUeyOg00HDc3evUOPRxz3LC-MrP_JITkQZ8';

    public function __construct()
    {
        $this->client = new \Google_Client();
        $this->client->setClientId($this->ClientId);
        $this->client->setClientSecret($this->ClientSecret);
        $this->client->refreshToken($this->refreshToken);

        $this->service = new \Google_Service_Drive($this->client);


    }

    /**
     * create folder in google drive.
     *
     * @return [type] [description]
     */
    public function create_folder()
    {
        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name'     => '1google_drive_folder_name',
            'mimeType' => 'application/vnd.google-apps.folder',
        ]);

        $folder = $this->service->files->create($fileMetadata, ['fields' => 'id']);

        return $folder->id;
    }

    /**
     * remove duplicated files before adding new ones
     * again thats because google use 'id' not 'name'.
     *
     * note that we cant search for files as bulk "a limitation in the drive Api it self"
     * so instead we call this method from a loop with all the files we want to remove
     *
     * also note the some of the api methods are from the v2 even if we are using v3 in this example
     * google docs are often mis-guiding
     * https://developers.google.com/drive/v2/reference/
     * https://developers.google.com/drive/v3/web/search-parameters
     *
     * @return [type] [description]
     */
    protected function remove_duplicated($file)
    {
        $response = $this->service->files->listFiles([
            'q' => "'$this->folder_id' in parents and name contains '$file' and trashed=false",
        ]);

        foreach ($response->files as $found) {
            return $this->service->files->delete($found->id);
        }
    }

    /**
     * this is the only method u need to call from ur controller.
     *
     * @param [type] $new_name [description]
     *
     * @return [type] [description]
     */
    public function upload_files()
    {
        $adapter    = new GoogleDriveAdapter($this->service,$this->folder_id);
        $filesystem = new Filesystem($adapter);

        // here we are uploading files from local storage
        // we first get all the files
        $files = Storage::disk('public')->files();

        // loop over the found files
        foreach ($files as $file) {
            // remove file from google drive in case we have something under the same name
            // comment out if its okay to have files under the same name
          //  $this->remove_duplicated($file);

            // read the file content
            $read = Storage::disk('public')->get($file);
            // save to google drive
            $filesystem->write($file, $read);
            // remove the local file
          //  Storage::disk('public')->delete($file);
        }
    }

    /**
     * in case u want to get the total file count
     * inside a specific folder.
     *
     * @return [type] [description]
     */
    public function files_count()
    {
        $response = $this->service->files->listFiles([
            'q' => "'$this->folder_id' in parents and trashed=false",
        ]);

        return count($response->files);
    }


    public function upload_file_from_server(){
        $calls=AsteriskCall::where('uploaded',0)->orderby('id','desc') ->get();
foreach ($calls as $call){
$url='http://82.146.43.227/records/'.$call->record;

    try {
        $read=file_get_contents($url);
        $adapter    = new GoogleDriveAdapter($this->service,$this->folder_id);
        $filesystem = new Filesystem($adapter);
        $filesystem->write($call->id.'.mp3', $read);
        $call->uploaded=2;
        $call-> save();
    }  catch (\Exception $e){
        $call->uploaded=1;
        $call-> save();
    }


}




    }
}