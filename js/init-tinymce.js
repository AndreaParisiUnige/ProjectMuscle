/* L'editor è sicuro rispetto ad attacchi Cross Site Scripting
   Utilizza di default il sanificatore DOMPurify per rimuvoere caratteri pericolosi
   Esempio: 
   <script src="js/init-tinymce.js"></script>
	   Verrà sanificato in:
   <p>&lt;script src='js/init-tinymce.js'&gt;&lt;/script&gt;</p>
   In tal modo lo script verrà trattato come una semplice stringa.
*/

tinymce.init({
	selector: "#textarea",

	auto_focus: 'textarea',
	highlight_on_focus: true,
	language: 'it',
	placeholder: 'Start writing your article here...',
	width: "100%",
	height: 450,

	// Agginge un vincolo sulla prima riga dell'articolo: necessario un titolo.
	setup: function (editor) {
		editor.on('keyup', function () {
			const content = editor.getContent();
			const lines = content.split('\n');
			const firstLine = lines[0].trim();

			if (firstLine !== '') {
				const startsWithTitle = firstLine.startsWith('<h');
				if (!startsWithTitle) {
					editor.setContent('')
					alert("La prima linea dell'articolo deve essere un titolo!");
				}
			}
		});
	},

	menubar: 'file edit insert format tools table',

	menu: {
		edit: { title: 'Edit', items: 'undo redo | selectall' },
		file: { title: 'File', items: 'newdocument restoredraft | preview | export print | deleteallconversations' },
		edit: { title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall | searchreplace' },
		view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen | showcomments' },
		insert: { title: 'Insert', items: 'image link media addcomment pageembed template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor tableofcontents | insertdatetime' },
		format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | styles blocks fontfamily fontsize align lineheight | forecolor backcolor | language | removeformat' },
		tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | a11ycheck code wordcount' },
		table: { title: 'Table', items: 'inserttable | cell row column | advtablesort | tableprops deletetable' },
		help: { title: 'Help', items: 'help' }
	},

	plugins: 'tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
	toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
	tinycomments_mode: 'embedded',
	tinycomments_author: 'Author name',
	mergetags_list: [
		{ value: 'First.Name', title: 'First Name' },
		{ value: 'Email', title: 'Email' },
	],

	style_formats: [
		{
			title: "Headers", items: [
				{ title: "Header 1", format: "h1" },
				{ title: "Header 2", format: "h2" },
				{ title: "Header 3", format: "h3" },
				{ title: "Header 4", format: "h4" },
				{ title: "Header 5", format: "h5" },
				{ title: "Header 6", format: "h6" }
			]
		},
		{
			title: "Inline", items: [
				{ title: "Bold", icon: "bold", format: "bold" },
				{ title: "Italic", icon: "italic", format: "italic" },
				{ title: "Underline", icon: "underline", format: "underline" },
				{ title: "Strikethrough", icon: "strikethrough", format: "strikethrough" },
				{ title: "Superscript", icon: "superscript", format: "superscript" },
				{ title: "Subscript", icon: "subscript", format: "subscript" },
				{ title: "Code", icon: "code", format: "code" }
			]
		},
		{
			title: "Blocks", items: [
				{ title: "Paragraph", format: "p" },
				{ title: "Blockquote", format: "blockquote" },
				{ title: "Div", format: "div" },
				{ title: "Pre", format: "pre" }
			]
		},
		{
			title: "Alignment", items: [
				{ title: "Left", icon: "alignleft", format: "alignleft" },
				{ title: "Center", icon: "aligncenter", format: "aligncenter" },
				{ title: "Right", icon: "alignright", format: "alignright" },
				{ title: "Justify", icon: "alignjustify", format: "alignjustify" }
			]
		}
	]
});