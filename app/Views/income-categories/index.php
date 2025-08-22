<?php $activeMenu = 'categories'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DuitQu - Income Categories</title>
    <link href="/css/global-font.css" rel="stylesheet">
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        
        .title-section {
            flex: 1;
        }
        
        .page-title {
            font-size: 2.5em;
            color: <?= MAIN_DARK_COLOR; ?>;
            margin: 0 0 10px 0;
        }
        
        .page-subtitle {
            font-size: 1.1em;
            color: <?= GRAY; ?>;
            margin: 0;
            font-weight: 400;
        }
        
        .create-btn {
            background-color: transparent;
            color: <?= MAIN_DARK_COLOR; ?>;
            border: 2px solid <?= MAIN_DARK_COLOR; ?>;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .create-btn:hover {
            background-color: <?= MAIN_DARK_COLOR; ?>;
            color: <?= WHITE; ?>;
        }
        
        .income-table {
            width: 100%;
            border-collapse: collapse;
            color: <?= WHITE; ?>;
        }
        
        .income-table th {
            background-color:  <?= VIOLET_ACCENT; ?>;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border: 1px solid <?= VIOLET_ACCENT; ?>;
        }
        
        .income-table td {
            background-color:  <?= MAIN_VERY_LIGHT_COLOR; ?>;
            padding: 15px;
            color: <?= MAIN_DARK_COLOR; ?>;
            border: 1px solid <?= VIOLET_ACCENT; ?>;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            min-width: 60px;
        }
        
        .btn-edit {
            background-color: <?= MAIN_COLOR; ?>;
            color: <?= WHITE; ?>;
        }
        
        .btn-edit:hover {
            background-color: <?= MAIN_DARK_COLOR; ?>;
        }
        
        .btn-delete {
            background-color: <?= DANGER; ?>;
            color: <?= WHITE; ?>;
        }
        
        .btn-delete:hover {
            background-color: <?= DANGER_DARK_COLOR; ?>;
        }
        
        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: <?= VIOLET_ACCENT; ?>;
            font-size: 1.2em;
        }
        
        .no-data-icon {
            font-size: 3em;
            margin-bottom: 20px;
            opacity: 0.7;
        }
    </style>
</head>
<body>
    <?php include(APPPATH . 'Views/partials/sidebar.php'); ?>
    
    <div class="main-content">
        <div class="page-header">
            <div class="title-section">
                <h1 class="page-title">Income Categories</h1>
                <h2 class="page-subtitle">Manage your income categories to organize your finances better</h2>
            </div>
            <a href="/income-categories/create" class="create-btn">Add New Income Category</a>
        </div>
        
        <div class="table-container">
                <table class="income-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Income Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($incomeCategories)): ?>
                            <tr>
                                <td colspan="3">
                                    <div class="no-data">
                                        <div class="no-data-icon">📊</div>
                                        <p>No data available</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($incomeCategories as $index => $category): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($category['category']) ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="/income-categories/edit/<?= $category['id'] ?>" class="btn-edit">Edit</a>
                                            <a href="/income-categories/delete/<?= $category['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
        </div>
    </div>
</body>
</html>
