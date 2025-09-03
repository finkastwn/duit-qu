<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Delete Category</h2>
            <span class="close" onclick="closeDeleteModal()">&times;</span>
        </div>
        <p id="deleteMessage"></p>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-submit" id="confirmDelete">Delete</button>
        </div>
    </div>
</div>

<script>
let deleteId = null;

document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        deleteId = this.getAttribute('href').split('/').pop();
        const categoryName = this.closest('tr').querySelector('td:nth-child(2)').textContent;
        document.getElementById('deleteMessage').textContent = `Are you sure you want to delete "${categoryName}"?`;
        document.getElementById('deleteModal').style.display = 'block';
    });
});

document.getElementById('confirmDelete').addEventListener('click', function() {
    fetch(`<?= base_url('income-categories/delete') ?>/${deleteId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success'){
            document.querySelector(`.btn-delete[href$='${deleteId}']`).closest('tr').remove();
            
            const tbody = document.querySelector('.income-table tbody');
            const remainingRows = tbody.querySelectorAll('tr:not(.no-data-row)');
            
            if (remainingRows.length === 0) {
                tbody.innerHTML = `
                    <tr class="no-data-row">
                        <td colspan="3" class="no-data-cell">
                            <div class="no-data">
                                <div class="no-data-icon">📊</div>
                                <p>No data available</p>
                            </div>
                        </td>
                    </tr>
                `;
            }
            
            showSnackbar('Category deleted successfully', 'success');
            
            closeDeleteModal();
        } else {
            showSnackbar(data.message || 'Failed to delete category', 'error');
        }
    })
    .catch(() => showSnackbar('Failed to delete category', 'error'));
});

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

function showSnackbar(message, type = 'success') {
    let snackbar = document.getElementById('snackbar');
    
    if (!snackbar) {
        snackbar = document.createElement('div');
        snackbar.id = 'snackbar';
        document.body.appendChild(snackbar);
    }
    
    snackbar.textContent = message;
    snackbar.className = `show ${type}`;
    
    setTimeout(() => {
        snackbar.className = snackbar.className.replace("show", "");
    }, 3000);
}
</script>