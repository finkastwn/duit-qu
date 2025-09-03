<?php include(APPPATH . 'Views/income-categories/modal-css.php'); ?>

<div id="createModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Create Income Category</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        
        <form id="createForm">
            <div class="form-group">
                <input type="text" 
                       id="category" 
                       name="category" 
                       class="form-input"
                       placeholder="Enter category name"
                       required>
                <div class="form-hint">Example: Salary, Investment Return, etc</div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-submit">Create Category</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelector('.create-btn').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('createModal').style.display = 'block';
    });
    
    document.getElementById('createForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('category', document.getElementById('category').value);
        
        fetch('<?= base_url('income-categories/store') ?>', {
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
                // Add new row to table if there are existing categories
                const tbody = document.querySelector('.income-table tbody');
                const noDataRow = tbody.querySelector('.no-data-row');
                
                if (noDataRow) {
                    // Replace no-data row with new category
                    tbody.innerHTML = `
                        <tr>
                            <td>1</td>
                            <td>${data.data.category}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="/income-categories/edit/${data.data.id}" class="btn-edit">✏️ Edit</a>
                                    <a href="/income-categories/delete/${data.data.id}" class="btn-delete">🗑️ Delete</a>
                                </div>
                            </td>
                        </tr>
                    `;
                } else {
                    const rowCount = tbody.querySelectorAll('tr').length;
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>${rowCount + 1}</td>
                        <td>${data.data.category}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="/income-categories/edit/${data.data.id}" class="btn-edit">✏️ Edit</a>
                                <a href="/income-categories/delete/${data.data.id}" class="btn-delete">🗑️ Delete</a>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(newRow);
                }
                
                showSnackbar('Income category created successfully', 'success');
                closeModal();
            } else {
                showSnackbar(data.message || 'Failed to create income category', 'error');
            }
        })
        .catch(() => showSnackbar('Failed to create income category', 'error'));
    });
    
    function closeModal() {
        document.getElementById('createModal').style.display = 'none';
        document.getElementById('createForm').reset();
    }
    
    window.onclick = function(event) {
        const modal = document.getElementById('createModal');
        if (event.target === modal) {
            closeModal();
        }
    }
    
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
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
