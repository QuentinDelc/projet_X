/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function(config) {
    config.filebrowserBrowseUrl = '../assets/kcfinder/browse.php?opener=ckeditor&type=files';
    config.filebrowserImageBrowseUrl = '../assets/kcfinder/browse.php?opener=ckeditor&type=images';
    config.filebrowserFlashBrowseUrl = '../assets/kcfinder/browse.php?opener=ckeditor&type=flash';
    config.filebrowserUploadUrl = '../assets/kcfinder/upload.php?opener=ckeditor&type=files';
    config.filebrowserImageUploadUrl = '../assets/kcfinder/upload.php?opener=ckeditor&type=images';
    config.filebrowserFlashUploadUrl = '../assets/kcfinder/upload.php?opener=ckeditor&type=flash';

    config.font_names =
        'Roboto-Slab/Roboto-Slab, Helvetica, sans-serif;' +
        'Times New Roman/Times New Roman, Times, serif;' +
        'Verdana';
};
