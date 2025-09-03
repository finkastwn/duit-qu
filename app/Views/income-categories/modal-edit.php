<?php include(APPPATH . 'Views/income-categories/modal-css.php'); ?>

<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Edit Income Category</h2>
            <span class="close" onclick="closeEditModal()">&times;</span>
        </div>
        
        <form id="editForm">
            <div class="form-group">
                <input type="text" 
                       id="editCategory" 
                       name="category" 
                       class="form-input"
                       placeholder="Enter category name"
                       required>
                <div class="form-hint">Example: Salary, Investment Return, etc</div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn-submit">Update Category</button>
            </div>
        </form>
    </div>
</div>

<script>
let editId = null;

document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        editId = this.getAttribute('href').split('/').pop();
        
        fetch(`<?= base_url('income-categories/edit') ?>/${editId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('editCategory').value = data.data.category;
                document.getElementById('editModal').style.display = 'block';
            } else {
                showSnackbar(data.message || 'Failed to load category data', 'error');
            }
        })
        .catch(() => showSnackbar('Failed to load category data', 'error'));
    });
});

document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('category', document.getElementById('editCategory').value);
    
    fetch(`<?= base_url('income-categories/update') ?>/${editId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            const row = document.querySelector(`.btn-edit[href$='${editId}']`).closest('tr');
            const categoryCell = row.querySelector('td:nth-child(2)');
            categoryCell.textContent = document.getElementById('editCategory').value;
            
            showSnackbar('Category updated successfully', 'success');
            closeEditModal();
        } else {
            showSnackbar(data.message || 'Failed to update category', 'error');
        }
    })
    .catch(() => showSnackbar('Failed to update category', 'error'));
});

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    document.getElementById('editForm').reset();
}

window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target === modal) {
        closeEditModal();
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeEditModal();
    }
});

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