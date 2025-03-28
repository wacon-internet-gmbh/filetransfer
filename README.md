# TYPO3 Extension: filetransfer
The filetransfer extension enables the secure transfer of files from your own web server ("on-premise"). This eliminates the need for email transfers, which can be challenging for large files and pose security risks for sensitive data. As an alternative to WeTransfer, organizations can use this extension to present themselves in a particularly security-conscious and professional manner.

More information (in German only): https://www.wacon.de/typo3-service/filetransfer.html

## 2 Usage

### 2.1 Installation

#### Installation as extension from TYPO3 Extension Repository (TER)
Download and install the [extension][1] with the extension manager module.

#### 2.2 Installation with composer
`composer req wacon/filetransfer`

### Recommended settings
1. Use a separate file storage and set subfolder and id inside TypoScript (plugin.tx_filetransfer.settings), see TypoScript Browser
2. Use for Apache server our example [.htaccess file](Documentation/Configuration/htaccess.txt) to block direct file access.
3. Don't make the upload page public available and use frontend login

## 3 Todos
- Upload Form Server Validation

## 4 Changelog
see [CHANGES.md](CHANGES.md)

[1]: https://extensions.typo3.org/extension/filetransfer
