## Version 2.0.0
- [FEATURE] Migrate DeleteExpiredCommand to QueryBuilder, because Repository is not possible in TYPO3 13 anymore
- [FEATURE] Migrate GarbageCollectorCommand to QueryBuilder, because Repository is not possible in TYPO3 13 anymore
- [FEATURE] Add GitHub action for TYPO3 13
- [FEATURE] Set Request for FluidEmail and UriBuilder in MailService
- [FEATURE] Migrate DeleteDownloadedCommand to QueryBuilder, because Repository is not possible in TYPO3 13 anymore
- [BUGFIX] Return value int for Symfony Command

## Version 1.2.0
- [FEATURE] Add downloadpage with downloadlink as step between mail link and download. This is useful to avoid problems with mailserver firewalls
- [FEATURE] Send Mail to Admin, when downloaded
- [NOTICE] Replace Extension.png with new svg file
- [NOTICE] Add PHP 8.1 Support

## Version 1.1.1
- [BUGFIX] tx_filetransfer_domain_model_upload Icon file extension

## Version 1.1.0
- [FEATURE] Upload all types of file extensions
- [FEATURE] Upload multiple files

## Version 1.0.6
- [NOTICE] Change extension icon

## Version 1.0.5
- [BUGFIX] Forgot Signature in FlexForm

## Version 1.0.4
- [BUGFIX] Upload Model: Set start value for receiverAddress and senderAddress
- [BUGFIX] Reduces incoming $_FILES to the current, because we only support one file
- [BUGFIX] GarbageCollector: getOriginalResource first before getOriginalFile

## Version 1.0.3
- [BUGFIX] min attribute not support on textfield in some TYPO3 versions
- [BUGFIX] Only show set testdata, when we are not in Development mode

## Version 1.0.2
- [BUGFIX] Remove placeholder attribute for select field

## Version 1.0.1
- [BUGFIX] Form UploadViewHelper does not support required and placeholder attributes, so I use additionalAttributes and put placeholder as form-text

## Version 1.0.0
- [IMPORTANT] First stable release 1.0.0

## Version 0.3.0
- [FEATURE] Add Symfony Task to delete expired uploads
- [FEATURE] Add Symfony Task to delete files with no uploads relation

## Version 0.2.0
- [FEATURE] Add Symfony Task to delete downloaded uploads
- [WIP] Add Symfony Task to delete expired uploads
- [BUGFIX] Uploaded file needs the file extension

## Version 0.1.0
- [IMPORTANT] Implement Download function
- [FEATURE] Add FlexForm for upload plugin to choose download page
- [FEATURE] tx_filetransfer_domain_model_upload is adminOnly, Exclude token field
- [FEATURE] Add upload success message
- [NOTICE] ext_emconf: Wrong Email and company

## Version 0.0.6
- [FEATURE] Create FileUploadService to handle the file upload

## Version 0.0.5
- [WIP] Create FileUploadService to handle the file upload
- [FEATURE] Init Upload object on form if not present to show initial values
- [FEATURE] Create target folder if not exist
- [BUGFIX] Upload Model getter/setter for downloadlimit

## Version 0.0.4
- [FEATURE] Add Fileupload.js Module to handle drag und drop file area
- [FEATURE] Implement Drag and Drop file upload (clientwise)
- [FEATURE] Add Constant Editor option to include utilities.css which has some bootstrap classes
- [FEATURE] Add some basic css styling

## Version 0.0.3
- [IMPORTANT] Rename downloaded to download_limit
- [FEATURE] Add Download Plugin
- [FEATURE] Add receiver and sender address
- [FEATURE] Add Upload Form Template
- [CHANGE] Remove versioning and deleted flag for Upload Model
- [CHANGE] Ignore .vscode from git

## Version 0.0.2
- [FEATURE] Create Upload Model
- [FEATURE] Register Typoscript
- [FEATURE] Register Upload Plugin with controller and view

## Version 0.0.1
- [IMPORTANT] Create github repository
- [IMPORTANT] Kickstart Extension
