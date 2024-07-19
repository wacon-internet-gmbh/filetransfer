export default class Fileupload {
  constructor(settings) {
    const defaults = {
      dropZone: '',
      fileUploadInput: '',
      supportedTypes: ['application/x-zip-compressed', 'application/x-gzip', 'application/x-tar'],
      errors: {
        unsupportedType: ''
      },
      cssClasses: {
        error: 'fileupload-error'
      }
    };

    this.settings = Object.assign({}, defaults, settings);

    if (!this.settings.dropZone || !this.settings.fileUploadInput) {
      console.error('Drop Zone not specified');
      return;
    }

    this.dropZone = document.querySelector(this.settings.dropZone);
    this.fileUploadInput = document.querySelector(this.settings.fileUploadInput);

    if (!this.dropZone || !this.fileUploadInput) {
      console.error('Drop Zone not found');
      return;
    }

    this.form = this.getClosestForm(this.dropZone);

    if (!this.form) {
      console.error('Form could not be found.')
      return;
    }

    this.initDropZone();
  }

  initDropZone() {
    const cObj = this;
    this.dropZone.addEventListener('drop', (event) => {
      event.preventDefault();
      cObj.hideAllErrors();
      let noErrors = true;

      if (event.dataTransfer.items) {
        [...event.dataTransfer.items].forEach((item, i) => {
          if (item.kind !== "file") {
            cObj.showError('unsupported_type');
            noErrors = false;const file = item.getAsFile();
            return;
          }
        });
      }else {
        [...event.dataTransfer.files].forEach((file, i) => {
          if (item.kind !== "file") {
            cObj.showError('unsupported_type');
            noErrors = false;const file = item.getAsFile();
            return;
          }
        });
      }

      if (noErrors) {
        cObj.hideAllErrors();
        cObj.fileUploadInput.files = event.dataTransfer.files;
      }
    });

    this.dropZone.addEventListener('dragover', (event) => {
      event.preventDefault();
    });
  }

  /**
   * Return true if file type is supported
   * @param String fileType
   * @return boolean
   */
  isFileTypeSupported(fileType) {
    let result = false;

    this.settings.supportedTypes.forEach((supportedType) => {
      if (supportedType == fileType) {
        result = true;
        return;
      }
    });

    return result;
  }

  /**
   * Display error message
   * @param String code
   */
  showError(code) {
    let target = document.querySelector(this.settings.errors.unsupportedType);

    if (!target) {
      console.error('Unsupported Type target element was not found');
      alert('The file is not supported. Please only upload zip, gzip or tar files.');
      return;
    }

    target.classList.add(this.settings.cssClasses.error);
    target.classList.remove('d-none');
  }

  /**
   * Hide all error messages
   */
  hideAllErrors() {
    this.form.querySelectorAll("." + this.settings.cssClasses.error).forEach((element) => {
      element.classList.add('d-none');
    });
  }

  /**
   * Get the closest form
   * @param HtmlElement element
   * @returns
   */
  getClosestForm(element) {
    if (!element || element.tagName == 'BODY') {
      return null;
    }else if (element.tagName == 'FORM') {
      return element;
    }

    return this.getClosestForm(element.parentElement);
  }
}
