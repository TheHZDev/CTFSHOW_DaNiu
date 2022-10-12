<?php
$jsFilePath = './DaNiu.js';
$auth_add_key = array(); // 执行kw指令添加大牛对话时的API密钥，置空则无需密钥即可操作
$auth_modify_key = array(md5('admin')); // 执行kw指令修改大牛已经存在的对话时的API密钥
$auth_delete_key = array(md5('admin')); // 远程删除大牛对话时所需要的API密钥