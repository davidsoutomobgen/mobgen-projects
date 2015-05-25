<h2>Users</h2>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $users->search(),
    'columns' => array(
        array(
            'name' => 'username',
        ),
        array(
            'name' => 'role',
            'value' => 'Role::toText($data->role)'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
            'updateButtonUrl' => '_url("admin/editUser", array("id" => $data->id))',
            'deleteButtonUrl' => '_url("admin/deleteUser", array("id" => $data->id))',
        ),
    ),
));

echo CHtml::link('Add user', _url('admin/addUser'), array('class' => 'button'));
?>