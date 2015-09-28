<?php

namespace KSPM\LCMS\Controllers;

use KSPM\LCMS\Model\AssetsFile as AssetsFile;
use KSPM\LCMS\Model\AssetsFolder as AssetsFolder;
use Imagine\Image\Box;
use Imagine\Image\Point;

class AssetController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    protected $layout = 'laikacms::layouts.default';

    public function setupLayout() {
        parent::setupLayout();
    }

    public function showIndex($folder = 0) {
        $folderId = (int) $folder;
        if ($folderId === 0 && strlen($folder) > 1) {
            return \Response::make('error', 400);
        }
        $folder = ($folderId == 0) ? (object) ['id' => 0] : AssetsFolder::find($folderId);
        $viewOptions = [
            'folder' => $folder,
            'assets' => ($folder instanceof AssetsFolder) ? $folder->files()->paginate(50) : array(),
            'folderCollection' => AssetsFolder::folders(0)
        ];
        if (key_exists('view', $_GET) && $_GET['view'] == "embeded") {
            return \View::make('laikacms::assets._folderview', array_merge($viewOptions, ['viewtype' => "embeded"]));
        }
        return \View::make('laikacms::assets.main', array_merge($viewOptions, ['viewtype' => "default"]));
    }

    public function createFolderAction($folder = 0) {
        $newFolder = AssetsFolder::create(['parent_id' => 0, 'name' => 'New Folder']);
        $getparams = key_exists('view', $_GET) ? '?view=' . $_GET['view'] : "";
        return \Redirect::to(_LCMS_PREFIX_ . '/assets/folder/' . $newFolder->id . $getparams);
    }

    public function updateFolderAttributeAction() {
        if (\Request::get('id')) {
            $folder = AssetsFolder::find(\Request::get('id'));
            $folder->update([\Request::get('attribute') => strip_tags(\Request::get('value'))]);
            $folder->save();
            return json_encode($folder->toArray());
        }

        return json_encode(['error' => true]);
    }

    public function uploadAction($folder) {
        $file = \Input::file('file');
        $destinationPath = public_path() . '/uploads/assets/' . $folder;
        $thumbDestinationPath = public_path() . '/uploads/assets/thumbs/' . $folder;
        if (!is_dir($destinationPath)) {mkdir($destinationPath);}
        if (!is_dir($thumbDestinationPath)) {mkdir($thumbDestinationPath);}
        
        $filename = $file->getClientOriginalName();
        $upload_success = $file->move($destinationPath, $filename);
        @chmod($thumbDestinationPath, 0777);
        @chmod($destinationPath, 0777);
        @chmod($destinationPath . '/' . $filename, 0777);
        $attributes = ['folder_id' => $folder, 'filename' => $filename, 'filepath' => '/uploads/assets/' . $folder, 'filetype' => AssetsFile::getFileType($file->getClientMimeType())];
        $assetFile = AssetsFile::updateOrCreate($attributes, $attributes);

        if ($assetFile->filetype == AssetsFile::FILETYPE_IMAGE) {
            $imagine = new \Imagine\Gd\Imagine();
            $imagine->open($destinationPath . '/' . $filename)
                    ->thumbnail(new Box(200, 200), \Imagine\Image\ImageInterface::THUMBNAIL_INSET)
                    ->save($thumbDestinationPath . '/' . $filename);
        }
 

        if ($upload_success) {
            return \Response::json(['file' => $assetFile->toArray()], 200);
        } else {
            return \Response::json('error', 400);
        }
    }
    
    public function assetDeleteAction($id){
        $asset = AssetsFile::find($id);
        if($asset){
             $file = public_path() . '/' . $asset->filepath . '/' . $asset->filename;
             @unlink($file);
             $asset->delete();
             return \Response::json('true', 200);
        }
        
        return \Response::json('false', 200);
       
    }

    public function showAssetManager() {
        return \View::make('laikacms::assets.modals.manager', []);
    }

}
