<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>创建分类</title>
        <link rel="stylesheet" href="/css/back.css" />
    </head>
    <body>
        <div class="manage">管理：<a href="/index.php/admin/back/index">文章</a> | <a href="/index.php/admin/back/typeList">分类</a></div>

<?php if(isset($type)):?>
    <div>原分类名：<?php echo $type[0]->name;?></div>
        <form action="/index.php/admin/back/addType/<?php echo $type[0]->tid;?>" method="post">
            <label for="">新分类名</label>
            <input type="text" name="t_name" />
            <div>
                <input type="submit" value="提交" />
            </div>
        </form>
<?php else:?>
    <div> </div>
        <form action="/index.php/admin/back/addType/" method="post">
            <label for="">新分类名</label>
            <input type="text" name="t_name" />
            <div>
                <input type="submit" value="提交" />
            </div>
        </form>
<?php endif;?>
    </body>
</html>
