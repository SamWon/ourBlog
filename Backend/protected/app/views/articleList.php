<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>文章列表</title>
        <link rel="stylesheet" href="/css/back.css" />
    </head>
    <body>
        <div class="manage">管理：<a href="/index.php/admin/back/index">文章</a> | <a href="/index.php/admin/back/typeList">分类</a></div>

        <a href="/index.php/admin/back/newArticle">创建新文章</a>

        <table>
            <tr>
              <th>文章名</th>
              <th>分类</th>
              <th>操作</th>
            </tr>

<?php foreach($articles as $a):?>
            <tr>
            <td><?php echo $a->title;?></td>
            <td><?php echo $t_array[$a->tid];?></td>
                <td>
                    <a href="/index.php/admin/back/newArticle/<?php echo $a->aid;?>">修改</a> |
                    <a href="/index.php/admin/back/deleteArticle/<?php echo $a->aid;?>">删除</a>
                </td>
            </tr>
<?php endforeach;?>
            
        </table>
    </body>
</html>
