<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>分类列表</title>
        <link rel="stylesheet" href="/css/back.css" />
    </head>
    <body>
        <div class="manage">管理：<a href="/index.php/admin/back/index">文章</a> | <a href="/index.php/admin/back/typeList">分类</a></div>

        <a href="/index.php/admin/back/newType">创建新分类</a>

        <table>
            <tr>
              <th>分类名</th>
              <th>操作</th>
            </tr>

<?php foreach($types as $t):?>
<?php if($t->tid != 0):?>
            <tr>
            <td><?php echo $t->name;?></td>
                <td>
                    <a href="/index.php/admin/back/newType/<?php echo $t->tid;?>">修改</a> |
                    <a href="/index.php/admin/back/deleteType/<?php echo $t->tid;?>">删除</a>
                </td>
            </tr>
<?php endif;?>
<?php endforeach;?>
        </table>
    </body>
</html>
