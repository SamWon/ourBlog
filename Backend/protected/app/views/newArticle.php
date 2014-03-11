<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>创建文章</title>
        <link rel="stylesheet" href="/css/back.css" />
    </head>
    <body>
        <div class="manage">管理：<a href="/index.php/admin/back/index">文章</a> | <a href="/index.php/admin/back/typeList">分类</a></div>

<?php if(isset($article)):?>
        <form method="post" action="/index.php/admin/back/addArticle/<?php echo $article[0]->aid;?>">
<?php else:?>
        <form method="post" action="/index.php/admin/back/addArticle">
<?php endif;?>
            <div>
                <label for="">文章名称</label>
<?php if(isset($article)):?>
                    <input class="articleName" type="text" name="title" value="<?php echo $article[0]->title;?>" />
<?php else:?>
                    <input class="articleName" type="text" name="title" />
<?php endif;?>
            </div>

            <div>
                <label for="">文章分类</label>
                <select name="type_id">
<?php foreach($types as $t):?>
<?php if($t->tid != 0):?>
    <?php if(isset($article) && $article[0]->tid == $t->tid):?>
                    <option value="<?php echo $t->tid;?>" selected="selected"><?php echo $t->name;?></option>
    <?php else:?>
                    <option value="<?php echo $t->tid;?>"><?php echo $t->name;?></option>
    <?php endif;?>
<?php endif;?>
<?php endforeach;?>
                </select>
            </div>

<?php if(isset($article)):?>
            <textarea id="test" name="content" style="width: 900px; height: 800px"><?php echo $article[0]->content;?> </textarea>
<?php else:?>
            <textarea id="test" name="content" style="width: 900px; height: 800px"> </textarea>
<?php endif;?>

            <input type="submit" value="提交" />
        </form>
    </body>
    <script type="text/javascript" src="/js/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/js/ueditor/ueditor.all.js"></script>
    <script type="text/javascript">
        var editor = UE.getEditor("test");
    </script>
</html>
