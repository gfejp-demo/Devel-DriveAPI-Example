<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\GoogleDrive;
use Illuminate\Support\Facades\Log;

class DriveApiController extends Controller
{

    /**
    * ドライブにファイルを作成
    * @param $client: Googleクライアント
    */
    public function createFile($client) {

        try {
            // ドライブサービス オブジェクトを生成
            $driveClient = new \Google_Service_Drive($client);

            // 作成するファイルの情報を準備
            $fileMetadata = new \Google_Service_Drive_DriveFile([
                'name' => 'sample.txt', // ファイル名
            ]);

            // ファイルを作成
            $driveClient->files->create($fileMetadata, [
                'data' => 'This is a sample file.', // ファイルのコンテンツ
                'mimeType' => 'text/plain', // MIMEタイプをテキストファイルに指定
                'uploadType' => 'media',
                'fields' => 'id',
            ]);

        } catch(\Exception $e) {
            $msg = $e -> getMessage();
            return $msg;
        }

    }


    /**
    * ドライブ内のファイルをコピー
    * @param $client: Googleクライアント
    */
    public function fileCopy($client) {

        try {
            // ドライブサービス オブジェクトを生成
            $driveClient = new \Google_Service_Drive($client);

            // 作成するファイルの情報を準備
            $fileMetadata = new \Google_Service_Drive_DriveFile([
                'name' => 'sampleのコピー.txt', // コピー後のファイル名
                'parents' => ['root'], // コピー先
            ]);

            // ドライブ内のファイルを検索
            $result = $driveClient->files->listFiles([
                "q" => "name='sample.txt'" // ファイル名を指定
            ]);
            $file = $result->getFiles()[0];

            // ファイルをコピー
            $driveClient->files->copy($file->getId(), $fileMetadata);

        } catch(\Exception $e) {
            $msg = "処理に失敗しました。ファイル「sample.txt」が存在するか、確認してください。";
            return $msg;
        }
    }


    /**
    * ドライブ内のファイルの名前を変更
    * $client: Googleクライアント
    */
    public function fileRename($client) {

        try {
            // ドライブサービス オブジェクトを生成
            $driveClient = new \Google_Service_Drive($client);

            // 変更後のファイルの情報を準備
            $fileMetadata = new \Google_Service_Drive_DriveFile();
            $fileMetadata->setName('Google.txt');

            // ドライブ内のファイルを検索
            $result = $driveClient->files->listFiles([
                "q" => "name='sample.txt'"
            ]);
            $file = $result->getFiles()[0];

            // ファイル名を変更
            $driveClient->files->update($file->getId(), $fileMetadata, array());

        } catch(\Exception $e) {
            $msg = "処理に失敗しました。ファイル「sample.txt」が存在するか、確認してください。";
            return $msg;
        }
        
    }


    public function demo_create($client) {
        $msg = $this->createFile($client);
        return view('ok')->with('msg', $msg);
    }

    public function demo_copy($client) {
        $msg = $this->fileCopy($client);
        return view('ok')->with('msg', $msg);
    }

    public function demo_rename($client) {
        $msg = $this->fileRename($client);
        return view('ok')->with('msg', $msg);
    }

}
