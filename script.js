document.getElementById('exportForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Show loading state
    submitBtn.textContent = 'Exporting...';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch('export.php', {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) {
            throw new Error('Export failed');
        }
        
        // Get filename from Content-Disposition header
        const disposition = response.headers.get('Content-Disposition');
        let filename = 'urls_export.txt';
        if (disposition) {
            const filenameMatch = disposition.match(/filename="(.+)"/);
            if (filenameMatch) {
                filename = filenameMatch[1];
            }
        }
        
        // Download file
        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
        
        // Show success message
        showMessage('Export completed successfully!', 'success');
        
    } catch (error) {
        showMessage('Export failed: ' + error.message, 'error');
    } finally {
        submitBtn.textContent = 'Export URLs';
        submitBtn.disabled = false;
    }
});

function showMessage(message, type) {
    const resultsDiv = document.getElementById('results');
    const resultsContent = document.getElementById('resultsContent');
    
    resultsDiv.classList.remove('hidden');
    resultsContent.innerHTML = `
        <div class="message ${type}">
            ${message}
        </div>
    `;
    
    setTimeout(() => {
        resultsDiv.classList.add('hidden');
    }, 5000);
}
