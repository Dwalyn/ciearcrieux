import './stimulus/stimulus';

// assets/app.js (ou un autre fichier JavaScript d'entrée)

import Quill from 'quill';
//import 'quill/dist/quill.snow.css';
//import 'quill/dist/quill.bubble.css';
// Ou 'quill/dist/quill.bubble.css' pour le thème bubble
// Si vous voulez un thème sans style prédéfini, vous pouvez omettre l'importation CSS

// Ensuite, vous pouvez initialiser Quill pour vos éléments.
// Il est souvent utile de le faire une fois que le DOM est chargé.
document.addEventListener('DOMContentLoaded', () => {
    const quillEditors = document.querySelectorAll('[data-quill-editor]');

    quillEditors.forEach(editorContainer => {
        const inputId = editorContainer.dataset.quillEditor;
        const hiddenInput = document.getElementById(inputId);

        if (!hiddenInput) {
            console.error(`Hidden input with ID "${inputId}" not found for Quill editor.`);
            return;
        }

        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],

            [{ 'header': 1 }, { 'header': 2 }],               // custom button values
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
            [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
            [{ 'direction': 'rtl' }],                         // text direction

            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'font': [] }],
            [{ 'align': [] }],

            ['clean']                                         // remove formatting button
        ];

        const quill = new Quill(editorContainer, {
            theme: 'snow', // Ou 'bubble'
            modules: {
                toolbar: toolbarOptions
            },
            placeholder: 'Saisissez votre texte ici...'
        });

        // Mettre à jour le champ caché avec le contenu HTML de Quill
        quill.on('text-change', () => {
            hiddenInput.value = quill.root.innerHTML;
        });

        // Initialiser Quill avec le contenu existant du champ caché (si édition)
        if (hiddenInput.value) {
            quill.clipboard.dangerouslyPasteHTML(hiddenInput.value);
        }
    });
});
