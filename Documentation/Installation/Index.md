# Installation Instructions for filetransfer
## Step 1: Install extension
1. Legacy
For legacy TYPO3 installation go to the Extension Manager and search for **filetransfer** and install and activate it.

2. Composer
For composer based TYPO3 installation simple type
``composer req wacon/filetransfer``

## Step 2: Create TYPO3 pages and folder
Create a suitable folder and page structure in the backend. For example:

![Page and folder structure for filetransfer](assets/csm_filetransfer-ordner_41c5151e19.jpg)

A folder called filetransfer and the two pages Upload and Download underneath it.

### Protect the upload page

It is recommended to set up frontend protection for the “Upload” page. This will allow only registered frontend users with access data to store files on the server.

## Step 3: Configure filestorage
![Individual filestorage for filetransfer](assets/csm_filestorage_37ce68af4a.jpg)
Define a new "file storage" to which the files will later be uploaded.

### Protect the file storage
It is highly recommended to set the access for this file storage to non public.

Also use our [example htaccess protection](../Configuration/htaccess.txt). to avoid direct browser access to all uploaded files.

## Step 4: Include TypoScript (only until version 2)
Include the extension's TypoScript template ("Create an additional TypoScript record") in the created folder.

Define the storage folder and the path in the setup:

    plugin.tx_filetransfer.settings.upload.folder = /
    plugin.tx_filetransfer.settings. upload.storage = 2

![Typoscript-Untertemplate anlegen](assets/csm_typoscript1_54410f9762.jpg "Typoscript-Untertemplate anlegen")

![Einstellungen vornehmen](assets/csm_typoscript2_23ce298b68.jpg "Einstellungen vornehmen")

![Storage-ID im Root Filestorage Container (Mouseover)alt text](assets/csm_typoscript3.jpg_c9ef995daf.jpg "Storage-ID im Root Filestorage Container (Mouseover)")

## Step 4: Include TypoScript (version 3 and above)
Include site set: **Filetransfer**.

Define the storage folder and the path in the setup:
![Site Set settings](assets/site-set.PNG)

If you have already Bootstrap included, then disable the inclusion of Utility Templates.

## Step 5: Configure upload page
Auf der Uploadseite wird nun das Plugin “Filetransfer - Upload [filetransfer_upload]” eingebunden.

![Plugin für das Uploadformular](assets/csm_upload-plugin_2328400a0e.jpg "Plugin für das Uploadformular")

Dabei werden folgende Parameter benötigt:

- die Downloadseite
- eine sinnvolle Signatur für die Mail
- der Ablageort auf dem Server (Filestorage bzw. Verzeichnis)

## Step 6: Configure download page
![Einstellungen Download-Plugin](assets/csm_download-plugin_13e74f001f.jpg "Einstellungen Download-Plugin")

The plugin “Filetransfer - Download [filetransfer_download]” is integrated on the download page. All you have to do is specify the directory.

## Step 7: Configure scheduler
To ensure that files and old data are deleted from the server, three scheduler tasks must be created:

![Scheduler tasks for filetransfer](assets/csm_scheduler-Tasks.jpg_6f6561313b.jpg)

- With "delete_downloaded" all files and data that have reached their download limit are deleted (specify the ID of the folder "filetransfer", as this is where the records are located).
- With "delete_expired" all files and data whose expiration time has been reached are deleted (specify the ID of the folder "filetransfer", as this is where the records are located).
- With "garbage_collector" all files for which there is no corresponding data record are deleted (specify the ID of the folder)

