<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<title>Goals 🎯</title>
<div class="container">
    <div class="row">
        <h1 class="h2">Цели</h1>
        <?php
        const file = 'db.json';
        $json_data = json_decode(file_get_contents(file), true);
        ?>
        <div class="col-sm-6 mb-4">
            <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModalToggle2" class="btn btn-outline-success me-2"><i class="fa-solid fa-plus"></i> Добавить</a>
        </div>
        <table class="table table-dark table-striped">
            <tr>
                <th>Выполнено</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Категория</th>
                <th>Дата</th>
                <th>Изменить</th>
                <th>Удалить</th>
            </tr>
            <?php foreach ($json_data as $goal) { ?>
                <tr <?php if ($goal['status'] == 'on') { ?> class="status_checked" <?php } ?>>
                    <td>
                        <form method="post" action="main.php" id="formname_<?php echo $goal['id']; ?>">
                            <input type="hidden" name="id" value="<?php echo $goal['id']; ?>">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="status" value="<?php echo $goal['status']; ?>">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox" type="checkbox" <?php if ($goal['status'] == 'on') { ?> checked <?php } ?> name="status" value="<?php echo $goal['id']; ?>" id="status_<?php echo $goal['id']; ?>" onchange="document.getElementById('formname_<?php echo $goal['id']; ?>').submit()">
                            </div>
                        </form>
                    </td>
                    <td><?php echo $goal['name']; ?></td>
                    <td><?php echo $goal['description']; ?></td>
                    <td><?php echo $goal['category']; ?></td>
                    <td><span class="badge bg-secondary"><?php echo $goal['date']; ?></span></td>
                    <td>
                        <a type="button" data-bs-toggle="modal" data-bs-target="#Modal_change_<?php echo $goal['id']; ?>" class="btn btn-outline-info me-2">
                            <small><i class="fa-solid fa-pen-to-square"></i> Изменить</small>
                        </a>
                    </td>
                    <td>
                        <form action="main.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $goal['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-outline-danger me-2"><small><i class="fa-solid fa-trash-can "></i> Удалить</small></button>
                        </form>
                    </td>
                </tr>

                <div class="modal fade" id="Modal_change_<?php echo $goal['id']; ?>" aria-labelledby="exampleModalToggleLabel2" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3 class="modal-title fs-5" id="exampleModalToggleLabel2">Редактировать цель №<?php echo $goal['id']; ?></h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="main.php">
                                    <input type="hidden" name="status" value="<?php echo $goal['status']; ?>">
                                    <input type="hidden" name="id" value="<?php echo $goal['id']; ?>">
                                    <input type="hidden" name="action" value="edit">
                                    <div class="form-group">
                                        <label class="col-form-label mt-4" for="name">Название</label>
                                        <input type="text" class="form-control" name="name" placeholder="Название" id="edit_name_<?php echo $goal['id']; ?>" value="<?php echo htmlspecialchars($goal['name']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label mt-4" for="category">Категория</label>
                                        <input type="text" class="form-control" name="category" placeholder="Категория" id="edit_category_<?php echo $goal['id']; ?>" value="<?php echo htmlspecialchars($goal['category']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="form-label mt-4">Описание</label>
                                        <textarea class="form-control" id="edit_description_<?php echo $goal['id']; ?>" name="description" rows="3"><?php echo htmlspecialchars($goal['description']); ?></textarea>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Изменить">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </table>
    </div>
</div>

<div class="modal fade" id="exampleModalToggle2" aria-labelledby="exampleModalToggleLabel2" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="main.php">
                <input type="hidden" name="action" value="add">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalToggleLabel2">Добавить цель</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-form-label mt-4" for="name">Название</label>
                        <input type="text" class="form-control" name="name" placeholder="Название" id="name">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label mt-4" for="category">Категория</label>
                        <input type="text" class="form-control" name="category" placeholder="Категория" id="category">
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label mt-4">Описание</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Описание"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Добавить">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
<?php
