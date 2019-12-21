# kodexplorer_onlyoffice

1: 运行命令 docker run --name onlyoffice --restart always -i -t -d -p 666:80 onlyoffice/documentserver  
2: 复制粘贴 OnlyOffice复制到kodexplorer根目录的plugins目录里  
3: 搞定了啦 上传个WPS文档试试 o(∩_∩)o~  

// 开放了一台8G5M的Office服务器,仅供测试使用,免去第一步自己部署  
// 如果运行不正常,可以在插件中心配置插件将服务器接口留空,查看相关使用参数是否有问题,重点关注下载地址是否可用  
// docker是啥自己百度别问我!  
// office.php为参数配置,修改自OnlyOffice官网 https://api.onlyoffice.com/editors  
// file.php用来往Office服务器上传文档以进行编辑  
// save.php用来将Office文档下载回本地保存  
// 剩下的文件基本为可道云插件模板修改 http://doc.kodcloud.com/#/plugins/main  
