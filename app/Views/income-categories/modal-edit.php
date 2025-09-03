<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }
    
    .modal-content {
        background-color: <?= WHITE; ?>;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    
    .modal-title {
        font-size: 1.5em;
        color: <?= MAIN_DARK_COLOR; ?>;
        margin: 0;
        font-weight: 600;
    }
    
    .close {
        color: <?= DANGER; ?>;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
    }
    
    .close:hover {
        color: <?= DANGER_DARK_COLOR; ?>;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: <?= MAIN_DARK_COLOR; ?>;
    }
    
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid <?= LIGHT_GRAY; ?>;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
        box-sizing: border-box;
    }
    
    .form-input:focus {
        outline: none;
        border-color: <?= MAIN_COLOR; ?>;
    }
    
    .form-hint {
        font-size: 14px;
        color: <?= GRAY; ?>;
        margin-top: 5px;
        font-style: italic;
    }
    
    .modal-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
    }
    
    .btn-cancel {
        background-color: transparent;
        color: <?= DANGER_DARK_COLOR; ?>;
        border: 2px solid <?= DANGER_DARK_COLOR; ?>;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
    }
    
    .btn-cancel:hover {
        background-color: <?= DANGER_DARK_COLOR; ?>;
        color: <?= WHITE; ?>;
    }
    
    .btn-submit {
        background-color: transparent;
        color: <?= MAIN_DARK_COLOR; ?>;
        border: 2px solid <?= MAIN_DARK_COLOR; ?>;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
    }
    
    .btn-submit:hover {
        background-color: <?= MAIN_DARK_COLOR; ?>;
        color: <?= WHITE; ?>;
    }
</style>

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