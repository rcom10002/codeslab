一、自动更新使用说明
1. 自动更新功能无法更新sEaxmLauncher.exe，除此之外可以更新所有程序。
2. 更新时需要提供xxxx.7z格式的文件，文件名需要为连续的数字字母，解压后的文件中必须包含xxxx.7z.readme文件
3. 程序启动后会自动寻找update_url中配置的URL，该URL需要给出具体的文件名称
<?php
echo "xxxx.7z";
?>
4. 文件更新
  4-1.准备更新文件时，先准备一个xxxx.7z.readme文件
  4-2.准备好要更新的文件
  4-3.将4-1和4-2文件压缩为7z文件，并以xxxx.7z命名
  4-4.修改update_url配置的站点信息，echo "xxxx.7z"
  4-5.启动客户端进行程序更新

备注：
配置文件中的配置信息，其中update_key的长度必须在20以内，包括20
update_key              =xxxx.7z
update_url              =http://localhost/z-test/

二、自动更新功能测试
测试用例
1. URL无效
2. 远程文件不存在
3. 本地已经存在同名文件
   有同名文件且被其它进程占用
4. 文件下载成功但7z格式无效
5. 文件成功解压，缺少readme文件
6. 启动进程失败