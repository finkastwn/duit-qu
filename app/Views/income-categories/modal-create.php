<?php include(APPPATH . 'Views/income-categories/modal-css.php'); ?>

<div id="createModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Create Income Category</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        
        <form id="createForm" action="/income-categories/store" method="post">
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
</script>
