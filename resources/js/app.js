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


window.addEventListener('DOMContentLoaded', () => {
    tinymce.init({
        selector: 'Textarea',
        plugins: [
             'autolink', 'link', 'lists',
        ],
        skin:false,
        content_css:false,
    });
});

import Alpine from 'alpinejs';
import tinymce from "tinymce";

window.Alpine = Alpine;

Alpine.start();
