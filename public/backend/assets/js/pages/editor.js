// [editor Javascript]
// Project: EduAdmin - Responsive Admin Template
// Primary use: Used only for the wysihtml5 Editor 

$(function () {
  "use strict";

  // Check if CKEDITOR is loaded and the textarea exists
  if (typeof CKEDITOR !== 'undefined' && $('#editor1').length) {
    // Replace the <textarea id="editor1"> with a CKEditor instance
    CKEDITOR.replace('editor1');
  } else {
    console.warn('CKEditor not initialized: #editor1 not found or CKEDITOR is undefined.');
  }

  // Initialize bootstrap WYSIHTML5 - text editor if any .textarea is found
  if ($.fn.wysihtml5 && $('.textarea').length) {
    $('.textarea').wysihtml5();
  } else {
    console.warn('WYSIHTML5 not initialized: .textarea not found or wysihtml5 plugin missing.');
  }
});
