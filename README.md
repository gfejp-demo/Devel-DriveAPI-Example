# Google Drive API サンプルコード

このサンプルでは、Google ドライブへのファイル保存、共有ドライブへのファイルの保存についてのコードを記載しています。<br/>
Google ドライブは DriveApp クラス、共有ドライブは Drive クラスを使用して操作します。

## ファイル構成
```
トップ
│
├ README.md .. このファイル
│
└ driveapi_sample.gs .. サンプルコード
```

## API に関するドキュメント
・Drive Service<br/>
 https://developers.google.com/apps-script/reference/drive


## サンプルコード

### Google ドライブでのファイル操作

#### フォルダへのファイルの保存
マイフォルダにファイルを作成するには、DriveApp.createFile を使用します。
```
// Create "Hey.txt" TEXT file in the root folder with the content "Hey Google".
let file = DriveApp.createFile('Hey.txt', 'Hey Google.', MimeType.PLAIN_TEXT);
```
保存するファイル名、ファイルの内容、ファイルタイプを指定して、DriveApp.createFile を呼び出します。<br/>
保存が完了すると、ファイルオブジェクトが返されます。


#### ファイルのコピー
マイフォオルダにあるファイルのコピーは、File.makeCopy を使用して行います。
```
// Make copy of "Hey.txt" file.
let copiedFile = file.makeCopy();
```
file はコピー元のファイル、copiedFile はコピー先のファイルです。


#### ファイルのリネーム
File.setName でファイルのリネームを行います。
```
// Set file name to "Google.txt".
copiedFile.setName('Google.txt');
```

### 共有フォルダのファイル操作

#### 共有ドライブの作成
新しいドライブを作成し、共有ドライブ下に挿入します。
```
// Create team drive and set name to "Shared Folder 1".
let teamDrive = Drive.newTeamDrive();
teamDrive.name = 'Shared Folder 1';

// Insert the drive in Team drive.
let driveId = Utilities.getUuid();
let newTeamDrive = Drive.Teamdrives.insert(teamDrive, driveId);
```
Drive.newTeamDrive で、新しいドライブを作成し、名前を設定します。<br/>
作成されたドライブは、このままでは利用できません。Drive.Teamdrives.insert を呼び出して共有ドライブの下に配置することで、共有ドライブとしてアクセスできるようになります。


#### 共有ドライブのドライブを通常のフォルダとして扱う
共有ドライブは、DriveAppのフォルダに変換することで、通常の Googleドライブ内のフォルダと同じように扱うことができます。
```
// Get team drive as a drive folder.
let teamFolder = DriveApp.getFolderById ( newTeamDrive.id );
let subFolder = teamFolder.createFolder('Sub Shared Folder 1');
```
DriveApp.Folder.crateFolder でフォルダを作成することができます。


#### フォルダにファイルを作成
ファイルの作成も Googleドライブと同じ方法で実行できます。
```
// Create "OK.txt" TEXT file with the content "OK Google".
let file = subFolder.createFile('OK.txt', 'OK Google.', MimeType.PLAIN_TEXT);
```
