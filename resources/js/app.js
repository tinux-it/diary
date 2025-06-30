// Modal functionality
document.addEventListener('livewire:init', () => {
    Livewire.on('openModal', (event) => {
        const { component, arguments: args } = event;
        
        // Create modal container if it doesn't exist
        let modalContainer = document.getElementById('modal-container');
        if (!modalContainer) {
            modalContainer = document.createElement('div');
            modalContainer.id = 'modal-container';
            document.body.appendChild(modalContainer);
        }
        
        // Create modal element
        const modalElement = document.createElement('div');
        modalElement.innerHTML = `<livewire:${component} ${Object.entries(args).map(([key, value]) => `${key}="${value}"`).join(' ')} />`;
        
        // Add modal to container
        modalContainer.appendChild(modalElement);
        
        // Focus trap and escape key handling
        const handleEscape = (e) => {
            if (e.key === 'Escape') {
                closeModal();
            }
        };
        
        const closeModal = () => {
            modalContainer.innerHTML = '';
            document.removeEventListener('keydown', handleEscape);
        };
        
        document.addEventListener('keydown', handleEscape);
        
        // Listen for close modal event
        Livewire.on('closeModal', () => {
            closeModal();
        });
    });
});
