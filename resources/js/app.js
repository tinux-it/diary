import Quill from 'quill';
import 'quill/dist/quill.snow.css';

document.addEventListener('DOMContentLoaded', function () {
    // Initialize Quill for all textareas with class 'quill-editor'
    const quillElements = document.querySelectorAll('.quill-editor');
    
    quillElements.forEach(function(element) {
        const quill = new Quill(element, {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'header': [1, 2, 3, false] }],
                    ['link', 'image'],
                    ['clean']
                ]
            },
            placeholder: 'Begin met het schrijven van je gedachten...'
        });

        // Sync Quill content with hidden textarea for form submission
        const textarea = element.nextElementSibling;
        if (textarea && textarea.tagName === 'TEXTAREA') {
            // Set initial content
            textarea.value = quill.root.innerHTML;
            
            // Update textarea on content change
            quill.on('text-change', function() {
                textarea.value = quill.root.innerHTML;
            });
        }
    });

    // Handle toggle switches
    const toggleSwitches = document.querySelectorAll('input[type="checkbox"][id="is_visible"]');
    toggleSwitches.forEach(function(checkbox) {
        const label = checkbox.nextElementSibling;
        const span = label.querySelector('span');
        
        // Set initial state
        if (checkbox.checked) {
            label.classList.add('bg-blue-600', 'dark:bg-blue-500');
            span.classList.add('translate-x-6');
        }
        
        // Handle click
        label.addEventListener('click', function() {
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                label.classList.add('bg-blue-600', 'dark:bg-blue-500');
                span.classList.add('translate-x-6');
            } else {
                label.classList.remove('bg-blue-600', 'dark:bg-blue-500');
                span.classList.remove('translate-x-6');
            }
        });
    });
});
