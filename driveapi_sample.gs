
function runExample() {
  // Save contents to drive folder.
  saveContentsToDriveFolder();

  // Save contents to the shared drive.
  saveContentsToSharedDrive();
}


// Save contents to drive folder.
function saveContentsToDriveFolder() {
  // Create Folder.

  // Create "Hey.txt" TEXT file in the root folder with the content "Hey Google".
  let file = DriveApp.createFile('Hey.txt', 'Hey Google.', MimeType.PLAIN_TEXT);

  // Make copy of "Hey.txt" file.
  let copiedFile = file.makeCopy();

  // Set file name to "Google.txt".
  copiedFile.setName('Google.txt');
}


// Save contents to the shared drive.
function saveContentsToSharedDrive() {
  // Create team drive and set name to "Shared Folder 1".
  let teamDrive = Drive.newTeamDrive();
  teamDrive.name = 'Shared Folder 1';

  // Insert the drive in Team drive.
  let driveId = Utilities.getUuid();
  let newTeamDrive = Drive.Teamdrives.insert(teamDrive, driveId);

  // Get team drive as a drive folder.
  let teamFolder = DriveApp.getFolderById ( newTeamDrive.id );
  let subFolder = teamFolder.createFolder('Sub Shared Folder 1');

  // Create "OK.txt" TEXT file with the content "OK Google".
  let file = subFolder.createFile('OK.txt', 'OK Google.', MimeType.PLAIN_TEXT);
}
