import './bootstrap';

import 'tinymce/tinymce';
import 'tinymce/skins/ui/oxide/skin.min.css';
import 'tinymce/skins/content/default/content.min.css';
import 'tinymce/skins/content/default/content.css';
import 'tinymce/icons/default/icons';
import 'tinymce/themes/silver/theme';
import 'tinymce/models/dom/model';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/charmap';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/anchor';
import 'tinymce/plugins/pagebreak';
import 'tinymce/plugins/advlist';


window.addEventListener('DOMContentLoaded', () => {
    tinymce.init({
        selector: 'Textarea',
        plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
        toolbar_mode: 'floating',
        skin:false,
        content_css:false,
        setup: function (editor) {
            editor.on('init', function () {
                editor.getBody().style.fontSize = '14px';  // Adjust the default font size
            });
        }
    });
});

import Alpine from 'alpinejs';
import tinymce from "tinymce";

window.Alpine = Alpine;

Alpine.start();
