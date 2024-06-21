import './bootstrap';

import 'tinymce/tinymce';
import 'tinymce/skins/ui/oxide/skin.min.css';
import 'tinymce/skins/content/default/content.min.css';
import 'tinymce/skins/content/default/content.css';

import 'tinymce/icons/default/icons';
import 'tinymce/themes/silver/theme';
import 'tinymce/models/dom/model';

import 'tinymce/plugins/autolink';
import 'tinymce/plugins/autoresize';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/charmap';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/anchor';
import 'tinymce/plugins/pagebreak';
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/wordcount';
import 'tinymce/plugins/emoticons';
import 'tinymce/plugins/emoticons/js/emojiimages.min.js';
import 'tinymce/plugins/emoticons/js/emojis.min.js';
import 'tinymce/plugins/code';
import 'tinymce/plugins/help';
import 'tinymce/plugins/visualblocks';
import 'tinymce/plugins/fullscreen';
// import 'tinymce/plugins/paste';

import Alpine from 'alpinejs';
import tinymce from "tinymce";

window.addEventListener('DOMContentLoaded', () =>
{
	tinymce.init({
		selector: 'textarea.tinymce-full',
		license_key: 'gpl',
		promotion: false,
		menubar: false,
		statusbar: false,
		min_height: 150,
		autoresize_bottom_margin: 0,
		plugins: [
			'advlist', 'autolink', 'autoresize', 'lists', 'link', 'image', 'charmap', 'preview',
			'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
			'insertdatetime', 'media', 'table', 'wordcount', 'pagebreak',
			'emoticons', 'paste'
		],
		toolbar_mode: 'floating',
		toolbar: 'blocks bold italic removeformat link unlink ' +
			'alignleft aligncenter alignright ' +
			'bullist numlist outdent indent charmap emoticons ' +
			'fullscreen code',
		toolbar_sticky: true,
		link_context_toolbar: true,
		skin: false,
		content_css: [
			'https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap',
			'/css/dynamic.css'
		],
		setup: function(editor)
		{
			editor.on('init', function()
			{
				editor.getBody().classList.add('dynamic');
				editor.getBody().style.fontSize = '16px';  // Adjust the default font size
				editor.getBody().style.fontFamily = 'Figtree, ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji';  // Adjust the default font family
			});
		},
		paste_preprocess: function(plugin, args) {
			// Strip out images from the pasted content
			args.content = args.content.replace(/<img[^>]*>/g, '');
		}
	});


	tinymce.init({
		license_key: 'gpl',
		promotion: false,
		selector: 'textarea.tinymce',
		min_height: 300,
		autoresize_bottom_margin: 0,
		plugins: [
			'advlist', 'autolink', 'autoresize', 'lists', 'link',
			'insertdatetime', 'media', 'table', 'wordcount', 'pagebreak', 'paste'
		],
		menubar: false,
		statusbar: false,
		toolbar_mode: 'floating',
		toolbar: 'bold italic removeformat link unlink ',
		toolbar_sticky: true,
		link_context_toolbar: true,
		skin: false,
		content_css: [
			'https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap',
			'/css/dynamic.css'
		],
		setup: function(editor)
		{
			editor.on('init', function()
			{
				editor.getBody().classList.add('dynamic');
				editor.getBody().style.fontSize = '16px';  // Adjust the default font size
				editor.getBody().style.fontFamily = 'Figtree, ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji';  // Adjust the default font family
			});
		},
		paste_preprocess: function(plugin, args) {
			// Strip out images from the pasted content
			args.content = args.content.replace(/<img[^>]*>/g, '');
		}
	});







});

window.Alpine = Alpine;

Alpine.start();
