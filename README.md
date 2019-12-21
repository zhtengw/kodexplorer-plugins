# kodexplorer_onlyoffice

1: 运行命令 docker run --name onlyoffice --restart always -i -t -d -p 666:80 onlyoffice/documentserver  
2: 替换文本 YourServerIP替换为对应的ip或域名  
3: 复制粘贴 OnlyOffice复制到kodexplorer根目录的plugins文件夹里  
4: 配置参数 在插件中心的OnlyOffice在线编辑器配置服务器接口http://YourServerIP/plugins/OnlyOffice/office.php?src=  
5: 搞定了啦 上传个WPS文档试试 o(∩_∩)o~  

// 开放了一台8G5M的Office服务器,仅供测试使用,免去第一步自己部署
// 修改 YourServerIP:666 为 47.107.226.98:666 另外两个 YourServerIP依旧为你自己可道云服务器的IP或域名
