
                    <form action="/index.php/home/search" method="post" class="search">
                        <input class="searchText" type="text"  name="search" placeholder="搜索你想要的内容..." />
                        <input class="searchSubmit" type="submit" value="" />
                    </form>
                    <div class="kind">
                        <h3>分类列表</h3>
                        <ul>
<?php foreach($types as $t):?>
                            <li><a href="/index.php/home/index/<?php echo $t->tid;?>"><?php echo $t->name;?></a></li>
<?php endforeach;?>
                        </ul>
                    </div>
